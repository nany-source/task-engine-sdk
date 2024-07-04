<?php

namespace B2Sign\TaskEngineSdk;

/**
 * Class TaskEngine
 * @package B2Sign\TaskEngineSdk
 */
class TaskEngineResponse
{
    protected $messages = [];
    protected $errors = [];

    /**
     * Add message
     * @param $messages string|array
     * @return $this
     */
    public function withMessage($messages)
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                $this->messages[] = $message;
            }
            return $this;
        }
        $this->messages[] = $messages;
        return $this;
    }

    /**
     * Add error
     * @param $errors string|array
     * @return $this
     */
    public function withError($errors)
    {
        if (is_array($errors)) {
            foreach ($errors as $error) {
                $this->errors[] = $error;
            }
            return $this;
        }
        $this->errors[] = $errors;
        return $this;
    }

    /**
     * Get response data
     */
    public function __toString()
    {
        $result = [];
        if (empty($this->errors)) {
            // has no error
            $result['code'] = 0;
            if (! empty($this->messages)) {
                $result['messages'] = $this->messages;
            }
        } else {
            // has error
            $result['code'] = 1;
            $result['errors'] = $this->errors;
        }
        return json_encode($result);
    }
}
