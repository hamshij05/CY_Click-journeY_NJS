<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    // Redirect to login page if user is not logged in
    header('Location: login.php');
    exit;
}

// Initialize message variable
$message = '';
$messageClass = '';

// Check if the reservation index is provided
if (!isset($_GET['index']) || !is_numeric($_GET['index'])) {
    // Redirect to profile page if no valid index
    header('Location: profil.php');
    exit;
}

$reservationIndex = intval($_GET['index']);
$userId = $_SESSION['user_id'];
$usersFile = "users.json";

// Get users data
$usersData = json_decode(file_get_contents($usersFile), true);

// Find current user and reservation
$user = null;
$userKey = null;
$reservation = null;

foreach ($usersData['users'] as $key => $u) {
    if ($u['id'] === $userId) {
        $user = $u;
        $userKey = $key;
        // Check if reservation exists
        if (isset($u['reservation']) && 
            is_array($u['reservation']) && 
            isset($u['reservation'][$reservationIndex])) {
            $reservation = $u['reservation'][$reservationIndex];
        }
        break;
    }
}

// If reservation not found, redirect to profile
if ($reservation === null) {
    header('Location: profil.php');
    exit;
}

// Function to generate the price
function generatePrice($theme, $region, $duration = 5, $transport = 'standard', $hotel = 'standard') {
    $basePrice = 3500; // Prix de base par personne
    
    // Additional cost for regions
    if ($region == 'kansai') {
        $basePrice += 200; // Add 200€ for Kansai region
    }
    
    // If it's a 5-day trip, the price is half of the 10-day price
    if ($duration == 5) {
        $basePrice = round($basePrice / 2);
    }

    // Additional cost for VIP transport and hotel
    if ($transport == 'vip') {
        $basePrice += 100; // Add 100€ for VIP transport
    }

    if ($hotel == 'vip') {
        $basePrice += 150; // Add 150€ for VIP hotel
    }
    
    return $basePrice;
}

// Function to extract region code from full name
function getRegionCode($fullName) {
    if (strpos($fullName, 'Kantō') !== false || strpos($fullName, 'Kanto') !== false) return 'kanto';
    if (strpos($fullName, 'Kansai') !== false) return 'kansai';
    if (strpos($fullName, 'Tōhoku') !== false || strpos($fullName, 'Tohoku') !== false) return 'tohoku';
    return '';
}

// Function to extract theme code from full name
function getThemeCode($fullName) {
    if (strpos($fullName, 'Culture') !== false) return 'culture';
    if (strpos($fullName, 'Gastronomique') !== false) return 'gastronomique';
    if (strpos($fullName, 'Détente') !== false || strpos($fullName, 'Detente') !== false) return 'détente';
    return '';
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $duration = $_POST['duration'];
    $firstTheme = $_POST['first-theme'];
    $firstRegion = $_POST['first-region'];
    $secondTheme = isset($_POST['second-theme']) ? $_POST['second-theme'] : '';
    $secondRegion = isset($_POST['second-region']) ? $_POST['second-region'] : '';
    $date = $_POST['date'];
    $travelers = intval($_POST['travelers']);
    $transport = $_POST['transport'];
    $hotel = $_POST['hotel'];
    
    // Format the date for display
    $dateFormatted = date("d/m/Y", strtotime($date));
    
    // Get region and theme codes for price calculation
    $firstRegionCode = getRegionCode($_POST['first-region']);
    $firstThemeCode = getThemeCode($_POST['first-theme']);
    
    // Calculate prices
    $firstPrice = generatePrice($firstThemeCode, $firstRegionCode, 5, $transport, $hotel);
    $secondPrice = 0;
    
    if ($duration == 10 && !empty($secondTheme) && !empty($secondRegion)) {
        $secondRegionCode = getRegionCode($secondRegion);
        $secondThemeCode = getThemeCode($secondTheme);
        $secondPrice = generatePrice($secondThemeCode, $secondRegionCode, 5, $transport, $hotel);
    }
    
    $totalPrice = ($duration == 10) ? ($firstPrice + $secondPrice) : $firstPrice;
    $totalGroupPrice = $totalPrice * $travelers;
    
    // Create updated reservation
    $updatedReservation = [
        'date' => $dateFormatted,
        'duration' => $duration,
        'participants' => $travelers,
        'transport' => $transport == 'vip' ? 'Transport VIP' : 'Transport Standard',
        'hotel' => $hotel == 'vip' ? 'Hotel VIP' : 'Hotel Standard',
        'region1' => $_POST['first-region'],
        'theme1' => $_POST['first-theme'],
        'region2' => $duration == 10 ? $_POST['second-region'] : '',
        'theme2' => $duration == 10 ? $_POST['second-theme'] : '',
        'total_price' => $totalGroupPrice
    ];
    
    // Update the reservation in the user data
    $usersData['users'][$userKey]['reservation'][$reservationIndex] = $updatedReservation;
    
    // Save the updated data
    if (file_put_contents($usersFile, json_encode($usersData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        $message = "Votre réservation a été mise à jour avec succès!";
        $messageClass = "success";
        $reservation = $updatedReservation; // Update the reservation for display
    } else {
        $message = "Une erreur s'est produite lors de la mise à jour de la réservation.";
        $messageClass = "error";
    }
}

// Get current date for date input min attribute
$currentDate = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 5 ou 10 jours.">
    <title>Modifier votre réservation - Momiji Travel</title>
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
        <nav>
            <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
            <a href="tour.php">Les circuits typiques</a>
            <?php include 'nav.php'; ?>
        </nav>
    </header>

    <main>
        <section class="page-hero">
            <h2>Modifier la réservation</h2>
            <p>Ajustez les détails du voyage selon vos préférences</p>
        </section>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <section class="search-section">
            <form class="search-form" action="modify_reservation.php?index=<?php echo $reservationIndex; ?>" method="POST">
                <div class="form-group">
                    <label for="duration">Durée du séjour :</label>
                    <select id="duration" name="duration" required>
                        <option value="">Choisir la durée</option>
                        <option value="5" <?php echo $reservation['duration'] == '5' ? 'selected' : ''; ?>>5 jours</option>
                        <option value="10" <?php echo $reservation['duration'] == '10' ? 'selected' : ''; ?>>10 jours</option>
                    </select>
                </div>

                <!-- First period fields -->
                <div class="form-group" id="first-theme-group">
                    <label for="first-theme">Thème du voyage pour les premiers 5 jours :</label>
                    <select id="first-theme" name="first-theme">
                        <option value="">Choisir le thème</option>
                        <option value="Culture & Temples" <?php echo $reservation['theme1'] == 'Culture & Temples' ? 'selected' : ''; ?>>Culture & Temples</option>
                        <option value="Gastronomique & Traditionnel" <?php echo $reservation['theme1'] == 'Gastronomique & Traditionnel' ? 'selected' : ''; ?>>Gastronomique & Traditionnel</option>
                        <option value="Détente & Bien-être" <?php echo $reservation['theme1'] == 'Détente & Bien-être' ? 'selected' : ''; ?>>Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group" id="first-region-group">
                    <label for="first-region">Région pour les premiers 5 jours :</label>
                    <select id="first-region" name="first-region">
                        <option value="">Choisir la région</option>
                        <option value="Kantō (Tokyo et alentours)" <?php echo $reservation['region1'] == 'Kantō (Tokyo et alentours)' ? 'selected' : ''; ?>>Kantō (Tokyo et alentours)</option>
                        <option value="Kansai (Kyoto, Osaka, Nara, Kobe)" <?php echo $reservation['region1'] == 'Kansai (Kyoto, Osaka, Nara, Kobe)' ? 'selected' : ''; ?>>Kansai (Kyoto, Osaka, Nara, Kobe)</option>
                        <option value="Tōhoku (Nord du Japon)" <?php echo $reservation['region1'] == 'Tōhoku (Nord du Japon)' ? 'selected' : ''; ?>>Tōhoku (Nord du Japon)</option>
                    </select>
                </div>

                <!-- Second period fields -->
                <div class="form-group" id="second-theme-group" style="display: <?php echo $reservation['duration'] == '10' ? 'block' : 'none'; ?>;">
                    <label for="second-theme">Thème du voyage pour les 5 derniers jours :</label>
                    <select id="second-theme" name="second-theme">
                        <option value="">Choisir le thème</option>
                        <option value="Culture & Temples" <?php echo $reservation['theme2'] == 'Culture & Temples' ? 'selected' : ''; ?>>Culture & Temples</option>
                        <option value="Gastronomique & Traditionnel" <?php echo $reservation['theme2'] == 'Gastronomique & Traditionnel' ? 'selected' : ''; ?>>Gastronomique & Traditionnel</option>
                        <option value="Détente & Bien-être" <?php echo $reservation['theme2'] == 'Détente & Bien-être' ? 'selected' : ''; ?>>Détente & Bien-être</option>
                    </select>
                </div>

                <div class="form-group" id="second-region-group" style="display: <?php echo $reservation['duration'] == '10' ? 'block' : 'none'; ?>;">
                    <label for="second-region">Région pour les 5 derniers jours :</label>
                    <select id="second-region" name="second-region">
                        <option value="">Choisir la région</option>
                        <option value="Kantō (Tokyo et alentours)" <?php echo $reservation['region2'] == 'Kantō (Tokyo et alentours)' ? 'selected' : ''; ?>>Kantō (Tokyo et alentours)</option>
                        <option value="Kansai (Kyoto, Osaka, Nara, Kobe)" <?php echo $reservation['region2'] == 'Kansai (Kyoto, Osaka, Nara, Kobe)' ? 'selected' : ''; ?>>Kansai (Kyoto, Osaka, Nara, Kobe)</option>
                        <option value="Tōhoku (Nord du Japon)" <?php echo $reservation['region2'] == 'Tōhoku (Nord du Japon)' ? 'selected' : ''; ?>>Tōhoku (Nord du Japon)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Date de départ souhaitée :</label>
                    <?php
                    // Convert the date format from dd/mm/yyyy to yyyy-mm-dd for the input
                    $dateParts = explode('/', $reservation['date']);
                    if (count($dateParts) === 3) {
                        $dateForInput = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
                    } else {
                        $dateForInput = date('Y-m-d');
                    }
                    ?>
                    <input type="date" id="date" name="date" min="<?php echo $currentDate; ?>" value="<?php echo $dateForInput; ?>" required>
                </div>

                <div class="form-group" id="transport-group">
                    <label for="transport">Type de transport :</label>
                    <select id="transport" name="transport">
                        <option value="">Choisir type de transport</option>
                        <option value="vip" <?php echo strpos($reservation['transport'], 'VIP') !== false ? 'selected' : ''; ?>>VIP ( + 100 euros)</option>
                        <option value="standard" <?php echo strpos($reservation['transport'], 'Standard') !== false ? 'selected' : ''; ?>>Standard</option>
                    </select>
                </div>

                <div class="form-group" id="hotel-group">
                    <label for="hotel">Type de Hotel :</label>
                    <select id="hotel" name="hotel">
                        <option value="">Choisir type de Hotel</option>
                        <option value="vip" <?php echo strpos($reservation['hotel'], 'VIP') !== false ? 'selected' : ''; ?>>VIP ( + 150 euros)</option>
                        <option value="standard" <?php echo strpos($reservation['hotel'], 'Standard') !== false ? 'selected' : ''; ?>>Standard</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="travelers">Nombre de voyageurs :</label>
                    <input type="number" id="travelers" name="travelers" min="1" max="15" value="<?php echo $reservation['participants']; ?>" required>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-search">Enregistrer les modifications</button>
                    <a href="view_reservation.php?index=<?php echo $reservationIndex; ?>" class="btn btn-cancel">Annuler</a>
                </div>
            </form>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
