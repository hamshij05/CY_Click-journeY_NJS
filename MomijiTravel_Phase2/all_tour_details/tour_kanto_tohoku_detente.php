<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">



<!--description part-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours.">
    <title>Momiji Travel - Voyages d'automne au Japon</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>



<body>
    <header>
        <h1>紅葉 Momiji Travel</h1>
	<!--navigation part to navigate through different pages-->
        <nav>
	    <a href="../index.php">Accueil</a>
            <a href="../presentation.php">Présentation</a>
            <a href="../search.php">Rechercher un voyage</a>
	    <a href="../tour.html">Les circuits typiques</a>
        <?php include 'nav.php'; ?> 
        </nav>
    </header>

    <main>
	
	<!--journey highlights is used here to represent all the details for this trip with a list-->

        <section class="journey-highlights" style="background-image: url('../assets/images/kanto-tohoku-detente.jpg') center/cover;">
            <h2>Circuit <em>Kanto - Tohoku</em></h2>
	    <p>10 jours entre culture et détente : explorez Kanto, ses temples et sa modernité, puis laissez-vous envelopper par les onsen apaisants de Tohoku. Un voyage de bien-être et de découvertes.</p><br/>


	    <h3> 5 Jours à Kanto (Tokyo – Nikko – Kamakura)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel Mandarin Oriental à Tokyo, idéalement situé pour visiter tous les sites touristiques.</p>
	    
            <ul class="highlights-list">
                <li>Jour 1 : Tokyo – Dîner de kaiseki, découverte du marché de Tsukiji</li>
                <li>Jour 2 : Hakone – Onsen avec vue sur le Mont Fuji, dégustation de tofu yuba</li>
                <li>Jour 3 : Chiba – Dégustation de poissons frais à Katsuura, promenade au temple Naritasan</li>
                <li>Jour 4 : Tokyo – Shopping de spécialités japonaises avant le départ</li>
                <li>Jour 5 : Aller à Akita en Shikansen 新幹線 – Aller à Nyuto Onsen en Train </li>
            </ul><br/>

	    <h3> 5 Jours à Tohoku (Nyuto Onsen – Ginzan Onsen – Sendai)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel Akita Castle Hotel à Aizu-Wakamatsu, idéalement situé pour visiter tous les sites touristiques.</p>

            <ul class="highlights-list">
                <li>Jour 6 :  Nyuto Onsen – Séjour en ryokan avec onsen naturel</li>
                <li>Jour 7 : Ginzan Onsen – Promenade dans un village thermal d’époque</li>
                <li>Jour 8 : Sendai – Visite du jardin Jozenji-dori et détente</li>
                <li>Jour 9 : Sendai – Visite Libre </li>
                <li>Jour 10 : Revenir en France</li>
            </ul>

        </section>

    </main>

    <?php include '../footer.php'; ?>

