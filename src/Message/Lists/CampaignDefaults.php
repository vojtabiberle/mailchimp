<?php

namespace Mailchimp\Message\Lists;
use Mailchimp\Message\MessageInterface;

/**
 * Campaign Defaults
 *
 * Default values for campaigns created for this list
 *
 * Class CampaignDefaults
 * @package Mailchimp\Message\Lists
 */
class CampaignDefaults implements MessageInterface
{
    /**
     * The default from name for campaigns sent to this list
     *
     * @var string $from_name Sender's Name
     */
    private $from_name;

    /**
     * the default from email (must be a valid email address) for campaigns sent to this list
     *
     * @var string $from_email Sender's Email Address
     */
    private $from_email;

    /**
     * the default subject line for campaigns sent to this list
     *
     * @var string $subject Subject
     */
    private $subject;

    /**
     * The default language for this lists's forms
     *
     * @var string $language Language
     */
    private $language;

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->from_name;
    }

    /**
     * @param string $from_name
     */
    public function setFromName($from_name)
    {
        $this->from_name = $from_name;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->from_email;
    }

    /**
     * @param string $from_email
     */
    public function setFromEmail($from_email)
    {
        $this->from_email = $from_email;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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

    public function getEndpoint()
    {
        return false;
    }

    public function getAllowedHttpVerbs()
    {
        return false;
    }
}