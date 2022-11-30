<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/zalogowany_main.css">
    <link rel="stylesheet" type="text/css" href="public/css/profile_like.css">
    <link rel="stylesheet" type="text/css" href="public/css/profile_ad.css">
    <script type="text/javascript" src="/js/projectsOptions.js" defer></script>
    <link rel="stylesheet" href="https://fonts.google.com/specimen/Glegoo?query=glegoo"/>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/84b42560c5.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Aladin&display=swap" rel="stylesheet">
    <title> AD </title>
</head>

<body>
<div class="base-container">
    <header>
        <nav>
            <a href="http://localhost:8080/"><img id="logo" src="public/img/logo2.svg"></a>
            <div class="search-bar">
                <input class="userInfo" placeholder="miasto, województwo" type="text">
                <img id="icons" src="public/img/ikonki/lupka.png"></img>
            </div>
            <div id="buttons">
                <div class="concreteButton">
                    <button class="profileButton"></button>
                    profil
                </div>
                <div class="concreteButton">
                    <button class="alarmButton"></button>
                    powiadomienia
                </div>
                <div class="concreteButton">
                    <button class="logoutButton"></button>
                    wyloguj
                </div>
            </div>
        </nav>
    </header>

    <main>

        <nav2>
            <button id= "option1" class="optionButton">moje ogłoszenia</button>
            <button class="optionButton">polubione</button>
            <button class="optionButton">ustawienia</button>
        </nav2>
        <div id="rightContainer">
                <form  action="addAdvertisement" method="GET">
                <button id="addButton" type="submit"><img src="public/img/ikonki/add.svg"> DODAJ NOWE</button>
                </form>

                <?php
                if(isset($advertisment))
                foreach ($advertisment as $add): ?>
                    <div class="ad" id="<?=$add->getId()?>">
                        <img src="public/uploads/<?= $add->getFirstPicture(); ?>">
                        <div class="buttonsContainer1">
                            <div class="buttonsContainer2">
                                <form  id="gearForm"  action="addAdvertisement" method="GET" ENCTYPE="multipart/form-data"> <button type="submit" class="gearButton" name='gear' value="<?=$add->getId()?>"></button></form>
                                <button class="binButton"></button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>




        </div>


    </main>
</div>
</body>