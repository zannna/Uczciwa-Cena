<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Advertisement.php';
require_once __DIR__ . '/../repository/AdvertisementRepository.php';

class AdvertisementController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/jpg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';
    private $message = [];
    private $advertisementRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->advertisementRepository = new AdvertisementRepository();
        $this->userRepository = new UserRepository();
    }

    public function getPicturesFromUser()
    {
        $fileArray = [];
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $temp = array("size" => $_FILES['file']['size'][$i], "type" => $_FILES['file']['type'][$i]);
            if ($this->validate($temp)) {
                if (strlen($_FILES['file']['name'][$i]) > 0) {
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
        $id = $_GET['gear'];
        if ($id != null) {
            $advertisment = $this->advertisementRepository->getAd($id, "php");
            return $this->render('addAdvertisement', ['add' => $advertisment[0], 'messages' => $this->message]);

        }

        if ($this->isPost()) {
            $fileArray = $this->getPicturesFromUser();
            $hash = $_COOKIE['user'];
            $id = $this->userRepository->getUser($hash)->getId();
            if (strlen($_POST['description']) > 2000) {
                $this->message[] = " Podano za długi opis";
            } else if (strlen($_POST['name']) > 200) {
                $this->message[] = " Podano za długą nazwę";
            } elseif (strlen($_POST['place']) > 300) {
                $this->message[] = " Podano za długą nazwę miejsca";
            } else {
                $advertisment = new Advertisement($fileArray, $_POST['name'], $_POST['place'], $_POST['description']);
                $this->advertisementRepository->addAdvertisment($advertisment, $id);

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/getUserAdvertisements");
            }
            // return $this->render('profile_ad', ['messages' => $this->message, 'advertisment'=> $this->advertisementRepository->getUserAdd(10)]);
        }

        return $this->render('addAdvertisement', ['messages' => $this->message]);
    }

    public function getUserAdvertisements($option)
    {
        $this->checkAutentication();
        $hash = $_COOKIE['user'];
        $user = $this->userRepository->getUser($hash);
        $id = $user->getId();
        //żeby wyświtlić jedno ogłoszenie
        if ($_GET['toShow'] != null) {
            $likeRepository = new LikeRepository();
            $response = $this->advertisementRepository->getAd((int)$_GET['toShow'], "php");
            $ad_id = $response[0]->getId();
            $this->render('index', ['add' => $response[0], 'com' => $response[1], "liked" => ($likeRepository->isLiked($id, $ad_id)['exists'] == 1) ? [$ad_id] : []]);
        } else if ($option == null)
            return $this->render('profile_ad', ['advertisment' => $this->advertisementRepository->getUserAdd($id, "php"), 'name' => $user->getName()]);
        else if ($option != null) {
            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($this->advertisementRepository->getUserAdd($id, "js"), true);
        }
    }

    public function getAllAdvertisements($offset, $place = null)
    {
        return $this->advertisementRepository->getAllAdds($offset, $place);
    }

    public function deleteAdvertisement($id)
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
            $likeRepo = new LikeRepository();
            $user_id = 0;
            $allLiked = [];
            if (isset($_COOKIE['user'])) {
                $user_id = $this->userRepository->getUser($_COOKIE['user'])->getId();
                $tmp = $likeRepo->getLikedId($user_id);
                foreach ($tmp as $l) {
                    array_push($allLiked, $l['id_ad']);
                }
            }
            $liked = [];
            if ($decoded['search'] != null)
                $advertisements = $this->advertisementRepository->getAddByPlace($decoded['search']);
            $commentRepository = new CommentRepository();
            $comments = [];
            foreach ($advertisements as $ad) {
                $ad_id = $ad['id'];
                array_push($comments,  $commentRepository->getAllComments($ad_id));
                if ($user_id != 0 and in_array($ad_id, $allLiked)) {
                    array_push($liked, $ad_id);
                }


            }
            echo json_encode([$this->advertisementRepository->getAddByPlace($decoded['search']), $comments, $liked], true);
        }
    }

    public function modifyAdvertisement()
    {
        $this->checkAutentication();
        if ($this->isPost()) {
            $fileArray = $this->getPicturesFromUser();
            $id = $_POST['change'];
            $advertisment = $this->advertisementRepository->getAd((int)$id, "php");
            $advertisment = $advertisment[0];
            if ($fileArray != null)
                $advertisment->setPictures($fileArray);
            if ($_POST['name'] != null)
                $advertisment->setName($_POST['name']);
            if ($_POST['place'] != null)
                $advertisment->setPlace($_POST['place']);
            if ($_POST['description'] != null)
                $advertisment->setDescription($_POST['description']);
            $this->advertisementRepository->updateAdd($advertisment);
            $this->getUserAdvertisements(null);
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
        $ad_id = (int)$_GET['toShow'];
        $response = $this->advertisementRepository->getAd($ad_id, "php");
        $user_id = 0;
        if (isset($_COOKIE['user']))
            $user_id = $this->userRepository->getUser($_COOKIE['user'])->getId();

        $likeRepository = new LikeRepository();

        $this->render('index', ['add' => $response[0], 'com' => $response[1], 'liked' => [1, 2, 3, 4]]);

    }

    function deleteAdvertisementAdmin($id)
    {

        $hash = $_COOKIE['user'];
        if ($this->userRepository->getUser($hash)->getRole() == "admin") {
            $this->deleteAdvertisement($id);
        }
        http_response_code(200);

    }
}
