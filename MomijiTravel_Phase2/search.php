<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="fr">


<!-- Description of the page-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un voyage - Momiji Travel</title>
    <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours." />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>



<body>


    <header>
        <h1>紅葉 Momiji Travel</h1>
	<!--Navigation part to navigate through different page-->
        <nav>
		<a href="presentation.php">Présentation</a>
		<a href="search.php">Rechercher un voyage</a>
		<a href="tour.html">Les circuits typiques</a>
        <?php include 'nav.php'; ?> 

		<a href="profil.html">Votre Profil</a>
        </nav>
    </header>


    <main>

	<!-- important par of the page and its design-->
        <section class="page-hero">
            <h2>Trouvez votre voyage d'automne idéal</h2>
            <p>Sélectionnez vos dates pour découvrir nos circuits disponibles</p>
        </section>

	<!--this section is a formular to choose the perfect trip for the client-->
        <section class="search-section">
            <form class="search-form"> <!--start of the formular-->
                <div class="form-group"> <!--form-group represent each field that the client is required to fill to be able to send the formular and find the perfect trip-->
                    <label for="region"> 2 Régions du Japon à Voyager :</label> <!--title of the "question"-->
                    <select id="region" name="region" required>
                        <option value="">Choisir les 2 régions</option> <!-- instruction for the client -->
                        <option value="kanto-kansai">Kantō (Tokyo et alentours) - Kansai (Kyoto, Osaka, Nara, Kobe)</option>
                        <option value="kanto-tohoku">Kantō (Tokyo et alentours) - Tōhoku (Nord du Japon, nature et paysages grandioses)</option>
                        <option value="kansai-tohoku">Kansai (Kyoto, Osaka, Nara, Kobe) - Tōhoku (Nord du Japon, nature et paysages grandioses)</option>
                    </select>
                </div>

                <div class="form-group"> <!-- same as the first form group just with a different label , name-->
                    <label for="theme"> Thème du Voyage :</label>
                    <select id="theme" name="theme" required>
                        <option value="">Choisir le thème</option>
                        <option value="culture">Culture & Temples</option>
                        <option value="food">Gastronomique & Traditionnel</option>
                        <option value="detente">Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group"> <!-- this formular is to show a calendar so the client can choose a date-->
                    <label for="date">Date de départ souhaitée :</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="form-group">  <!-- here is not a formular but an obligation, each trip is for 10 days only, no more no less-->
                    <label for="duration">Durée du séjour :</label>
                    <select id="duration" name="duration" required>
                        <option value="10">10 jours</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="travelers">Nombre de voyageurs :</label>
                    <input type="number" id="travelers" name="travelers" min="1" max="15" required> <!--the client can choose between 1 to 15 travelers per group of buyers-->
                </div>

                <button type="submit" class="btn btn-search">Rechercher</button> <!-- button to sumit the formular-->
            </form>
        </section>

	<section class="page-hero"> <!-- another important section that represent the two most popular trip-->
        <section class="popular-tours">
            <h2>Circuits populaires</h2>
            <div class="tour-grid">
                <div class="tour-card">
		    <h4>Circuit Classique <em>Kanto - Kansai (Culture & Temples)</em></h4>
                    <p>10 jours de découverte des temples et jardins</p>
                    <span class="price">À partir de 3300€</span>
		    <a href="all_tour_details/tour_kanto_kansai_culture.html">Découvrir</a>
                </div>
                <div class="tour-card">
                    <h4>Circuit inoubliable favorite <em>Kanto - Kansai (Gastronomique & Traditionnel)</em> </h4>
                    <p>Entre tradition et modernité</p>
                    <span class="price">À partir de 3500€</span>
		    <a href="all_tour_details/tour_kanto_kansai_food.html">Découvrir</a>
                </div>
            </div>
        </section>
	</section>

    </main>
    <footer>
        <p>&copy; 2025 Momiji Travel - Tous droits réservés</p>
    </footer>
</body>
</html>
