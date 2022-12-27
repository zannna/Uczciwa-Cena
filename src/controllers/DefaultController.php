<?php

require_once 'AppController.php';
require_once 'AdvertisementController.php';

class DefaultController extends AppController {

    public function index($id)
    {

        $adController= new  AdvertisementController();
        $likeController= new LikeController();
        if($id !=null)
        {
            $response=$adController->getAd($id);
        }
        else{
            $response=$adController->getAllAdvertisements(0);

        }

        foreach($response[1] as $i)
        {
            print($i->getContent());
        }

        $this->render('index',  ['add' =>$response[0], 'com' =>$response[1], 'liked' =>$likeController->likedAddsId()]);
    }
 public function indexWithAdvertisements()
    {
        $adController= new  AdvertisementController();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-Type: application/json');
            http_response_code(200);
            $likeController= new LikeController();
            $liked=$likeController->likedAddsId();
            $toReturn=$adController->getAllAdvertisements($decoded['offset']);
            array_push( $toReturn, $liked);
            echo json_encode( $toReturn , true);
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
        setcookie("user",$_COOKIE['user'],time()-3600,"/");
        if(isset($_COOKIE['user']))
        {
            header("Refresh:0");
        }
     $this->index(null);

    }
    public function getPhoneNumber(){
    if ($this->isPost()) {
        $advertisementRepository= new AdvertisementRepository();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-Type: application/json');
            $number=$advertisementRepository->getOwner($decoded['search']);
            //print($number);
            http_response_code(200);
            echo json_encode($number);
        }
    }
    }

}