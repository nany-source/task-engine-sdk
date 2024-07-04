<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use B2Sign\TaskEngineSdk\TaskEngine;

$response = TaskEngine::response();
echo 'Success response: ' . $response . PHP_EOL;

$response = TaskEngine::response()->withMessage('message');
echo 'Success response with message: ' . $response . PHP_EOL;

$response = TaskEngine::response()->withError('error_message');
echo 'Error response: ' . $response . PHP_EOL;

$response = TaskEngine::response()->withError([ 'error_message1', 'error_message2' ]);
echo 'Error response: ' . $response . PHP_EOL;
