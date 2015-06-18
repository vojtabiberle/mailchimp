<?php


namespace Mailchimp\Message;


interface MessageCollectionInterface extends MessageInterface {
    public function createChildClass();
    public function getDataMemberName();
}