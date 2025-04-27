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

        <section class="journey-highlights" style="background-image: url('../assets/images/kanto-kansai-detente.jpg');">
            <h2>Circuit <em>Kanto - Kansai</em></h2>
	    <p>Vivez 10 jours de pure détente : entre Kanto et Kansai, profitez de paysages splendides et de moments de bien-être inégalés dans les onsen.</p><br/>


	    <h3> 5 Jours à Kanto (Hakone – Izu – Karuizawa – Tokyo )</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux ryokan Gora Kadan à Hakone, idéalement situé pour visiter tous les sites touristiques.</p>
	    
            <ul class="highlights-list">
                <li>Jour 1 : Hakone – Nuit en ryokan avec onsen, promenade près du lac Ashi</li>
                <li>Jour 2 : Izu – Bain dans un onsen en bord de mer, découverte des sources thermales de Shuzenji</li>
                <li>Jour 3 : Karuizawa – Observation des érables dans le jardin Kumoba, spa haut de gamme</li>
                <li>Jour 4 : Tokyo – Journée shopping détente à Ginza et Omotesando</li>
                <li>Jour 5 : Aller à Kyoto en Shikansen 新幹線 – Kyoto à Arashiyama en train</li>
            </ul><br/>

	    <h3> 5 Jours à Kansai (Arashiyama – Kinosaki Onsen – Wakayama – Kyoto)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours dans différentes Ryokan de Luxe, idéalement situé pour visiter tous les sites touristiques.</p>

            <ul class="highlights-list">
                <li>Jour 6 : Arashiyama – Forêt de bambous, temples et ryokan</li>
                <li>Jour 7 : Kinosaki Onsen – Expérience de sept bains publics traditionnels</li>
                <li>Jour 8 :  Wakayama – Détente en bord de mer, onsen avec vue sur l’océan</li>
                <li>Jour 9 :  Kyoto – Jardins zen et cérémonie du thé </li>
                <li>Jour 10 : Revenir en France</li>
            </ul>

        </section>

    </main>

    <?php include '../footer.php'; ?>

