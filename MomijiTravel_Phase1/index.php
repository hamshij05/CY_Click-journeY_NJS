<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">

<!--The description of the page*-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours.">
    <title>Momiji Travel - Voyages d'automne au Japon</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>紅葉 Momiji Travel</h1>

        <!--Here is the navigation of the page: place where you can go to others pages-->
        <nav>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
            <a href="tour.html">Les circuits typiques</a>
            <?php include 'nav.php'; ?> 
        </nav>
    </header>

    <main>
        <!--Here is the hero of the page: the most important part of the page-->
        <section class="page-hero">
            <h2>Explorez le Japon en automne</h2>
            <p>Découvrez nos circuits exclusifs de 10 jours à travers les plus beaux paysages automnaux du Japon. 
               Des temples ancestraux aux érables flamboyants, vivez une expérience inoubliable.</p>
		
            <div class="cta-buttons"> <!-- class cta = call-to-action buttons. It means you can click it. -->
                <a href="search.php" class="btn">Explorer les circuits</a>
                <a href="presentation.php" class="btn btn-outline">En savoir plus</a>
            </div>
        </section>
        
        <!-- section  "features" is for description card (info of the page)-->
        <section class="features">
            <h3>Pourquoi choisir Momiji Travel ?</h3>
            <div class="feature-grid">
                <!-- there is a grid and here will be the first card with its info-->
                <div class="feature-card">
                    <h4>Circuits exclusifs</h4>
                    <p>Des itinéraires enchâssés de poésie, où l'automne japonais dévoile ses couleurs dans deux régions fascinantes, à travers des thèmes uniques et envoûtants.</p>
                </div>
                <div class="feature-card">
                    <h4>Guides experts</h4>
                    <p>Accompagnement par des guides locaux passionnés et francophones.</p>
                </div>
                <div class="feature-card">
                    <h4>Petits groupes</h4>
                    <p>Maximum 15 personnes pour une expérience plus authentique.</p>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
