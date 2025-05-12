<?php
session_start();

require 'functions/functions.php';

// Verify if the user is already connected
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}



// connexion form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $error = '';
    
    // check if full 
    if (empty($login) || empty($password)) {
        $error = 'Veuillez remplir tous les champs';
    } else {
        $result = verifyCredentials($login, $password);
        
        if (isset($result['success']) && $result['success']) {
            // connexion succeed
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['user_login'] = $result['user']['login'];
            
            // redirection to index
            header('Location: index.php');
            exit;
        } else {
            $error = $result['error'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<!--Description of the page-->
<head>
  <meta charset="UTF-8">
  <title>Page de connexion</title>
  <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
  <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours." />
  <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">

</head>
  
<body>
<!--login form code-->

  <header>	
  <h1> 紅葉 Momiji Travel  </h1>

	<!-- navigation part: place to go to others pages-->
        <nav>
		 <a href="index.php">Accueil</a>
		<a href="presentation.php">Présentation</a>
		<a href="search.php">Rechercher un voyage</a>
		<a href="tour.php">Les circuits typiques</a>
        <a href="sign_up.php">S'inscrire</a>
        </nav>
  </header>

    <main>
	<!-- this section is for another background image-->
	<section class = "background"> 
		
  		<div class="wrap">
			
  			<div class="login_box">
    				<div class="login-header"> 
      					<span>Connexion</span>
    				</div>

					<?php if (isset($error) && !empty($error)): ?>
						<div class="error-message">
							<p><?php echo htmlspecialchars($error); ?></p>
						</div>
					<?php endif; ?>

					<form action="login_form.php" method="post">
  						<div class="input_box">
    						<input type="text" name="login" class="input-field" placeholder="Identifiant" required>
    						<i class="bx bx-user icon"></i>
  						</div>
    				
  						<div class="input_box">
    						<input type="password" name="password" class="input-field" placeholder="Mot de passe" required>
    						<i class="bx bx-lock-alt icon"></i> <!--icon for password-->
  						</div>

			<form action="index.php" method="get">
  				<div class="input_box">
    					<input type="submit" class="input-submit" value="Se connecter"> <!-- button to login in-->
  				</div>
			</form>

    			<div class="register">
      				<p>Pas encore de compte ? 
      				<a href="sign_up.php">Inscrivez-vous</a></p>    
    			</div>
  		</div>
	</div>
</section>  

    </main>
	<?php include 'footer.php'; ?> 