<?php

namespace Mailchimp\Common;

use GuzzleHttp\Psr7\Response;
use Mailchimp\Exception\RuntimeException;
use Mailchimp\Message\MessageCollectionInterface;
use Mailchimp\Message\MessageInterface;
use phpDocumentor\Reflection\DocBlock;
use Psr\Http\Message\StreamInterface;

class JsonHydrator
{
    /**
     * @var MessageInterface $object
     */
    private $object;

    private $basicTypes = ['string', 'bool', 'boolean', 'int', 'integer', 'bool|string', 'mixed'];

    /**
     * TODO: tohle hodit někam do konfigurace
     *
     * @var string $baseNS
     */
    private $baseNS = 'Mailchimp\\Message';

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * @param string $data JSON
     * @param bool $newObject
     *
     * @return MessageInterface
     */
    public function hydrate($data, $newObject = false)
    {
        $array = Json::decode($data);

        if ($newObject) {
            $object = clone $this->object;
        } else {
            $object = $this->object;
        }

        return $this->_doHydrate($object, $array);
    }

    /**
     * @param MessageInterface $object
     * @param array $data
     *
     * @return MessageInterface
     */
    private function _doHydrate(MessageInterface $object, $data)
    {
        $reflected = new \ReflectionClass($object);

        if ($object instanceof MessageCollectionInterface && $object instanceof ArrayCollectionInterface) {
            foreach ($data->{$object->getDataMemberName()} as $singleData) {
                $class = $object->createChildClass();
                $object->add($this->_doHydrate($class, $singleData));
            }
        }

        foreach ($data as $key => $value) {
            if ( $reflected->hasProperty($key)) {
                $property = $reflected->getProperty($key);
                $setter = $this->generateSetter($key);
                $doc = new DocBlock($property);
                if ($doc->hasTag('var')) {
                    $tags = $doc->getTagsByName('var');
                    if (count($tags) !== 1) {
                        throw new RuntimeException('Property "'.$property->getName().'" of class '.$property->getDeclaringClass(). 'has more @var tags. Only one is allowed.');
                    }

                    $type = $tags[0]->getType();

                    switch (true) {
                        /**
                         * Internal type Enum
                         */
                        /*case $type === '\\Enum':
                            $getter = $this->generateGetter($key);
                            $object->{$getter}()->setValue($value);
                            break;*/
                        /**
                         * All basic types
                         */
                        case in_array(strtolower($type), $this->basicTypes, false):
                            $object->{$setter}($value);
                            break;
                        /**
                         * Object types - special cases first
                         */
                        case $type === '\DateTime':
                            $class = new \DateTime($value);
                            $object->{$setter}($class);
                            break;
                        case $type === '\DateTimeZone':
                            if (empty($value)) {
                                continue;
                            }
                            $class = new \DateTimeZone($value);
                            $object->{$setter}($class);
                            break;
                        case !is_array($value) && class_exists($type, true):
                            $class = new $type($value);
                            $object->{$setter}($class);
                            break;
                        /**
                         * Try to find class and hydrate object
                         */
                        default:
                            $possibleClassNames = [];
                            $possibleClassNames[] = $this->baseNS . $type;
                            $possibleClassNames[] = $reflected->getNamespaceName() . $type;
                            $possibleClassNames[] = $type;

                            foreach ($possibleClassNames as $className) {
                                if (class_exists($className, true)) {
                                    $class = new $className;

                                    $hydrated = $this->_doHydrate($class, $value);

                                    $object->{$setter}($hydrated);
                                    continue 2;
                                }
                            }

                            /**
                             * Class not found, we use raw $value.
                             */
                            $object->{$setter}($value);
                            break;
                    }
                }
            } elseif ($key === '_links') {
                foreach($value as $link) {
                    $object->addMethod($link->method, $link->rel, $link->href);
                }
            }
        }

        return $object;
    }

    private function generateGetter($propertyName) {
        return 'get'.Utils::CamelCase($propertyName);
    }

    private function generateSetter($propertyName) {
        return 'set'.Utils::CamelCase($propertyName);
    }
}