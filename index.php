<?php

$title = "Catalogue de cours";

include 'partiales/header.php';
require'request/catalogue.dao.php';
$cours = getCours();
//Fonction permettant de tronquer le texte
function truncate($text, $ending = '...'){
    if (strlen($text) > 50) {
        return substr($text, 0, 50).$ending;
    }
    return $text;
}
?>

<div class="container-md mt-5">
    <div class="h-100 p-5 text-bg-info text-white rounded-3">
        <h1>Catalogue des cours</h1>
            <p class="h3">Bienvenue sur le site de cours en ligne</p>
            <a class="btn btn-outline-light btn-lg" href="ajout-cours.php">Ajouter un cours</a>
    </div>

    <?php
        if(isset($_GET['type']) && $_GET['type'] === 'suppression')
        {
            $coursNameToDelete = getCoursNameToDelete($_GET['idCours']);
            ?>
            <div class="container-md">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p>Voulez vous vraiment supprimer <strong><?= $coursNameToDelete ?></strong> ?</p>
                    <a href="?delete<?= $_GET['idCours'] ?>" class="btn btn-outline-danger">Confirmer</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php }
    ?>

    <section class="d-flex justify-content-around mt-5">
        <?php foreach ($cours as $cour): ?>
            <div class="card" style="width: 18rem">
                <img src="assets/img/<?= $cour['image'] ?>" class="card-img-top" alt="<?= $cour['libelle'] ?>"/>
                <div class="card-body">
                    <h5 class="card-title"><?= $cour['libelle'] ?></h5>
                    <p class="card-text"><?= truncate($cour['description']) ?></p>
                    <?php 
                        $type = getCoursType($cour['idType']);
                    ?>
                    <span class="badge bg-primary"><?= $type['libelle'] ?></span>
                </div>
                <div class="card-footer mt-3 d-flex justify-content-around">
                    <form action="" method="GET">
                        <input type="hidden" name="idCours" value="<?=$cour['idCours']?>" />
                        <input type="hidden" name="type" value="modification" />
                        <input type="submit" value="Modifier" class="btn btn-primary" />
                    </form>
                    <form action="" method="GET">
                        <input type="hidden" name="idCours" value="<?=$cour['idCours']?>" />
                        <input type="hidden" name="type" value="suppression" />
                        <input type="submit" value="Supprimer" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>

<?php include 'partiales/footer.php'; ?>

