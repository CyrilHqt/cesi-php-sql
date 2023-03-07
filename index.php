<?php

$title = "Catalogue de cours";

include 'partiales/header.php';

/* Configuration de la base de données environnement */
define('DB_HOST', 'localhost');
define('DB_NAME', 'cesi_php_sql');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

/* Utilisation de PDO dans un try and catch afin de se connecter a la bdd */
// PHP se connecte au sql s'il y arrive sinon il renvoie une erreur

try {
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=3306;dbname=' . DB_NAME, DB_USER, DB_PASSWORD, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //On veut un tableau associatif en résultat
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ]);
} catch (Exception $exception) {
    echo '<h1>' . $exception->getMessage() . '</h1>';
    echo '<a href="https://www.google.fr/search?q=' . $exception->getMessage() . '" target="_blank">Recherche Google</a>';
    die; // On arrête le code PHP
}

$req = "SELECT * FROM cours";
$stmt = $dbh->query($req);
$cours = $stmt->fetchAll();
?>

<div class="">
    <h1>Liste des cours</h1>
    <section class="d-flex justify-content-around mt-5">
        <?php foreach ($cours as $cour): ?>
            <div class="card" style="width: 18rem">
                <img src="assets/img/<?= $cour['image'] ?>" class="card-img-top" alt="<?= $cour['libelle'] ?>"/>
                <div class="card-body">
                    <h5 class="card-title"><?= $cour['libelle'] ?></h5>
                    <p class="card-text"><?= $cour['description'] ?></p>
                    <?php 
                        $req2 = "SELECT libelle FROM type WHERE idType = :idType";
                        $stmt =$dbh->prepare($req2);
                        // On bind la value en paramettre pour sécur la requête
                        $stmt->bindValue(":idType", $cours['idType'],PDO::PARAM_INT);
                        $stmt->execute();
                        $type = $stmt->fetch();
                    ?>

                    <span class="badge bg-primary"><?= $type['libelle'] ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>

<?php include 'partiales/footer.php'; ?>

