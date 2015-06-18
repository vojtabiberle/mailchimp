<?php

use Mailchimp\Common\Json;

include('../vendor/autoload.php');
include('api_keys.php');

$client = new Mailchimp\Client(APIKEY);

$accountDetails = $client->getAccountDetails();

$subscriberListCollection = $client->getLists();

$subscriberList = $client->getList(LIST_ID);

$jocho = $client->getMember(LIST_ID, md5(TEST_EMAIL));

$members = $subscriberList->getMembers();

$member = $members->findMembers(['email_address' => TEST_EMAIL]);

/**
 * @var Mailchimp\Message\Members $newMember
 */
$newMember = $client->createMessage('Members');

$newMember->setEmailAddress(TEST_EMAIL2);
$newMember->setStatus('subscribed');

$reallyNewMember = $members->create($newMember);

/**
 * @var Mailchimp\Message\Members $vojta
 */
$vojta = $client->getMember(LIST_ID, md5(TEST_EMAIL2));

$vojta->setVip(true);
$vojta->setLanguage('cs');
$vojta->update();

//$vojta->delete();


$encoded = Json::encode($member[0]);

$member[0]->setEmailAddress('email');
$member[0]->save();

//$subscriberList->addMember(new \Mailchimp\Message\Members());
