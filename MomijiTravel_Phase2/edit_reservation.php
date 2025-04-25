<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

require 'functions/functions.php';

// Determine which user ID to use
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
} else if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    // Redirect to login page if no user ID is available
    header('Location: login.php');
    exit;
}

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

if (!isset($_GET['reservation_index']) || !is_numeric($_GET['reservation_index'])) {
    // Redirect to profile page if no valid index
    header('Location: profil.php');
    exit;
}


$reservationIndex = intval($_GET['reservation_index']);
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 5 ou 10 jours.">
    <title>Modifier la Réservation - Momiji Travel</title>
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
        <section class="journey-highlights" style="background-image: url('assets/images/<?php echo $firstTheme; ?>.jpg');">
            <h2>Le circuit réservé de <?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['surname']); ?></h2>
            
            <div class="journey-info">
                <p><strong>Date de départ:</strong> <?php echo $formattedDate; ?></p>
                <p><strong>Durée du séjour:</strong> <?php echo $reservation['duration']; ?> jours</p>
                <p><strong>Nombre de voyageurs:</strong> <?php echo $reservation['participants']; ?></p>
                <p><strong>Type de transport:</strong> <?php echo isset($reservation['transport']) ? $reservation['transport'] : 'Standard'; ?></p>
                <p><strong>Type d'hébergement:</strong> <?php echo isset($reservation['hotel']) ? $reservation['hotel'] : 'Standard'; ?></p>
            </div>
            
            <?php if (!empty($firstItinerary)): ?>
                <h3>5 Jours à <?php echo $reservation['region1']; ?> (<?php echo $reservation['theme1']; ?>)</h3>
                <p>Vous séjournerez pendant 5 jours dans différents hébergements de luxe, idéalement situés pour visiter tous les sites touristiques.</p>
                
                <ul class="highlights-list">
                    <?php for ($i = 0; $i < count($firstItinerary); $i++): ?>
                        <li>Jour <?php echo $i + 1; ?> : <?php echo $firstItinerary[$i]; ?></li>
                    <?php endfor; ?>
                </ul>
            <?php endif; ?>
            
            <?php if ($reservation['duration'] === '10' && !empty($secondItinerary)): ?>
                <h3>5 Jours à <?php echo $reservation['region2']; ?> (<?php echo $reservation['theme2']; ?>)</h3>
                <p>Vous séjournerez pendant 5 jours dans différents hébergements de luxe, idéalement situés pour visiter tous les sites touristiques.</p>
                
                <ul class="highlights-list">
                    <?php for ($i = 0; $i < count($secondItinerary); $i++): ?>
                        <li>Jour <?php echo $i + 6; ?> : <?php echo $secondItinerary[$i]; ?></li>
                    <?php endfor; ?>
                </ul>
            <?php endif; ?>
            
            <div class="price-info">
                <p class="total-price">Prix total: <?php echo $reservation['total_price']; ?>€ pour <?php echo $reservation['participants']; ?> voyageur<?php echo $reservation['participants'] > 1 ? 's' : ''; ?></p>
            </div>
            
            <div class="booking-buttons">
                <button type="button" class="btn btn-search" onclick="window.location.href='profil.php'">Retour au profil</button>
                <button type="button" class="btn btn-search" onclick="window.location.href='modify_reservation.php?index=<?php echo $reservationIndex; ?>'">Modifier cette réservation</button>
                
                <form method="post" action="" style="display: inline;" onsubmit="return confirmDelete();">
                    <input type="hidden" name="delete_reservation" value="1">
                    <input type="hidden" name="reservation_index" value="<?php echo $reservationIndex; ?>">
                    <button type="submit" class="btn btn-delete">Supprimer cette réservation</button>
                </form>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
