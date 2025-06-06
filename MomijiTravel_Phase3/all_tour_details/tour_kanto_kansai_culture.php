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

        <section class="journey-highlights" style="background-image: url('../assets/images/kanto-kansai-culture.jpg');">
            <h2>Circuit Classique <em>Kanto - Kansai</em></h2>
	    <p>10 jours entre Tokyo et Kyoto pour découvrir les temples emblématiques du Japon, des sanctuaires sacrés et les paysages d’automne. Un itinéraire alliant tradition, sérénité et beauté naturelle.</p><br/>


	    <h3> 5 Jours à Kanto (Tokyo – Nikko – Kamakura)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel Mandarin Oriental à Tokyo, idéalement situé pour visiter tous les sites touristiques.</p>
	    
            <ul class="highlights-list">
                <li>Jour 1 : Tokyo – Dépose les valises à l'hotel – Visite du temple Sensō-ji, promenade dans le jardin Rikugien (érables rouges)</li>
                <li>Jour 2 : Nikko – Sanctuaire Toshogu (UNESCO), balade au lac Chuzenji</li>
                <li>Jour 3 : Hakone – Visite du temple Choanji, détente dans un ryokan avec onsen</li>
                <li>Jour 4 : Kamakura – Temples Engaku-ji et Hasedera, vue sur l’océan</li>
                <li>Jour 5 : Aller à Kyoto en Shikansen 新幹線</li>
            </ul><br/>

	    <h3> 5 Jours à Kansai (Kyoto – Nara – Koyasan)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel The Ritz-Carlton à Kyoto, idéalement situé pour visiter tous les sites touristiques.</p>

            <ul class="highlights-list">
                <li>Jour 6 : Kyoto – Temple Kiyomizu-dera, promenade à Gion</li>
                <li>Jour 7 : Kyoto – Arashiyama (forêt de bambous) et temple Tofuku-ji (feuilles rouges)</li>
                <li>Jour 8 : Nara – Parc de Nara, visite du temple Todai-ji</li>
                <li>Jour 9 :  Koyasan – Nuit dans un temple bouddhiste, méditation zen</li>
                <li>Jour 10 : Revenir en France</li>
            </ul>

        </section>

    </main>

    <?php include '../footer.php'; ?>

