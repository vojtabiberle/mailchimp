<?php

namespace Mailchimp\Message;

class Contact extends AbstractMessage implements MessageInterface
{
    /**
     * The company name assocated with the account.
     *
     * @var string $company Company
     */
    private $company;

    /**
     * The street address for the account contact.
     *
     * @var string $addr1 Address Line 1
     */
    private $addr1;

    /**
     * The street address for the account contact.
     *
     * @var string $addr2 Address Line 2
     */
    private $addr2;

    /**
     * The city for the account contact.
     *
     * @var string $city City
     */
    private $city;

    /**
     * The state (if available) for the account contact.
     *
     * @var string $state State
     */
    private $state;

    /**
     * The zip code (if available) for the account contact.
     *
     * @var string $zip Zip code
     */
    private $zip;

    /**
     * The country for the account contact.
     *
     * @var string $country Country
     */
    private $country;

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getAddr1()
    {
        return $this->addr1;
    }

    /**
     * @param string $addr1
     */
    public function setAddr1($addr1)
    {
        $this->addr1 = $addr1;
    }

    /**
     * @return string
     */
    public function getAddr2()
    {
        return $this->addr2;
    }

    /**
     * @param string $addr2
     */
    public function setAddr2($addr2)
    {
        $this->addr2 = $addr2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getEndpoint()
    {
        return false;
    }

    public function getAllowedHttpWerbs()
    {
        return false;
    }
}