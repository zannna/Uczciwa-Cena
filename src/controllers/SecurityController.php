<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function confirmlogin()
    {
        if (isset($_POST['register']))
            return $this->render('registration');

        $userRepository = new UserRepository();
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = null;
        try {
            $user = $userRepository->getUser(md5($email));
        } catch (UnexpectedValueException $e) {
            $this->render('login', ['messages' => ['User with this email not exist!']]);


        }

        if (!$user) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }
        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }
        setcookie("user", md5($_POST['email']), time() + (3600 * 5), "/");

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/");

    }
}