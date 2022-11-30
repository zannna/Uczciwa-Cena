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
        <form class="postAdvertisement"
            <?php
            if (isset($add)) {  ?>
                action="modifyAdvertisement"
            <?php } else { ?>
                action="addAdvertisement"
            <?php } ?>
              method="POST" ENCTYPE="multipart/form-data">
            <?php
            if (isset($messages)) {
                foreach ($messages as $message) {
                    echo $message;
                }
            }
            ?>
            dodaj zdjęcia:
            <div class="addContainer">
                <input id='files' name='file[]' type="file" multiple="multiple" hidden
                       accept="image/jpeg, image/png, image/jpg"/>
                <input id="addButton" type="button""></input>
                <div id="result">
                    <?php
                    if (isset($add)) {
                        foreach ($add->getPictures() as $image) {
                            ?>
                            <img src="public/uploads/<?= $image ?>">
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="radioContainer"
            <label><input type="radio" name="choice"> Szukam</label>
            <label><input id="radio2" type="radio" name="choice"> Oddaje</label>
</div>
<br id="name">przedmiot:</br>
<input class="userInfo" name="name" type="text" placeholder="
<?php
if (isset($add)) {
    echo $add->getName();
}
?>
">
<br>miejsce:</br>
<input class="userInfo" name="place" type="text" placeholder="
<?php
if (isset($add)) {
    echo $add->getPlace();
}
?>
">
<br>opis:</br>
<textarea name="description" placeholder="
<?php
if (isset($add)) {
    echo $add->getDescription();
}
?>
"></textarea>
<div class="endingButtons">
    <button id="undo" class="button" type="button">ANULUJ</button>
    <button name="change" type="submit" id="add" class="button"
        <?php
        if (isset($add)) {
            echo $add->getId();
        ?>
            value="<?=$add->getId()?>">
         <?php } ?>
        <?php
        if (isset($add)) {
            ?>
            ZMIEŃ
        <?php } else { ?>
            DODAJ
        <?php } ?>
    </button>
</div>
</form>


</main>
</div>
</body>
</html>