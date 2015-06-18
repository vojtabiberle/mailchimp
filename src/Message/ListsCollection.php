<?php

namespace Mailchimp\Message;

class ListsCollection extends AbstractMessageCollection implements MessageCollectionInterface
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $endpoint
     */
    protected $endpoint = '/lists/';

    /**
     * Available HTTP operations
     *
     * @var array $httpVerbs
     */
    protected $httpVerbs = ['GET', 'POST'];

    protected $childClassName = 'Mailchimp\\Message\\Lists';

}