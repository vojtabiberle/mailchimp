<?php

namespace Mailchimp\Common;

/**
 * This implementation is part of the Nette Framework (http://nette.org)
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 */

/**
 * JSON encoder and decoder.
 *
 * @author     David Grudl
 */
class Json
{
    const FORCE_ARRAY = 0b0001;
    const PRETTY = 0b0010;
    /** @var array */
    private static $messages = [
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_STATE_MISMATCH => 'Syntax error, malformed JSON',
        JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
        JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => 'Invalid UTF-8 sequence',
    ];
    /**
     * Static class - cannot be instantiated.
     */
    final private function __construct()
    {}

    /**
     * Returns the JSON representation of a value.
     * @param  mixed
     * @param  int  accepts Json::PRETTY
     * @return string
     */
    public static function encode($value, $options = 0)
    {
        $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | ($options & self::PRETTY ? JSON_PRETTY_PRINT : 0);
        if (PHP_VERSION_ID < 50500) {
            $json = self::invokeSafe('json_encode', [$value, $flags], function($message) { // needed to receive 'recursion detected' error
                throw new JsonException($message);
            });
        } else {
            $json = json_encode($value, $flags);
        }
        if ($error = json_last_error()) {
            $message = isset(static::$messages[$error]) ? static::$messages[$error]
                : (PHP_VERSION_ID >= 50500 ? json_last_error_msg() : 'Unknown error');
            throw new JsonException($message, $error);
        }
        $json = str_replace(["\xe2\x80\xa8", "\xe2\x80\xa9"], ['\u2028', '\u2029'], $json);
        return $json;
    }
    /**
     * Decodes a JSON string.
     * @param  string
     * @param  int  accepts Json::FORCE_ARRAY
     * @return mixed
     */
    public static function decode($json, $options = 0)
    {
        $json = (string) $json;
        if (defined('JSON_C_VERSION') && !preg_match('##u', $json)) {
            throw new JsonException('Invalid UTF-8 sequence', 5);
        }
        $forceArray = (bool) ($options & self::FORCE_ARRAY);
        if (!$forceArray && preg_match('#(?<=[^\\\\]")\\\\u0000(?:[^"\\\\]|\\\\.)*+"\s*+:#', $json)) { // workaround for json_decode fatal error when object key starts with \u0000
            throw new JsonException(static::$messages[JSON_ERROR_CTRL_CHAR]);
        }
        $args = [$json, $forceArray, 512];
        if (!defined('JSON_C_VERSION') || PHP_INT_SIZE === 4) { // not implemented in PECL JSON-C 1.3.2 for 64bit systems
            $args[] = JSON_BIGINT_AS_STRING;
        }
        $value = call_user_func_array('json_decode', $args);
        if ($value === NULL && $json !== '' && strcasecmp($json, 'null')) { // '' is not clearing json_last_error
            $error = json_last_error();
            throw new JsonException(isset(static::$messages[$error]) ? static::$messages[$error] : 'Unknown error', $error);
        }
        return $value;
    }

    /**
     * Invokes internal PHP function with own error handler.
     * @return mixed
     */
    private static function invokeSafe($function, array $args, $onError)
    {
        $prev = set_error_handler(function($severity, $message, $file) use ($onError, & $prev) {
            if ($file === __FILE__ && $onError($message, $severity) !== FALSE) {
                return;
            } elseif ($prev) {
                return call_user_func_array($prev, func_get_args());
            }
            return FALSE;
        });
        try {
            $res = call_user_func_array($function, $args);
            restore_error_handler();
            return $res;
        } catch (\Exception $e) {
            restore_error_handler();
            throw $e;
        }
    }
}
/**
 * The exception that indicates error of JSON encoding/decoding.
 */
class JsonException extends \Exception
{
}