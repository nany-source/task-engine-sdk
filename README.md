# Task Engine SDK
The Task Engine SDK is a PHP library that provides a simple interface to interact with the B2Sign Task Engine API. The SDK is designed to make it easy to create, update, and delete tasks, as well as to retrieve task information.

## Installation
To install the Task Engine SDK, run the following command:

```bash
composer require b2sign/task-engine-sdk
```

## Usage
To use the Task Engine SDK, you must first create an instance of the `TaskEngine` class. You can then use this instance to interact with the Task Engine API.

```php
use B2Sign\TaskEngineSdk\TaskEngine;

$taskEngine = new TaskEngine('api-endpoint', 'your-app-key', 'your-app-secret');
```

### Create a Task
To create a task, use the `create` method. This method takes an array of task data as its only argument.

```php
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
```

#### Reference
- `setType(string $type)`: **REQUIRED** The type of the task.
- `setCallbackUrl(string $callbackUrl)`: **REQUIRED** The URL to which the Task Engine will send a POST request when the task is completed.
- `setPriority(string $priority)`: (Optional, default: `normal`) The priority of the task. Possible values are `low`, `normal`, and `high`.
- `setUnique(array $unique | false)`: (Optional, default: `false`) An array of key-value pairs that uniquely identify the task, or `false` if the task is not unique.
- `setKeepAlive(bool $keepAlive)`: (Optional, default: `false`) Whether the task should be kept alive until it is completed.
- `setQueueData(array $queueData)`: (Optional) An array of key-value pairs that will be stored for the task.
- `setData(array $data)`: (Optional) An array of key-value pairs that will be stored for the task.
- `setTask(string $taskId)`: (Optional) The ID of the task to create when creating a keep-alive task. Typically used to update the task queue data.

### Update a Task
To update a task, use the `update` method. This method takes the task ID as its only argument.

```php
$taskId = 'task-id';

$task = $taskEngine->setTask($taskId)
    ->setPriority('high')
    ->update();
```

### Log
To log a message for a task, use the `log` method. This method takes the task ID and the message as its arguments.

```php
$taskId = 'task-id';

$task = $taskEngine->setTask($taskId)
    ->log('This is a log message', 'success');
```

#### Reference
- `log(string $message, string $level = null)`
  - `$message`: The log message.
  - `$level`: The log level. Possible values are `success`, `info`, `warning`, and `error`. Default is `info`.

### Complete / Fail a Task
To complete or fail a task, use the `complete` or `fail` method. These methods take the task ID as their only argument.

```php
$taskId = 'task-id';

$task = $taskEngine->setTask($taskId)
    ->complete('Completed successfully');

$task = $taskEngine->setTask($taskId)
    ->fail('Failed to complete task');
```

### Get a Task
To get a task, use the `get` method. This method takes the task ID as its only argument.

```php
$taskId = 'task-id';

$task = $taskEngine->setTask($taskId)
    ->get();
```

## Callback Response
When the Task Engine sends a POST request to the callback URL, the response will be a JSON string with a code and message. You can use the `TaskEngine::response` method to create a response object.

```php
// Success response
return TaskEngine::response();

// Success response with message
return TaskEngine::response()->withMessage('Task processed successfully');

// Error response with error
return TaskEngine::response()->withError('An error occurred');

// Error response with errors
return TaskEngine::response()->withErrors([
    'Error message 1',
    'Error message 2',
]);
```

## License
The Task Engine SDK is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
