<?php
$title = "AJout d'un cours";

include 'partiales/header.php';
require 'request/catalogue.dao.php';

$types = getTypes();
?>

<?php
// Alert
if (isset($_POST['libelle'])) {
    try {
        $success = addTypeCours($_POST['libelle']);
        if ($success) { ?>
            <div class="container-md">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>L'ajout du type de cours s'est bien déroulée</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php } else { ?>
            <div class="container-md">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p>L'ajout du type de cours ne s'est pas bien déroulée</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
<?php  }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<?php
// Supp
if (isset($_GET['type']) && $_GET['type'] == 'suppression') {
    $typeNameToDelete = getTypeNameToDelete($_GET['idType']);
?>
    <div class="container-md">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <p>Voulez vous vraiment supprimer <strong><?= $typeNameToDelete ?></strong> ?</p>
            <a href="?delete=<?= $_GET['idType'] ?>" class="btn btn-outline-danger">Confirmer</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php }
if (isset($_GET['delete'])) {
    $success = deleteType($_GET['delete']);
    if ($success) { ?>
        <div class="container-md">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p>La suppression du type s'est bien déroulée</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php } else { ?>
        <div class="container-md">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <p>La suppression du type ne s'est pas bien déroulée</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
<?php }
}
$types = getTypes();
?>

<div class="container-md mt-5">
    <div class="h-100 p-5 text-bg-info text-white rounded-3">
        <h1>Création d'un type de cours</h1>
        <p class="h3">Bienvenue sur la page d'ajout d'un type de cours</p>
        <a class="btn btn-outline-light btn-lg" href="index.php">Retourner à l'accueil</a>
    </div>
    <!-- Ajout type -->
    <div class="mt-5 w-75 mx-auto">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="libelle">Type du cours : </label>
                <input class="form-control mt-3" type="text" name="libelle" id="libelle" placeholder="Saisir le type du cours">
            </div>
            <input type="submit" value="Enregistrer" class="btn btn-primary btn-lg mt-5">
        </form>
    </div>
</div>

<!--  -->
<div class="row no-gutters">
    <h2 class="text-center my-4">Voici la liste de nos types de cours</h2>
    <?php foreach ($types as $type) : ?>
        <div class="col-md-4 mt-5">
            <div class="card mx-auto " style="width: 18rem;">
             <div class="card-body d-flex justify-content-around">
                    <?php
                    $type = getCoursType($type['idType']);
                    ?>
                    <div class="text-center">
                        <span class="badge bg-primary"><?= $type['libelle'] ?></span>
                    </div>
                    <form action="" method="GET">
                        <input type="hidden" name="idType" value="<?= $type['libelle'] ?>" />
                        <input type="hidden" name="type" value="suppression" />
                        <input type="submit" value="Supprimer" class="btn btn-outline-danger" />
                    </form>
                </div>
            </div>

        </div>
    <?php endforeach; ?>
    <?php
    include 'partiales/footer.php';
    ?>