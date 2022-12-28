<?php
require_once 'Repository.php';
require_once __DIR__ . './../models/User.php';

class UserRepository extends Repository
{
    public function getUser($value): User
    {
        $stmt=null;

        if(gettype($value)== "string") {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE md5(email) = :email
        ');
            $stmt->bindParam(':email', $value, PDO::PARAM_STR);
        }
        elseif (gettype($value)=="integer")
        {
            $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE id = :id
        ');
            $stmt->bindParam(':id', $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new UnexpectedValueException();
        }

        $stmt2 = $this->database->connect()->prepare('
            SELECT * FROM public.user_details WHERE id = :id
        ');
        $stmt2->bindParam(':id',  $user['id_user_details'], PDO::PARAM_INT);
        $stmt2->execute();
        $details = $stmt2->fetch(PDO::FETCH_ASSOC);
        if (!$details) {
            throw new UnexpectedValueException();
        }

        return new User(
            $user['email'],
            $user['password'],
            $details['name'],
            $details['surname'],
            $details['place'],
            $details['phone_number'],
            $user['id']

        );
    }

    public function addUser(User $user, $givenId)
    {


        $db = $this->database->connect();
        $stmt = $db->prepare('INSERT INTO user_details(name, surname, place, phone_number) 
            VALUES (?, ?, ?, ?) RETURNING id;');
        $stmt->execute([$user->getName(), $user->getSurname(), $user->getPlace(), $user->getPhone()]);
        $id = $db->lastInsertId();

        if($givenId !=null)
        {
            $stmt = $this->database->connect()->prepare('
           INSERT INTO users(password, email, id_user_details, id)
            VALUES (?,?,?,?)
        ');
            $stmt->execute([$user->getPassword(), $user->getEmail(), $id, $givenId]);
        }
        else {
            $stmt = $this->database->connect()->prepare('
           INSERT INTO users(password, email, id_user_details)
            VALUES (?,?,?)
        ');
            $stmt->execute([$user->getPassword(), $user->getEmail(), $id]);
        }


    }
    public function deleteUser($id)
    {
        $stmt = $this->database->connect()->prepare('
           SELECT id_user_details FROM users WHERE id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $detailsId = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('
           DELETE FROM users WHERE id=:id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
           DELETE FROM user_details WHERE id=:id
        ');
        $stmt->bindParam(':id', $detailsId['id_user_details'], PDO::PARAM_INT);
        $stmt->execute();
    }
    public function modifyUser($user)
    {
        $stmt = $this->database->connect()->prepare('
                UPDATE users SET email= :email, password= :password 
            WHERE id = :id
        ');

        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
            SELECT id_user_details FROM users WHERE id = :id
        ');
        $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $detailsId= $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->database->connect()->prepare('
                UPDATE user_details SET name= :name, surname= :surname, place= :place, phone_number= :phone
            WHERE id = :id
        ');
$num= $detailsId;

        $stmt->bindValue(':name', $user->getName());
        $stmt->bindValue(':surname', $user->getSurname());
        $stmt->bindValue(':place', $user->getPlace());
        $stmt->bindValue(':phone', $user->getPhone());
        $stmt->bindValue(':id', $detailsId['id_user_details'], PDO::PARAM_INT);
        $stmt->execute();


    }


}