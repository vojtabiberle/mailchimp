# Mailchimp v3 PHP API client
Unoficial Mailchimp v3 API client library

## This library is under development
 - event not every endpoins are implemented yet (but you can help me! its easy!)

## Usage

### Get data
```php
$client = new Mailchimp\Client('YOUR-API-KEY-HERE');

$accountDetails = $client->getAccountDetails();

$subscriberListCollection = $client->getLists();

$subscriberList = $client->getList(LIST_ID);

$member1 = $client->getMember(LIST_ID, md5(TEST_EMAIL)); //use API search

$members = $subscriberList->getMembers();

$member2 = $members->findMembers(['email_address' => TEST_EMAIL]); //filter in memory
```

### Create new data
```php
$client = new Mailchimp\Client('YOUR-API-KEY-HERE');

/**
 * This is factory method for Messages.
 * You can create new message like: new Members($client->getWorker());
 */
/**
 * @var Mailchimp\Message\Members $newMember
 */
$newMember = $client->createMessage('Members');

$newMember->setEmailAddress(TEST_EMAIL2);
$newMember->setStatus('subscribed');

$reallyNewMember = $members->create($newMember); //returns same object but with new data from API
```

### Update and delete data
```php
$client = new Mailchimp\Client('YOUR-API-KEY-HERE');

/**
 * @var Mailchimp\Message\Members $member3
 */
$member3 = $client->getMember(LIST_ID, md5(TEST_EMAIL2));

$member3->setVip(true);
$member3->setLanguage('cs');
$member3->update(); //send PATCH request

$member3->delete(); //send DELETE request
```

If something goes wrong, client throw Exceptions. Look into code ;-)
