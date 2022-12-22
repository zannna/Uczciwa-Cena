<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Advertisement.php';
require_once __DIR__ . '/../repository/AdvertisementRepository.php';
class AdvertisementController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/jpg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private $message = [];
    private $advertisementRepository;

    public function __construct()
    {
        parent::__construct();
        $this->advertisementRepository=new AdvertisementRepository();
    }
    public function getPicturesFromUser()
    {
        $fileArray=[];
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $temp= array("size" => $_FILES['file']['size'][$i], "type" =>$_FILES['file']['type'][$i]);
            if(  $this->validate($temp))
            {
                if(strlen($_FILES['file']['name'][$i])>0){
                    //print($_FILES['file']['name'][$i]);
                    $fileArray[$j] = $_FILES['file']['name'][$i];
                    $j++;
                    move_uploaded_file(
                        $_FILES['file']['tmp_name'][$i],
                        dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name'][$i]
                    );
                }

            }
        }
        return $fileArray;

    }
    public function addAdvertisement()
    {
        $this->checkAutentication();
        $id=$_GET['gear'];
        if ($id!=null)
        {
            $advertisment= $this->advertisementRepository->getAd($id, "php");
            return $this->render('addAdvertisement',  ['add'=> $advertisment[0], 'messages' => $this->message]);

        }

        if ($this->isPost()){
        $fileArray=$this->getPicturesFromUser();

            $advertisment= new Advertisement( $fileArray, $_POST['name'], $_POST['place'], $_POST['description']);
            $this->advertisementRepository->addAdvertisment($advertisment);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/getUserAdvertisements");

           // return $this->render('profile_ad', ['messages' => $this->message, 'advertisment'=> $this->advertisementRepository->getUserAdd(10)]);
    }

        return $this->render('addAdvertisement', ['messages' => $this->message]);
    }

    public function getUserAdvertisements($option)
    {
        $this->checkAutentication();
       $userId=10;
       //żeby wyświtlić jedno ogłoszenie
        if($_GET['toShow']!=null)
        {
            $response=$this->advertisementRepository->getAd((int) $_GET['toShow'], "php");

            $this->render('index',  ['add' =>$response[0], 'com' =>$response[1]]);
        }
        else if($option==null)
        return $this->render('profile_ad', ['advertisment' => $this->advertisementRepository->getUserAdd(10, "php")]);
        else if($option!=null)
        {
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode(   $this->advertisementRepository->getUserAdd(10, "js"), true);
        }
    }
    public function getAllAdvertisements($offset)
    {
        return  $this->advertisementRepository->getAllAdds($offset);
    }
    public  function deleteAdvertisement($id)
{
    $this->checkAutentication();
    $this->advertisementRepository->deleteAdd($id);
   // $this->render('profile_ad', ['messages' => $this->message, 'advertisment'=> $this->advertisementRepository->getUserAdd(10)]);

}


    public function getAdvertisementByPlace()
    {

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($this->advertisementRepository->getAddByPlace($decoded['search']), true);
        }
    }

    public function modifyAdvertisement()
    {
        $this->checkAutentication();
        if ($this->isPost()) {
            $fileArray = $this->getPicturesFromUser();
            $id=$_POST['change'];
            $advertisment=$this->advertisementRepository->getAd((int) $id, "php");
            $advertisment=$advertisment[0];
            if($fileArray!=null)
                $advertisment->setPictures($fileArray);
            if( $_POST['name']!=null)
                $advertisment->setName($_POST['name']);
            if($_POST['place'] !=null)
                $advertisment->setPlace($_POST['place']);
            if($_POST['description']!=null)
                $advertisment->setDescription($_POST['description']);
            $this->advertisementRepository->updateAdd($advertisment);
            $this->getUserAdvertisements();
        }

    }


    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }


        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }
    function getAdvertisement()
    {
        $id=$_GET['toShow'];
        $response=$this->advertisementRepository->getAd((int) $id, "php");
       /* foreach($response[1] as $i)
        {
            print($i->getContent());
        }*/
        $this->render('index',  ['add' =>$response[0], 'com' =>$response[1]]);

    }

}
/*
public function modifyAdvertisement($id)
{
 //   print($this->advertisementRepository->getAd($id)->getName());
   //header(null);
   //$url = "http://$_SERVER[HTTP_HOST]";
   // header("Location: {$url}/addAdvertisement");

    $variables =['messages' => $this->message, 'ad'=> $this->advertisementRepository->getAd((int)$id)];
    $templatePath = 'public/views/addAdvertisement.php';
    $output = 'File not found';

   if(file_exists($templatePath)){
        extract($variables);
        ob_start();
       require_once($templatePath);
       $url = "http://$_SERVER[HTTP_HOST]";
       header("Location: {$url}/addAdvertisement");
       print('echooo');
        $output = ob_get_clean();
    }
   print $output;
}*/
//  return $this->render('addAdvertisement',  ['messages' => $this->message, 'advertisment'=> $this->advertisementRepository->getAd((int)$id)]);
// $this->render('profile_ad',  ['messages' => $this->message, 'advertisment'=> $this->advertisementRepository->getAd($id)]);
// header("Location: {$url}/addAdvertisement",  ['messages' => $this->message, 'advertisment'=> $this->advertisementRepository->getAd($id)]);
