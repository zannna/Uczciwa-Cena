<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../repository/CommentRepository.php';

class CommentsController extends AppController
{
    private $commentRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
    }

    public function sendComment()
    {
        $this->checkAutentication();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $hash = $_COOKIE['user'];
            $id = $this->userRepository->getUser($hash)->getId();
            $comment = new Comment($decoded['idAd'], $id, $decoded['content']);
            $this->commentRepository->addComment($comment);
            http_response_code(200);

        }

    }

    public function getComments($id)
    {

        $this->commentRepository->getAllComments($id);
        /*$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $this->commentRepository->getAllComments($decoded['idAd']);
            http_response_code(200);
        }*/


    }

    public function getNotifications()
    {
        $this->checkAutentication();
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $hash = $_COOKIE['user'];
            $id = $this->userRepository->getUser($hash)->getId();
            header('Content-Type: application/json');
            http_response_code(200);
            $likeRepo = new  LikeRepository();
            echo json_encode($this->commentRepository->getNotif($id, $decoded['offset'], $likeRepo->getLikedId($id)), true);
        }
    }

}