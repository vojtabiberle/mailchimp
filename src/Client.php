<?php
namespace Mailchimp;

use Mailchimp\Exception\Exception;
use Mailchimp\Exception\RuntimeException;
use Mailchimp\Message\Client\AccountDetails;
use Mailchimp\Message\Lists;
use Mailchimp\Message\ListsCollection;
use Mailchimp\Message\Members;

class Client
{
    private $worker;

    /**
     * TODO: Předávat instanci Handleru kvůli testování a možnosti výběru Handleru
     *  - při testování se vloží Mock Handleru, který bude na určité requesty vracet stále stejná data
     * @param $apikey
     */
    public function __construct($apikey)
    {
        $this->worker = new Worker($apikey);
    }

    public function createMessage($name)
    {
        $possibleNames[] = $name;
        $possibleNames[] = '\\Mailchimp\\Message\\'.ucfirst($name);

        foreach ($possibleNames as $className)
        {
            if (class_exists($className, true)) {
                return new $className($this->worker);
            }
        }

        throw new RuntimeException('Class not found: '.$name);
    }

    public function getWorker()
    {
        return $this->worker;
    }

    /**
     * @return Message\Client\AccountDetails
     */
    public function getAccountDetails()
    {
        return $this->worker->load(new AccountDetails($this->worker));
    }

    /**
     * @param array $options
     * @return Message\Lists[]
     */
    public function getLists($options = [])
    {
        return $this->worker->load(new ListsCollection($this->worker), $options);
    }

    /**
     * @param $listId
     *
     * @return Message\Lists
     */
    public function getList($listId)
    {
        return $this->worker->load(new Lists($this->worker), ['params' => ['list_id' => $listId]]);
    }

    public function getMember($listId, $memberId)
    {
        return $this->worker->load(new Members($this->worker), ['params' => ['list_id' => $listId, 'member_id' => $memberId]]);
    }

    /**
     * @return Message\Report[]
     */
    public function getReports()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @param $reportId
     *
     * @return Message\Report
     */
    public function getReport($reportId)
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @return Message\Conversation[]
     */
    public function getConversations()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @param $conversationId
     *
     * @return Message\Conversation
     */
    public function getConversation($conversationId)
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @return Message\Campaign[]
     */
    public function getCampaigns()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @param $campaignId
     *
     * @return Message\Campaign
     */
    public function getCampaign($campaignId)
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @return Message\Automation[]
     */
    public function getAutomations()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @param $automationId
     *
     * @return Message\Automation
     */
    public function getAutomation($automationId)
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @return Message\Template[]
     */
    public function getTemplates()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @param $templateId
     *
     * @return Message\Template
     */
    public function getTemplate($templateId)
    {
        throw new Exception('Not implemented yet');
    }

    public function getFileManager()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @return Message\AuthorizedApp[]
     */
    public function getAuthorizedApps()
    {
        throw new Exception('Not implemented yet');
    }

    /**
     * @param $appId
     *
     * @return Message\AuthorizedApp
     */
    public function getAuthorizedApp($appId)
    {
        throw new Exception('Not implemented yet');
    }
}