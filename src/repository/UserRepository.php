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
            SELECT * FROM public.users WHERE email = :email
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
            $details['phone_number']

        );
    }

    public function addUser(User $user)
    {


        $db = $this->database->connect();
        $stmt = $db->prepare('INSERT INTO user_details(name, surname, place, phone_number) 
            VALUES (?, ?, ?, ?) RETURNING id;');
        $stmt->execute([$user->getName(), $user->getSurname(), $user->getPlace(), $user->getPhone()]);
        $id = $db->lastInsertId();

        $stmt = $this->database->connect()->prepare('
           INSERT INTO users(password, email, id_user_details)
            VALUES (?,?,?)
        ');
        $stmt->execute([$user->getPassword(), $user->getEmail(), $id]);

        //DO POPRAWY PRZYPISANE NA SZTYWNO ID_OWNER, pobranie tej wartości na podstawie sesji użytkownika lab9 minuta25


    }


}