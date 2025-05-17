<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);


require 'functions/functions.php';

// Check if user ID is provided
if (!isset($_GET['id'])) {
    header('Location: admin_page.php');
    exit;
}

$userId = $_GET['id'];
$usersFile = "users.json";
$userData = getAllUsers($usersFile);
$uploadDir = 'assets/images/profil';

// Find the user with the provided ID
$user = null;
foreach ($userData['users'] as $u) {
    if ($u['id'] == $userId) {
        $user = $u;
        break;
    }
}

// If user not found, redirect back to admin page
if ($user === null) {
    header('Location: admin_page.php');
    exit;
}

// Initialize message variable
$message = '';
$messageClass = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedUserData = [
        'first_name' => htmlspecialchars($_POST['first_name']),
        'surname' => htmlspecialchars($_POST['surname']),
        'email' => htmlspecialchars($_POST['email'])
    ];
    
    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['profile_pic']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array($extension, $allowed)) {
            foreach ($allowed as $format) {
                $oldFile = "{$uploadDir}/profile_{$userId}.{$format}";
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }
            
            // Save new profile picture
            $newFileName = "{$uploadDir}/profile_{$userId}.{$extension}";
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $newFileName);
        }
    }
    
    // Update user data
    if (updateUserData($usersFile, $userId, $updatedUserData)) {
        $message = "Les informations du client ont été mises à jour avec succès!";
        $messageClass = "success";
        
        // Refresh user data
        $userData = getAllUsers($usersFile);
        foreach ($userData['users'] as $u) {
            if ($u['id'] == $userId) {
                $user = $u;
                break;
            }
        }
    } else {
        $message = "Une erreur s'est produite lors de la mise à jour des informations.";
        $messageClass = "error";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_action'], $_POST['target_user_id'])) {
    $action = $_POST['user_action'];
    $targetUserId = $_POST['target_user_id'];
    $currentUserId = $_SESSION['user_id'] ?? null;

    if ($currentUserId && isUserAdmin($currentUserId)) {
        $usersFile = 'users.json';
        $usersData = json_decode(file_get_contents($usersFile), true);

        if (is_array($usersData) && isset($usersData['users'])) {
            foreach ($usersData['users'] as &$user) {
                if ($user['id'] === $targetUserId) {
                    if ($action === 'make_admin') {
                        $user['role'] = 'admin';
                    } elseif ($action === 'remove_admin') {
                        unset($user['role']); 
                    }
                    break;
                }
            }
            file_put_contents($usersFile, json_encode($usersData, JSON_PRETTY_PRINT));
            header("Location: view_client.php?id=" . urlencode($targetUserId));
            exit;
        }
    }
}




$profilePicture = getProfilePicture($userId);
?>

<!-- html start -->

<?php include 'header.php'; ?> 

    <main>
        <div class="back-link">
            <a href="admin_page.php">&larr; Retour à la liste des clients</a> <!-- &larr; is an HTML entity that displays a left arrow symbol (←)  == go back to the previous page-->

        </div>
        <br/>
        
        <?php if (!empty($message)): ?> <!--if error in update, send a message to inform -->
            <div class="message <?php echo $messageClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <section class="feature-card">
            <h2>Modifier le profil de <?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['surname']); ?></h2> <!-- to prevent any injection, def in admin page php-->
            
            <div class="profile-picture-container">
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Photo de profil">
            </div>
        </section>    
            

        <section class="search-section">
            <form class="search-form" method="post" action="edit_client.php?id=<?php echo $userId; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="surname">Nom:</label>
                    <input type="text" id="surname" name="surname"  
                           value="<?php echo htmlspecialchars($user['surname']); ?>"   
                           required>
                </div>
                
                <div class="form-group">
                    <label for="first_name">Prénom:</label>
                    <input type="text" id="first_name" name="first_name" 
                           value="<?php echo htmlspecialchars($user['first_name']); ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="login">Identifiant:</label>
                    <input type="text" id="login" 
                           value="<?php echo htmlspecialchars($user['login']); ?>" 
                           disabled>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user['email']); ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="profile_pic">Photo de profil:</label>
                    <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-edit">Enregistrer les modifications</button>
                    <a href="view_client.php?id=<?php echo $userId; ?>" class="btn">Annuler</a>
                    <?php if (isset($_SESSION['user_id']) && isUserAdmin($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['user_id']) && isUserAdmin($_SESSION['user_id'])): ?>
                            <form method="POST">
                                <input type="hidden" name="user_action" value="make_admin">
                                <input type="hidden" name="target_user_id" value="<?php echo $userId; ?>">
                                <button type="submit" class="btn btn-admin">Donner les droits admin</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </form>
        </section>
            <br/><br/>
            
            <section class="feature-card">
            <div class="client-reservations">
                <h3>Réservations</h3>
                
                <?php if (isset($user['reservation']) && !empty($user['reservation'])): ?>
                    <table class="reservations-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Durée</th>
                                <th>Participants</th>
                                <th>Région 1</th>
                                <th>Thème 1</th>
                                <th>Région 2</th>
                                <th>Thème 2</th>
                                <th>Prix Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user['reservation'] as $index => $reservation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['duration']); ?> jours</td>
                                    <td><?php echo htmlspecialchars($reservation['participants']); ?> personnes</td>
                                    <td><?php echo htmlspecialchars($reservation['region1']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['theme1']); ?></td>
                                    <td><?php echo !empty($reservation['region2']) ? htmlspecialchars($reservation['region2']) : '-'; ?></td>
                                    <td><?php echo !empty($reservation['theme2']) ? htmlspecialchars($reservation['theme2']) : '-'; ?></td>
                                    <td><?php echo htmlspecialchars($reservation['total_price']); ?>€</td>
                                    <td class="reservation-actions">
                                        <a href="edit_reservation.php?user_id=<?php echo $user['id']; ?>&reservation_index=<?php echo $index; ?>" class="btn btn-edit">Modifier</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-reservation">Ce client n'a pas encore de réservation.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
