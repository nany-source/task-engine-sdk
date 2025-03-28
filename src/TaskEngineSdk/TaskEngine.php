<?php

namespace B2Sign\TaskEngineSdk;

/**
 * Class TaskEngine
 * @package B2Sign\TaskEngineSdk
 */
class TaskEngine
{
    protected $apiEndpoint = null;
    protected $appKey = null;
    protected $appSecret = null;
    protected $client = null;

    protected $params = [];

    /**
     * Create a new response instance
     */
    public static function response()
    {
        return new TaskEngineResponse();
    }

    /**
     * TaskEngine constructor.
     * @param $apiEndpoint string API endpoint
     * @param $appKey string App key
     * @param $appSecret string App secret
     */
    public function __construct($apiEndpoint, $appKey, $appSecret)
    {
        $this->apiEndpoint = $apiEndpoint;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;

        // 创建 guzzle client
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->apiEndpoint,
            'headers' => [
                'app-id' => $this->appKey,
                'app-token' => $this->appSecret,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /* Post */
    protected function call($params)
    {
        $response = $this->client->post('', [
            'json' => $params,
        ]);
        $body = json_decode($response->getBody()->getContents(), true);
        if ($body['code'] !== 0) {
            throw new \Exception ($body['message'] ?? 'Unknown error', $body['code']);
        }
        return $body['result'];
    }

    /* Reset */
    protected function reset()
    {
        $this->params = [];
    }

    /**
     * Set task ID
     * @param $taskId string Task ID
     * @return $this
     */
    public function setTask($taskId)
    {
        $this->params['task_id'] = $taskId;
        return $this;
    }

    /**
     * Set task type
     * @param $type string Task type
     * @return $this
     */
    public function setType($type)
    {
        $this->params['type'] = $type;
        return $this;
    }

    /**
     * Set task callback url
     * @param $url string Callback url
     * @return $this
     */
    public function setCallbackUrl($url)
    {
        $this->params['callback_url'] = $url;
        return $this;
    }

    /**
     * Set task priority
     * @param $priority "low"|"normal"|"high" Task priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->params['priority'] = $priority;
        return $this;
    }

    /**
     * Set unique key
     * @param $uniqueKey false|mixed Unique key
     * @return $this
     */
    public function setUnique($uniqueKey)
    {
        $this->params['unique'] = $uniqueKey;
        return $this;
    }

    /**
     * Set if task should be kept alive
     * @param $keepAlive bool Keep alive
     * @return $this
     */
    public function setKeepAlive($keepAlive)
    {
        $this->params['keep_alive'] = boolval($keepAlive);
        return $this;
    }

    /**
     * Set task queue data
     * @param $queueData array Queue data
     * @return $this
     */
    public function setQueueData(array $queueData)
    {
        $this->params['queue_data'] = $queueData;
        return $this;
    }

    /**
     * Set task user data
     * @param $data mixed User data
     * @return $this
     */
    public function setData($data)
    {
        $this->params['data'] = $data;
        return $this;
    }

    /**
     * Set will be over-written unique task user data (only for normal & unique task and pending status)
     * @param $value bool Overwrite mode (default: false)
     * @return $this
     */
    public function setOverWrite($value = false)
    {
        $this->params['rewrite'] = $value;
        return $this;
    }

    /**
     * Create task
     * @return Task $task
     */
    public function create()
    {
        $params = $this->params;
        $params['action'] = 'create';
        $result = $this->call($params);
        $this->reset();
        return new Task($result);
    }

    /**
     * Get task
     */
    public function get()
    {
        $params = $this->params;
        if (empty ($params['task_id'])) {
            return null;
        }
        $params['action'] = 'detail';
        $result = $this->call($params);
        $this->reset();
        return new Task($result);
    }

    /**
     * Write task log
     */
    public function log($message, $level = null)
    {
        $params = $this->params;
        if (empty ($params['task_id'])) {
            return null;
        }
        $params['action'] = 'log';
        $params['level'] = $level ?? 'info';
        $params['message'] = $message;
        $this->call($params);
        $this->reset();
        return true;
    }

    /**
     * Complete task
     */
    public function complete()
    {
        $params = $this->params;
        if (empty ($params['task_id'])) {
            return null;
        }
        $params['action'] = 'complete';
        $result = $this->call($params);
        $this->reset();
        return new Task($result);
    }

    /**
     * Fail task
     */
    public function fail($message = null)
    {
        $params = $this->params;
        if (empty ($params['task_id'])) {
            return null;
        }
        $params['action'] = 'fail';
        $params['message'] = $message;
        $result = $this->call($params);
        $this->reset();
        return new Task($result);
    }
}
