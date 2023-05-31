<?php
    require_once './config/bdd.php';

    // récupération des données
    $artiste = [];
    $reqsalle = $bdd->query('SELECT * FROM artiste');
    $salle = $reqsalle->fetchAll();
?>

<h1>Espace administrateur</h1>

<h2 class="mt-5">artiste</h2>

<table class="table table-hover text-center my-5">
    <thead class="table-dark">  
        <tr>
            <th>N°</th>
            <th>NOM</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($artiste)) {
                // foreach
            } else {
                echo '
                    <tr>
                        <td colspan=5>Aucun artiste trouvé</td>
                    </tr>
                ';
            }
        ?>
        <!-- liste des articles -->
    </tbody>
</table>

<div class="text-end">
    <a href="index.php?page=article-form" class="btn btn-primary">Rédiger un article</a>
</div>

<h2 class="mt-5">Salle</h2>

<table class="table table-hover text-center my-5">
    <thead class="table-dark">
        <tr>
            <th>N°</th>
            <th>NOM</th>
            <th>Adresse</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($salle)) {
                foreach ($salle as $salle) { ?>
                    <tr>
                        <td><?= $salle['id'] ?></td>
                        <td><?= $salle['nom'] ?></td>
                        <td><?= $salle['adresse'] ?></td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square"></i></a>
                            <a href="./functions/traitement.php?action=category-delete&id=<?= $salle['id'] ?>" class="text-danger"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo '
                    <tr>
                        <td colspan=3>Aucune salle trouvé</td>
                    </tr>
                ';
            }
        ?>
    </tbody>
</table>

<form action="./functions/traitement.php?action=category-create" method="POST">
    <label for="name">Nom</label>
    <input type="text" name="name" maxlength="45" required>
    <input type="submit" value="Créer une catégorie" class="btn btn-primary">
</form>
