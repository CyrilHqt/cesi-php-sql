<?php

$title = "Catalogue de cours";

include'partiales/header.php';
require'request/catalogue.dao.php';
require'services/imageService.php';

$cours = getCours();
$type = getTypes();
// Fonction permettant de tronquer le texte
function truncate($text, $ending = '...') {
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
    // SUPPRESSION
        if(isset($_GET['type']) && $_GET['type'] === 'suppression')
        {
            $coursNameToDelete = getCoursNameToDelete($_GET['idCours']);
            ?>
            <div class="container-md">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p>Voulez vous vraiment supprimer <strong><?= $coursNameToDelete ?></strong> ?</p>
                    <a href="?delete=<?= $_GET['idCours'] ?>" class="btn btn-outline-danger">Confirmer</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php }
        if(isset($_GET['delete']))
        {
            $imageToDelete = getImageToDelete($_GET['delete']);
            deleteImage("assets/img/", $imageToDelete);
            $success = deleteCours($_GET['delete']);
            if($success){ ?>
                <div class="container-md">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>La suppression s'est bien déroulée</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php }else{?>
                <div class="container-md">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p>La suppression ne s'est pas bien déroulée</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php }
        }
        // MODIFICATION
        if(isset($_POST['type']) && $_POST['type'] === 'modificationEtape2')
        {
            $newImageName = "";
            if($_FILES['imageCours']['name'] !== ""){
                $imageToDelete = getImageToDelete($_POST['idCours']);
                deleteImage("assets/img/", $imageToDelete);
                $fileImage = $_FILES['imageCours'];
                $directory = __DIR__."/assets/img/";
                try{
                    $newImageName = ajoutImage($fileImage, $directory, str_replace(' ', '-', strtolower($_POST['nomCours'])));
                }catch (Exception $e){
                    echo $e->getMessage();
                }
            }
            $success = updateCours($_POST['idCours'], $_POST['nomCours'], $_POST['descCours'], $_POST['idType'], $newImageName);
            if($success){ ?>
                <div class="container-md">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>La modification s'est bien déroulée</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php }else { ?>
                <div class="container-md">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p>La modification ne s'est pas bien déroulée</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php }
        }
        $cours = getCours();
    ?>
    <div class="row no-gutters">
        <?php foreach ($cours as $cour) : ?>
            <div class="col-md-4 mt-5">
                <?php
                if(!isset($_GET['type']) || $_GET['type'] !== 'modification' || $_GET['idCours'] !== $cour['idCours'])
                {?>
                    <div class="card mx-auto" style="width: 18rem;height: 30rem">
                        <img src="assets/img/<?= $cour['image'] ?>" class="card-img-top img-fluid" alt="<?= $cour['libelle'] ?>">
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
                                <input type="hidden" name="idCours" value="<?= $cour['idCours'] ?>" />
                                <input type="hidden" name="type" value="modification" />
                                <input type="submit" value="Modifier" class="btn btn-primary" />
                            </form>
                            <form action="" method="GET">
                                <input type="hidden" name="idCours" value="<?= $cour['idCours'] ?>" />
                                <input type="hidden" name="type" value="suppression" />
                                <input type="submit" value="Supprimer" class="btn btn-outline-danger" />
                            </form>
                        </div>
                    </div>
                <?php }else{?>
                    <form class="card mx-auto" style="width: 22rem;height: 40rem" action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="type" value="modificationEtape2" />
                        <input type="hidden" name="idCours" value="<?= $cour['idCours'] ?>" />
                        <img src="assets/img/<?= $cour['image'] ?>" class="card-img-top img-fluid" alt="<?= $cour['libelle'] ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="imageCours">Image du cours :</label>
                                <input type="file" name="imageCours" id="imageCours" class="form-control-file mt-3" />
                            </div>
                            <div class="form-group">
                                <label for="nomCours">Nom du cours :</label>
                                <input type="text" name="nomCours" value="<?= $cour['libelle'] ?>" id="nomCours" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="descCours">Description du cours :</label>
                                <textarea name="descCours" id="descCours" class="form-control"><?= $cour['description'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="idType">Type du cours :</label>
                                <select id="idType" name="idType" class="form-control">
                                    <?php foreach($type as $type): ?>
                                    <option value="<?= $type['idType'] ?>" <?= ($type['idType'] === $cour['idType']) ? "selected" : "" ?>>
                                        <?= $type['libelle'] ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-around">
                            <input type="submit" value="Valider" class="btn btn-primary" />
                            <input type="submit" value="Annuler" onclick="cancelModification(event)" class="btn btn-outline-danger" />
                        </div>
                    </form>
                <?php }
                ?>

            </div>
        <?php endforeach; ?>
</div>

<?php include 'partiales/footer.php'; ?>