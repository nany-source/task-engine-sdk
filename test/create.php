<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use B2Sign\TaskEngineSdk\TaskEngine;

$apiEndpoint = 'http://10.0.0.24/api/sdk';
$appKey = 'test';
$appSecret = 'test';

$taskEngine = new TaskEngine($apiEndpoint, $appKey, $appSecret);

$task = $taskEngine->setType('type_name')
    ->setCallbackUrl('https://your-callback-url.com')
    ->setPriority('normal')
    ->setUnique([ 'key' => 'value' ])
    ->setKeepAlive(true)
    ->setQueueData([
      'queue1' => [ 1, 2, 3 ],
      'queue2' => [ 'a', 'b', 'c' ],
    ])
    ->setData([
      'foo' => 'bar',
    ])
    ->setTask('task-id')  // Optional for creating keep-alive tasks
    ->create();

echo 'Create task: ' . $task->id . PHP_EOL;
