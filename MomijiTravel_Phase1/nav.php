<!-- navigation part to navigation through different page-->

    <?php if ($isLoggedIn): ?>
        <a href="profil.php">Votre Profil</a>
        <a href="logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="login_form.php">Connexion</a>
        <a href="sign_up.php">S'inscrire</a>
    <?php endif; ?>
</nav> 