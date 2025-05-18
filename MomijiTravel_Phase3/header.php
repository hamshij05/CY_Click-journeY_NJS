<?php


// Check actual page to not have twice the link
$currentPage = basename($_SERVER['PHP_SELF']);

// check dark / light mode with cookies
$theme = isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark' ? 'darkstyles.css' : 'styles.css';

// check if connected
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Momiji Travel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ">
  <meta name="description" content="Une page web d'agence de voyage au Japon en automne.">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link id="theme-link" rel="stylesheet" href="assets/css/styles.css">
     <script src="js/theme.js" defer></script>
</head>


<body>
  <header>
  <button id="toggle-theme" class="btn btn-outline">Changer de thème</button>
    <h1>紅葉 Momiji Travel </h1></br></br>
    
    <nav>
      <?php if ($currentPage !== 'index.php'): ?>
        <a href="index.php">Accueil</a>
      <?php endif; ?>
      <?php if ($currentPage !== 'presentation.php'): ?>
        <a href="presentation.php">Présentation</a>
      <?php endif; ?>
      <?php if ($currentPage !== 'search.php'): ?>
        <a href="search.php">Rechercher un voyage</a>
      <?php endif; ?>
      <?php if ($currentPage !== 'tour.php'): ?>
        <a href="tour.php">Les circuits typiques</a>
      <?php endif; ?>

      <?php if ($isLoggedIn): ?>
        <?php if ($currentPage !== 'profil.php'): ?>
          <a href="profil.php">Votre Profil</a>
        <?php endif; ?>
        <a href="logout.php">Déconnexion</a>
      <?php else: ?>
        <?php if ($currentPage !== 'login_form.php'): ?>
          <a href="login_form.php">Connexion</a>
        <?php endif; ?>
        <?php if ($currentPage !== 'sign_up.php'): ?>
          <a href="sign_up.php">S'inscrire</a>
        <?php endif; ?>
      <?php endif; ?>

      
    </nav>
  </header>


