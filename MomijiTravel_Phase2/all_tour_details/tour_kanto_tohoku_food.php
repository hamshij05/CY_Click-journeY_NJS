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

        <section class="journey-highlights" style="background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('../assets/images/kanto-tohoku-food.jpg') center/cover;">
            <h2>Circuit <em>Kanto - Tohoku</em></h2>
	    <p>10 jours d'évasion : 5 jours à explorer la culture de Kanto, suivis de 5 jours de délices gastronomiques de Tohoku. Un voyage entre tradition et bien-être.</p><br/>


	    <h3> 5 Jours à Kanto (Tokyo – Nikko – Kamakura)</h3><br/>
	    <p> Vous séjournerez pendant 5 jours au luxueux hôtel Mandarin Oriental à Tokyo, idéalement situé pour visiter tous les sites touristiques.</p>
	    
            <ul class="highlights-list">
                <li>Jour 1 : Tokyo – Dîner de kaiseki, découverte du marché de Tsukiji</li>
                <li>Jour 2 : Hakone – Onsen avec vue sur le Mont Fuji, dégustation de tofu yuba</li>
                <li>Jour 3 : Chiba – Dégustation de poissons frais à Katsuura, promenade au temple Naritasan</li>
                <li>Jour 4 : Tokyo – Shopping de spécialités japonaises avant le départ</li>
                <li>Jour 5 : Aller à Koriyama en Shikansen – Aller à Aizu-Wakamatsu en Train express 新幹線</li>
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

