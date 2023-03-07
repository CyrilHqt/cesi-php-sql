<?php
$title = isset($title) ? $title : "Cataloghe de cours";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div>
                <button>

                </button>
                <div>
                    <a href="index.php">Catalogue de cours</a>
                    <ul>
                        <li classe="nav-item">
                            <a href="index.php">Accueil</a>
                        </li>
                        <li classe="nav-item">
                            <a href="index.php">Catalogue</a>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
    </header>

    
</body>
</html>