<?php
require_once 'Repository.php';
require_once __DIR__ . './../models/Advertisement.php';

class AdvertisementRepository extends Repository
{

    public function getAd(int $id, String $option): Array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.advertisement WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $ad = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($ad == false) {
            throw new UnexpectedValueException();
        }
        $id=$ad['id'];
        // moga sie wysłac puste
        if($option=="php") {
            $pictures = [$ad ['picture1'], $ad['picture2'], $ad['picture3'], $ad['picture4']];
            $ad = new Advertisement($pictures, $ad['name'], $ad['place'], $ad['description'], $ad['id'], $ad['id_owner']);
        }

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.comments WHERE ad_id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $comments =[];
        while ($com= $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($comments, new Comment($com['ad_id'], $com['user_id'], $com['content']));
        }


        //print($ad->getName());
        //print_r($comments);
        return [$ad,$comments];
    }

    public function getOwner(int $id): int
    {
        $stmt = $this->database->connect()->prepare('
           SELECT user_details.phone_number
        FROM advertisement INNER JOIN users
                              ON advertisement.id_owner = users.id INNER JOIN user_details
        ON users.id_user_details =user_details.id where advertisement.id= :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $number = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$number) {
            throw new UnexpectedValueException();
        }
        return $number['phone_number'];

    }


    public function getAllAdds($offset)
    {  /* if($offset==0)
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM comments
                  INNER JOIN (SELECT  * from public.advertisement
                              ORDER BY advertisement.id DESC
                              LIMIT 2
                                  OFFSET :offset)
    as t2 ON t2.id = comments.ad_id ORDER BY t2.id DESC;
          ');
        else
        {*/
        $base=$this->database->connect();
        $stmt = $base->prepare('
            SELECT * FROM public.advertisement 
                    ORDER BY id DESC
                    LIMIT 2
                    OFFSET  :offset;
        ');
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $advertisements = [];
        $comments = [];
        $likes=[];
        if ($offset == 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $pictures = [$row ['picture1'], $row ['picture2'], $row['picture3'], $row['picture4']];
                array_push($advertisements, new Advertisement($pictures, $row['name'], $row['place'], $row['description'], $row['id']));
                $stmt2 = $this->database->connect()->prepare('
            SELECT * FROM public.comments WHERE ad_id = :id
                ');
                $stmt2->bindParam(':id',  $row['id'], PDO::PARAM_INT);
                $stmt2->execute();
               // $stmt2->bindParam(':id', $row['id'], PDO::PARAM_INT);
                while ($com= $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    array_push($comments, new Comment($com['ad_id'], $com['user_id'], $com['content']));
                }
            }

            return [$advertisements, $comments];
        } else {/*
            $stmt = $this->database->connect()->prepare('
        SELECT * FROM comments
                  INNER JOIN (SELECT  * from public.advertisement
                              ORDER BY advertisement.id DESC
                              LIMIT 2
                                  OFFSET :offset)
    as t2 ON t2.id = comments.ad_id ORDER BY t2.id DESC;
          ');

 NOWE
 SELECT * FROM comments
                    RIGHT JOIN(SELECT  * from public.advertisement
                              ORDER BY advertisement.id DESC
                              LIMIT 10
                                  OFFSET :offset)
    as t2 ON t2.id = comments.ad_id ORDER BY t2.id DESC;

            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
*/
$advertisements=$stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($advertisements as $ad)
{
    $stmt2 = $this->database->connect()->prepare('
            SELECT * FROM public.comments WHERE ad_id = :id
                ');
    $stmt2->bindParam(':id', $ad['id'], PDO::PARAM_INT);
    $stmt2->execute();
    array_push($comments, $stmt2->fetchAll(PDO::FETCH_ASSOC));

}


            return [$advertisements, $comments];


        }

    }

    public function addAdvertisment( $ad,  $id): void
    {
        $stmt = $this->database->connect()->prepare('
           INSERT INTO advertisement(name, place, description, picture1, picture2, picture3, picture4, id_owner) 
            VALUES (?,?,?,?,?,?,?,?)
        ');
        //DO POPRAWY PRZYPISANE NA SZTYWNO ID_OWNER, pobranie tej wartości na podstawie sesji użytkownika lab9 minuta25

        //dodawane wszystkie są obrazki trochę bezsensu bo mogą być puste
        $stmt->execute([$ad->getName(), $ad->getPlace(), $ad->getDescription(), $ad->getFirstPicture(), $ad->getSecondPicture(), $ad->getThirdPicture(), $ad->getFourthPicture(), $id]);

    }


    public function getUserAdd($element, string $option = null): array
    {
        //DO POPRAWY PRZYPISANE NA SZTYWNO ID_OWNER, pobranie tej wartości na podstawie sesji użytkownika lab9 minuta25

        /*
                if($option=="getByUser")
                $stmt = $this->database->connect()->prepare('
                    SELECT * FROM public.adverisement WHERE id_owner = :element
                ');
                if($option=="getByCity")
                    $stmt = $this->database->connect()->prepare('
                    SELECT * FROM public.adverisement WHERE place = :element
                ');*/

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.advertisement WHERE id_owner = :element
        ');
        $stmt->bindParam(':element', $element, PDO::PARAM_INT);
        $stmt->execute();
        // $info=$stmt->fetch(PDO::FETCH_ASSOC); CHYBA NIEPOTRZEBNE LOL
        if($option=="js")
        {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $ad = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pictures = [$row ['picture1'], $row ['picture2'], $row['picture3'], $row['picture4']];
            array_push($ad, new Advertisement($pictures, $row['name'], $row['place'], $row['description'], $row['id']));
        }

        return $ad;
    }

    public function deleteAdd($id): void
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.advertisement WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateAdd(Advertisement $ad): void
    {


        $stmt = $this->database->connect()->prepare('
               UPDATE advertisement SET name= :name, place= :place, description= :description, picture1= :picture1, picture2= :picture2, picture3= :picture3, picture4= :picture4 
            WHERE id = :id
        ');

        $stmt->bindValue(':name', $ad->getName());
        $stmt->bindValue(':place', $ad->getPlace());
        $stmt->bindValue(':description', $ad->getDescription());
        $stmt->bindValue(':picture1', $ad->getFirstPicture());
        $stmt->bindValue(':picture2', $ad->getSecondPicture());
        $stmt->bindValue(':picture3', $ad->getThirdPicture());
        $stmt->bindValue(':picture4', $ad->getFourthPicture());
        $id = $ad->getId();
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();


    }

    public function getAddByPlace($place)
    {
        // $place= '%'.strtolower($place).'%';
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.advertisement WHERE LOWER(place) = :place
        ');
        $stmt->bindParam(':place', $place, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}