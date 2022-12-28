<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
class RegistrationController extends AppController
{
    private $userRepository;
    public function __construct()
    {
        parent::__construct();
        $this->userRepository=new UserRepository();
    }

public function confirmRegistration()
{

    if (!$this->isPost()) {
        return $this->render('registration');
    }

    //  SPRAWDZENIE CZY EMAIL JEST
    $email = $_POST['email'];
    $user=null;
    try {
        $user=$this->userRepository->getUser(md5($email));
    }catch( UnexpectedValueException $e)
    { }

    if($user!=null)
    {
        return $this->render('registration', ['messages' => ['User with this email exist!']]);
    }

        $newUser= new User($_POST['email'], password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['name'], $_POST['surname'], $_POST['place'], (int)$_POST['phone']);
    $this->userRepository->addUser($newUser);
    setcookie("user", md5($_POST['email']), time()+(3600*5), "/");
    header("Refresh:0, http://$_SERVER[HTTP_HOST]/");



}

public function getUserCredentials()
{
   //$this->checkAutentication();
    header('Content-Type: application/json');
    http_response_code(200);
    $user=$this->userRepository->getUser($_COOKIE['user']);
    $user->setPassword("-");
   echo json_encode($user, true);


}
    public function modifyProfile()
    { $this->checkAutentication();

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $hash=$_COOKIE['user'];
            $user= $this->userRepository->getUser($hash);
            if( $decoded['name']!=null)
                $user->setName($decoded['name']);
            if( $decoded['surname']!=null)
                $user->setSurname($decoded['surname']);
            if( $decoded['place']!=null)
                $user->setPlace($decoded['place']);
            if($decoded['phone']!=null)
                $user->setPhone((int)$decoded['phone']);
            if( $decoded['password']!=null)
                $user->setPassword(md5($decoded['password']));

            if( $decoded['email']!="") {
                $existingUser=null;
                try {
                    $existingUser = $this->userRepository->getUser(md5($decoded['email']));
                } catch (UnexpectedValueException $e) {
                }
                if ($existingUser != null) {
                    header('Content-Type: application/json');

                    echo json_encode('User with this email exist!', true);

                } else {
                    $user->setEmail($decoded['email']);
                    setcookie("user",$_COOKIE['user'],time()-3600,"/");
                 //   setcookie("user", md5($decoded['email']), time()+(3600*5), "/");
                }
            }

            $this->userRepository->modifyUser($user);
            if( $decoded['email']!=null)
                setcookie("user", md5($decoded['email']), time()+(3600*5), "/");

            http_response_code(200);
            echo json_encode('added');
        }

    }
}

/*
 {"name": "kot",
"surname": "sdffdsdf",
 "place": "",
 "email": "",
  "password": "dsasds"}

 */