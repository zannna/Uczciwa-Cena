<?php

require_once 'AppController.php';
require_once 'AdvertisementController.php';

class DefaultController extends AppController
{

    public function index($id)
    {

        $admin = false;
        $adController = new  AdvertisementController();
        $likeController = new LikeController();
        if ($id != null) {
            $response = $adController->getAd($id);
        } else {
            $place = null;
            if (isset($_COOKIE['user'])) {
                $userRepository = new UserRepository();
                $user = $userRepository->getUser($_COOKIE['user']);
                $place = $user->getPlace();
                if ($user->getRole() == "admin") {
                    $place = null;
                    $admin = true;
                }

            }
            $response = $adController->getAllAdvertisements(0, $place);

        }

        $this->render('index', ['add' => $response[0], 'com' => $response[1], 'liked' => $likeController->likedAddsId(), 'admin' => $admin]);
    }

    public function indexWithAdvertisements()
    {
        $adController = new  AdvertisementController();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-Type: application/json');
            http_response_code(200);
            $likeController = new LikeController();
            $liked = $likeController->likedAddsId();
            $place = null;
            $admin = false;
            if (isset($_COOKIE['user'])) {
                $userRepository = new UserRepository();
                $user = $userRepository->getUser($_COOKIE['user']);
                $place = $user->getPlace();
                if ($user->getRole() == "admin") {
                    $place = null;
                    $admin = true;
                }
            }


            $toReturn = $adController->getAllAdvertisements($decoded['offset'], $place);
            array_push($toReturn, $liked, $admin);
            echo json_encode($toReturn, true);
        }

    }

    public function login()
    {
        $this->render('login');
    }

    public function registration()
    {
        $this->render('registration');
    }

    public function logout()
    {
        setcookie("user", $_COOKIE['user'], time() - 3600, "/");
        if (isset($_COOKIE['user'])) {
            header("Refresh:0");
        }
        $this->index(null);

    }

    public function getPhoneNumber()
    {
        $this->checkAutentication();
        if ($this->isPost()) {
            $advertisementRepository = new AdvertisementRepository();
            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType === "application/json") {

                $content = trim(file_get_contents("php://input"));
                $decoded = json_decode($content, true);
                header('Content-Type: application/json');
                $number = $advertisementRepository->getOwner($decoded['search']);
                http_response_code(200);
                echo json_encode($number);
            }
        }
    }

}