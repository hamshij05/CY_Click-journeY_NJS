<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) { // if the user is not connected, redirect to the login page
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$usersFile = "users.json";
$uploadDir = 'assets/images/profil';


require 'functions/functions.php';



// Initialize message variable
$message = '';
$messageClass = '';

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'first_name' => htmlspecialchars($_POST['first_name']), // secure the data from malicious code
        'surname' => htmlspecialchars($_POST['surname']),
        'email' => htmlspecialchars($_POST['email'])
    ];
    
    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['profile_pic']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION); // get the extension of the file
        
        if (in_array($extension, ['jpg', 'png', 'jpeg'])) {
            foreach ($allowed as $format) {
                $oldFile = "{$uploadDir}/profile_{$userId}.{$format}"; // old file
                if (file_exists($oldFile)) { // if the file exists, delete it
                    unlink($oldFile);
                }
            }
            
            // Save new profile picture
            $newFileName = "{$uploadDir}/profile_{$userId}.{$extension}";
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $newFileName);
        }
    }
    
    // Update user data
    if (updateUserData($usersFile, $userId, $userData)) {
        $message = "Votre profil a été mis à jour avec succès!";
        $messageClass = "success";
    } else {
        $message = "Une erreur s'est produite lors de la mise à jour du profil.";
        $messageClass = "error";
    }
}

// Get current user data
$user = getUserData($usersFile, $userId);
// Get profile picture path using convention
$profilePicture = getProfilePicture($userId);
?>

<!DOCTYPE html>
<html>
    <!--description part-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ -">
    <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours.">
    <title>Momiji Travel - Voyages d'automne au Japon</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
       <header>
        <h1>紅葉 Momiji Travel</h1>
	<!--navigation part is to navigate through different pages -->
        <nav>
	        <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
		    <a href="tour.php">Les circuits typiques</a>
            <a href="logout.php">Déconnexion</a>
        </nav>

    </header> 
  <main>

  <?php if ($isLoggedIn): ?>
        <section class="page-hero">
            <h2>Votre profil</h2>
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $messageClass; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <div class="profile-picture-container">
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" 
                     alt="Photo de profil">
            </div>
        </section>

        
        <div class="wrap"> 
        <div class="login_box"> 
            <div class="login-header"> 
                <span>Profil</span>
            </div>
 
                <form method="post" action="profil.php" enctype="multipart/form-data">  <!-- Form for profile editing-->
                    <div class="profil-section">
                     
                        
                    
                            <label for="surname">Nom:</label>
                            <input type="text" id="surname" name="surname" 
                                 value="<?php echo htmlspecialchars($user['surname'] ?? ''); ?>"
                                 required>
                    

                            <label for="first_name">Prénom:</label>
                            <input type="text" id="first_name" name="first_name" 
                                 value="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" 
                                 required>

                            <label for="login">Identifiant:</label>
                            <input type="text" id="login" 
                                 value="<?php echo htmlspecialchars($user['login'] ?? ''); ?>" 
                                 disabled>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" 
                                 value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" 
                                 required>

                            <label for="profile_pic">Photo de profil:</label>
                            <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                       
                    
                            <div class="edit-profil">
                              <button type="submit" class="btn btn-edit">Enregistrer les modifications</button>
                            
                          </div>
                    </div>
                    </div>
                    </div>
                </form>
            
          
                <?php
    // Check if the user has any reservations
                    if (isset($user['reservation']) && !empty($user['reservation'])): ?>
                        
                    <section class="journey-highlights">
                        <h3>Mes Réservations</h3>
                        <?php 
                        // temporary table
                        $sortedReservations = $user['reservation'];
                        
                        // function to sort date
                        usort($sortedReservations, function($a, $b) {
                            return strtotime($a['date']) - strtotime($b['date']);
                        });
                        
                        // print reservation sorted
                        foreach ($sortedReservations as $index => $reservation): 
                            // get og index to have the correct link
                            $originalIndex = array_search($reservation, $user['reservation']);
                        ?>
                            <a href="view_reservation.php?index=<?php echo $originalIndex; ?>" class="reservation-link">
                                <p class="reservation-date">
                                    <strong>Date:</strong> <?php echo htmlspecialchars($reservation['date']); ?>
                                    
                                    <strong>Région 1:</strong> <?php echo htmlspecialchars($reservation['region1']); ?>
                                    <strong>Thème 1:</strong> <?php echo htmlspecialchars($reservation['theme1']); ?>
                                    <?php if (!empty($reservation['region2'])): ?>
                                        <strong>Région 2:</strong> <?php echo htmlspecialchars($reservation['region2']); ?>
                                        <strong>Thème 2:</strong> <?php echo htmlspecialchars($reservation['theme2']); ?>
                                    <?php endif; ?>
                                </p>
                                <div class="reservation-price"><strong>Prix total:</strong> <?php echo htmlspecialchars($reservation['total_price']); ?>€</div>
                                <?php if ($reservation['status'] == 'payé'): ?>
                                    <strong>Déjà Payé!</strong>
                                <?php endif; ?>
                                <br/><br/>

                            </a>
                        <?php endforeach; ?>
                    </section>
        
    <?php endif; ?>
        </section>

    
    <?php else: ?>
    <section class="page-hero">
      <h2>Il faut avoir un compte</h2>
      <div class="auth-buttons">
        <a href="login_form.php" class="btn">Se connecter</a>
        <a href="sign_up.php" class="btn">S'inscrire</a>
      </div>
    </section>
    <?php endif; ?>
  </main>
  <?php include 'footer.php'; ?> 


