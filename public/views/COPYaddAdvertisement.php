<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>announcement adding</title>
    <link rel="stylesheet" type="text/css" href="public/css/zalogowany_main.css">
    <link rel="stylesheet" type="text/css" href="public/css/adding.css">
    <script type="text/javascript" src="/js/adding.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">


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
            <form class="postAdvertisement" action="addAdvertisement" method="POST" ENCTYPE="multipart/form-data">
                dodaj zdjęcia:</br>
                <?php
                  if(isset($messages)){
                      foreach($messages as $message) {
                          echo $message;
                      }
                  }
                  ?>
                <div class="addContainer">
                    <input id='file' name='file' type='file' hidden/>
                    <button id="addButton"><img src="../img/ikonki/add.svg"  ></button>
                </div>
                <br>przedmiot:</br>
                <input name="object" type="text">
                <br>miejsce:</br>
                <input name="place" type="text">
                <br>opis:</br>
                <textarea></textarea>
                <div class="endingButtons">
                    <button class="button">ANULUJ</button>
                    <button type="submit" id="add" class="button" >DODAJ</button>
                </div>
            </form>


    </main>
</div>
</body>
</html>