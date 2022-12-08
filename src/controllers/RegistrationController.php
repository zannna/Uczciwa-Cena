<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
class RegistrationController extends AppController
{

public function confirmRegistration()
{

    $userRepository= new UserRepository();
    if (!$this->isPost()) {
        return $this->render('registration');
    }

    //  SPRAWDZENIE CZY EMAIL JEST
    $email = $_POST['email'];
    $user=null;
    try { print("tutaj");
        print($email);
        $user=$userRepository->getUser($email);
    }catch( UnexpectedValueException $e)
    {print("tutaj");

    }
    print("tutaj");
    if($user!=null)
    {
        return $this->render('registration', ['messages' => ['User with this email exist!']]);
    }
    $newUser= new User($_POST['email'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['place'], (int)$_POST['phone']);
    $userRepository->addUser($newUser);
    $this->render('index');

  //  return $this->render('login', ['messages' => $this->message]);

    //return $this->render('index', ['messages' => $this->message]);

}

}