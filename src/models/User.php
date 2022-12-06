<?php

class User
{
    private $email;
    private $password;
    private $name;
    private $surname;
    private $place;
    private $phone;


    public function __construct(string $email, string $password,string $name, string $surname, string $place, int $phone)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->place = $place;
        $this->phone = $phone;
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }



}