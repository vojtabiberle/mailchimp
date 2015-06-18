<?php

namespace Mailchimp\Message;

class MembersCollection extends AbstractMessageCollection
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $endpoint
     */
    protected $endpoint = '/lists/{list_id}/members';

    /**
     * Available HTTP operations
     *
     * @var array $httpVerbs
     */
    protected $httpVerbs = ['GET', 'POST'];

    protected $childClassName = 'Mailchimp\\Message\\Members';
}