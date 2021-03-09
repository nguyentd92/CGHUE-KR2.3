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

        // Validate Request
        $errors = [];

        // Store email to rewrite in view
        $_SESSION["email"] = $email;

        $isMailValid = preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g", $email);
        if(!$isMailValid) $errors[] = "Email is not valid";
        
        $isPasswordValid = strlen($password) >= 6;
        if(!$isPasswordValid) $errors[] = "Password must be at least 6 characters";
        
        if(count($errors) > 0) {
            $_SESSION["errors"] = $errors;

            header("Location:?controller=auth&action=login");
            return;
        }

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