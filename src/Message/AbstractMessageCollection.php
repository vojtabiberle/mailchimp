<?php

namespace Mailchimp\Message;

use Mailchimp\Common\ArrayCollectionInterface;
use Mailchimp\Common\ArrayCollectionTrait;
use Mailchimp\Worker;

abstract class AbstractMessageCollection extends AbstractMessage implements MessageCollectionInterface, ArrayCollectionInterface
{
    /**
     * The total number of items matching the query, irrespective of pagination.
     *
     * @var int $total_items Item Count
     */
    private $total_items;

    use ArrayCollectionTrait;
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
     * Class name of child stored in this collection
     *
     * @var string $__childClassName
     */
    protected $__childClassName;

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return $this->total_items;
    }

    /**
     * @param int $total_items
     */
    public function setTotalItems($total_items)
    {
        $this->total_items = $total_items;
    }

    public function isChild(MessageInterface $object)
    {
        return $this->__childClassName === get_class($object);
    }

    public function createChildClass()
    {
        return new $this->__childClassName($this->getWorker());
    }

    public function getDataMemberName()
    {
        return strtolower(str_replace($this->__baseNS.'\\', '', $this->__childClassName));
    }

    public function jsonSerialize() {
        $tmp = [];
        foreach ($this->__elements as $element) {
            $tmp[] = $element->jsonSerialize();
        }

        return $tmp;
    }

    public function getDefaultParams()
    {
        return [];
    }
}