<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html>
    <!--description part-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ -">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours.">
    <title>Momiji Travel - Voyages d'automne au Japon</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
       <header>
        <h1>紅葉 Momiji Travel</h1>
	<!--navigation part is to navigate through different pages -->
        <nav>
	        <a href="index.php">Accueil</a>
          <a href="presentation.php">Présentation</a>
          <a href="search.php">Rechercher un voyage</a>
		<a href="tour.html">Les circuits typiques</a>
    <?php include 'nav.php'; ?> 

        </nav>
    </header> 
  <main>
    <?php if ($isLoggedIn): ?>
    <section class="title-profil">
     <h3>Votre profil</h3>
      <div class="photo-container">
        <img src="profil.jpg"class="profil-picture">
      </div>
    </section>
    <section class="wrap">
      <div class="login_box">
          <div class="profil-section">
            <div class="profil">Nom</div>
            <div class="profil">Prénom</div>
            <div class="profil">Identifiant</div>
            <div class="profil">Email</div>
            <div class="edit-profil"> 
             <a href="editer-profil.html">Editez votre profil <a> </div>
          </div>
      </div>
    </section>
    <?php else: ?>
    <section class="page-hero">
      <h2>Il faut avoir un compte</h2>
      <div class="auth-buttons">
        <a href="login_form.php" class="btn">Se connecter</a>
        <a href="sign_up.php" class="btn">S'inscrire</a>
      </div>
    </section>
    <?php endif; ?>
  </main>
   <footer>
        <p>&copy; 2025 Momiji Travel - Tous droits réservés</p>
   </footer>
  
  </body>
  </html>
