<?php

include('../vendor/autoload.php');
include('api_keys.php');

$client = new Mailchimp\Client(APIKEY);

$accountDetails = $client->getAccountDetails();

$subscriberListCollection = $client->getLists();

$subscriberList = $client->getList(LIST_ID);

$jocho = $client->getMember(LIST_ID, md5(TEST_EMAIL));

$members = $subscriberList->getMembers();

$member = $members->findMembers(['email_address' => TEST_EMAIL]);

$member[0]->setEmailAddress('email');
$member[0]->save();

//$subscriberList->addMember(new \Mailchimp\Message\Members());
