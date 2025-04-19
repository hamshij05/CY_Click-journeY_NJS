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
?>

<!DOCTYPE html>
<html lang="fr">

<!-- Description of the page-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un voyage - Momiji Travel</title>
    <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 5 ou 10 jours." />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">

    <script>
            document.addEventListener('DOMContentLoaded', function() {
                const durationSelect = document.getElementById('duration');
                const firstThemeGroup = document.getElementById('first-theme-group');
                const firstRegionGroup = document.getElementById('first-region-group');
                const secondThemeGroup = document.getElementById('second-theme-group');
                const secondRegionGroup = document.getElementById('second-region-group');
                const transportGroup = document.getElementById('transport-group');
                const hotelGroup = document.getElementById('hotel-group');
            
            // Initial setup
            updateFormVisibility();
            
            // Event listener for duration change
            durationSelect.addEventListener('change', updateFormVisibility);
            
            function updateFormVisibility() {
                const duration = durationSelect.value;
                
                if (duration === "5") {
                    firstThemeGroup.style.display = "block";
                    firstRegionGroup.style.display = "block";
                    secondThemeGroup.style.display = "none";
                    secondRegionGroup.style.display = "none";
                    transportGroup.style.display = "block";
                    hotelGroup.style.display = "block";
                    
                    // Make sure second fields are not required
                    document.getElementById('second-theme').required = false;
                    document.getElementById('second-region').required = false;
                    
                    // First fields are required
                    document.getElementById('first-theme').required = true;
                    document.getElementById('first-region').required = true;
                } else if (duration === "10") {
                    firstThemeGroup.style.display = "block";
                    firstRegionGroup.style.display = "block";
                    secondThemeGroup.style.display = "block";
                    secondRegionGroup.style.display = "block";
                    transportGroup.style.display = "block";
                    hotelGroup.style.display = "block";
                    
                    // All fields are required
                    document.getElementById('first-theme').required = true;
                    document.getElementById('first-region').required = true;
                    document.getElementById('second-theme').required = true;
                    document.getElementById('second-region').required = true;
                } else {
                    // Nothing selected, hide all specific fields
                    firstThemeGroup.style.display = "none";
                    firstRegionGroup.style.display = "none";
                    secondThemeGroup.style.display = "none";
                    secondRegionGroup.style.display = "none";
                    transportGroup.style.display = "block";
                    hotelGroup.style.display = "block";
                }
            }
                    });
    </script>
</head>

<body>
    <header>
        <h1>紅葉 Momiji Travel</h1>
        <!--Navigation part to navigate through different page-->
        <nav>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
            <a href="tour.php">Les circuits typiques</a>
            <?php include 'nav.php'; ?> 

        </nav>
    </header>

    <main>
        <!-- important part of the page and its design-->
        <section class="page-hero">
            <h2>Trouvez votre voyage d'automne idéal</h2>
            <p>Sélectionnez vos préférences pour découvrir nos circuits disponibles</p>
        </section>

        <!-- this section is a formular to choose the perfect trip for the client-->
        <section class="search-section">
            <?php if (!empty($errorMessage)): ?>
                <div class="error-message">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>

            <form class="search-form" action="result_tour.php" method="POST"> <!-- form submits to a new page -->
                <div class="form-group">
                    <label for="duration">Durée du séjour :</label>
                    <select id="duration" name="duration" required>
                        <option value="">Choisir la durée</option>
                        <option value="5">5 jours</option>
                        <option value="10">10 jours</option>
                    </select>
                </div>

                <!-- First period fields (shown for both 5 and 10 days) -->
                <div class="form-group" id="first-theme-group" style="display: none;">
                    <label for="first-theme">Thème du voyage pour les premiers 5 jours :</label>
                    <select id="first-theme" name="first-theme">
                        <option value="">Choisir le thème</option>
                        <option value="culture">Culture & Temples</option>
                        <option value="gastronomique">Gastronomique & Traditionnel</option>
                        <option value="détente">Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group" id="first-region-group" style="display: none;">
                    <label for="first-region">Région pour les premiers 5 jours :</label>
                    <select id="first-region" name="first-region">
                        <option value="">Choisir la région</option>
                        <option value="kanto">Kantō (Tokyo et alentours)</option>
                        <option value="kansai">Kansai (Kyoto, Osaka, Nara, Kobe)</option>
                        <option value="tohoku">Tōhoku (Nord du Japon)</option>
                    </select>
                </div>

                <!-- Second period fields (shown only for 10 days) -->
                <div class="form-group" id="second-theme-group" style="display: none;">
                    <label for="second-theme">Thème du voyage pour les 5 derniers jours :</label>
                    <select id="second-theme" name="second-theme">
                        <option value="">Choisir le thème</option>
                        <option value="culture">Culture & Temples</option>
                        <option value="gastronomique">Gastronomique & Traditionnel</option>
                        <option value="détente">Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group" id="second-region-group" style="display: none;">
                    <label for="second-region">Région pour les 5 derniers jours :</label>
                    <select id="second-region" name="second-region">
                        <option value="">Choisir la région</option>
                        <option value="kanto">Kantō (Tokyo et alentours)</option>
                        <option value="kansai">Kansai (Kyoto, Osaka, Nara, Kobe)</option>
                        <option value="tohoku">Tōhoku (Nord du Japon)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Date de départ souhaitée :</label>
                    <input type="date" id="date" name="date" min="<?php echo $currentDate; ?>" required>
                </div>

                <div class="form-group" id="transport-group" style="display: none;">
                    <label for="transport">Type de transport :</label>
                    <select id="transport" name="transport">
                        <option value="">Choisir type de transport</option>
                        <option value="vip">VIP ( + 100 euros)</option>
                        <option value="standard">Standard</option>
                    </select>
                </div>

                <div class="form-group" id="hotel-group" style="display: none;">
                    <label for="hotel">Type de Hotel :</label>
                    <select id="hotel" name="hotel">
                        <option value="">Choisir type de Hotel</option>
                        <option value="vip">VIP ( + 150 euros)</option>
                        <option value="standard">Standard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="travelers">Nombre de voyageurs :</label>
                    <input type="number" id="travelers" name="travelers" min="1" max="15" required>
                </div>

                <button type="submit" class="btn btn-search">Rechercher</button>
            </form>
        </section>

        <section class="page-hero">
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
    <?php include 'footer.php'; ?>
