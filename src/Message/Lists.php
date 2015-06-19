<?php

namespace Mailchimp\Message;

use Mailchimp\Common\Enum;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Worker;

class Lists extends AbstractMessage
{
    protected $__endpoint = '/lists/{list_id}';
    protected $__httpVerbs = [HttpVerbs::GET, HttpVerbs::PATCH, HttpVerbs::DELETE];

    /**
     * A string that uniquely identifies this list
     *
     * @var string $id List ID
     */
    private $id;

    /**
     * @var string $name List Name
     */
    private $name;

    /**
     * displayed in campaign footers to comply with international spam laws
     *
     * @var Contact $contact List Contact
     */
    private $contact;

    /**
     * @var string $permissionReminder Permission Reminder
     */
    private $permission_reminder;

    /**
     * Whether or not campaigns for this list use the Archive Bar in archives by default
     *
     * @var bool $useArchiveBar Use Archive Bar
     */
    private $use_archive_bar = false;

    /**
     * Default values for campaigns created for this list
     *
     * @var Lists\CampaignDefaults $campaignDefaults Campaign Defaults
     */
    private $campaign_defaults;

    /**
     * the email address to send subscribe notifications to, when enabled
     *
     * @var bool|string $notifyOnSubscribe Notify on Subscribe
     */
    private $notify_on_subscribe = false;

    /**
     * the email address to send unsubscribe notifications to, when enabled
     *
     * @var bool|string $notifyOnUnsubscribe Notify on Unsubscribe
     */
    private $notify_on_unsubscribe = false;

    /**
     * The date and time that this list was created
     *
     * @var \DateTime $dateCreated Creation Date
     */
    private $date_created;

    /**
     * An auto-generated activity score for the list (0-5)
     *
     * @var int $listRating List Rating
     */
    private $list_rating;

    /**
     * Whether or not the list supports multiple formats ofr emails or just HTML (which is true and which is false?)
     *
     * @var bool $emailTypeOption Email Type Option
     */
    private $email_type_option;

    /**
     * Our eepurl shortened version of this list's subscribe from (host will vary)
     *
     * @var string $subscribeUrlShort Subscribe URL Short
     */
    private $subscribe_url_short;

    /**
     * The full version of this list's subscribe form (host will vary)
     *
     * @var string $subscribeUrlLong Subscribe URL Long
     */
    private $subscribe_url_long;

    /**
     * The email address to use for this list's Email Beamer
     *
     * @var string $beamerAddress Beamer Address
     */
    private $beamer_address;

    /**
     * Whether this list is Public (pub) or Private (prv).  Used internally for projects like Wavelength
     *
     * @var Enum $visibility Visibility ["pub", "prv"]
     */
    private $visibility;

    /**
     * Any list specific modules installed for this list (example is SocialPro)
     *
     * @var string[] $modules Modules
     */
    private $modules;

    /**
     * various stats and counts for the list - many of these are cached for at least 5 minutes
     *
     * @var Lists\Stats $stats Statistics
     */
    private $stats;

    public function __construct(Worker $worker)
    {
        parent::__construct($worker);
        $this->visibility = new Enum(['pub', 'priv']);
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return string
     */
    public function getPermissionReminder()
    {
        return $this->permission_reminder;
    }

    /**
     * @param string $permission_reminder
     */
    public function setPermissionReminder($permission_reminder)
    {
        $this->permission_reminder = $permission_reminder;
    }

    /**
     * @return boolean
     */
    public function getUseArchiveBar()
    {
        return $this->use_archive_bar;
    }

    /**
     * @param boolean $use_archive_bar
     */
    public function setUseArchiveBar($use_archive_bar)
    {
        $this->use_archive_bar = $use_archive_bar;
    }

    /**
     * @return Lists\CampaignDefaults
     */
    public function getCampaignDefaults()
    {
        return $this->campaign_defaults;
    }

    /**
     * @param Lists\CampaignDefaults $campaign_defaults
     */
    public function setCampaignDefaults($campaign_defaults)
    {
        $this->campaign_defaults = $campaign_defaults;
    }

    /**
     * @return bool|string
     */
    public function getNotifyOnSubscribe()
    {
        return $this->notify_on_subscribe;
    }

    /**
     * @param bool|string $notify_on_subscribe
     */
    public function setNotifyOnSubscribe($notify_on_subscribe)
    {
        $this->notify_on_subscribe = $notify_on_subscribe;
    }

    /**
     * @return bool|string
     */
    public function getNotifyOnUnsubscribe()
    {
        return $this->notify_on_unsubscribe;
    }

    /**
     * @param bool|string $notify_on_unsubscribe
     */
    public function setNotifyOnUnsubscribe($notify_on_unsubscribe)
    {
        $this->notify_on_unsubscribe = $notify_on_unsubscribe;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param \DateTime $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return int
     */
    public function getListRating()
    {
        return $this->list_rating;
    }

    /**
     * @param int $list_rating
     */
    public function setListRating($list_rating)
    {
        $this->list_rating = $list_rating;
    }

    /**
     * @return boolean
     */
    public function getEmailTypeOption()
    {
        return $this->email_type_option;
    }

    /**
     * @param boolean $email_type_option
     */
    public function setEmailTypeOption($email_type_option)
    {
        $this->email_type_option = $email_type_option;
    }

    /**
     * @return string
     */
    public function getSubscribeUrlShort()
    {
        return $this->subscribe_url_short;
    }

    /**
     * @param string $subscribe_url_short
     */
    public function setSubscribeUrlShort($subscribe_url_short)
    {
        $this->subscribe_url_short = $subscribe_url_short;
    }

    /**
     * @return string
     */
    public function getSubscribeUrlLong()
    {
        return $this->subscribe_url_long;
    }

    /**
     * @param string $subscribe_url_long
     */
    public function setSubscribeUrlLong($subscribe_url_long)
    {
        $this->subscribe_url_long = $subscribe_url_long;
    }

    /**
     * @return string
     */
    public function getBeamerAddress()
    {
        return $this->beamer_address;
    }

    /**
     * @param string $beamer_address
     */
    public function setBeamerAddress($beamer_address)
    {
        $this->beamer_address = $beamer_address;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility->getValue();
    }

    /**
     * @param string $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility->setValue($visibility);
    }

    /**
     * @return \string[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @param \string[] $modules
     */
    public function setModules($modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return Lists\Stats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param Lists\Stats $stats
     */
    public function setStats($stats)
    {
        $this->stats = $stats;
    }

    public function getDefaultParams()
    {
        return [
            'list_id' => $this->getId()
        ];
    }
}