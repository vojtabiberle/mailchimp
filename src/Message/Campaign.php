<?php

namespace Mailchimp\Message;
use Mailchimp\Common\Enum;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Worker;

/**
 * https://us9.api.mailchimp.com/schema/3.0/Campaigns/Instance.json
 *
 * Class Campaign
 * @package Mailchimp\Message
 */
class Campaign extends AbstractMessage implements MessageInterface
{
    /**
     * Endpoint string relative to API URL
     *
     * @var string $endpoint
     */
    protected $endpoint = '/campaigns/{id}';

    /**
     * Available HTTP operations
     *
     * @var array $httpVerbs
     */
    protected $httpVerbs = [HttpVerbs::GET, HttpVerbs::DELETE];

    /**
     * ======= Mailchimp atributes =========
     */

    /**
     * A string that uniquely identifies this campaign.
     *
     * @var string $id Campaing ID
     */
    private $id;

    /**The type of campaign (regular, plain-text, ab_split, rss, or automation).
     *
     * @var Enum $type Campaign Type ['regular','plain-text','absplit','rss']
     */
    private $type;

    /**
     * The date and time the campaign was created.
     *
     * @var \DateTime $createTime Create Time
     */
    private $create_time;

    /**
     * The link to the campaign's archive version.
     *
     * @var string $archiveUrl Archive URL
     */
    private $archive_url;

    /**
     * The current status of the campaign ('save', 'paused', 'schedule', 'sending', 'sent').
     *
     * @var Enum $status Campaign Status ['save', 'paused', 'schedule', 'sending', 'sent']
     */
    private $status;

    /**
     * The total number of emails sent for this campaign.
     *
     * @var int $emailsSent Emails Sent
     */
    private $emails_sent;

    /**
     * The time and date a campaign was sent.
     *
     * @var \DateTime $sendTime Send Time
     */
    private $send_time;

    /**
     * How the campaign's content is put together ('template', 'drag_and_drop', 'html', 'url').
     *
     * @var string $contentType Content Type
     */
    private $content_type;

    /**
     * List settings for the campaign.
     *
     * @var Recipient[] $recipients List
     */
    private $recipients;

    /**
     * @var Campaign\Setting $settings Campaign Settings
     */
    private $settings;

    /**The tracking options for a campaign.
     *
     * @var Campaign\Tracking $tracking Campiagn Tracking Options
     */
    private $tracking;

    /**
     * RSS-specific options for a campaign.
     *
     * @var Campaign\RssOpts $rssOpts RSS Options
     */
    private $rss_opts;

    /**
     * AB Split-specific options for a campaign.
     *
     * @var Campaign\AbSplitOpts $abSplitOpts AB Split Options
     */
    private $ab_split_opts;

    /**
     * The preview for the campaign as rendered by social networks like Facebook and Twitter.
     *
     * @var Campaign\SocialCard $socialCard Campaign Social Card
     */
    private $social_card;

    /**
     * For sent campaigns, a summary of opens, clicks, and unsubscribes.
     *
     * @var Campaign\ReportSummary $reportSummary Campaign Report Summary
     */
    private $report_summary;

    public function __construct(Worker $worker)
    {
        parent::__construct($worker);
        $this->type = new Enum(['regular','plain-text','absplit','rss']);
        $this->status = new Enum(['save', 'paused', 'schedule', 'sending', 'sent']);
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
     * @return Enum
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Enum $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * @param \DateTime $create_time
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
    }

    /**
     * @return string
     */
    public function getArchiveUrl()
    {
        return $this->archive_url;
    }

    /**
     * @param string $archive_url
     */
    public function setArchiveUrl($archive_url)
    {
        $this->archive_url = $archive_url;
    }

    /**
     * @return Enum
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Enum $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getEmailsSent()
    {
        return $this->emails_sent;
    }

    /**
     * @param int $emails_sent
     */
    public function setEmailsSent($emails_sent)
    {
        $this->emails_sent = $emails_sent;
    }

    /**
     * @return \DateTime
     */
    public function getSendTime()
    {
        return $this->send_time;
    }

    /**
     * @param \DateTime $send_time
     */
    public function setSendTime($send_time)
    {
        $this->send_time = $send_time;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @param string $content_type
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
    }

    /**
     * @return Recipient[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param Recipient[] $recipients
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    }

    /**
     * @return Campaign\Setting
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param Campaign\Setting $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return Campaign\Tracking
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * @param Campaign\Tracking $tracking
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;
    }

    /**
     * @return Campaign\RssOpts
     */
    public function getRssOpts()
    {
        return $this->rss_opts;
    }

    /**
     * @param Campaign\RssOpts $rss_opts
     */
    public function setRssOpts($rss_opts)
    {
        $this->rss_opts = $rss_opts;
    }

    /**
     * @return Campaign\AbSplitOpts
     */
    public function getAbSplitOpts()
    {
        return $this->ab_split_opts;
    }

    /**
     * @param Campaign\AbSplitOpts $ab_split_opts
     */
    public function setAbSplitOpts($ab_split_opts)
    {
        $this->ab_split_opts = $ab_split_opts;
    }

    /**
     * @return Campaign\SocialCard
     */
    public function getSocialCard()
    {
        return $this->social_card;
    }

    /**
     * @param Campaign\SocialCard $social_card
     */
    public function setSocialCard($social_card)
    {
        $this->social_card = $social_card;
    }

    /**
     * @return Campaign\ReportSummary
     */
    public function getReportSummary()
    {
        return $this->report_summary;
    }

    /**
     * @param Campaign\ReportSummary $report_summary
     */
    public function setReportSummary($report_summary)
    {
        $this->report_summary = $report_summary;
    }
}