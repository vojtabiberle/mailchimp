<?php

namespace Mailchimp\Message;

use Mailchimp\Common\ArrayCollectionInterface;
use Mailchimp\Common\ArrayCollectionTrait;
use Mailchimp\Worker;

abstract class AbstractMessageCollection extends AbstractMessage implements MessageCollectionInterface, ArrayCollectionInterface
{
    use ArrayCollectionTrait;
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
     * Class name of child stored in this collection
     *
     * @var string $childClassName
     */
    protected $childClassName;

    public function createChildClass()
    {
        return new $this->childClassName($this->getWorker());
    }

    public function getDataMemberName()
    {
        return strtolower(str_replace($this->baseNS.'\\', '', $this->childClassName));
    }
}