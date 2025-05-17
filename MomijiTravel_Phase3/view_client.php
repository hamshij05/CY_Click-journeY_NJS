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

// Check if the user has Kansai in any of their reservations
$isVIP = false;
if (isset($user['reservation'])) {
    foreach ($user['reservation'] as $reservation) {
        if (strpos($reservation['region1'], 'Kansai') !== false || 
            (isset($reservation['region2']) && strpos($reservation['region2'], 'Kansai') !== false)) {
            $isVIP = true;
            break;
        }
    }
}

// Get user's status
$userStatus = $isVIP ? 'VIP' : 'Standard';

// Get profile picture
$profilePicture = getProfilePicture($userId);
?>

<!-- html start -->

<?php include 'header.php'; ?> 

    </header>

    <main>
        <div class="back-link">
            <a href="admin_page.php">&larr; Retour à la liste des clients</a>
        </div>
        <br/>
        
        <section class="feature-card">
            <div class="client-header">
                <div class="profile-picture-container">
                    <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Photo de profil">
                </div>


                    <h2><?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['surname']); ?></h2>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Identifiant:</strong> <?php echo htmlspecialchars($user['login']); ?></p>
                    <p>
                        <strong>Statut:</strong> 
                        <span class="status-badge status-<?php echo strtolower($userStatus); ?>">
                            <?php echo $userStatus; ?>
                        </span>
                    </p>

                <div class="client-actions">
                    <a href="edit_client.php?id=<?php echo $user['id']; ?>" class="btn btn-edit">Modifier</a>
                </div>
            </div>
            </section>
            <br/><br/>

            
            <section class="feature-card">
            <div class="client-reservations">
                <h3>Réservations</h3>
                
                <?php if (isset($user['reservation']) && !empty($user['reservation'])): ?>
                    <table class="reservations-table">
                        <thead>
                            <tr>
                                <th>  Date  </th>
                                <th>  Durée  </th>
                                <th>  Participants  </th>
                                <th>  Région 1  </th>
                                <th>  Thème 1  </th>
                                <th>  Région 2  </th>
                                <th>  Thème 2  </th>
                                <th>  Prix Total  </th>
                                <th>  Actions  </th>
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
