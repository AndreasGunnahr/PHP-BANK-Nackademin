<?php

interface TransactionInterface
{
    public function validateTransaction($db, $data);

    public function createTransaction($db, $data);
}

class SwishPayment extends TransactionBase implements TransactionInterface
{
    public function validateTransaction($db, $data)
    {
        return $this->checkBalance($db, $data);
    }

    public function createTransaction($db, $data)
    {
        $to_user = $db->getAccount(array($data['receiver']));
        $from_user = $db->getAccount(array($_SESSION['user']));
        $db->setTransaction(array(
            $data['amount'],
            $from_user['account_id'],
            $from_user['currency'],
            $this->getRate($data['amount'], $from_user['currency'], $to_user['currency']),
            $to_user['account_id'],
            $to_user['currency'],
            $this->rate,
        ));

        $this->setError('Successful payment!');

        return true;
    }
}

class AccountPayment extends TransactionBase implements TransactionInterface
{
    public function validateTransaction($db, $data)
    {
        return $this->checkBalance($db, $data);
    }

    public function createTransaction($db, $data)
    {
        $to_user = $db->getAccount(array($data['receiver']));
        $from_user = $db->getAccount(array($_SESSION['user']));

        $db->setTransaction(array(
            $data['amount'],
            $from_user['account_id'],
            $from_user['currency'],
            $this->getRate($data['amount'], $from_user['currency'], $to_user['currency']),
            $to_user['account_id'],
            $to_user['currency'],
            $this->rate,
        ));

        $this->setError('Successful payment!');

        return true;
    }
}

class Transaction
{
    private $db;
    private $data;

    public function __construct(Database $db, $body_data)
    {
        $this->db = $db;
        $this->data = $body_data;
    }

    public function makeTransfer(TransactionInterface $transferType)
    {
        $validateBalance = $transferType->validateTransaction($this->db, $this->data);
        if ($validateBalance) {
            $created = $transferType->createTransaction($this->db, $this->data);

            return $created;
        } else {
            return $validateBalance;
        }
    }
}

class TransactionBase
{
    public $rate;
    private $error;

    public function checkBalance($db, $data)
    {
        if (empty($data['amount'])) {
            $this->setError('Amount is required');

            return false;
        } elseif (empty($data['receiver'])) {
            $this->setError('Receiver is required');

            return false;
        } else {
            $balance = $db->getBalance(array($_SESSION['id']));
            if ((intval($balance[0]['balance']) - intval($data['amount'])) < 0) {
                $this->setError('Invalid amount to transfer.');

                return false;
            }

            return true;
        }
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getRate($amount = null, $from_currency, $to_currency)
    {
        $url = "https://api.exchangeratesapi.io/latest?base=$from_currency";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $results = json_decode(curl_exec($curl));
        curl_close($curl);
        $this->rate = $results->rates->$to_currency;

        $newAmount = $this->rate * $amount;

        return $newAmount;
    }
}
