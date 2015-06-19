<?php

namespace Mailchimp\Message\Lists;
use Mailchimp\Message\AbstractMessage;

/**
 * Statistics
 *
 * various stats and counts for the list - many of these are cached for at least 5 minutes
 *
 * Class Stats
 * @package Mailchimp\Message\Lists
 */
class Stats extends AbstractMessage
{
    /**
     * The number of active members in the given list.
     *
     * @var int $member_count Member Count
     */
    private $member_count;

    /**
     *The number of members who have unsubscribed from the given list.
     *
     * @var int $unsubscribe_count Unsubscribe Count
     */
    private $unsubscribe_count;

    /**
     * The number of members cleaned from the given list.
     *
     * @var int $cleaned_count Cleaned Count
     */
    private $cleaned_count;

    /**
     * The number of active members in the given list since the last campaign was sent
     *
     * @var int $member_count_since_send Member Count Since Send
     */
    private $member_count_since_send;

    /**
     * The number of members who have unsubscribed since the last campaign was sent
     *
     * @var int $unsubscribe_count_since_send Unsubscribe Count Since Send
     */
    private $unsubscribe_count_since_send;

    /**
     * The number of members cleaned from the given list since the last campaign was sent
     *
     * @var int $cleaned_count_since_send Cleaned Count Since Send
     */
    private $cleaned_count_since_send;

    /**
     * The number of campaigns in any status that use this list.
     *
     * @var int $campaign_count Campaign Count
     */
    private $campaign_count;

    /**
     * The date and time the last campaign was sent to this list.
     *
     * @var \DateTime $campaign_last_sent Campaign Last Sent
     */
    private $campaign_last_sent;

    /**
     * The number of merge vars for this list (not including the required EMAIL one)
     *
     * @var int $merge_field_count Merge Var Count
     */
    private $merge_field_count;

    /**
     * The average number of subscriptions per month for the list (not returned if we haven't calculated it yet)
     *
     * @var int $avg_sub_rate Average Subscription Rate
     */
    private $avg_sub_rate;

    /**
     * The average number of unsubscriptions per month for the list (not returned if we haven't calculated it yet)
     *
     * @var int $avg_unsub_rate Average Unsubscription Rate
     */
    private $avg_unsub_rate;

    /**
     * The target numberof subscriptions per month for the list to keep it growing (not returned if we haven't calculated it yet)
     *
     * @var int $target_sub_rate Average Subscription Rate
     */
    private $target_sub_rate;

    /**
     * The average open rate (a percentage represented as a number between 0 and 100) per campaign for the list (not returned if we haven't calculated it yet)
     *
     * @var int $open_rate Open Rate
     */
    private $open_rate;

    /**
     * The average click rate (a percentage represented as a number between 0 and 100) per campaign for the list (not returned if we haven't calculated it yet)
     *
     * @var int $click_rate Click Rate
     */
    private $click_rate;

    /**
     * The date and time of the last time someone subscribed to this list.
     *
     * @var \DateTime $last_sub_date Date of Last List Subscribe
     */
    private $last_sub_date;

    /**
     * The date and time of the last time someone unsubscribed from this list.
     *
     * @var \DateTime $last_unsub_date Date of Last List Unsubscribe
     */
    private $last_unsub_date;

    /**
     * @return int
     */
    public function getMemberCount()
    {
        return $this->member_count;
    }

    /**
     * @param int $member_count
     */
    public function setMemberCount($member_count)
    {
        $this->member_count = $member_count;
    }

    /**
     * @return int
     */
    public function getUnsubscribeCount()
    {
        return $this->unsubscribe_count;
    }

    /**
     * @param int $unsubscribe_count
     */
    public function setUnsubscribeCount($unsubscribe_count)
    {
        $this->unsubscribe_count = $unsubscribe_count;
    }

    /**
     * @return int
     */
    public function getCleanedCount()
    {
        return $this->cleaned_count;
    }

    /**
     * @param int $cleaned_count
     */
    public function setCleanedCount($cleaned_count)
    {
        $this->cleaned_count = $cleaned_count;
    }

    /**
     * @return int
     */
    public function getMemberCountSinceSend()
    {
        return $this->member_count_since_send;
    }

    /**
     * @param int $member_count_since_send
     */
    public function setMemberCountSinceSend($member_count_since_send)
    {
        $this->member_count_since_send = $member_count_since_send;
    }

    /**
     * @return int
     */
    public function getUnsubscribeCountSinceSend()
    {
        return $this->unsubscribe_count_since_send;
    }

    /**
     * @param int $unsubscribe_count_since_send
     */
    public function setUnsubscribeCountSinceSend($unsubscribe_count_since_send)
    {
        $this->unsubscribe_count_since_send = $unsubscribe_count_since_send;
    }

    /**
     * @return int
     */
    public function getCleanedCountSinceSend()
    {
        return $this->cleaned_count_since_send;
    }

    /**
     * @param int $cleaned_count_since_send
     */
    public function setCleanedCountSinceSend($cleaned_count_since_send)
    {
        $this->cleaned_count_since_send = $cleaned_count_since_send;
    }

    /**
     * @return int
     */
    public function getCampaignCount()
    {
        return $this->campaign_count;
    }

    /**
     * @param int $campaign_count
     */
    public function setCampaignCount($campaign_count)
    {
        $this->campaign_count = $campaign_count;
    }

    /**
     * @return \DateTime
     */
    public function getCampaignLastSent()
    {
        return $this->campaign_last_sent;
    }

    /**
     * @param \DateTime $campaign_last_sent
     */
    public function setCampaignLastSent($campaign_last_sent)
    {
        $this->campaign_last_sent = $campaign_last_sent;
    }

    /**
     * @return int
     */
    public function getMergeFieldCount()
    {
        return $this->merge_field_count;
    }

    /**
     * @param int $merge_field_count
     */
    public function setMergeFieldCount($merge_field_count)
    {
        $this->merge_field_count = $merge_field_count;
    }

    /**
     * @return int
     */
    public function getAvgSubRate()
    {
        return $this->avg_sub_rate;
    }

    /**
     * @param int $avg_sub_rate
     */
    public function setAvgSubRate($avg_sub_rate)
    {
        $this->avg_sub_rate = $avg_sub_rate;
    }

    /**
     * @return int
     */
    public function getAvgUnsubRate()
    {
        return $this->avg_unsub_rate;
    }

    /**
     * @param int $avg_unsub_rate
     */
    public function setAvgUnsubRate($avg_unsub_rate)
    {
        $this->avg_unsub_rate = $avg_unsub_rate;
    }

    /**
     * @return int
     */
    public function getTargetSubRate()
    {
        return $this->target_sub_rate;
    }

    /**
     * @param int $target_sub_rate
     */
    public function setTargetSubRate($target_sub_rate)
    {
        $this->target_sub_rate = $target_sub_rate;
    }

    /**
     * @return int
     */
    public function getOpenRate()
    {
        return $this->open_rate;
    }

    /**
     * @param int $open_rate
     */
    public function setOpenRate($open_rate)
    {
        $this->open_rate = $open_rate;
    }

    /**
     * @return int
     */
    public function getClickRate()
    {
        return $this->click_rate;
    }

    /**
     * @param int $click_rate
     */
    public function setClickRate($click_rate)
    {
        $this->click_rate = $click_rate;
    }

    /**
     * @return \DateTime
     */
    public function getLastSubDate()
    {
        return $this->last_sub_date;
    }

    /**
     * @param \DateTime $last_sub_date
     */
    public function setLastSubDate($last_sub_date)
    {
        $this->last_sub_date = $last_sub_date;
    }

    /**
     * @return \DateTime
     */
    public function getLastUnsubDate()
    {
        return $this->last_unsub_date;
    }

    /**
     * @param \DateTime $last_unsub_date
     */
    public function setLastUnsubDate($last_unsub_date)
    {
        $this->last_unsub_date = $last_unsub_date;
    }


    public function getEndpoint()
    {
        return false;
    }

    public function getAllowedHttpVerbs()
    {
        return false;
    }

    public function getDefaultParams()
    {
        return [];
    }
}