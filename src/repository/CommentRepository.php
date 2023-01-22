<?php
require_once 'Repository.php';

class CommentRepository extends Repository
{
    public function addComment(Comment $comment)
    {
        {
            $stmt = $this->database->connect()->prepare('
           INSERT INTO comments(ad_id, user_id, content, adding_date) 
            VALUES (?,?,?,current_timestamp)
        ');
            //DO POPRAWY PRZYPISANE NA SZTYWNO ID_OWNER,
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


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getNotif($id, $offset, $liked)
    {

        $array = [];
        foreach ($liked as $like) {
            array_push($array, $like['id_ad']);
        }
        $stmt = $this->database->connect()->prepare('
           SELECT comments.content, a.picture1, a.name, a.id FROM comments
inner join advertisement a on a.id = comments.ad_id where a.id_owner=? OR a.id = ANY(?)
order by comments.adding_date desc
LIMIT 5
OFFSET  ?;
        ');
        $encoded = json_encode($array);
        $encoded = str_replace('[', '{', $encoded);
        $encoded = str_replace(']', '}', $encoded);

        $stmt->execute([$id, $encoded, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
public function deleteComment($id)
{
    $stmt = $this->database->connect()->prepare('
           DELETE FROM comments WHERE comment_id= :id    
        ');
    $stmt->execute([$id]);
}

}
/*
 SELECT comments.content, a.picture1, a.name, a.id FROM comments
inner join advertisement a on a.id = comments.ad_id where a.id_owner=:id OR a.id in :array
order by comments.adding_date desc
LIMIT 3
OFFSET  :offset;
 */