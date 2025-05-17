<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);


require 'functions/functions.php';

// Load users data
$usersFile = "users.json";
$userData = getAllUsers($usersFile);
$users = $userData['users'];

// Filter users based on search criteria
$searchName = isset($_GET['search']) ? $_GET['search'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : '';

// Initialize filtered users array
$filteredUsers = [];



// Apply filters
foreach ($users as $user) {
    // Check if the user has Kansai in any of their reservations
    $isVIP = false;
    if (isset($user['reservation'])) {
        foreach ($user['reservation'] as $reservation) {
            if ((strpos($reservation['transport'], 'vip') !== false || 
                (isset($reservation['transport']) && strpos($reservation['transport'], 'VIP') !== false)) ||
                (strpos($reservation['hotel'], 'vip') !== false || 
                (isset($reservation['hotel']) && strpos($reservation['hotel'], 'VIP') !== false))) {
                $isVIP = true;
                break;
            }
        }
    }
    
    // Apply status filter
    if ($filterStatus === 'vip' && !$isVIP) {
        continue;
    } elseif ($filterStatus === 'standard' && $isVIP) {
        continue;
    }
    
    // Apply search filter
    if (!empty($searchName) && 
        stripos($user['surname'] . ' ' . $user['first_name'], $searchName) === false &&
        stripos($user['email'], $searchName) === false) {
        continue;
    }
    
    // Add user status
    $user['status'] = $isVIP ? 'VIP' : 'Standard';
    
    // Add user to filtered list
    $filteredUsers[] = $user;
}
?>



<!-- html start -->

<?php include 'header.php'; ?> 

    <main>
        <br/>

        <!--Section features with search form-->
        <section class="journey-highlights">
            <section class="search-section">
                <form class="search-form" action="admin_page.php" method="get">
                    <div class="form-group">
                        <input type="text" name="search" class="search-input" placeholder="Rechercher un client..." value="<?php echo htmlspecialchars($searchName); ?>">
                        <select id="status" name="status">
                            <option value="">Tous les statuts</option>
                            <option value="vip" <?php echo $filterStatus === 'vip' ? 'selected' : ''; ?>>VIP</option>
                            <option value="standard" <?php echo $filterStatus === 'standard' ? 'selected' : ''; ?>>Standard</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-search">Rechercher</button>
                    <a href="sign_up.php" class="btn btn-search">+ Ajouter un Client</a>
                </form>
            </section>
        </section>

        <!--A table that will display all clients-->
        <table class="client-table">
            <thead>
                <tr 
                    data-nom="<?php echo htmlspecialchars($user['surname']); ?>" 
                    data-prix="<?php echo $user['prix'] ?? 0; ?>" 
                    data-duree="<?php echo $user['duree'] ?? 0; ?>" 
                    data-etapes="<?php echo $user['etapes'] ?? 0; ?>"
>
                    <th data-sort="nom">Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Réservations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($filteredUsers)): ?>
                    <tr 
                        data-nom="<?php echo htmlspecialchars($user['surname']); ?>" 

>
                        <td colspan="6" class="empty-state">Aucun client trouvé</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($filteredUsers as $user): ?>
                        <tr 
                            data-nom="<?php echo htmlspecialchars($user['surname']); ?>" 
                            
>
                            <td><?php echo htmlspecialchars($user['surname']); ?></td> <!-- htmlspecialchars() is used to prevent code injection by converting special characters into safe HTML entities. -->

                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($user['status']); ?>">
                                    <?php echo $user['status']; ?>
                                </span>
                            </td>
                            <td> <!--list reservation of the client-->
                                <?php if (isset($user['reservation']) && !empty($user['reservation'])): ?>
                                    <ul class="reservation-list">
                                        <?php foreach ($user['reservation'] as $index => $reservation): ?>
                                            <li>
                                                <?php echo htmlspecialchars($reservation['region1']); ?>
                                                <?php if (!empty($reservation['region2'])): ?>
                                                    , <?php echo htmlspecialchars($reservation['region2']); ?>
                                                <?php endif; ?>
                                                <strong><?php echo htmlspecialchars($reservation['status']); ?> </strong>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <span class="no-reservation">Aucune réservation</span>
                                <?php endif; ?>
                            </td>
                            <td class="client-actions">
                                <a href="edit_client.php?id=<?php echo $user['id']; ?>" class="btn btn-edit">Modifier</a>
                                <a href="view_client.php?id=<?php echo $user['id']; ?>" class="btn btn-view">Voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <?php include 'footer.php'; ?>