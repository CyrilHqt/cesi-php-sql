<?php
require'config/db.php';

/**
 * Permet de récupérer les cours en base de données
 */
function getCours()
{
    $dbh = getConnexion();
    $req = "SELECT * FROM cours";
    return $dbh->query($req)->fetchAll();
}

function getCoursType($idType)
{
    $dbh = getConnexion();
    $req2 = "SELECT libelle FROM type WHERE idType = :idType";
    $stmt = $dbh->prepare($req2);
    // On bind la value en paramètre pour sécuriser la requête
    $stmt->bindValue(":idType", $idType, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

function getCoursNameToDelete($idCours)
{
    $dbh = getConnexion();
    $req = 'SELECT CONCAT(idCours, " : ",libelle) AS monCours FROM cours WHERE idCours = :idCours';
    $stmt = $dbh->prepare($req);
    $stmt->bindValue(":idCours", $idCours, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch();
    return $res['monCours'];
}

?>