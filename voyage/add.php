<?php
include('config/connect.php');

$nomville = $descville = $nompays = $nomcon = $typenec = $nomnec = '';

$errors = array(
    'nomville' => '',
    'descville' => '',
    'nompays' => '',
    'nomcon' => '',
    'typenec' => '',
    'nomnec' => '',
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

    if (empty($_POST['typenec'])) {
        $errors['typenec'] = "Entrez le nom d'une gare <br/>";
    } else {
        $typenec = $_POST['typenec'];
    }

    if (empty($_POST['nomnec'])) {
        $errors['nomnec'] = "Entrez le nom necessaire <br/>";
    } else {
        $nomnec = $_POST['nomnec'];
    }

    if (!array_filter($errors)) {
        $nomville = mysqli_real_escape_string($conn, $_POST['nomville']);


        $descville = mysqli_real_escape_string($conn, $_POST['descville']);
        $nompays = mysqli_real_escape_string($conn, $_POST['nompays']);
        $nomcon = mysqli_real_escape_string($conn, $_POST['nomcon']);
        $typenec = mysqli_real_escape_string($conn, $_POST['typenec']);
        $nomnec = mysqli_real_escape_string($conn, $_POST['nomnec']);


        // Insertion dans la table "ville"

        $idpay = "SELECT idpays FROM pays where nompays ='$nompays';";
                
        $result = mysqli_query($conn, $idpay);
        $voyages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $a=$voyages[0]['idpays'];


        // if (empty($a) ){
        //      // Insertion dans la table "pays"
        // $sql2 = "INSERT INTO pays (nompays) VALUES ('$nompays')";
        // mysqli_query($conn, $sql2);
        // $paysId = mysqli_insert_id($conn); // Récupérer l'ID généré pour le pays inséré
        // }
        $sql = "INSERT INTO ville (nomville, descville,idpays) VALUES ('$nomville','$descville','$a');";
        $conn->query($sql);
        
        $villeId =mysqli_insert_id($conn); // Récupérer l'ID généré pour la ville insérée

        // Insertion dans la table "contient"
        // $sql3 = "INSERT INTO contient (nomcon) VALUES ('$nomcon')";
        // mysqli_query($conn, $sql3);
        // $contientId = mysqli_insert_id($conn); // Récupérer l'ID généré pour le continent inséré
        
        // Insertion dans la table "necessaire"
        $sql4 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','$typenec', '$nomnec');";
        $conn->query($sql4);
        // Insertion dans la table "site"
       

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
        <label>typenec :</label>
        <input type="text" name="typenec" value="<?php echo htmlspecialchars($typenec) ?>">
        <div class="red-text"><?php echo $errors['typenec'] ?></div>
        <label>nomnec :</label>
        <input type="text" name="nomnec" value="<?php echo htmlspecialchars($nomnec) ?>">
        <div class="red-text"><?php echo $errors['nomnec'] ?></div>
       
        <div class="center">
            <input type="submit" value="Submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
</html>