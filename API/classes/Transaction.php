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
        return $this->checkTransfer($db, $data);
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
        return $this->checkTransfer($db, $data);
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
        try {
            if (empty($data['amount'])) {
                throw new Exception('Amount is required', E_USER_ERROR);
            } elseif (empty($data['receiver'])) {
                throw new Exception('Receiver is required', E_USER_ERROR);
            } else {
                $balance = $db->getBalance(array($_SESSION['id']));
                if ((intval($balance[0]['balance']) - intval($data['amount'])) < 0) {
                    throw new Exception('Invalid amount to transfer', E_USER_ERROR);
                }

                return true;
            }
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function checkTransfer($db, $data)
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

        return true;
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
