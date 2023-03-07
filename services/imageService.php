<?php
function ajoutImage($file, $dir, $nom):string
{
    // On teste que l'on récupère bien un fichier
    if(!isset($file['name']) || empty($file['name'])){
        throw new RuntimeException("Vous devez indiquer une image");
    }

    // On teste que l'on ait bien un répertoire vers lequel enregistrer le fichier
    if(!file_exists($dir)) if(!mkdir($dir, 0777) && !is_dir($dir)){
        throw new RuntimeException(sprintf('Le répertoire "%s" n\a pas été créé !', $dir));
    }

    // On récupère l'extension du fichier, son type MIME
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    // On enregistre le futur nom de notre fichier
    $target_file = $dir.$nom."_".$file['name'];
    // On teste que le type MIME soit bien un type image
    if(!getimagesize($file['tmp_name'])){
        throw new RuntimeException("Le fichier n'est pas une image");
    }
    // On teste le type MIME que ce soit bien un type autorisé
    if($extension !== "jpg" && $extension !== "png" && $extension !== "jpeg"){
        throw new RuntimeException("L'extension du fichier n'est pas reconnu");
    }
    // On teste que l'on n'a pas déjà un fichier avec ce nom
    if(file_exists($target_file)){
        throw new RuntimeException("Le fichier existe déjà");
    }
    // On teste que le fichier ne dépasse pas un certain poids
    if($file['size'] > 500000){
        throw new RuntimeException("Le fichier est trop gros");
    }
    // On teste que l'enregistrement du fichier dans le répertoire souhaité soit fait
    if(!move_uploaded_file($file['tmp_name'], $target_file)){
        throw new RuntimeException("L'ajout d'image n'a pas fonctionné");
    }else{
        return ($nom."_".$file['name']);
    }
}

function deleteImage($directory, $nom)
{
    unlink($directory.$nom);
}
?>