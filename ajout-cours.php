<?php

$title="Ajout d'un cours";

include 'partials/header.php';

require 'request/catalogue.dao.php';

require 'services/imageService.php';

$type = getTypes();
?>
<?php
    // AJOUT
    if(isset($_POST['libelle'], $_POST['description'], $_POST['idType']))
    {
        $fileImage = $_FILES['imageCours'];
        $directory = __DIR__."/assets/img/";
        try{
           $imageName = ajoutImage($fileImage, $directory, str_replace(' ', '-', strtolower($_POST['libelle'])));
            $success = addCours($_POST['libelle'], $_POST['description'], $_POST['idType'], $imageName);
            if($success){ ?>
                <div class="container-md">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>La création s'est bien déroulée</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="container-md">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <p>La création ne s'est pas bien déroulée</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php }
        }catch(Exception $e){
            echo $e->getMessage();
        }

    }
?>
<div class="container-md mt-5">
    <div class="h-100 p-5 text-bg-info text-white rounded-3">
        <h1>Création d'un cours</h1>
        <p class="h3">Bienvenue sur la page d'ajout de cours</p>
        <a class="btn btn-outline-light btn-lg" href="index.php">Retourner à l'accueil</a>
    </div>
    <div class="mt-5 w-75 mx-auto">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="libelle">Nom du cours :</label>
                <input class="form-control mt-3" id="libelle" name="libelle" type="text" placeholder="Saisir le nom du cours" />
            </div>
            <div class="form-group mt-3">
                <label for="description">Description du cours :</label>
                <textarea class="form-control mt-3" id="description" name="description" ></textarea>
            </div>
            <div class="form-group mt-3">
                <label for="idType">Type du cours :</label>
                <select id="idType" name="idType" class="form-control">
                    <?php foreach($type as $type): ?>
                        <option value="<?= $type['idType'] ?>">
                            <?= $type['libelle'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mt-3">
                <label for="imageCours">Image du cours :</label>
                <input type="file" name="imageCours" id="imageCours" class="form-control-file mt-3" />
            </div>
            <input type="submit" value="Enregistrer" class="btn btn-primary btn-lg mt-5" />
        </form>
    </div>
</div>
<?php
include 'partials/footer.php'; ?>