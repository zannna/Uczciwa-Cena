<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/LikeRepository.php';

class LikeController extends AppController
{
    private $likeRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->likeRepository = new LikeRepository();
        $this->userRepository = new UserRepository();
    }

    public function like()
    {
        $this->checkAutentication();
        if ($this->isPost()) {

            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType === "application/json") {

                $content = trim(file_get_contents("php://input"));
                $decoded = json_decode($content, true);
                $hash = $_COOKIE['user'];
                $user_id = $this->userRepository->getUser($hash)->getId();

                if ($decoded['option'] == "like")
                    $this->likeRepository->addLike($user_id, $decoded['liked']);
                else
                    $this->likeRepository->deleteLike($user_id, $decoded['liked']);
                http_response_code(200);
            }
        }
    }

    public function unlike()
    {
        $this->checkAutentication();
        if ($this->isPost()) {

            http_response_code(200);
        }
    }

    public function likedAdvertisements()
    {
        $this->checkAutentication();
        header('Content-Type: application/json');
        http_response_code(200);
        $hash = $_COOKIE['user'];
        $user_id = $this->userRepository->getUser($hash)->getId();
        echo json_encode($this->likeRepository->getLiked($user_id), true);


    }

    public function likedAddsId()
    {
        $toReturn = [];
        if (!isset($_COOKIE['user']))
            return [];
        try {
            $likes = $this->likeRepository->getLikedId($this->userRepository->getUser($_COOKIE['user'])->getId());
        } catch (Exception $e) {
            return [];
        }
        foreach ($likes as $like) {
            array_push($toReturn, $like['id_ad']);


        }

        return $toReturn;
    }


}