<?php

namespace Mailchimp\Message\Client;


use Mailchimp\Common\HttpVerbs;
use Mailchimp\Message\AbstractMessage;
use Mailchimp\Message\Contact;
use Mailchimp\Message\MessageInterface;

class AccountDetails extends AbstractMessage
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $__endpoint
     */
    protected $__endpoint = '/';

    /**
     * Available HTTP operations
     *
     * @var array $__httpVerbs
     */
    protected $__httpVerbs = [HttpVerbs::GET];

    /**
     * ======= Mailchimp atributes =========
     */

    /**
     * The id associated with this account.  Used for things like subscribe forms.
     *
     * @var string $accountId User ID
     */
    private $account_id;

    /**
     * The name of the login for this account.
     *
     * @var string $accountName Login Name
     */
    private $account_name;

    /**
     * @var Contact $contact Account Contact
     */
    private $contact;

    /**
     * The date and time of the last login for this account.
     *
     * @var \DateTime $lastLogin Last Login Date
     */
    private $last_login;

    /**
     * The total number of subscribers across all lists in the account.
     *
     * @var int $totalSubscribers Total Subscribers
     */
    private $total_subscribers;

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param string $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->account_name;
    }

    /**
     * @param string $account_name
     */
    public function setAccountName($account_name)
    {
        $this->account_name = $account_name;
    }

    /**
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->last_login;
    }

    /**
     * @param \DateTime $last_login
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }

    /**
     * @return int
     */
    public function getTotalSubscribers()
    {
        return $this->total_subscribers;
    }

    /**
     * @param int $total_subscribers
     */
    public function setTotalSubscribers($total_subscribers)
    {
        $this->total_subscribers = $total_subscribers;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->__endpoint;
    }

    /**
     * @return array
     */
    public function getAllowedHttpVerbs()
    {
        return $this->__httpVerbs;
    }

    public function createRequestParams()
    {
        return null;
    }
}