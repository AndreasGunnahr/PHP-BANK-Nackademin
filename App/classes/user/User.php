<?php

namespace User;

use Session\Session;

class User
{
    private $user_info;
    private $isLoggedIn;
    private $db;

    public function __construct($user = null, $db)
    {
        $this->db = $db;
        if (Session::exists('user')) {
            $user = Session::get('user');
            if ($this->find($user)) {
                $this->isLoggedIn = true;
            } else {
                //logged out
            }
        }
    }

    public function create($values = array())
    {
        //Behöver göras om mot Mickes DB
        // $this->db->query('INSERT INTO users (username, userEmail, password) VALUES (?,?,?)', $values);
    }

    public function find($user = null)
    {
        if ($user) {
            $data = $this->db->getUser(array($user));
            if (count($data)) {
                $this->user_info = $data;

                return true;
            }
        }

        return false;
    }

    public function login($username = null, $password = null)
    {
        $user = $this->find($username);
        if ($user) {
            if (password_verify($password, $this->user_info[0]['password'])) {
                Session::put('id', $this->user_info[0]['id']);
                Session::put('user', $this->user_info[0]['username']);
                Session::put('mobilephone', $this->user_info[0]['mobilephone']);
                // Session::put('firstName', $this->user_info[0]['firstName']);
                // Session::put('lastName', $this->user_info[0]['lastName']);

                return true;
            } else {
                Session::flashMessage('error', 'Wrong password');

                return false;
            }
        }
        Session::flashMessage('error', "Username don't exists");

        return false;
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logout()
    {
        Session::delete('user');
    }

    public function showBalance($user_id)
    {
        $data = $this->db->getBalance(array($user_id));

        return $data;
    }
}
