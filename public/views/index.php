<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <script type="text/javascript" src="/js/index.js" defer></script>
    <script type="text/javascript" src="/js/navigation.js" defer></script>
    <script type="text/javascript" src="/js/loadingProjects.js" defer></script>
    <link rel="stylesheet" href="https://fonts.google.com/specimen/Glegoo?query=glegoo"/>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/84b42560c5.js" crossorigin="anonymous"></script>
    <title> MAIN </title>
</head>

<body>
<header>
    <nav>
        <a href="http://localhost:8080/"><img id="logo" src="public/img/logo2.svg"></a>
        <div class="search-bar">
            <input name="search-place" <?php
            if (isset($_COOKIE['user'])) {
                $userRepository = new UserRepository();
                $user = $userRepository->getUser($_COOKIE['user']);
                if (isset($admin) and !$admin) {
                    ?>
                    placeholder="<?= $user->getPlace(); ?>" <?php }
            } else { ?>  placeholder="miasto, województwo" <?php } ?> type="text">
            <img id="icons" src="public/img/ikonki/lupka.png"></img>
        </div>
        <?php
        if (isset($_COOKIE['user'])) {
            ?>

            <div id="buttons">
                <div class="concreteButton">
                    <form action="getUserAdvertisements" method="GET">
                        <button class="profileButton"></button>
                    </form>
                    profil
                </div>
                <div class="concreteButton">
                    <div class="dropdown">
                        <button id="alarm" class="alarmButton"></button>
                        powiadomienia
                        <div class="dropdown-menu">
                            Nowe komentarze:
                        </div>
                    </div>
                </div>
                <div class="concreteButton">
                    <form action="logout" method="GET">
                        <button class="logoutButton"></button>
                    </form>
                    wyloguj
                </div>
            </div>
        <?php } else { ?>
            <a id="link-button" href="http://localhost:8080/login">
                <button class="button">ZALOGUJ</button>
            </a>
        <?php } ?>
    </nav>
</header>
<div class="base-container">
    <main>
        <div class="things" <?php
        if (isset($add)) {
            ?>  id=<?=
            gettype($add);
        } ?>>
            <?php
            if (isset($add)) {
                if (gettype($add) != "array")
                    $add = [$add];
                foreach ($add as $ad): ?>
                    <div class="advertisement" id="<?= $ad->getId() ?>">
                        <?php if (isset($admin) and $admin) { ?>
                            <div class="deleteDescription">USUŃ</div>
                            <button class="deleteButton"></button>
                        <?php } ?>
                        <img src="public/uploads/<?= $ad->getFirstPicture(); ?>">
                        <div class="buttonsContainer1">
                            <div class="buttonsContainer2">
                                <button
                                    <?php if (isset($_COOKIE['user']) and $liked != null and in_array($ad->getId(), $liked))  { ?>class="redHeartButton"
                                    <?php } else { ?>
                                        class="heartButton"
                                    <?php } ?>
                                ></button>
                                <button class="phoneButton"></button>
                            </div>
                            <div class="popup-section"></div>
                        </div>
                        przedmiot:
                        <p1> <?= $ad->getName() ?></p1>
                        <br>
                        miejsce: <?php echo $admin; ?>
                        <p2><?= $ad->getPlace() ?></p2>
                        <br>
                        opis:
                        <p3><?= $ad->getDescription() ?></p3>
                        <br>
                        Komentarze:
                        <div class="comments-section">
                            <?php
                            if (isset($com))
                                foreach ($com as $c): if ($c->getIdAd() == $ad->getId()) {
                                    if (isset($admin) and !$admin) { ?>
                                        <div class="comments">
                                            <?= $c->getContent() ?>
                                        </div>
                                    <?php }
                                    if (isset($admin) and $admin) { ?>
                                        <div class="admin-comments">
                                            <button class="deleteCommentButton" value="<?= $c->getId(); ?>"></button>
                                            <div class="comments"> <?= $c->getContent() ?> </div>
                                        </div>
                                    <?php }
                                } endforeach; ?>
                        </div>
                        <div class="commentsContainer">
                            <input class="commentToSend" type="text">
                            <button class="sendButton"></button>
                        </div>
                        <div class="message"></div>
                    </div>
                <?php endforeach;
            } ?>
        </div>

    </main>
</div>
</body>
<template id="dropdown-template">
    <form action="getUserAdvertisements" method="GET">
        <button type="submit" class="b1" name="toShow" value="">
            <img src="">
            <div class="b1-div">
                <p>heejka</p>
            </div>
        </button>
    </form>
</template>
<template id="advertisement-template">
    <div class="advertisement" id="">
        <div class="deleteDescription" style="visibility:hidden;">USUŃ</div>
        <button class="deleteButton" style="visibility:hidden;"></button>
        <img src="">

        <div class="buttonsContainer1">
            <div class="buttonsContainer2">
                <button class="heartButton"></button>
                <button class="phoneButton"></button>
            </div>
            <div class="popup-section"></div>
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
        <div class="admin-commentsContainer">
            <div class="admin-comments" style="visibility:hidden;">
                <button class="deleteCommentButton" value=""></button>
                <div class="comments"></div>
            </div>
        </div>
        <div class="message"></div>
    </div>


</template>
<template id="admin-comments-template">
    <div class="admin-comments">
        <button class="deleteCommentButton" value=""></button>
        <div class="comments"></div>
    </div>
</template>