<?php

namespace Mailchimp\Message\Members;

use Mailchimp\Message\AbstractMessage;

class Stats extends AbstractMessage
{
    /**
     * A subscriber's average open rate.
     *
     * @var int $avg_open_rate Average Open Rate
     */
    private $avg_open_rate;

    /**
     * A subscriber's average clickthrough rate.
     *
     * @var int $avg_click_rate Average Click Rate
     */
    private $avg_click_rate;

    /**
     * @return int
     */
    public function getAvgOpenRate()
    {
        return $this->avg_open_rate;
    }

    /**
     * @param int $avg_open_rate
     */
    public function setAvgOpenRate($avg_open_rate)
    {
        $this->avg_open_rate = $avg_open_rate;
    }

    /**
     * @return int
     */
    public function getAvgClickRate()
    {
        return $this->avg_click_rate;
    }

    /**
     * @param int $avg_click_rate
     */
    public function setAvgClickRate($avg_click_rate)
    {
        $this->avg_click_rate = $avg_click_rate;
    }

    public function getEndpoint()
    {
        return false;
    }

    public function getAllowedHttpVerbs()
    {
        return false;
    }

    public function createRequestParams()
    {
        return null;
    }
}