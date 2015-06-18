<?php

namespace Mailchimp\Message\Members;

use Mailchimp\Message\AbstractMessage;

class Location extends AbstractMessage
{
    /**
     * @var int $latitude Latitude
     */
    private $latitude;

    /**
     * @var int $longitude Longitude
     */
    private $longitude;

    /**
     * @var int $gmtoff GTM Offset
     */
    private $gmtoff;

    /**
     * @var int $dstoff DST Offset
     */
    private $dstoff;

    /**
     * @var string $country_code Country Code
     */
    private $country_code;

    /**
     * @var \DateTimeZone $timezone Timezone
     */
    private $timezone;

    /**
     * @return int
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param int $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return int
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param int $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return int
     */
    public function getGmtoff()
    {
        return $this->gmtoff;
    }

    /**
     * @param int $gmtoff
     */
    public function setGmtoff($gmtoff)
    {
        $this->gmtoff = $gmtoff;
    }

    /**
     * @return int
     */
    public function getDstoff()
    {
        return $this->dstoff;
    }

    /**
     * @param int $dstoff
     */
    public function setDstoff($dstoff)
    {
        $this->dstoff = $dstoff;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * @param string $country_code
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param \DateTimeZone $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
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