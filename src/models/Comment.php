<?php

class Comment
{
  private $idAd;
  private $idUser;
  private $content;
  private $date;

    /**
     * @param $idAd
     * @param $idUser
     * @param $content
     */
    public function __construct($idAd, $idUser, $content)
    {
        $this->idAd = $idAd;
        $this->idUser = $idUser;
        $this->content = $content;

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


}