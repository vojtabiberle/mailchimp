<?php

namespace Mailchimp\Message;

use Mailchimp\Client;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Common\Utils;
use Mailchimp\Exception\Exception;
use Mailchimp\Exception\RuntimeException;
use Mailchimp\Worker;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $endpoint
     */
    protected $endpoint;

    /**
     * Available HTTP operations
     *
     * @var array $httpVerbs
     */
    protected $httpVerbs;

    /**
     * @var array $__methods
     */
    private $__methods;

    /**
     * @var Worker $__worker
     */
    protected $__worker;

    protected $baseNS = 'Mailchimp\\Message';

    public function __construct(Worker $worker = null)
    {
        $this->__worker = $worker;
    }

    /**
     * @return Client
     */
    public function getWorker()
    {
        return $this->__worker;
    }

    /**
     * @param Client $_master
     */
    public function setWorker($_master)
    {
        $this->__worker = $_master;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }
    
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getAllowedHttpVerbs()
    {
        return $this->httpVerbs;
    }

    public function addMethod($httpMethod, $target, $href)
    {
        $this->__methods[$httpMethod][$target]['href'] = $href;
    }

    public function __call($method, $args)
    {
        if (substr($method, 0, 3) === 'get') {
            $object = str_replace('get', '', $method);
            $method = HttpVerbs::GET;
        }

        if (substr($method, 0, 4) === 'find') {
            $object = str_replace('find', '', $method);
            $method = 'FIND';
        }

        if ($method === 'update') {
            $method = HttpVerbs::PATCH;
        }

        if ($method === 'create') {
            $method = HttpVerbs::POST;
        }

        switch ($method) {
            case HttpVerbs::GET:
                    return $this->_tryCreateMessage($object);
                break;
            case HttpVerbs::DELETE:
                if (isset($this->__methods[HttpVerbs::DELETE]['delete'])) {
                    return $this->_doSelfDelete();
                }
                throw new Exception('Method '.HttpVerbs::DELETE.' is not supported for for this object.');
                break;
            case HttpVerbs::PATCH:
                if (isset($this->__methods[HttpVerbs::PATCH]['update'])) {
                    return $this->_doSelfUpdate();
                }
                throw new Exception('Method '.HttpVerbs::PATCH.' is not supported for for this object.');
                break;
            case HttpVerbs::POST:
                if (isset($this->__methods[HttpVerbs::POST]['create'])) {
                    return $this->_doCreate($args[0]);
                }
                throw new Exception('Method '.HttpVerbs::POST.' is not supported for for this object.');
                break;
            case HttpVerbs::PUT:
                break;
            case 'FIND':
                return $this->_doFind($args[0]);
                break;
        }
    }

    private function _tryCreateMessage($className)
    {
        //$className = $this->baseNS.'\\'.Utils::CamelCase($name);
        $fullClassName = $this->baseNS.'\\'.$className.'Collection';
        if (!class_exists($fullClassName, true)) {
            throw new RuntimeException('Cannot find class for object name: '.$className.' ['.$fullClassName.']');
        }

        $object = new $fullClassName($this->__worker);

        $endpoint = $this->__worker->extractEndpoint($this->__methods[HttpVerbs::GET][strtolower($className)]['href']);
        $object->setEndpoint($endpoint);

        return $this->__worker->load($object);
    }

    private function _doCreate(MessageInterface $object)
    {
    }

    private function _doSelfUpdate()
    {

    }

    private function _doSelfDelete()
    {

    }

    private function _doFind($args)
    {
        if (!$this instanceof AbstractMessageCollection) {
            throw new RuntimeException('Finding is supported only for Collections');
        }

        if (!$this->count() > 0) {
            return false;
        }

        return $this->filter(function($item) use ($args){
            foreach ($args as $key => $value) {
                $cc = Utils::CamelCase($key);
                $getter = 'get'.$cc;

                if (!method_exists($item, $getter)) {
                    return false;
                }

                if ($item->{$getter}() !== $value) {
                    return false;
                }
            }

            return true;
        });
    }
}