<?php

class Account {
    public $account_id;
    public $full_name;
    public $email;
    public $password;
    public $last_login_at;

    public function __construct(
        $account_id,
        $full_name,
        $email,
        $password = null,
        $last_login_at = null
    ) {
        $this->account_id = $account_id;
        $this->email = $email;
        $this->full_name = $full_name;
        $this->password = $password;
        $this->last_login_at = $last_login_at;
    }

    static function findByEmailAndPassword($email, $password) {
        $db = DbConnection::getInstance();
        
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $req = $db->query($query, [$email, $password]);
        $rawData = $req->fetch();

        if(isset($rawData)) {
            return new Account(
                $rawData["account_id"],
                $rawData["full_name"],
                $rawData["email"],
                $rawData["password"],
                $rawData["last_login_at"]
            );
        }

        return null;
    }
}