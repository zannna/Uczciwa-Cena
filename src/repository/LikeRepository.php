<?php
require_once 'Repository.php';

class LikeRepository extends Repository
{
    public function addLike($idUser, $idAd)
    {
        $stmt = $this->database->connect()->prepare('
           INSERT INTO liked(id_user, id_ad) 
            VALUES (?,?)
        ');

        $stmt->execute([$idUser, $idAd]);

    }

    public function deleteLike($idUser, $idAd)
    {
        $stmt = $this->database->connect()->prepare('
           DELETE FROM liked WHERE id_user= :idUser AND id_ad= :idAd
    
        ');
        $stmt->execute([$idUser, $idAd]);
    }

    public function getLiked($id)
    {

        $stmt = $this->database->connect()->prepare('
          SELECT * FROM getUserLiked(:id)
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $advertisements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$advertisements) {
            throw new UnexpectedValueException();
        }
        return $advertisements;
    }

    public function getLikedId($id)
    {

        $stmt = $this->database->connect()->prepare('
          SELECT liked.id_ad FROM liked WHERE id_user=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isLiked($user_id, $ad_id)
    {
        $stmt = $this->database->connect()->prepare('SELECT EXISTS(SELECT 1 FROM liked WHERE id_user=:user_id and id_ad=:ad_id)');
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}