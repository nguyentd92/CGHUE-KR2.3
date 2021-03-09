<?php
require_once("controllers/common/base_controller.php");
require_once("models/account.php");

class AuthController extends BaseController {
    protected function getFolder()
    {
        return "auth";
    }

    function logIn()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->submitLogin();
        } else {
            $this->showLoginPage();
        }
    }

    function logOut()
    {
        // Check if user has been auth, then remove authentication, then header to Login page
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            Account::removeAuthUser();

            header("Location:?controller=auth&action=login");
        }
    }

    protected function submitLogin()
    {
        // Get email & password from request
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Find user by email & password, if user has been existed, then store authentication, else pass error to view login
        $user = Account::findByEmailAndPassword($email, $password);

        if($user) {
            Account::storeAuthUser($user);

            header("Location:?controller=dashboard&action=dashboard");
        } else {
            // Store errors into session
            $_SESSION["errors"] = ["Email or password is not matched"];

            header("Location:?controller=auth&action=login");
        }
    }

    protected function showLoginPage()
    {
        // Check if user has been authenticated, then redirect to home page
        if(Account::getAuthUser()) {
            header("Location:?controller=dashboard&action=dashboard");
        }
        
        $this->render('login', [], 'auth');
    }
}