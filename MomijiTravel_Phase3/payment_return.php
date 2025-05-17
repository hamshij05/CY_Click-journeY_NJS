<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);

// Include the API key function
require 'functions/functions.php';

// Initialize variables
$paymentStatus = false;
$message = "";
$statusClass = "error";

// Verify if we have necessary parameters
if (isset($_GET['transaction']) && isset($_GET['montant']) && isset($_GET['vendeur']) && isset($_GET['status']) && isset($_GET['control'])) {
    
    // Get the parameters from the URL
    $transactionId = $_GET['transaction'];
    $amount = $_GET['montant'];
    $vendorCode = $_GET['vendeur'];
    $status = $_GET['status'];
    $controlValue = $_GET['control'];
    $userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    
    // Get the API key
    $apiKey = getAPIKey($vendorCode);
    
    // Verify the control value
    $calculatedControl = md5($apiKey . "#" . $transactionId . "#" . $amount . "#" . $vendorCode . "#" . $status . "#");
    
    if ($calculatedControl === $controlValue) {
        // Control value matches - the response is genuine
        
        if ($status === 'accepted') {
            // Payment was accepted
            $paymentStatus = true;
            $message = "Votre paiement a été accepté. Merci pour votre achat !";
            $statusClass = "success";
            
            // Verify if we have the payment details in session
            if (isset($_SESSION['payment_details']) && $transactionId === $_SESSION['payment_details']['transaction_id']) {
                // Get payment details
                $paymentDetails = $_SESSION['payment_details'];



$filePath = 'users.json';
$usersData = json_decode(file_get_contents($filePath), true);

// Format the date for display
$dateFormatted = date("d/m/Y", strtotime($paymentDetails['date']));

// Vérifier si cette transaction correspond à une réservation existante
$foundExistingReservation = false;

// Find user to update or add info
foreach ($usersData['users'] as &$user) {
    if ($user['id'] === $userId) {
 
        if (isset($user['reservation']) && is_array($user['reservation'])) {
            foreach ($user['reservation'] as &$existingReservation) {
                // if find the right reservation to update
                if (isset($existingReservation['id_tour']) && 
                    $existingReservation['id_tour'] === $paymentDetails['tour_id'] &&
                    $existingReservation['status'] === 'réservé') {
                    
                    // update
                    $existingReservation['status'] = 'payé';
                    $existingReservation['transaction_id'] = $transactionId;
                    $foundExistingReservation = true;
                    break;
                }
            }
        }
        
        // if no reservation found
        if (!$foundExistingReservation) {
            $reservation = [
                'id_tour' => $paymentDetails['tour_id'],
                'date' => $dateFormatted,
                'duration' => $paymentDetails['duration'],
                'participants' => $paymentDetails['travelers'],
                'transport' => getTransportName($paymentDetails['transport']),
                'hotel' => getHotelName($paymentDetails['hotel']),
                'region1' => getRegionName($paymentDetails['first_region']),
                'theme1' => getThemeName($paymentDetails['first_theme']),
                'region2' => $paymentDetails['duration'] == 10 ? getRegionName($paymentDetails['second_region']) : '',
                'theme2' => $paymentDetails['duration'] == 10 ? getThemeName($paymentDetails['second_theme']) : '',
                'total_price' => $amount,
                'status' => 'payé',
                'transaction_id' => $transactionId
            ];
            

            $isDuplicate = false;
            if (isset($user['reservation']) && is_array($user['reservation'])) {
                foreach ($user['reservation'] as $checkReservation) {
                    if (isset($checkReservation['transaction_id']) && 
                        $checkReservation['transaction_id'] === $transactionId) {
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
            }
        }
        

        file_put_contents($filePath, json_encode($usersData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        break;
    }
}
                
              
                
                // Clear the payment details from session
                unset($_SESSION['payment_details']);
            }
        } else {
            // Payment was declined
            $message = "Votre paiement a été refusé. Veuillez réessayer ou utiliser une autre carte bancaire.";
        
        }
    } else {
        // Control value doesn't match - possible tampering
        $message = "Erreur de validation des données. Veuillez réessayer votre paiement.";
    }
} else {
    // Missing required parameters
    $message = "Données de paiement incomplètes. Veuillez réessayer.";
}


?>

<!-- html start -->

<?php include 'header.php'; ?> 


    <main>
        <section class="page-hero">
            <h2>Confirmation de paiement</h2>
            
            <?php if($paymentStatus): ?>
                <div class="icon success-icon">✓</div>
                <div class="success-message">
                    <?php echo $message; ?>
                </div>
                
                <div class="transaction-details">
                    <h3>Détails de la transaction</h3>
                    <p><strong>ID de transaction:</strong> <?php echo $transactionId; ?></p>
                    <p><strong>Montant payé:</strong> <?php echo number_format((float)$amount, 2, ',', ' '); ?>€</p>
                    <p><strong>Statut:</strong> Paiement accepté</p>
                </div>
                
                <p>Votre réservation a été enregistrée avec succès. Vous pouvez consulter les détails de votre voyage dans votre espace personnel.</p>
            <?php else: ?>
                <div class="icon error-icon">✗</div> <!--error messqge-->
                <div class="error-message">
                    <?php echo $message; ?>
                </div>
                
                <?php if(isset($transactionId)): ?>
                <div class="transaction-details">
                    <h3>Détails de la transaction</h3>
                    <p><strong>ID de transaction:</strong> <?php echo $transactionId; ?></p>
                    <p><strong>Montant:</strong> <?php echo number_format((float)$amount, 2, ',', ' '); ?>€</p>
                    <p><strong>Statut:</strong> Paiement refusé</p>
                </div>
                <?php endif; ?>
                
                <p>Vous pouvez réessayer le paiement ou contacter notre service client pour obtenir de l'aide.</p>
            <?php endif; ?>
            
            <div class="buttons">
                <a href="profil.php">Voir mes réservations</a>
                <a href="search.php">Rechercher un nouveau voyage</a>
            </div>
        </section>
    </main>
    
    <?php include 'footer.php'; ?>
