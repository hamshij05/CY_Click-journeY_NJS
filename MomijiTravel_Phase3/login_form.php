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

<!-- html start -->

<?php include 'header.php'; ?> 

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
  							<input type="password" id="password" name="password" class="input-field" placeholder="Mot de passe" required >
							<i class="bx bx-hide toggle-password" data-target="#password"></i>
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