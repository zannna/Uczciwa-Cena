<?php

class Advertisement
{
    private $id;
    private $pictures;

    /**
     * @return array
     */
    public function getPictures(): array
    {
        return $this->pictures;
    }

    private $name;
    private $place;
    private $description;
    private $idOwner;


    //DO ZMIANY TE -1 xdddd
    public function __construct(array $pictures, $name, $place, $description, $id = -1, $idOwner = -1)
    {
        $this->pictures = [];
        foreach ($pictures as $p) {
            if ($p != null) {
                array_push($this->pictures, $p);
            }
        }
        $this->name = $name;
        $this->place = $place;
        $this->description = $description;
        $this->id = $id;
        $this->idOwner = $idOwner;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|mixed
     */
    public function getIdOwner()
    {
        return $this->idOwner;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getFirstPicture(): string
    {

        if (sizeof($this->pictures) >= 1) {
            return $this->pictures[0];
        } else
            return '';
    }

    public function getSecondPicture(): string
    {

        if (sizeof($this->pictures) >= 2) {
            return $this->pictures[1];
        } else
            return '';
    }

    public function getThirdPicture(): string
    {
        if (sizeof($this->pictures) >= 3)
            return $this->pictures[2];
        else
            return '';
    }

    public function getFourthPicture(): string
    {
        if (sizeof($this->pictures) >= 4)
            return $this->pictures[3];
        else
            return '';
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param array $pictures
     */
    public function setPictures(array $pictures): void
    {
        $this->pictures = $pictures;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place): void
    {
        $this->place = $place;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }


}