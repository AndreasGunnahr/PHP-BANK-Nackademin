<?php

class User
{
    private $db;

    public function __construct(Database $db, $body_data = null)
    {
        $this->db = $db;
    }

    public function transactions()
    {
        $account = $this->db->getAccount(array($_SESSION['user']));
        $data = $this->db->getTransactions(array($account['account_id'], $account['account_id']));

        return $data;
    }

    public function balance()
    {
        $data = $this->db->getBalance(array($_SESSION['id']));

        return $data;
    }

    public function users()
    {
        $data = $this->db->getReceivers();

        return $data;
    }
}
