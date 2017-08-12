<?php

namespace Liliom\Firebase;

class FirebaseMessage
{
    const PRIORITY = [
        'NORMAL' => 'normal',
        'HIGH' => 'high',
    ];

    /**
     * @var array
     */
    const OPTIONS_GETTERS = [
        'getData' => 'data',
        'getPriority' => 'priority',
        'getTimeToLive' => 'time_to_live',
        'getCollapseKey' => 'collapse_key',
        'getNotification' => 'notification',
        'getCondition' => 'condition',
        'getContentAvailable' => 'content_available',
        'getMutableContent' => 'mutable_content',
        'getPackageName' => 'restricted_package_name',
    ];

    /**
     * @var mixed
     */
    protected $recipient;

    /**
     * @var mixed
     */
    protected $notification;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string high|normal
     */
    private $priority = self::PRIORITY['NORMAL'];

    /**
     * @var int
     */
    private $timeToLive;

    /**
     * @var string
     */
    private $condition;

    /**
     * @var string
     */
    private $collapseKey;

    /**
     * @var boolean
     */
    private $contentAvailable;

    /**
     * @var boolean
     */
    private $mutableContent;

    /**
     * @var string
     */
    private $packageName;

    /**
     * Recipient.
     *
     * @return $this
     */
    public function to($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get Recipient.
     *
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set timeToLive
     *
     * @param int $time
     * @return $this
     */
    public function setTimeToLive($time)
    {
        $this->timeToLive = $time;

        return $this;
    }

    /**
     * Get timeToLive
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * Set restricted package name
     *
     * @param int $time
     * @return $this
     */
    public function setPackageName($name)
    {
        $this->packageName = $name;

        return $this;
    }

    /**
     * Get packageName
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * The notification object to send to Firebase. `title` and `body` are required.
     * @param array $params ['title' => '', 'body' => '', 'sound' => '', 'icon' => '', 'click_action' => '']
     *
     * @return $this
     */
    public function notification(array $params)
    {
        $this->notification = $params;

        return $this;
    }

    /**
     * Get notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param string $condition
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param string $collapseKey
     * @return $this
     */
    public function setCollapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * @param boolean $contentAvailable
     * @return $this
     */
    public function setContentAvailable($contentAvailable)
    {
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * @param boolean $mutableContent
     * @return $this
     */
    public function setMutableContent($mutableContent)
    {
        $this->mutableContent = $mutableContent;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getMutableContent()
    {
        return $this->mutableContent;
    }

    /**
     * @param array|null $data
     * @return $this
     */
    public function setData($data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return $this
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param high|normal $priority
     *
     * @return $this
     */
    public function setPriority($priority)
    {
        if (isset(self::PRIORITY[strtoupper($priority)])) {
            $this->priority = self::PRIORITY[strtoupper($priority)];
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return string json
     */
    public function payload()
    {
        $payload = [];

        if (is_array($this->getRecipient())) {
            $payload['registration_ids'] = $this->getRecipient();
        } else {
            $payload['to'] = $this->getRecipient();
        }

        foreach (self::OPTIONS_GETTERS as $function => $arrayKey) {
            if (method_exists($this, $function) && count($this->$function())) {
                $payload[$arrayKey] = $this->$function();
            }
        }

        return \GuzzleHttp\json_encode($payload);
    }

    /**
     * Determine if recipient is not given.
     *
     * @return bool
     */
    public function recipientNotGiven()
    {
        return !$this->recipient;
    }
}