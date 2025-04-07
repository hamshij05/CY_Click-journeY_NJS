<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">

<!--Description part-->
<head>
  <meta charset="UTF-8">
  <title>HTML Page d'Administrateur </title>
  <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
  <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours." />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">


</head>


<!-- this page won't be accessible from any other pages. Normally, only the administrator that had the accountof admin will be able to access to this page.--> 

<body>
    <header>
        <h1>紅葉 Momiji Travel - Administration des Clients</h1>  
	<!--Navigation part to navigate through different pages--> 
        <nav>
	    <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
	    <a href="tour.html">Les circuits typiques</a>
        <?php include 'nav.php'; ?> 
        </nav>
    </header>



<main>

	<br/>

	<!--Section features is used just like in the presentation page with a search form, adding and input field to find the client directly-->
        <section class="features">
	        <section class="search-section" >
		<input type="text" class="search-input" placeholder="Rechercher un client..."
                <form class="search-form" action="admin_page.html" method="get">
                    <div class="form-group">
                     
                        <select id="statut" name="Statut" required onchange="this.form.action = 'admin_page.html#' + this.value;">
                            <option value="">Choisir le statut</option>
                            <option value="vip">VIP</option>
                            <option value="standard">Standard </option>
                        </select>
                    </div>
                <button type="submit" class="btn btn-search">Rechercher</button>
		<button type="submit" class="btn btn-search">+ Ajouter un Client</button>
	        </form>
	    </section>
	</section>




      <!--this is only temporaly, because without client we can't show all these option-->
        <div class="style-examples">
            <h2>Styles disponibles</h2>
            <div class="example-section">
                <h3>Badges de statut :</h3>
                <span class="status-badge status-standard">Standard</span>
                <span class="status-badge status-vip">VIP</span>
            </div>
            <div class="example-section">
                <h3>Boutons d'action :</h3>
                <div class="client-actions">
                    <button class="btn btn-edit">Modifier</button>
                    <button class="btn btn-delete">Supprimer</button>
                </div>
            </div>
        </div>

	
	<!--A table that will have every client-->
        <table class="client-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Réservation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="empty-state">Aucun client trouvé</td>  <!--this is also temporaly as there is no client-->
                </tr>
            </tbody>
        </table>
    </div>
</main>
    <?php include 'footer.php'; ?>
</body>
</html>
