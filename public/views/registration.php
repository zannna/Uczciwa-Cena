<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans:ital,wght@0,300;0,400;0,500;1,200&display=swap"
          rel="stylesheet">
    <title> LOGIN </title>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">
    <script type="text/javascript" src="/js/registration.js" defer></script>
</head>

<body>
<div class="container">
    <div id="containerlogo">
        <img src="public/img/logo.svg">
    </div>
    <div class="formContainer">
        <form action="confirmRegistration" method="POST">
            <div class="messages">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <br>imie</br>
            <input name="name" type="text">
            <br>nazwisko</br>
            <input name="surname" type="text">
            <br>miasto lub województwo</br>
            <input name="place" type="text">
            <br>email</br>
            <input name="email" type="text">
            <br>hasło</br>
            <input name="password" type="password">
            <br>powtórz hasło</br>
            <input name="repeatedPassword" type="password"">
            <br>numer telefonu</br>
            <input name="phone" type="text">

            <button id="submit" type="submit" class="button">ZAREJESTRUJ SIĘ</button>

        </form>
    </div>
</div>
</body>
