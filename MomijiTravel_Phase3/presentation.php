<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!-- html start -->

<?php include 'header.php'; ?> 


    <main>
        <!--Most important part of the page-->
        <section class="page-hero">
            <h2>À propos de Momiji Travel</h2>
            <p>Spécialiste des voyages au Japon pendant la saison des érables</p>
        </section>

        <section class="features">
            <div class="feature-grid">
                <!--this class is to show info of the page and the description of our service-->
                <div class="feature-card">
                    <h3>Notre histoire</h3>
                    <p>Momiji Travel est né d'une passion pour le Japon et ses traditions séculaires. 
                       Nous nous spécialisons dans les voyages automnaux, quand les érables se parent 
                       de leurs plus belles couleurs et que le pays révèle toute sa splendeur.</p>
                </div>
                <div class="feature-card">
                    <h3>Notre engagement</h3>
                    <p>Nous vous proposons des circuits de 10 jours minutieusement élaborés pour vous 
                       faire découvrir les plus beaux sites du Japon dans des conditions optimales.</p>
                </div>
            </div>
        </section>

        <section class="journey-highlights">
            <h3>Points forts de nos circuits</h3>
            <!--this class is only used to represente the planning of the travel or in this case, a list of things with its unique design-->
            <ul class="highlights-list">
                <li>Visite des temples les plus renommés</li>
                <li>Hébergement en ryokan traditionnel</li>
                <li>Découverte de la gastronomie locale</li>
                <li>Expérience des onsen (sources thermales)</li>
                <li>Observation des érables dans des jardins séculaires</li>
                <li>Annulation possible</li>
            </ul>
        </section>

        <section class="features">
            <!--the class search section and form make it a place to search for a theme of the travel (interraction with the web)-->
            <section class="search-section">
                <form class="search-form" action="tour.html" method="get">
                    <div class="form-group">
                        <label for="theme">Thème du Voyage :</label>

                        <!--the ID is used here so the page know where to send the client on the tour page ( culture part, food part or detente part-->
                        <!-- required is to obligate the client before sending the form to choose an option and onchange is to modify dynamically the action attribute-->
                        <select id="theme" name="theme" required onchange="this.form.action = 'tour.php#' + this.value;">
                            <option value="">Choisir un thème</option>
                            <option value="culture">Culture & Temples </option>
                            <option value="food">Gastronomique & Traditionnel</option>
                            <option value="detente">Détente & Bien-être </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-search">Rechercher</button> 
                </form>
            </section>
        </section>
    </main>
    <?php include 'footer.php'; ?> 
