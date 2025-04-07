<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>



<!DOCTYPE html>
<html lang="fr" >

<!--description part-->
<head>
  <meta charset="UTF-8">
  <title>Page d'inscription</title>
  <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
  <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours." />
  <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">

</head>
  
<body>
<!--sign up form code-->

  <header>	
  <h1 style="text-align:center"> 紅葉 Momiji Travel  </h1>

	<!--navigation part to navigate through different pages-->
        <nav>
	    <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
            <a href="tour.html">Les circuits typiques</a>
	    <a href="login_form.php">Connexion</a>
		<a href="profil.html">Votre Profil</a>
        </nav>
  </header>

    <main>
<section class = "background"> <!--for the background image-->
  <div class="wrap"> <!-- container that centers its content both horizontally and vertically on the screen. -->
  <div class="login_box"> <!--Login box styling with blur effect, border, and shadow-->
    <div class="login-header"> <!--title of the sign up form-->
      <span>Inscription</span>
    </div>
        
<div class="input_box">
      <input type="text" id="user" class="input-field" required>
      <label for="user" class="label">Prénom</label>
      <i class="bx bx-user-circle icon"></i> <!--each i class bx bx is for a icon that represent the field-->
 </div>
    
 <div class="input_box">
      <input type="text" id="user" class="input-field" required>
      <label for="user" class="label">Nom</label>
      <i class="bx bx-user-circle icon"></i>
 </div>
    
 <div class="input_box">
      <input type="text" id="user" class="input-field" required>
      <label for="user" class="label">Adresse email</label>
      <i class="bx bx-envelope icon"></i>
 </div>
    
<div class="input_box">
      <input type="text" id="user" class="input-field" required>
      <label for="user" class="label">Identifiant</label>
      <i class="bx bx-user icon"></i>
    </div>
    
    <div class="input_box">
      <input type="password" id="pass" class="input-field" required>
      <label for="pass" class="label">Mot de passe</label>
      <i class="bx bx-lock-alt icon"></i>  
 </div>
    

<form action="index.html" method="get">
  <div class="input_box">
    <input type="submit" class="input-submit" value="S'inscrire"> <!--here is to submit the sign up info-->
  </div>
</form>

    <div class="register">
      <p>Déjà un de compte ? 
      <a href="login_form.html">Connectez-vous</a></p>   
    </div>
  </div>
</div>
</section>  

    </main>
    <footer>
        <p>&copy; 2025 Momiji Travel - Tous droits réservés</p>
    </footer>

</body>
</html>
