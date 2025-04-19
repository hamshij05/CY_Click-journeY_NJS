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

        <section class="journey-highlights" style="background-image: url('../assets/images/kansai-tohoku-food.jpg');">
            <h2>Circuit <em>Kansai - Tohoku</em></h2>
	    <p>10 jours d’évasion entre la magie du paysages de Kansai et les délices gastronomiques de Tohoku. Tradition et saveurs au cœur du Japon.</p><br/>


	    <h3> 5 Jours à Kansai (Kyoto – Nara – Koyasan)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel The Ritz-Carlton à Kyoto, idéalement situé pour visiter tous les sites touristiques.</p>
	    
            <ul class="highlights-list">
                <li>Jour 1 : Arrive à Osaka – Dépose les valises à l'hotel – Dégustation de takoyaki et okonomiyaki, visite du château
</li>
                <li>Jour 2 : Kyoto – Dîner kaiseki, nuit en ryokan avec onsen privé</li>
                <li>Jour 3 :Kobe – Dégustation du bœuf de Kobe, visite du Mont Rokko</li>
                <li>Jour 4 : Kyoto – Visite libre</li>
                <li>Jour 5 : Kyoto à Koriyama en Shikansen 新幹線 – Koriyama à Aizu-Wakamatsu en train</li>
            </ul><br/>

	    <h3> 5 Jours à Tohoku (Aizu-Wakamatsu – Akita – Morioka)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel Akita Castle Hotel à Aizu-Wakamatsu, idéalement situé pour visiter tous les sites touristiques.</p>


            <ul class="highlights-list">
                <li>Jour 6 : Aizu-Wakamatsu – Dégustation de soba, visite du château de Tsuruga-jo</li>
                <li>Jour 7 : Akita – Expérience du kiritanpo nabe (fondue locale), ryokan traditionnel</li>
                <li>Jour 8 : Nyuto Onsen – Bain dans une source thermale cachée en pleine nature</li>
                <li>Jour 9 :  Morioka – Dégustation de wanko soba (nouilles servies en petites portions)</li>
                <li>Jour 10 : Revenir en France</li>
            </ul>

        </section>

    </main>

    <?php include '../footer.php'; ?>

