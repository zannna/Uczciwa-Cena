<?php

class Comment
{
    private $idAd;
    private $idUser;
    private $content;
    private $date;
    private $id;

    /**
     * @param $idAd
     * @param $idUser
     * @param $content
     */
    public function __construct($idAd, $idUser, $content, $id = 0)
    {
        $this->idAd = $idAd;
        $this->idUser = $idUser;
        $this->content = $content;
        $this->id = $id;

    }

    /**
     * @return mixed
     */
    public function getIdAd()
    {
        return $this->idAd;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}