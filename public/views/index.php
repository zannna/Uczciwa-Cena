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
            <button class="button">ZALOGUJ</button>
        </nav>
    </header>

    <main>
        <div class="things">
            <?php
            if (isset($add))
                foreach ($add as $ad): echo 'dziala?';?>
                    <div class="advertisement">
                        <img src="public/uploads/<?= $ad->getFirstPicture(); ?>">

                        <div class="buttonsContainer1">
                            <div class="buttonsContainer2">
                                <button class="heartButton"></button>
                                <button class="phoneButton"></button>
                            </div>
                        </div>
                        przedmiot:
                        <p1><?=$ad->getName()?></p1>
                        <br>
                        miejsce:
                        <p2><?=$ad->getPlace()?></p2>
                        <br>
                        opis:
                        <p3><?=$ad->getDescription()?></p3>
                        <br>
                        Komentarze:
                        <div class="commentsContainer">
                            <div class="comments"></div>
                            <input class="commentToSend" type="text">
                            <button class="sendButton"></button>
                        </div>


                    </div>
                <?php endforeach; ?>
        </div>

    </main>
</div>
</body>
<template id="advertisement-template">
    <div class="advertisement">
        <img src="">

        <div class="buttonsContainer1">
            <div class="buttonsContainer2">
                <button class="heartButton"></button>
                <button class="phoneButton"></button>
            </div>
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
        <div class="commentsContainer">
            <input class="userInfo" type="text">
            <button class="sendButton"></button>
        </div>


    </div>


</template>