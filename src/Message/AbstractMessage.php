<?php

namespace Mailchimp\Message;

use JsonSerializable;
use Mailchimp\Client;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Common\Json;
use Mailchimp\Common\Utils;
use Mailchimp\Exception\Exception;
use Mailchimp\Exception\RuntimeException;
use Mailchimp\Worker;

abstract class AbstractMessage implements MessageInterface, JsonSerializable
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $__endpoint
     */
    protected $__endpoint;

    /**
     * Available HTTP operations
     *
     * @var array $__httpVerbs
     */
    protected $__httpVerbs;

    /**
     * @var array $__methods
     */
    private $__methods;

    /**
     * @var Worker $__worker
     */
    protected $__worker;

    protected $__baseNS = 'Mailchimp\\Message';

    public function __construct(Worker $worker = null)
    {
        $this->__worker = $worker;
    }

    abstract public function createRequestParams();

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

    public function setEndpoint($__endpoint)
    {
        $this->__endpoint = $__endpoint;
    }
    
    public function getEndpoint()
    {
        return $this->__endpoint;
    }

    public function getAllowedHttpVerbs()
    {
        return $this->__httpVerbs;
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

        $method = strtoupper($method);

        switch ($method) {
            case HttpVerbs::GET:
                    return $this->_tryCreateMessage($object);
                break;
            case HttpVerbs::DELETE:
                if (isset($this->__methods[HttpVerbs::DELETE]['delete'])) {
                    return $this->_doSelfDelete();
                }
                throw new RuntimeException('Method '.HttpVerbs::DELETE.' is not supported for for this object ['.get_class($this).'].');
                break;
            case 'UPDATE':
                if (isset($this->__methods[HttpVerbs::PATCH]['update'])) {
                    return $this->_doSelfUpdate();
                }
                throw new RuntimeException('Method '.HttpVerbs::PATCH.' is not supported for for this object ['.get_class($this).'].');
                break;
            case 'CREATE':
                if (isset($this->__methods[HttpVerbs::POST]['create'])) {
                    return $this->_doCreate($args[0]);
                }
                throw new RuntimeException('Method '.HttpVerbs::POST.' is not supported for for this object ['.get_class($this).'].');
                break;
            case HttpVerbs::PUT:
                break;
            case 'FIND':
                return $this->_doFind($object, $args[0]);
                break;
        }
    }

    private function _tryCreateMessage($className)
    {
        //$className = $this->baseNS.'\\'.Utils::CamelCase($name);
        $fullClassName = $this->__baseNS.'\\'.$className.'Collection';
        if (!class_exists($fullClassName, true)) {
            throw new RuntimeException('Cannot find class for object name: '.$className.' ['.$fullClassName.']');
        }

        $object = new $fullClassName($this->__worker);

        $object->setEndpoint($this->__methods[HttpVerbs::GET][strtolower($className)]['href']);

        return $this->__worker->load($object);
    }

    private function _doCreate($object)
    {
        if (!$this instanceof AbstractMessageCollection) {
            throw new RuntimeException('Creating new instances is supported only for Collections');
        }

        if (!$this->isChild($object)) {
            throw new RuntimeException('Collection '.get_class($this). ' don\'t have members: '.get_class($object));
        }

        $object->setEndpoint($this->__methods[HttpVerbs::POST]['create']['href']);

        return $this->__worker->create($object);
    }

    private function _doSelfUpdate()
    {
        if (!$this instanceof AbstractMessage) {
            throw new RuntimeException('Updating is supported only for Messages');
        }

        return $this->__worker->update($this);
    }

    private function _doSelfDelete()
    {
        if (!$this instanceof AbstractMessage) {
            throw new RuntimeException('Deleting is supported only for Messages');
        }

        return $this->__worker->delete($this);
    }

    private function _doFind($objectName, $args)
    {
        if (!$this instanceof AbstractMessageCollection) {
            throw new RuntimeException('Finding is supported only for Collections');
        }

        if($this->getDataMemberName() !== strtolower($objectName)) {
            throw new RuntimeException('Collection '.get_class($this). ' don\'t have members: '.$objectName);
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

    public function jsonSerialize() {
        $reflected = new \ReflectionClass($this);
        $properties = $reflected->getProperties();

        $stdClass = new \stdClass();
        foreach ($properties as $property)
        {
            $name = $property->getName();
            /**
             * Skip all internal properties.
             */
            if(substr($name, 0, 2) === '__') {
                continue;
            }

            $getter = 'get'.Utils::CamelCase($name);

            $value = $this->{$getter}();
            if (empty($value)) {
                continue;
            }
            $stdClass->{$name} = $this->_doPrepareJsonData($value);
        }

        return $stdClass;
    }

    private function _doPrepareJsonData($data)
    {
        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        } elseif (is_array($data)) {
            $tmp = [];
            foreach($data as $val) {
                $tmp[] = $this->_doPrepareJsonData($val);
            }
            return $tmp;
        } elseif($data instanceof \DateTimeZone) {
            return $data->getName();
        } else {
            return $data;
        }
    }
}