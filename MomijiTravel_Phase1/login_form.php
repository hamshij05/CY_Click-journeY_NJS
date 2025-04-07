<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="fr" >

<!--Description of the page-->
<head>
  <meta charset="UTF-8">
  <title>Page de connexion</title>
  <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
  <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours." />
  <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">

</head>
  
<body>
<!--login form code-->

  <header>	
  <h1> 紅葉 Momiji Travel  </h1>

	<!-- navigation part: place to go to others pages-->
        <nav>
		 <a href="index.php">Accueil</a>
		<a href="presentation.php">Présentation</a>
		<a href="search.php">Rechercher un voyage</a>
		<a href="tour.html">Les circuits typiques</a>
		<a href="sign_up.php">S'inscrire</a>
		<a href="profil.php">Votre Profil</a>
        </nav>
  </header>

    <main>
	<!-- this section is for another background image-->
	<section class = "background"> 
		<!-- container that centers its content both horizontally and vertically on the screen. -->
  		<div class="wrap">
			<!--Login box styling with blur effect, border, and shadow-->
  			<div class="login_box">
    				<div class="login-header"> <!--title of the login form-->
      					<span>Connexion</span>
    				</div>

    				<div class="input_box">
      					<input type="text" id="user" class="input-field" required>
      					<label for="user" class="label">Identifiant</label>
      					<i class="bx bx-user icon"></i> <!-- This is to put the "user icon" to represente the field--> 
    				</div>

    				<div class="input_box">
      					<input type="password" id="pass" class="input-field" required>
      					<label for="pass" class="label">Mot de passe</label>
      					<i class="bx bx-lock-alt icon"></i> <!--icon for password-->
    				</div>

    				<div class="remember-forgot">
      					<div class="remember-me">
        				<input type="checkbox" id="remember"> <!--checknox to notice the web to remember the password-->
        				<label for="remember">Se souvenir de moi</label>
      				</div>

      				<div class="forgot">
        				<a href="#">Mot de passe oublié ?</a> <!-- there is still no page to recover the account of the client-->
      				</div>
    			</div>

			<form action="index.html" method="get">
  				<div class="input_box">
    					<input type="submit" class="input-submit" value="Se connecter"> <!-- button to login in-->
  				</div>
			</form>

    			<div class="register">
      				<p>Pas de compte ? 
      				<a href="sign_up.html">Inscrivez-vous</a></p>    
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
