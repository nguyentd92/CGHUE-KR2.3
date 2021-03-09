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

    protected function updateLastLoginAt() {
        $db = DbConnection::getInstance();

        $currentTime = date("Y-m-d H:i:s", time());
        
        $sql = "UPDATE accounts SET last_login_at = ? WHERE account_id = ?";
        
        $req = $db->prepare($sql);
        $req->execute([$currentTime, $this->account_id]);
    }

    static function findByEmailAndPassword($email, $password) {
        $db = DbConnection::getInstance();
        
        $query = "SELECT * FROM accounts WHERE email = ? AND password = ?";
        
        $req = $db->prepare($query);
        $req->execute([$email, $password]);
        $rawData = $req->fetch();

        if($rawData) {
            $account = new Account(
                $rawData["account_id"],
                $rawData["full_name"],
                $rawData["email"],
                $rawData["password"],
                $rawData["last_login_at"]
            );

            $account->updateLastLoginAt();

            return $account;
        }

        return null;
    }

    // Return Type: void
    // Params: $account: Account
    static function storeAuthUser($account) {
        $_SESSION[AUTH_KEY] = serialize($account);
    }

    // Return Type: Account
    static function getAuthUser() {
        return isset($_SESSION[AUTH_KEY]) ? unserialize($_SESSION[AUTH_KEY]) : null;
    }

    static function removeAuthUser() {
        unset($_SESSION[AUTH_KEY]);
    }
}