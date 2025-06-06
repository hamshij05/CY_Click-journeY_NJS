<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    // Redirect to login page if user is not logged in
    header('Location: login.php');
    exit;
}

require 'functions/functions.php';

// Check if deletion is requested
if (isset($_POST['delete_reservation'])) {
    $reservationIndex = intval($_POST['reservation_index']);
    $userId = $_SESSION['user_id'];
    $usersFile = "users.json";
    
    // Get users data
    $usersData = json_decode(file_get_contents($usersFile), true);
    
    // Find current user and delete reservation
    foreach ($usersData['users'] as &$user) {
        if ($user['id'] === $userId) {
            if (isset($user['reservation']) && is_array($user['reservation']) && 
                isset($user['reservation'][$reservationIndex])) {
                // Remove the reservation
                array_splice($user['reservation'], $reservationIndex, 1);
                
                // Save changes
                file_put_contents($usersFile, json_encode($usersData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                
                // Redirect to profile with success message
                header('Location: profil.php?delete_success=1');
                exit;
            }
            break;
        }
    }
    
    // If we get here, something went wrong
    header('Location: profil.php?delete_error=1');
    exit;
}

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
$reservation = null;
foreach ($usersData['users'] as $user) {
    if ($user['id'] === $userId) {
        // Check if reservation exists
        if (isset($user['reservation']) && 
            is_array($user['reservation']) && 
            isset($user['reservation'][$reservationIndex])) {
            $reservation = $user['reservation'][$reservationIndex];
        }
        break;
    }
}




// If reservation not found, redirect to profile
if ($reservation === null) {
    header('Location: profil.php');
    exit;
}

// Load schedule data to display itinerary
$scheduleData = json_decode(file_get_contents('schedule.json'), true);

// Extract theme and region from reservation
$firstTheme = '';
$firstRegion = '';
$secondTheme = '';
$secondRegion = '';



// Get region and theme codes
$firstRegion = getRegionCode($reservation['region1']);
$firstTheme = getThemeCode($reservation['theme1']);

if (!empty($reservation['region2'])) {
    $secondRegion = getRegionCode($reservation['region2']);
    $secondTheme = getThemeCode($reservation['theme2']);
}

// Get itinerary data
$firstItinerary = [];
$secondItinerary = [];

if (!empty($firstTheme) && !empty($firstRegion) && isset($scheduleData[$firstTheme][$firstRegion])) {
    $firstItinerary = $scheduleData[$firstTheme][$firstRegion];
}

if (!empty($secondTheme) && !empty($secondRegion) && isset($scheduleData[$secondTheme][$secondRegion])) {
    $secondItinerary = $scheduleData[$secondTheme][$secondRegion];
}

// Generate background image based on regions
$backgroundImage = '';
if ($reservation['duration'] === '5') {
    $backgroundImage = "assets/images/{$firstRegion}-{$firstTheme}.jpg";
} elseif ($reservation['duration'] === '10') {
    $backgroundImage = "assets/images/{$firstRegion}-{$secondRegion}-mix.jpg";
}

// Format date from the reservation format
$formattedDate = $reservation['date']; // Already in display format
$duration = $reservation['duration'];
$travelers = $reservation['participants'];
$transport = $reservation['transport'];
$hotel = $reservation['hotel']; 
$totalGroupPrice = $reservation['total_price'];

// Generate a unique tour ID - fixing null strings issue
$tourId = 'MT-';
$tourId .= !empty($firstRegion) ? strtoupper(substr($firstRegion, 0, 2)) : 'XX';
$tourId .= !empty($firstTheme) ? strtoupper(substr($firstTheme, 0, 1)) : 'X';

if ($duration == 10) {
    $tourId .= '-';
    $tourId .= !empty($secondRegion) ? strtoupper(substr($secondRegion, 0, 2)) : 'XX';
    $tourId .= !empty($secondTheme) ? strtoupper(substr($secondTheme, 0, 1)) : 'X';
}

$tourId .= '-' . date('Ymd', strtotime($formattedDate));



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 5 ou 10 jours.">
    <title>Détails de votre réservation - Momiji Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script>
        function confirmDelete() {
            return confirm("Êtes-vous sûr de vouloir supprimer cette réservation ?");
        }
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
        <section class="journey-highlights">
            <h3>Votre circuit <?php echo $reservation['status']?></h3><br/>
            
            <div class="journey-info">
                <p><strong>Date de départ:</strong> <?php echo $formattedDate; ?></p>
                <p><strong>Durée du séjour:</strong> <?php echo $reservation['duration']; ?> jours</p>
                <p><strong>Nombre de voyageurs:</strong> <?php echo $reservation['participants']; ?></p>
                <p><strong>Type de transport:</strong> <?php echo isset($reservation['transport']) ? $reservation['transport'] : 'Standard'; ?></p>
                <p><strong>Type d'hébergement:</strong> <?php echo isset($reservation['hotel']) ? $reservation['hotel'] : 'Standard'; ?></p>
            </div>
            
            
            <div class="price-info">
                <p class="total-price">Prix total: <?php echo $reservation['total_price']; ?>€ pour <?php echo $reservation['participants']; ?> voyageur<?php echo $reservation['participants'] > 1 ? 's' : ''; ?></p>
            </div>
            <br/>

            <div class="booking-buttons">

                <?php if ($reservation['status']=='réservé'): ?>
                <button type="button" class="btn btn-search" onclick="window.location.href='modify_reservation.php?index=<?php echo $reservationIndex; ?>'">Modifier cette réservation</button>
                
                <form method="post" action="" style="display: inline;" onsubmit="return confirmDelete();">
                    <input type="hidden" name="delete_reservation" value="1">
                    <input type="hidden" name="reservation_index" value="<?php echo $reservationIndex; ?>">
                    <button type="submit" class="btn btn-delete">Supprimer cette réservation</button>
                </form>
                <?php endif; ?>
                <br/>
                <form method="post" action="result_tour.php" style="display: inline;">
    <!-- change name -->
    <input type="hidden" name="duration" value="<?php echo $reservation['duration']; ?>">
    <input type="hidden" name="first-theme" value="<?php echo $firstTheme; ?>">
    <input type="hidden" name="first-region" value="<?php echo $firstRegion; ?>">
    
    <?php if ($reservation['duration'] == 10): ?>
        <input type="hidden" name="second-theme" value="<?php echo $secondTheme; ?>">
        <input type="hidden" name="second-region" value="<?php echo $secondRegion; ?>">
    <?php endif; ?>
    
    <?php 
    // convert date to an english style
    $dateParts = explode('/', $reservation['date']);
    if (count($dateParts) === 3) {
        $dateFormatted = $dateParts[2].'-'.$dateParts[1].'-'.$dateParts[0];
    } else {
        $dateFormatted = date('Y-m-d'); // Fallback to today if invalid format
    }
    ?>
    
    <input type="hidden" name="date" value="<?php echo $dateFormatted; ?>">
    <input type="hidden" name="travelers" value="<?php echo $reservation['participants']; ?>">
    
    <?php
    // code for transport and hotel
    $transportCode = 'standard';
    if ($reservation['transport'] == 'Transport VIP') $transportCode = 'vip';
    if ($reservation['transport'] == 'Transport Standard') $transportCode = 'standard';
    
    $hotelCode = 'standard';
    if ($reservation['hotel'] == 'Hotel VIP') $hotelCode = 'vip';
    if ($reservation['hotel'] == 'Hotel Standard') $hotelCode = 'standard';
    ?>
    
    <input type="hidden" name="transport" value="<?php echo $transportCode; ?>">
    <input type="hidden" name="hotel" value="<?php echo $hotelCode; ?>">
    
    <?php
    // calculate price
    $pricePerPerson = $reservation['total_price'] / $reservation['participants'];
    ?>
    
    <input type="hidden" name="total_price" value="<?php echo $pricePerPerson; ?>">
    <input type="hidden" name="total_group_price" value="<?php echo $reservation['total_price']; ?>">
    
    <form method="post" action="result_tour.php" style="display: inline;">
    <input type="hidden" name="duration" value="<?php echo $reservation['duration']; ?>">
    <br/>
                <a href="tour_details.php?reservation_id=<?php echo $reservation['id_tour']; ?>">Voir le Parcours (et payé si non payé)</a><br/>
                <a onclick="window.location.href='profil.php'">Retour au profil</a>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>