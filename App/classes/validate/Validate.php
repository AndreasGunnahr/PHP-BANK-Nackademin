<?php

namespace Validate;

use Db\Database;

class Validate extends Database
{
    private $passed;
    private $error;

    public function check($method, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                $input_value = trim($method[$item]);
                if ($rule === 'required' && empty($input_value)) {
                    $this->setError("$item is required");

                    return;
                } elseif (!empty($input_value)) {
                    if ($rule === 'email') {
                        if (!filter_var($input_value, FILTER_VALIDATE_EMAIL)) {
                            $this->setError("Invalid $item");

                            return;
                        }
                    } elseif ($rule === 'matches') {
                        if ($input_value != $method[$rule_value]) {
                            $this->setError("Passwords don't match");

                            return;
                        }
                    } elseif ($rule === 'unique') {
                        $check = self::query('SELECT * FROM users WHERE username = ?', array($input_value));
                        if (count($check)) {
                            $this->setError('Username is already taken');

                            return;
                        }
                    }
                }
            }
        }
        if (!isset($this->error)) {
            $this->passed = true;
        }
    }

    private function setError($error)
    {
        $this->error = $error;
        $this->passed = false;
    }

    public function error()
    {
        return $this->error;
    }

    public function passed()
    {
        return $this->passed;
    }
}
