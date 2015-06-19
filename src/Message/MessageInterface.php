<?php

namespace Mailchimp\Message;

interface MessageInterface
{
    public function getEndpoint();
    public function getAllowedHttpVerbs();
    public function getDefaultParams();
}