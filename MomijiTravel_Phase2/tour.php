<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

// Get current date for date input min attribute
$currentDate = date('Y-m-d');

// Check for error messages
$error = isset($_GET['error']) ? $_GET['error'] : '';
$errorMessage = '';
if ($error === 'past_date') {
    $errorMessage = 'La date de départ doit être dans le futur.';
}

require 'functions/functions.php'

?>

<!DOCTYPE html>
<html lang="fr">


<!--description part-->
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
	<!--navigation part is to navigate through different pages -->
        <nav>
	    <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
			<?php include 'nav.php'; ?> 
        </nav>
    </header>     
	    
	    
    <main>
	<br/>
	<h1 id="culture"><strong>Culture & Temples</strong></h1> <!-- there is three id in this page, used to link this page with the formular in the presentation page-->
	<div class="tour-grid">
	    <!-- tour card is in the tour grid: used only to show info of the each trip available -->
   	    <div class="tour-card" style="background-image: url('assets/images/kanto-kansai-culture.jpg');"> <!--different image for each tour card-->
       		<h4>Circuit Classique <em>Kanto - Kansai</em></h4>
       		<p>10 jours entre Tokyo et Kyoto pour découvrir les temples emblématiques du Japon, des sanctuaires sacrés et les paysages d’automne. Un itinéraire alliant tradition, sérénité et beauté naturelle.</p>
       		<span class="price">À partir de 3700€</span>
		<a href="all_tour_details/tour_kanto_kansai_culture.php">Découvrir</a> <!-- link to send the client to a more detail page about this trip only accesible here -->
   	    </div>

   	    <div class="tour-card" style="background-image: url('assets/images/kanto-tohoku-culture.jpg');">
       		<h4>Circuit <em>Kanto - Tohoku</em></h4>
       		<p>Explorez les temples emblématiques de Tokyo et Nikko, puis découvrez les paysages époustouflants de Tohoku. Un voyage entre tradition et nature, où chaque étape vous plonge dans l’essence du Japon.</p>
       		<span class="price">À partir de 3500€</span>
		<a href="all_tour_details/tour_kanto_tohoku_culture.php">Découvrir</a>
   	    </div>

   	    <div class="tour-card" style="background-image: url('assets/images/kansai-tohoku-culture.jpg');">
       		<h4>Circuit <em>Kansai - Tohoku</em></h4>
       		<p>Explorez les trésors spirituels de Kyoto et Nara, avant de plonger dans la beauté sauvage de Tohoku. 10 jours d’émerveillement entre temples ancestraux et paysages automnaux. Une aventure unique au cœur du Japon.</p>
       		<span class="price">À partir de 3700€</span>
		<a href="all_tour_details/tour_kansai_tohoku_culture.php">Découvrir</a>
   	    </div>


	<br/>
	<h1 id="food"><strong>Gastronomique & Traditionnel</strong></h1>

   	    <div class="tour-card" style="background-image: url('assets/images/kanto-kansai-food.jpg');">
       		<h4>Circuit <em>Kanto - Kansai</em></h4>
       		<p>10 jours entre gastronomie et traditionnel pour savourer l'authenticité du Japon à travers ses spécialités culinaires et son ambiance unique.</p>
       		<span class="price">À partir de 3700€</span>
		<a href="all_tour_details/tour_kanto_kansai_food.php">Découvrir</a>
   	    </div>

   	    <div class="tour-card" style="background-image: url('assets/images/kanto-tohoku-food.jpg');">
       		<h4>Circuit <em>Kanto - Tohoku</em></h4>
       		<p>10 jours d'évasion : 5 jours à explorer la culture de Kanto, suivis de 5 jours de délices gastronomiques de Tohoku. Un voyage entre tradition et bien-être.</p>
       		<span class="price">À partir de 3500€</span>
		<a href="all_tour_details/tour_kanto_tohoku_food.php">Découvrir</a>
   	    </div>

   	    <div class="tour-card" style="background-image: url('assets/images/kansai-tohoku-food.jpg');">
       		<h4>Circuit <em>Kansai - Tohoku</em></h4>
       		<p>10 jours d’évasion entre la magie du paysages de Kansai et les délices gastronomiques de Tohoku. Tradition et saveurs au cœur du Japon.</p>
       		<span class="price">À partir de 3700€</span>
		<a href="all_tour_details/tour_kansai_tohoku_food.php">Découvrir</a>
   	    </div>

	<br/>
	<h1 id="detente"><strong>Détente & Bien-être</strong></h1>

   	    <div class="tour-card" style="background-image: url('assets/images/kanto-kansai-detente.jpg');">
       		<h4>Circuit <em>Kanto - Kansai</em></h4>
       		<p>Vivez 10 jours de pure détente : entre Kanto et Kansai, profitez de paysages splendides et de moments de bien-être inégalés dans les onsen.</p>
       		<span class="price">À partir de 3700€</span>
		<a href="all_tour_details/tour_kanto_kansai_detente.php">Découvrir</a>
   	    </div>

   	    <div class="tour-card" style="background-image: url('assets/images/kanto-tohoku-detente.jpg');">
       		<h4>Circuit <em>Kanto - Tohoku</em></h4>
       		<p>10 jours entre culture et détente : explorez Kanto, ses temples et sa modernité, puis laissez-vous envelopper par les onsen apaisants de Tohoku. Un voyage de bien-être et de découvertes.</p>
       		<span class="price">À partir de 3500€</span>
		<a href="all_tour_details/tour_kanto_tohoku_detente.php">Découvrir</a>
   	    </div>

   	    <div class="tour-card" style="background-image:  url('assets/images/kansai-tohoku-detente.jpg');">
       		<h4>Circuit <em>Kansai - Tohoku</em></h4>
       		<p>10 jours entre tradition et bien-être.
5 jours à Kansai, entre temples et paysages automnaux, suivis de 5 jours de détente absolue dans les onsen de Tohoku. Un voyage de pure sérénité.</p>
       		<span class="price">À partir de 3700€</span>
		<a href="all_tour_details/tour_kansai_tohoku_detente.php">Découvrir</a>
   	    </div>

	</div>

	

    </main>

    <?php include 'footer.php'; ?>
