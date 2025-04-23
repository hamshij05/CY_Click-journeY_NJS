<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);

require 'functions/functions.php';

// Process the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Retrieving the form data
    $first_name = $_POST['first_name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation of the fields
    if (empty($first_name)) $errors[] = "Le prénom est requis";
    if (empty($surname)) $errors[] = "Le nom est requis";
    if (empty($email)) $errors[] = "L'email est requis";
    if (!isValidEmail($email)) $errors[] = "L'email n'est pas valide";
    if (empty($login)) $errors[] = "L'identifiant est requis";
    if (isLoginExists($login)) $errors[] = "Cet identifiant est déjà utilisé";
    if (empty($password)) $errors[] = "Le mot de passe est requis";
    if ($password !== $confirmPassword) $errors[] = "Les mots de passe ne correspondent pas";
    
    if (empty($errors)) {
        // Reading the users.json file
        $usersFile = file_get_contents('users.json');
        $usersData = json_decode($usersFile, true);
        
        // Creation of the new user
        $newUser = [
            'id' => uniqid(),
            'first_name' => $first_name,
            'surname' => $surname,
            'email' => $email,
            'login' => $login,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        // Adding the new user
        $usersData['users'][] = $newUser;
        
        // Saving in the file
        file_put_contents('users.json', json_encode($usersData, JSON_PRETTY_PRINT));
        
        // Automatic connection
        $_SESSION['user_id'] = $newUser['id'];
        $_SESSION['user_login'] = $newUser['login'];
        
        // Redirection to the home page
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<!--description part-->
<head>
  <meta charset="UTF-8">
  <title>Page d'inscription</title>
  <meta name="author" content="Thuy Tran NGUYEN - Hamshigaa JEKUMAR - Elsa SANCHEZ" />
  <meta name="description" content="Une page web d'agence de voyage au Japon en automne pour 10 jours." />
  <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css">

</head>
  
<body>
<!--sign up form code-->

  <header>	
  <h1 style="text-align:center"> 紅葉 Momiji Travel  </h1>

	<!--navigation part to navigate through different pages-->
        <nav>
	          <a href="index.php">Accueil</a>
            <a href="presentation.php">Présentation</a>
            <a href="search.php">Rechercher un voyage</a>
            <a href="tour.php">Les circuits typiques</a>
	          <a href="login_form.php">Connexion</a>
        </nav>
  </header>

    <main>
<section class = "background"> <!--for the background image-->
  <div class="wrap"> <!-- container that centers its content both horizontally and vertically on the screen. -->
  <div class="login_box"> <!--Login box styling with blur effect, border, and shadow-->
    <div class="login-header"> <!--title of the sign up form-->
      <span>Inscription</span>
    </div>
        
<?php if (!empty($errors)): ?>
    <div class="error-message">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="sign_up.php" method="post">

 

  <div class="input_box">
  <input type="text" name="first_name" class="input-field" placeholder="Prénom" required>
  <i class="bx bx-user-circle icon"></i>
</div>

<div class="input_box">
  <input type="text" name="surname" class="input-field" placeholder="Nom" required>
  <i class="bx bx-user-circle icon"></i>
</div>
    
<div class="input_box">
  <input type="email" name="email" class="input-field" placeholder="Adresse email" required>
  <i class="bx bx-envelope icon"></i>
</div>
    
<div class="input_box">
  <input type="text" name="login" class="input-field" placeholder="Identifiant" required>
  <i class="bx bx-user icon"></i>
</div>
    
<div class="input_box">
  <input type="password" name="password" class="input-field" placeholder="Mot de passe" required>
  <i class="bx bx-lock-alt icon"></i>
</div>
    
<div class="input_box">
  <input type="password" name="confirm_password" class="input-field" placeholder="Confirmer le mot de passe" required>
  <i class="bx bx-lock-alt icon"></i>
</div>
    
    
  <div class="input_box">
    <input type="submit" class="input-submit" value="S'inscrire">
  </div>
</form>

    <div class="register">
      <p>Déjà un de compte ? 
      <a href="login_form.php">Connectez-vous</a></p>   
    </div>
  </div>
</div>
</section>  

    </main>
    <?php include 'footer.php'; ?> 
