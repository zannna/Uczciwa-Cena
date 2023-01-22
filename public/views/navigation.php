<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <script type="text/javascript" src="/js/navigation.js" defer></script>

    <link rel="stylesheet" href="https://fonts.google.com/specimen/Glegoo?query=glegoo"/>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/84b42560c5.js" crossorigin="anonymous"></script>
    <title> Navigation </title>
</head>
<body>
<header>
    <nav>
        <a id="link-button" href="http://localhost:8080/"><img id="logo" src="public/img/logo2.svg"></a>
        <?php
        if(isset($_COOKIE['user']))
        {?>

            <div id="buttons">
                <div class="concreteButton">
                    <form action="getUserAdvertisements" method="GET"><button class="profileButton"></button></form>
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
                    <form action="logout" method="GET"><button class="logoutButton"></button></form>
                    wyloguj
                </div>
            </div>
        <?php } else { ?>
            <a href="http://localhost:8080/login"><button class="button">ZALOGUJ</button></a>
        <?php } ?>
    </nav>
</header>
</body>
<template id="dropdown-template">
    <form action="getUserAdvertisements" method="GET">
        <button type="submit" class="b1"  name="toShow" value="">
            <img src="">
            <div class="b1-div">
                <p>heejka</p>
            </div>
        </button>
    </form>
</template>