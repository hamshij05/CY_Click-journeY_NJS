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


// Function to get profile picture path
function getProfilePicture($userId) {
    // Check for user's profile picture in common image formats
    $formats = ['jpg', 'jpeg', 'png'];
    foreach ($formats as $format) {
        $path = "assets/images/profil/profile_{$userId}.{$format}";
        if (file_exists($path)) {
            return $path;
        }
    }
    // Return default image if no custom profile picture exists
    return 'assets/images/profil/profil.jpg';
}

// Function to get all users data
function getAllUsers($filePath) {
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        return json_decode($jsonData, true);
    }
    return ["users" => []];
}

// Function to get specific user data
function getUserData($filePath, $userId) {
    $allUsers = getAllUsers($filePath);
    
    foreach ($allUsers['users'] as $user) {
        if ($user['id'] === $userId) {
            return $user;
        }
    }
    return null;
}

// Function to update user data
function updateUserData($filePath, $userId, $userData) {
    $allUsers = getAllUsers($filePath);
    
    foreach ($allUsers['users'] as $key => $user) {
        if ($user['id'] === $userId) {
            $allUsers['users'][$key] = array_merge($user, $userData);
            break;
        }
    }
    
    return file_put_contents($filePath, json_encode($allUsers, JSON_PRETTY_PRINT));
}

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
		      <a href="tour.html">Les circuits typiques</a>
          <?php include 'nav.php'; ?> 
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

        
        <div class="wrap"> <!-- container that centers its content both horizontally and vertically on the screen. -->
        <div class="login_box"> <!--Login box styling with blur effect, border, and shadow-->
        <div class="login-header"> <!--title of the sign up form-->
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


