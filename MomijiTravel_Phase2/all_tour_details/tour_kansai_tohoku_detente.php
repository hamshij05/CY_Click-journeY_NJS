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
	    <a href="../tour.php">Les circuits typiques</a>
        <?php include 'nav.php'; ?> 
        </nav>
    </header>

    <main>
	
	<!--journey highlights is used here to represent all the details for this trip with a list-->
        <section class="journey-highlights" style="background-image: url('../assets/images/kansai-tohoku-detente.jpg') ;">
            <h2>Circuit <em>Kansai - Tohoku</em></h2>
	    <p>10 jours entre tradition et bien-être. 5 jours à Kansai, entre temples et paysages automnaux, suivis de 5 jours de détente absolue dans les onsen de Tohoku. Un voyage de pure sérénité.</p><br/>


	    <h3> 5 Jours à Kansai (Arashiyama – Kinosaki Onsen – Wakayama – Kyoto)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours dans différentes Ryokan de Luxe, idéalement situé pour visiter tous les sites touristiques.</p>
	    
            <ul class="highlights-list">
                <li>Jour 1 : Arashiyama – Forêt de bambous, temples et ryokan
</li>
                <li>Jour 2 : Kinosaki Onsen – Expérience de sept bains publics traditionnels</li>
                <li>Jour 3 :Wakayama – Détente en bord de mer, onsen avec vue sur l’océan</li>
                <li>Jour 4 : Kyoto – Jardins zen et cérémonie du thé</li>
                <li>Jour 5 : Kyoto à Morioka en Shikansen 新幹線 – Morioka à Nyuto Onsen en train</li>
            </ul><br/>

	    <h3> 5 Jours à Tohoku (Nyuto Onsen – Ginzan Onsen – Sendai)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel Akita Castle Hotel à Aizu-Wakamatsu, idéalement situé pour visiter tous les sites touristiques.</p>


            <ul class="highlights-list">
                <li>Jour 6 : Nyuto Onsen – Séjour en ryokan avec onsen naturel</li>
                <li>Jour 7 : Ginzan Onsen – Promenade dans un village thermal d’époque</li>
                <li>Jour 8 : Sendai – Visite du jardin Jozenji-dori et détente</li>
                <li>Jour 9 : Sendai – Visite libre</li>
                <li>Jour 10 : Revenir en France</li>
            </ul>

        </section>

    </main>

    <?php include '../footer.php'; ?>

