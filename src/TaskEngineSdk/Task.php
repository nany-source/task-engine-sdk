<?php

namespace B2Sign\TaskEngineSdk;

/**
 * Class Task
 * @package B2Sign\TaskEngineSdk
 */
class Task
{
    protected $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get response data
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }
}
