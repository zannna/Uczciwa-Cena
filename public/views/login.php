<!DOCTYPE html>
   <head>
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@800&display=swap" rel="stylesheet">
    <title> LOGIN </title>
   </head> 

   <body>
        <div class="container">
         <div id="containerlogo">
            <img src="public/img/logo.svg">
         </div> 
         <div id="containerLoginInfo">
          <form action="confirmlogin" method="POST">
              <div class="messages">
                  <?php
                  if(isset($messages)){
                      foreach($messages as $message) {
                          echo $message;
                      }
                  }
                  ?>
              </div>
            <label for="email">EMAIL</label>
            <input name="email" type="text">
            <label for="password">PASSWORD</label>
            <input name="password" type="password">
            <div id="containerButton">
            <button type="submit" class="button"">ZALOGUJ</button>
          </div>
             Nie masz konta?
              <a href="index.php"> Zarejestruj się</a>
          </form>
        </div> 
        </div>
   </body>
