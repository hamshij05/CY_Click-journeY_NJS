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

// special print for duration
$duration = isset($_POST['duration']) ? $_POST['duration'] : '';


$firstThemeDisplay = "none";
$firstRegionDisplay = "none";
$secondThemeDisplay = "none";
$secondRegionDisplay = "none";
$transportDisplay = "none";
$hotelDisplay = "none";


$firstThemeRequired = "";
$firstRegionRequired = "";
$secondThemeRequired = "";
$secondRegionRequired = "";

// update if duration is selected
if (!empty($duration)) {
    if ($duration === "5") {
        $firstThemeDisplay = "block";
        $firstRegionDisplay = "block";
        $firstThemeRequired = "required";
        $firstRegionRequired = "required";
        $transportDisplay = "block";
        $hotelDisplay = "block";
    } elseif ($duration === "10") {
        $firstThemeDisplay = "block";
        $firstRegionDisplay = "block";
        $secondThemeDisplay = "block";
        $secondRegionDisplay = "block";
        $firstThemeRequired = "required";
        $firstRegionRequired = "required";
        $secondThemeRequired = "required";
        $secondRegionRequired = "required";
        $transportDisplay = "block";
        $hotelDisplay = "block";
    }
}
?>

<!-- html start -->

<?php include 'header.php'; ?> 


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

            <form class="search-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="durationForm">
                <div class="form-group">
                    <label for="duration">Durée du séjour :</label>
                    <select id="duration" name="duration" required onchange="this.form.submit()">
                        <option value="" <?php echo empty($duration) ? 'selected' : ''; ?>>Choisir la durée</option>
                        <option value="5" <?php echo $duration === '5' ? 'selected' : ''; ?>>5 jours</option>
                        <option value="10" <?php echo $duration === '10' ? 'selected' : ''; ?>>10 jours</option>
                    </select>
                </div>
            </form>

            <form class="search-form" action="result_tour.php" method="POST">
                <!-- save duration  -->
                <input type="hidden" name="duration" value="<?php echo htmlspecialchars($duration); ?>">

                <!-- First period fields (shown for both 5 and 10 days) -->
                <div class="form-group" id="first-theme-group" style="display: <?php echo $firstThemeDisplay; ?>;">
                    <label for="first-theme">Thème du voyage pour les premiers 5 jours :</label>
                    <select id="first-theme" name="first-theme" <?php echo $firstThemeRequired; ?>>
                        <option value="">Choisir le thème</option>
                        <option value="culture">Culture & Temples</option>
                        <option value="gastronomique">Gastronomique & Traditionnel</option>
                        <option value="détente">Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group" id="first-region-group" style="display: <?php echo $firstRegionDisplay; ?>;">
                    <label for="first-region">Région pour les premiers 5 jours :</label>
                    <select id="first-region" name="first-region" <?php echo $firstRegionRequired; ?>>
                        <option value="">Choisir la région</option>
                        <option value="kanto">Kantō (Tokyo et alentours)</option>
                        <option value="kansai">Kansai (Kyoto, Osaka, Nara, Kobe)</option>
                        <option value="tohoku">Tōhoku (Nord du Japon)</option>
                    </select>
                </div>

                <!-- Second period fields (shown only for 10 days) -->
                <div class="form-group" id="second-theme-group" style="display: <?php echo $secondThemeDisplay; ?>;">
                    <label for="second-theme">Thème du voyage pour les 5 derniers jours :</label>
                    <select id="second-theme" name="second-theme" <?php echo $secondThemeRequired; ?>>
                        <option value="">Choisir le thème</option>
                        <option value="culture">Culture & Temples</option>
                        <option value="gastronomique">Gastronomique & Traditionnel</option>
                        <option value="détente">Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group" id="second-region-group" style="display: <?php echo $secondRegionDisplay; ?>;">
                    <label for="second-region">Région pour les 5 derniers jours :</label>
                    <select id="second-region" name="second-region" <?php echo $secondRegionRequired; ?>>
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

                <div class="form-group" id="transport-group" style="display: <?php echo $transportDisplay; ?>;">
                    <label for="transport">Type de transport :</label>
                    <select id="transport" name="transport" required>
                        <option value="">Choisir type de transport</option>
                        <option value="vip">VIP ( + 100 euros)</option>
                        <option value="standard">Standard</option>
                    </select>
                </div>

                <div class="form-group" id="hotel-group" style="display: <?php echo $hotelDisplay; ?>;">
                    <label for="hotel">Type de Hotel :</label>
                    <select id="hotel" name="hotel" required>
                        <option value="">Choisir type de Hotel</option>
                        <option value="vip">VIP ( + 150 euros)</option>
                        <option value="standard">Standard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="travelers">Nombre de voyageurs :</label>
                    <input type="number" id="travelers" name="travelers" min="1" max="15" required>
                </div>

                <?php if (!empty($duration)): ?>
                    <button type="submit" class="btn btn-search">Rechercher</button>
                <?php endif; ?>
            </form>
            <div id="price-display">Prix estimé : <strong id="price">0</strong> €</div>
        </section>

        <section class="page-hero">
            <section class="popular-tours">
                <h2>Circuits populaires</h2>
                <div class="tour-grid">
                    <div class="tour-card">
                        <h4>Circuit Classique <em>Kanto - Kansai (Culture & Temples)</em></h4>
                        <p>10 jours de découverte des temples et jardins</p>
                        <span class="price">À partir de 3300€</span>
                        <a href="all_tour_details/tour_kanto_kansai_culture.php">Découvrir</a>
                    </div>
                    <div class="tour-card">
                        <h4>Circuit inoubliable favorite <em>Kanto - Kansai (Gastronomique & Traditionnel)</em> </h4>
                        <p>Entre tradition et modernité</p>
                        <span class="price">À partir de 3500€</span>
                        <a href="all_tour_details/tour_kanto_kansai_food.php">Découvrir</a>
                    </div>
                </div>
            </section>
        </section>
    </main>
    <?php include 'footer.php'; ?>
