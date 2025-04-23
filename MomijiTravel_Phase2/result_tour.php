<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Redirect to search page if accessed directly
    header("Location: search.php");
    exit;
}

require 'functions/functions.php';

// Verify if the reservation is due
if (isset($_POST['book_tour'])) {
    if (!$isLoggedIn) {
        // Rediration to profil page
        $_SESSION['redirect_after_login'] = 'search.php';
        header("Location: login.php?message=login_required");
        exit;
    } else {
        // user connected so reservation
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

        
        // add reservation for the users
        $filePath = 'users.json';
        $usersData = json_decode(file_get_contents($filePath), true);
        
        // Format the date for display
        $dateFormatted = date("d/m/Y", strtotime($date));

        // find user to add new infos
        foreach ($usersData['users'] as &$user) {
            if ($user['id'] === $_SESSION['user_id']) {
                $reservation = [
                    'id_tour' => uniqid(),
                    'date' => $dateFormatted,
                    'duration' => $duration,
                    'participants' => $travelers,
                    'transport' => getTransportName($transport),
                    'hotel' => getHotelName($hotel),
                    'region1' => getRegionName($firstRegion),
                    'theme1' => getThemeName($firstTheme),
                    'region2' => $duration == 10 ? getRegionName($secondRegion) : '',
                    'theme2' => $duration == 10 ? getThemeName($secondTheme) : '',
                    'total_price' => $totalGroupPrice,
                    'status' => 'réservé'  
                ];

                // verify is reservation already existed
                $isDuplicate = false;
                if (isset($user['reservation']) && is_array($user['reservation'])) {
                    foreach ($user['reservation'] as $existingReservation) {
                        // compared reservation
                        if ($existingReservation['date'] == $dateFormatted &&
                            $existingReservation['duration'] == $duration &&
                            $existingReservation['region1'] == getRegionName($firstRegion) &&
                            $existingReservation['theme1'] == getThemeName($firstTheme) &&
                            $existingReservation['total_price'] == $totalGroupPrice) {
                            $isDuplicate = true;
                            break;
                        }
                    }
                }

                
                if (!$isDuplicate) {
                    if (!isset($user['reservation'])) {
                        $user['reservation'] = [];
                    }
                    $user['reservation'][] = $reservation;
                    
                    // save the edited file
                    file_put_contents($filePath, json_encode($usersData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                    // if success, rediration
                    header('Location: profil.php?booking_success=1');
                    exit;
                } else {
                    // if not error
                    header('Location: profil.php?booking_duplicate=1');
                    exit;
                }
                
                break;
            }
        }
    }
}

// Get form data with validation
$duration = isset($_POST['duration']) ? $_POST['duration'] : 5;
$firstTheme = isset($_POST['first-theme']) ? $_POST['first-theme'] : '';
$firstRegion = isset($_POST['first-region']) ? $_POST['first-region'] : '';
$secondTheme = isset($_POST['second-theme']) ? $_POST['second-theme'] : '';
$secondRegion = isset($_POST['second-region']) ? $_POST['second-region'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
$travelers = isset($_POST['travelers']) ? intval($_POST['travelers']) : 1;
$transport = isset($_POST['transport']) ? $_POST['transport'] : '';
$hotel = isset($_POST['hotel']) ? $_POST['hotel'] : '';

// Verify that date is not in the past
$currentDate = date('Y-m-d');
if ($date < $currentDate) {
    // Redirect back to search page with error
    header("Location: search.php?error=past_date");
    exit;
}

// Format the date
$dateFormatted = date("d/m/Y", strtotime($date));

// Load schedule data
$scheduleData = json_decode(file_get_contents('schedule.json'), true);

// Get itinerary data
$firstItinerary = [];
$secondItinerary = [];

if (!empty($firstTheme) && !empty($firstRegion) && isset($scheduleData[$firstTheme][$firstRegion])) {
    $firstItinerary = $scheduleData[$firstTheme][$firstRegion];
}

if ($duration == 10 && !empty($secondTheme) && !empty($secondRegion) && isset($scheduleData[$secondTheme][$secondRegion])) {
    $secondItinerary = $scheduleData[$secondTheme][$secondRegion];
}




// Calculate prices
$firstPrice = generatePrice($firstTheme, $firstRegion, 5, $transport, $hotel);
$secondPrice = $duration == 10 ? generatePrice($secondTheme, $secondRegion, 5, $transport, $hotel) : 0;
$totalPrice = $duration == 10 ? ($firstPrice + $secondPrice) : $firstPrice;


// Calculate total price for all travelers
$totalGroupPrice = $totalPrice * $travelers;

// Generate a unique tour ID - fixing null strings issue
$tourId = 'MT-';
$tourId .= !empty($firstRegion) ? strtoupper(substr($firstRegion, 0, 2)) : 'XX';
$tourId .= !empty($firstTheme) ? strtoupper(substr($firstTheme, 0, 1)) : 'X';

if ($duration == 10) {
    $tourId .= '-';
    $tourId .= !empty($secondRegion) ? strtoupper(substr($secondRegion, 0, 2)) : 'XX';
    $tourId .= !empty($secondTheme) ? strtoupper(substr($secondTheme, 0, 1)) : 'X';
}

$tourId .= '-' . date('Ymd', strtotime($date));

// Generate background image based on regions
$backgroundImage = '';
if ($duration == 5) {
    $backgroundImage = "assets/images/{$firstRegion}-{$firstTheme}.jpg";
} else {
    $backgroundImage = "assets/images/{$firstRegion}-{$secondRegion}-mix.jpg";
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Elsa Sanchez - Hamshigaa JEKUMAR">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 5 ou 10 jours.">
    <title>Votre Voyage Personnalisé - Momiji Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <header>
        <h1>紅葉 Momiji Travel</h1>
        <nav> <!-- navigation -->
            <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
            <a href="tour.php">Les circuits typiques</a>
            <?php include 'nav.php'; ?>
            
        </nav>
    </header>

    <main>
        <section class="journey-highlights" style="background-image: url('<?php echo $backgroundImage; ?>') ;">
            <h2>Votre circuit personnalisé</h2>
            
            <div class="journey-info"> <!-- info of the reservation -->
                <p><strong>Date de départ:</strong> <?php echo $dateFormatted; ?></p>
                <p><strong>Durée du séjour:</strong> <?php echo $duration; ?> jours</p>
                <p><strong>Nombre de voyageurs:</strong> <?php echo $travelers; ?></p>
                <p><strong>Type de Transport:</strong> <?php echo $transport; ?></p>
                <p><strong>Type de Hotel:</strong> <?php echo $hotel; ?></p>
            </div>
            
            <?php if (($duration == 5 || $duration == 10) && !empty($firstItinerary)): ?>
                <h3>5 Jours à <?php echo getRegionName($firstRegion); ?> (<?php echo getThemeName($firstTheme); ?>)</h3>
                <p>Vous séjournerez pendant 5 jours dans différents hébergements de luxe, idéalement situés pour visiter tous les sites touristiques.</p>
                
                <ul class="highlights-list">
                    <?php for ($i = 0; $i < count($firstItinerary); $i++): ?>
                        <li>Jour <?php echo $i + 1; ?> : <?php echo $firstItinerary[$i]; ?></li>
                    <?php endfor; ?>
                </ul>
            <?php endif; ?>
            
            <?php if ($duration == 10 && !empty($secondItinerary)): ?>
                <h3>5 Jours à <?php echo getRegionName($secondRegion); ?> (<?php echo getThemeName($secondTheme); ?>)</h3>
                <p>Vous séjournerez pendant 5 jours dans différents hébergements de luxe, idéalement situés pour visiter tous les sites touristiques.</p>
                
                <ul class="highlights-list">
                    <?php for ($i = 0; $i < count($secondItinerary); $i++): ?>
                        <li>Jour <?php echo $i + 6; ?> : <?php echo $secondItinerary[$i]; ?></li>
                    <?php endfor; ?>
                </ul>
            <?php endif; ?>
            
            <div class="price-info">
                <?php if ($duration == 10): ?>
                    <p>Premier segment (<?php echo getRegionName($firstRegion); ?>): <?php echo $firstPrice; ?>€ par personne</p>
                    <p>Second segment (<?php echo getRegionName($secondRegion); ?>): <?php echo $secondPrice; ?>€ par personne</p>
                <?php endif; ?>
                <p class="total-price">Prix total: <?php echo $totalGroupPrice; ?>€ pour <?php echo $travelers; ?> voyageur<?php echo $travelers > 1 ? 's' : ''; ?></p>
                <p>(<?php echo $totalPrice; ?>€ par personne)</p>
            </div><br/>
            

<div class="booking-buttons">
    <button type="submit" class="btn btn-search" onclick="window.location.href='search.php'">Modifier la recherche</button>
    
    <?php if ($isLoggedIn): ?>
        <br/><br/>
        <form method="post" action=""> <!-- To reserved -->
            <input type="hidden" name="book_tour" value="1">
            <input type="hidden" name="duration" value="<?php echo $duration; ?>">
            <input type="hidden" name="first-theme" value="<?php echo $firstTheme; ?>">
            <input type="hidden" name="first-region" value="<?php echo $firstRegion; ?>">
            <input type="hidden" name="second-theme" value="<?php echo $secondTheme; ?>">
            <input type="hidden" name="second-region" value="<?php echo $secondRegion; ?>">
            <input type="hidden" name="date" value="<?php echo $date; ?>">
            <input type="hidden" name="travelers" value="<?php echo $travelers; ?>">
            <input type="hidden" name="transport" value="<?php echo $transport; ?>">
            <input type="hidden" name="hotel" value="<?php echo $hotel; ?>">
            <input type="hidden" name="tour_id" value="<?php echo $tourId; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <input type="hidden" name="total_group_price" value="<?php echo $totalGroupPrice; ?>">
            <button type="submit" class="btn btn-search">Réserver ce voyage</button>
        </form><br/>
        

        <!-- To pay -->
        <form method="post" action="payment.php">
            <input type="hidden" name="duration" value="<?php echo $duration; ?>">
            <input type="hidden" name="first-theme" value="<?php echo $firstTheme; ?>">
            <input type="hidden" name="first-region" value="<?php echo $firstRegion; ?>">
            <input type="hidden" name="second-theme" value="<?php echo $secondTheme; ?>">
            <input type="hidden" name="second-region" value="<?php echo $secondRegion; ?>">
            <input type="hidden" name="date" value="<?php echo $date; ?>">
            <input type="hidden" name="travelers" value="<?php echo $travelers; ?>">
            <input type="hidden" name="transport" value="<?php echo $transport; ?>">
            <input type="hidden" name="hotel" value="<?php echo $hotel; ?>">
            <input type="hidden" name="tour_id" value="<?php echo $tourId; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <input type="hidden" name="total_group_price" value="<?php echo $totalGroupPrice; ?>">
            <button type="submit" class="btn btn-payment">Payer maintenant</button>
        </form>
    <?php else: ?>
        <button type="button" class="btn btn-search" onclick="window.location.href='login_form.php?redirect=search'">Se connecter pour réserver</button>
    <?php endif; ?>
</div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
</body>
</html>