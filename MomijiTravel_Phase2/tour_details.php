<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);



if (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}


require 'functions/functions.php'; //Get all functions

$userId = $_SESSION['user_id'];
$reservationId = $_GET['reservation_id'] ?? null;
$scheduleData = json_decode(file_get_contents('schedule.json'), true);
$usersData = json_decode(file_get_contents('users.json'), true);
$selectedReservation = null;

foreach ($usersData['users'] as $user) {
    if ($user['id'] === $userId) {
        foreach ($user['reservation'] as $reservation) {
            if ($reservation['id_tour'] === $reservationId) {
                $selectedReservation = $reservation;
                break 2; 
            }
        }
    }
}

if (!$selectedReservation) {
    echo "Réservation introuvable.";
    exit;
}

$region1 = $selectedReservation['region1'];
$theme1 = $selectedReservation['theme1'];
$region2 = $selectedReservation['region2'];
$theme2 = $selectedReservation['theme2'];
$duration = intval($selectedReservation['duration']);
$dateFormatted = $selectedReservation['date'];
$participants = $selectedReservation['participants'];
$transport = $selectedReservation['transport'];
$hotel = $selectedReservation['hotel'];
$total = $selectedReservation['total_price'];
$status = $selectedReservation['status'];

$reg1Val = getRegionValue($region1);
$reg2Val = getRegionValue($region2);
$them1Val = getThemeValue($theme1);
$them2Val = getThemeValue($theme2);

// Get itinerary data
$firstItinerary = [];
$secondItinerary = [];

if (!empty($them1Val) && !empty($reg1Val) && isset($scheduleData[$them1Val][$reg1Val])) {
    $firstItinerary = $scheduleData[$them1Val][$reg1Val];
}

if ($duration == 10 && !empty($them2Val) && !empty($reg2Val) && isset($scheduleData[$them2Val][$reg2Val])) {
    $secondItinerary = $scheduleData[$them2Val][$reg2Val];
}

$tourId = 'MT-';
$tourId .= !empty($region1) ? strtoupper(substr($region1, 0, 2)) : 'XX';
$tourId .= !empty($theme1) ? strtoupper(substr($theme1, 0, 1)) : 'X';

if ($duration == 10) {
    $tourId .= '-';
    $tourId .= !empty($region2) ? strtoupper(substr($region2, 0, 2)) : 'XX';
    $tourId .= !empty($theme2) ? strtoupper(substr($theme2, 0, 1)) : 'X';
}

$tourId .= '-' . date('Ymd', strtotime($dateFormatted));

$firstPrice = generatePrice($theme1, $region1, 5, $transport, $hotel);
$secondPrice = $duration == 10 ? generatePrice($theme2, $region2, 5, $transport, $hotel) : 0;
$totalPrice = $duration == 10 ? ($firstPrice + $secondPrice) : $firstPrice; //price for one person

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 5 ou 10 jours.">
    <title>Détails de la Réservation</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header>
        <h1>紅葉 Momiji Travel</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="tour.php">Les circuits typiques</a>
            <a href="search.php">Rechercher</a>
            <a href="profil.php">Mon Profil</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <main>
        <section class="journey-highlights" style="background-image: url('assets/images/<?php echo $them1Val; ?>.jpg');">
            <h2>Récapitulatif de votre réservation</h2>
            <div class="journey-info">
                <p><strong>Date de départ :</strong> <?php echo $dateFormatted; ?></p>
                <p><strong>Durée :</strong> <?php echo $duration; ?> jours</p>
                <p><strong>Participants :</strong> <?php echo $participants; ?></p>
                <p><strong>Transport :</strong> <?php echo $transport; ?></p>
                <p><strong>Hôtel :</strong> <?php echo $hotel; ?></p>
                <p><strong>Prix total :</strong> <?php echo $total; ?> €</p>

            </div>

            <?php if (!empty($firstItinerary)): ?>
                <h3>5 jours à <?php echo $region1; ?> (<?php echo $theme1; ?>)</h3>
                <ul class="highlights-list">
                    <?php foreach ($firstItinerary as $i => $activity): ?>
                        <li>Jour <?php echo $i + 1; ?> : <?php echo $activity; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($duration == 10 && !empty($secondItinerary)): ?>
                <h3>5 jours à <?php echo $region2; ?> (<?php echo $theme2; ?>)</h3>
                <ul class="highlights-list">
                    <?php foreach ($secondItinerary as $i => $activity): ?>
                        <li>Jour <?php echo $i + 6; ?> : <?php echo $activity; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>


            <?php if ($status == 'réservé'): ?>
               <!-- To pay -->
                <form method="post" action="payment.php">
                    <input type="hidden" name="duration" value="<?php echo $duration; ?>">
                    <input type="hidden" name="first-theme" value="<?php echo $theme1; ?>">
                    <input type="hidden" name="first-region" value="<?php echo $region1; ?>">
                    <input type="hidden" name="second-theme" value="<?php echo $theme2; ?>">
                    <input type="hidden" name="second-region" value="<?php echo $region2; ?>">
                    <input type="hidden" name="date" value="<?php echo $dateFormatted; ?>">
                    <input type="hidden" name="travelers" value="<?php echo $participants; ?>">
                    <input type="hidden" name="transport" value="<?php echo $transport; ?>">
                    <input type="hidden" name="hotel" value="<?php echo $hotel; ?>">
                    <input type="hidden" name="tour_id" value="<?php echo $reservationId; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
                    <input type="hidden" name="total_group_price" value="<?php echo $total; ?>">
                    <button type="submit" class="btn btn-payment">Payer maintenant</button>
                </form>
        <?php endif; ?>
        </section>
    </main>

    <?php include 'footer.php'; ?>