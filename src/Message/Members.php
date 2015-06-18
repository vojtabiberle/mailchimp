<?php

namespace Mailchimp\Message;

use Mailchimp\Common\Enum;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Worker;

class Members extends AbstractMessage
{
    protected $__endpoint = '/lists/{list_id}/members/{member_id}';
    protected $__httpVerbs = [HttpVerbs::GET, HttpVerbs::PATCH, HttpVerbs::DELETE];

    /**
     * The list-specific ID for the given email address
     *
     * @var string $id Email ID
     */
    private $id;

    /**
     * Email address for a subscriber
     *
     * @var string $email_address Email Address
     */
    private $email_address;

    /**
     * An identifier for the address across all of MailChimp.
     *
     * @var string $unique_email_id Unique Email ID
     */
    private $unique_email_id;

    /**
     * Type of email this member asked to get ('html' or 'text')
     *
     * @var string $email_type Email Type
     */
    private $email_type;

    /**
     * Subscriber's current status ('subscribed', 'unsubscribed', 'cleaned', or 'pending')
     *
     * @var Enum $status Status
     */
    private $status;

    /**
     * An individual merge var and value for a member.
     *
     * @var mixed $merge_fields Member Merge Var
     */
    private $merge_fields;

    /**
     * The key of this object's properties is the ID of the interest in question.
     *
     * @var mixed $interests Subscriber Interests
     */
    private $interests;

    /**
     * General open rates for this subscriber.
     *
     * @var Members\Stats $stats Subscriber Stats
     */
    private $stats;

    /**
     * IP address the subscriber signed up from
     *
     * @var string $ip_signup Signup IP
     */
    private $ip_signup;

    /**
     * Date and time the subscriber signed up for the list
     *
     * @var string $timestamp_signup Signup Timestamp
     */
    private $timestamp_signup;

    /**
     * IP address the subscriber confirmed their opt-in status
     *
     * @var string $ip_opt Opt-in IP
     */
    private $ip_opt;

    /**
     * Date and time the subscribe confirmed their opt-in status
     *
     * @var string $timestamp_opt Opt-in Timestamp
     */
    private $timestamp_opt;

    /**
     * Star rating for this member between 1 and 5
     *
     * @var int $member_rating Member Rating
     */
    private $member_rating;

    /**
     * Date and time the member's info was last changed
     *
     * @var string $last_changed Last Changed Date
     */
    private $last_changed;

    /**
     * If set/detected, the language of the subscriber
     *
     * @var string $language Language
     */
    private $language;

    /**
     * VIP status for subscriber
     *
     * @var boolean $vip VIP
     */
    private $vip;

    /**
     * The email client we've track the address as using
     *
     * @var string $email_client Email Client
     */
    private $email_client;

    /**
     * Subscriber location information
     *
     * @var Members\Location $location Location
     */
    private $location;

    /**
     * The most recent Note added about this member
     *
     * @var Members\Notes $last_note Notes
     */
    private $last_note;

    /**
     * The id for the list.
     *
     * @var string $list_id List ID
     */
    private $list_id;

    public function __construct(Worker $worker)
    {
        parent::__construct($worker);
        $this->status = new Enum(['subscribed', 'unsubscribed', 'cleaned', 'pending']);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }

    /**
     * @param string $email_address
     */
    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
    }

    /**
     * @return string
     */
    public function getUniqueEmailId()
    {
        return $this->unique_email_id;
    }

    /**
     * @param string $unique_email_id
     */
    public function setUniqueEmailId($unique_email_id)
    {
        $this->unique_email_id = $unique_email_id;
    }

    /**
     * @return string
     */
    public function getEmailType()
    {
        return $this->email_type;
    }

    /**
     * @param string $email_type
     */
    public function setEmailType($email_type)
    {
        $this->email_type = $email_type;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status->getValue();
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status->setValue($status);
    }

    /**
     * @return mixed
     */
    public function getMergeFields()
    {
        return $this->merge_fields;
    }

    /**
     * @param mixed $merge_fields
     */
    public function setMergeFields($merge_fields)
    {
        $this->merge_fields = $merge_fields;
    }

    /**
     * @return mixed
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * @param mixed $interests
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    /**
     * @return Members\Stats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param Members\Stats $stats
     */
    public function setStats($stats)
    {
        $this->stats = $stats;
    }

    /**
     * @return string
     */
    public function getIpSignup()
    {
        return $this->ip_signup;
    }

    /**
     * @param string $ip_signup
     */
    public function setIpSignup($ip_signup)
    {
        $this->ip_signup = $ip_signup;
    }

    /**
     * @return string
     */
    public function getTimestampSignup()
    {
        return $this->timestamp_signup;
    }

    /**
     * @param string $timestamp_signup
     */
    public function setTimestampSignup($timestamp_signup)
    {
        $this->timestamp_signup = $timestamp_signup;
    }

    /**
     * @return string
     */
    public function getIpOpt()
    {
        return $this->ip_opt;
    }

    /**
     * @param string $ip_opt
     */
    public function setIpOpt($ip_opt)
    {
        $this->ip_opt = $ip_opt;
    }

    /**
     * @return string
     */
    public function getTimestampOpt()
    {
        return $this->timestamp_opt;
    }

    /**
     * @param string $timestamp_opt
     */
    public function setTimestampOpt($timestamp_opt)
    {
        $this->timestamp_opt = $timestamp_opt;
    }

    /**
     * @return int
     */
    public function getMemberRating()
    {
        return $this->member_rating;
    }

    /**
     * @param int $member_rating
     */
    public function setMemberRating($member_rating)
    {
        $this->member_rating = $member_rating;
    }

    /**
     * @return string
     */
    public function getLastChanged()
    {
        return $this->last_changed;
    }

    /**
     * @param string $last_changed
     */
    public function setLastChanged($last_changed)
    {
        $this->last_changed = $last_changed;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return boolean
     */
    public function getVip()
    {
        return $this->vip;
    }

    /**
     * @param boolean $vip
     */
    public function setVip($vip)
    {
        $this->vip = $vip;
    }

    /**
     * @return string
     */
    public function getEmailClient()
    {
        return $this->email_client;
    }

    /**
     * @param string $email_client
     */
    public function setEmailClient($email_client)
    {
        $this->email_client = $email_client;
    }

    /**
     * @return Members\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Members\Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return Members\Notes
     */
    public function getLastNote()
    {
        return $this->last_note;
    }

    /**
     * @param Members\Notes $last_note
     */
    public function setLastNote($last_note)
    {
        $this->last_note = $last_note;
    }

    /**
     * @return string
     */
    public function getListId()
    {
        return $this->list_id;
    }

    /**
     * @param string $list_id
     */
    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }

    public function createRequestParams()
    {
        return [
            'list_id' => $this->getListId(),
            'member_id' => $this->getId()
        ];
    }
}