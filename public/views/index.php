<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <script type="text/javascript" src="/js/index.js" defer></script>

    <link rel="stylesheet" href="https://fonts.google.com/specimen/Glegoo?query=glegoo"/>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/84b42560c5.js" crossorigin="anonymous"></script>
    <title> MAIN </title>
</head>
<body>
<div class="base-container">
    <header>
        <nav>
            <img id="logo" src="public/img/logo2.svg">
            <div class="search-bar">
                <input placeholder="miasto, województwo" type="text">
                <img id="icons" src="public/img/ikonki/lupka.png"></img>
            </div>
            <?php
            if(isset($_COOKIE['user']))
            {?>

            <div id="buttons">
                <div class="concreteButton">
                    <form action="getUserAdvertisements" method="GET"><button class="profileButton"></button></form>
                    profil
                </div>
                <div class="concreteButton">
                    <button class="alarmButton"></button>
                    powiadomienia
                </div>
                <div class="concreteButton">
                    <form action="logout" method="GET"><button class="logoutButton"></button></form>
                    wyloguj
                </div>
            </div>
            <?php } else { ?>
            <a href="http://localhost:8080/login"><button class="button">ZALOGUJ</button></a>
            <?php } ?>
        </nav>
    </header>

    <main>
        <div class="things" <?php
            if (isset($add)){?>  id=<?=
                gettype($add); }?>>
            <?php
            if (isset($add)){
                if(gettype($add)!="array")
                    $add=[$add];
                foreach ($add as $ad): echo "jestem;"?>
                    <div class="advertisement" id="<?= $ad->getId() ?>">
                        <img src="public/uploads/<?= $ad->getFirstPicture(); ?>">
                        <?php echo "heeej"; foreach ($liked as $l) echo $l?>
                        <div class="buttonsContainer1">
                            <div class="buttonsContainer2">
                                <button  <?php  if (isset($_COOKIE['user']) and  in_array( $ad->getId() ,$liked ))  { ?>class="redHeartButton"
                                    <?php } else { ?>
                                         class="heartButton"
                                    <?php } ?>
                                ></button>
                                <button class="phoneButton"></button>
                            </div>
                            <div class="popup-section"> </div>
                        </div>
                        przedmiot:
                        <p1> <?= $ad->getId() ?> <?=$ad->getName()?></p1>
                        <br>
                        miejsce:
                        <p2><?=$ad->getPlace()?></p2>
                        <br>
                        opis:
                        <p3><?=$ad->getDescription()?></p3>
                        <br>
                        Komentarze:
                        <div class="comments-section">
                        <?php
                        if (isset($com))
                        foreach ($com as $c):  if ($c->getIdAd()== $ad->getId()){?>
                        <div class="comments">
                            <?=$c->getContent()?>
                        </div>
                        <?php } endforeach; ?>
                        </div>
                        <div class="commentsContainer">
                            <input class="commentToSend" type="text">
                            <button class="sendButton"></button>
                        </div>

                    </div>
                <?php endforeach; } ?>
        </div>

    </main>
</div>
</body>
<template id="advertisement-template">
    <div class="advertisement" id="" >
        <img src="">

        <div class="buttonsContainer1">
            <div class="buttonsContainer2">
                <button class="heartButton"></button>
                <button class="phoneButton"></button>
            </div>
            <div class="popup-section"> </div>
        </div>
        przedmiot:
        <p1>adName</p1>
        <br>
        miejsce:
        <p2>place</p2>
        <br>
        opis:
        <p3>description</p3>
        <br>
        Komentarze:
        <div class="comments-section">

        </div>
        <div class="commentsContainer">
            <input class="commentToSend" type="text">
            <button class="sendButton"></button>
        </div>

    </div>


</template>