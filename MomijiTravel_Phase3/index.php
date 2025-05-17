<?php
session_start();

// Verify if the user is connected
$isLoggedIn = isset($_SESSION['user_id']);
?>


<!-- html start -->

<?php include 'header.php'; ?> 

    <main>
        <!--Here is the hero of the page: the most important part of the page-->
        <section class="page-hero">
            <h2>Explorez le Japon en automne</h2>
            <p>Découvrez nos circuits exclusifs de 10 jours à travers les plus beaux paysages automnaux du Japon. 
               Des temples ancestraux aux érables flamboyants, vivez une expérience inoubliable.</p>
		
            <div class="cta-buttons"> <!-- class cta = call-to-action buttons. It means you can click it. -->
                <a href="search.php" class="btn">Explorer les circuits</a>
                <a href="presentation.php" class="btn btn-outline">En savoir plus</a>
            </div>
        </section>
        
        <!-- section  "features" is for description card (info of the page)-->
        <section class="features">
            <h3>Pourquoi choisir Momiji Travel ?</h3>
            <div class="feature-grid">
                <!-- there is a grid and here will be the first card with its info-->
                <div class="feature-card">
                    <h4>Circuits exclusifs</h4>
                    <p>Des itinéraires enchâssés de poésie, où l'automne japonais dévoile ses couleurs dans deux régions fascinantes, à travers des thèmes uniques et envoûtants.</p>
                </div>
                <div class="feature-card">
                    <h4>Guides experts</h4>
                    <p>Accompagnement par des guides locaux passionnés et francophones.</p>
                </div>
                <div class="feature-card">
                    <h4>Petits groupes</h4>
                    <p>Maximum 15 personnes pour une expérience plus authentique.</p>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
