<?php

namespace Mailchimp\Message;

class ListsCollection extends AbstractMessageCollection
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $__endpoint
     */
    protected $__endpoint = '/lists/';

    /**
     * Available HTTP operations
     *
     * @var array $__httpVerbs
     */
    protected $__httpVerbs = ['GET', 'POST'];

    protected $__childClassName = 'Mailchimp\\Message\\Lists';

}