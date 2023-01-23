<!DOCTYPE html>
<?php
if (!isset($_COOKIE['user'])) {
    $url = "htp://$_SERVER[HTTP_HOST]";
    HEADER("Location: {$url}/");
} ?>
<head>
    <meta charset="UTF-8">
    <title>announcement adding</title>
    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <link rel="stylesheet" type="text/css" href="public/css/adding.css">
    <script type="text/javascript" src="/js/addProject.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">


</head>
<body>
<div class="base-container">
    <?php include 'navigation.php'; ?>
    <main>
        <form class="postAdvertisement"
            <?php
            if (isset($add)) { ?>
                action="modifyAdvertisement"
            <?php } else { ?>
                action="addAdvertisement"
            <?php } ?>
              method="POST" ENCTYPE="multipart/form-data">
            <?php
            if (isset($messages)) {
                foreach ($messages as $message) {
                    echo $message;
                    ?><br>
                    <?php
                }
            }

            ?>
            dodaj zdjęcia:
            <div class="addContainer">
                <input id='files' name='file[]' type="file" multiple="multiple" hidden
                       accept="image/jpeg, image/png, image/jpg"/>
                <input id="addButton" type="button"></input>
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
            value="<?= $add->getId() ?>"
        <?php } ?>
    >
        <?php
        if (isset($add)) {
            ?>
            ZMIEŃ
        <?php } ?>
        <?php if (!isset($add)) { ?>
            DODAJ
        <?php } ?>

    </button>
</div>
</form>


</main>
</div>
</body>
</html>