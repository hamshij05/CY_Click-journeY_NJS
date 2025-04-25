<?php
session_start();

// Verify if the user is connected
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    $_SESSION['redirect_after_login'] = 'search.php';
    header("Location: login.php?message=login_required");
    exit;
}

$isLoggedIn = isset($_SESSION['user_id']);


// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect to search page if accessed directly
    header("Location: search.php");
    exit;
}

require 'functions/functions.php';

// Get the tour details from the form
$duration = $_POST['duration'];
$firstTheme = $_POST['first-theme'];
$firstRegion = $_POST['first-region'];
$secondTheme = isset($_POST['second-theme']) ? $_POST['second-theme'] : '';
$secondRegion = isset($_POST['second-region']) ? $_POST['second-region'] : '';
$date = $_POST['date'];
$travelers = $_POST['travelers'];
$transport = $_POST['transport'];
$hotel = $_POST['hotel'];
$tourId = $_POST['tour_id'];
$totalPrice = $_POST['total_price'];
$totalGroupPrice = $_POST['total_group_price'];
$reservationId = isset($_POST['reservation_id']) ? $_POST['reservation_id'] : '';

// Format the price for CY Bank (with 2 decimal places)
$formattedPrice = number_format($totalGroupPrice, 2, '.', '');

// Generate a unique transaction ID
$transactionId = 'MT' . time() . substr(md5($tourId), 0, 10);

// Set the vendor code - Use one of the accepted codes from the PDF
$vendorCode = "MIM_D"; // Change this to your assigned vendor code

// Get the API key
$apiKey = getAPIKey($vendorCode);

// Set the return URL
$returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/MomijiTravel_Phase2/payment_return.php?user_id=" . $_SESSION['user_id'];

// Generate control value according to the specification - modified to remove trailing #
$controlValue = md5($apiKey . "#" . $transactionId . "#" . $formattedPrice . "#" . $vendorCode . "#" . $returnUrl . "#");


// Store the transaction details in session for later verification
$_SESSION['payment_details'] = [
    'reservation_id' => $reservationId,
    'transaction_id' => $transactionId,
    'amount' => $formattedPrice,
    'tour_id' => $tourId,
    'duration' => $duration,
    'first_theme' => $firstTheme,
    'first_region' => $firstRegion,
    'second_theme' => $secondTheme,
    'second_region' => $secondRegion,
    'date' => $date,
    'travelers' => $travelers,
    'transport' => $transport,
    'hotel' => $hotel
];

// Format the date for display
$dateFormatted = date("d/m/Y", strtotime($date));


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Page de paiement pour voyage au Japon.">
    <title>Paiement - Momiji Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    
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
            <h2>Paiement de votre voyage</h2>
            
        <section class="features">
            <div class="feature-card">
                <h3>Récapitulatif de votre commande</h3>
                <p><strong>Tour ID:</strong> <?php echo $tourId; ?></p>
                <p><strong>Date de départ:</strong> <?php echo $dateFormatted; ?></p>
                <p><strong>Durée du séjour:</strong> <?php echo $duration; ?> jours</p>
                <p><strong>Nombre de voyageurs:</strong> <?php echo $travelers; ?></p>
                <p><strong>Type de Transport:</strong> <?php echo getTransportName($transport); ?></p>
                <p><strong>Type d'Hôtel:</strong> <?php echo getHotelName($hotel); ?></p><br/>
                
                <h3>Détails du voyage:</h3>
                <p><?php echo getRegionName($firstRegion); ?> (<?php echo getThemeName($firstTheme); ?>)</p>
                <?php if ($duration == 10): ?>
                <p><?php echo getRegionName($secondRegion); ?> (<?php echo getThemeName($secondTheme); ?>)</p>
                <?php endif; ?>
                
                <p class="total-price"><strong>Montant total à payer:</strong> <?php echo number_format($totalGroupPrice, 2, ',', ' '); ?>€</p>
            </div>
            <br/>
            <div class="payment-form">
              

                <form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
                    <input type="hidden" name="transaction" value="<?php echo $transactionId; ?>">
                    <input type="hidden" name="montant" value="<?php echo $formattedPrice; ?>">
                    <input type="hidden" name="vendeur" value="<?php echo $vendorCode; ?>">
                    <input type="hidden" name="retour" value="<?php echo $returnUrl; ?>">
                    <input type="hidden" name="control" value="<?php echo $controlValue; ?>">
                    <button type="submit" class="btn">Procéder au paiement</button>
                </form>
                <br/>
                
                <a href="javascript:history.back()" class="">Retour à la page précédente</a>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
