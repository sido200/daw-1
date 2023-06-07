<?php
include('config/connect.php');

$nomville = $descville = $nompays = $nomcon = $gare = $hotel = $aeroport = '';

$errors = array(
    'nomville' => '',
    'descville' => '',
    'nompays' => '',
    'nomcon' => '',
    'gare' => '',
    'hotel' => '',
    'aeroport' => ''
);

if (isset($_POST['submit'])) {
    if (empty($_POST['nomville'])) {
        $errors['nomville'] = "Entrez un nom de ville <br/>";
    } else {
        $nomville = $_POST['nomville'];
    }

    if (empty($_POST['descville'])) {
        $errors['descville'] = "Entrez une description de ville <br/>";
    } else {
        $descville = $_POST['descville'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $descville)) {
            $errors['descville'] = 'La description doit être valide';
        }
    }

    if (empty($_POST['nompays'])) {
        $errors['nompays'] = "Entrez un nom de pays <br/>";
    } else {
        $nompays = $_POST['nompays'];
    }

    if (empty($_POST['nomcon'])) {
        $errors['nomcon'] = "Entrez un nom de continent <br/>";
    } else {
        $nomcon = $_POST['nomcon'];
    }

    if (empty($_POST['gare'])) {
        $errors['gare'] = "Entrez le nom d'une gare <br/>";
    } else {
        $gare = $_POST['gare'];
    }

    if (empty($_POST['hotel'])) {
        $errors['hotel'] = "Entrez le nom d'un hôtel <br/>";
    } else {
        $hotel = $_POST['hotel'];
    }

    if (empty($_POST['aeroport'])) {
        $errors['aeroport'] = "Entrez le nom d'un aéroport <br/>";
    } else {
        $aeroport = $_POST['aeroport'];
    }

    if (array_filter($errors)) {
        // Il y a des erreurs, ne rien faire
    } else {
        $nomville = mysqli_real_escape_string($conn, $_POST['nomville']);
        $descville = mysqli_real_escape_string($conn, $_POST['descville']);
        $nompays = mysqli_real_escape_string($conn, $_POST['nompays']);
        $nomcon = mysqli_real_escape_string($conn, $_POST['nomcon']);
        $gare = mysqli_real_escape_string($conn, $_POST['gare']);
        $hotel = mysqli_real_escape_string($conn, $_POST['hotel']);
        $aeroport = mysqli_real_escape_string($conn, $_POST['aeroport']);

        // Insertion dans la table "ville"
        $sql = "INSERT INTO ville (nomville, descville) VALUES ('$nomville', '$descville')";
        mysqli_query($conn, $sql);
        $villeId = mysqli_insert_id($conn); // Récupérer l'ID généré pour la ville insérée

        // Insertion dans la table "pays"
        $sql2 = "INSERT INTO pays (nompays) VALUES ('$nompays')";
        mysqli_query($conn, $sql2);
        $paysId = mysqli_insert_id($conn); // Récupérer l'ID généré pour le pays inséré

        // Insertion dans la table "contient"
        $sql3 = "INSERT INTO contient (nomcon) VALUES ('$nomcon')";
        mysqli_query($conn, $sql3);
        $contientId = mysqli_insert_id($conn); // Récupérer l'ID généré pour le continent inséré

        // Insertion dans la table "necessaire"
        $sql4 = "INSERT INTO necessaire (idville, gare, aeroport, hotel) VALUES ('$villeId', '$gare', '$aeroport', '$hotel')";
        mysqli_query($conn, $sql4);

        // Insertion dans la table "site"
        $sql5 = "INSERT INTO site (idville, nomsite) VALUES ('$villeId', '$nomsite')";
        mysqli_query($conn, $sql5);

        header('Location: index.php');
    }
}

?>

<html lang="en">
<?php include('template/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Ajouter une ville</h4>
    <form class="white" action="add.php" method="post">
        <label>Nom de la ville :</label>
        <input type="text" name="nomville" value="<?php echo htmlspecialchars($nomville) ?>">
        <div class="red-text"><?php echo $errors['nomville'] ?></div>
        <label>Description de la ville :</label>
        <input type="text" name="descville" value="<?php echo htmlspecialchars($descville) ?>">
        <div class="red-text"><?php echo $errors['descville'] ?></div>
        <label>Pays :</label>
        <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays) ?>">
        <div class="red-text"><?php echo $errors['nompays'] ?></div>
        <label>Continent :</label>
        <input type="text" name="nomcon" value="<?php echo htmlspecialchars($nomcon) ?>">
        <div class="red-text"><?php echo $errors['nomcon'] ?></div>
        <label>Gare :</label>
        <input type="text" name="gare" value="<?php echo htmlspecialchars($gare) ?>">
        <div class="red-text"><?php echo $errors['gare'] ?></div>
        <label>Aéroport :</label>
        <input type="text" name="aeroport" value="<?php echo htmlspecialchars($aeroport) ?>">
        <div class="red-text"><?php echo $errors['aeroport'] ?></div>
        <label>Hôtel :</label>
        <input type="text" name="hotel" value="<?php echo htmlspecialchars($hotel) ?>">
        <div class="red-text"><?php echo $errors['hotel'] ?></div>
        <div class="center">
            <input type="submit" value="Submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
</html>
