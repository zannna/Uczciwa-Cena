<?php
require_once 'Repository.php';
class CommentRepository extends Repository
{
    public function addComment(Comment $comment)
    {
        {
            $stmt = $this->database->connect()->prepare('
           INSERT INTO comments(ad_id, user_id, content) 
            VALUES (?,?,?)
        ');
            //DO POPRAWY PRZYPISANE NA SZTYWNO ID_OWNER, pobranie tej wartości na podstawie sesji użytkownika lab9 minuta25
            //$id_owner = 10;
            //dodawane wszystkie są obrazki trochę bezsensu bo mogą być puste
            $stmt->execute([$comment->getIdAd(), $comment->getIdUser(), $comment->getContent()]);

        }
}
    public function getAllComments(int $id): array
    {
        $stmt = $this->database->connect()->prepare('
          SELECT comments.content
            FROM comments INNER JOIN advertisement
                         ON advertisement.id = comments.ad_id where advertisement.id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $comments = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!comments) {
            throw new UnexpectedValueException();
        }

        return  $comments;

    }
}