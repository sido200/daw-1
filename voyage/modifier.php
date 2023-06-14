<?php
include("config/connect.php");

// Vérifier si les données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $idVille = $_POST["idVille"];
    $nomVille = $_POST["nomVille"];
    $descVille = $_POST["descVille"];
    $pays = $_POST["pays"];
    $site = $_POST["site"];
    $resto = $_POST["resto"];
    $gare = $_POST["gare"];
    $hotel = $_POST["hotel"];
    $aeroport = $_POST["aeroport"];
    
    // Vérifier si une image a été téléchargée
    // ...

    // Insérer les données dans la base de données
    $sql2 = "SELECT idpays FROM pays WHERE nompays='$pays'";
    $result = mysqli_query($conn, $sql2);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $idpays = $row['idpays'];

        // Effectuer la mise à jour dans la base de données
        $sqlUpdate = "UPDATE ville SET nomville = '$nomVille', descville = '$descVille', idpays = $idpays WHERE idville = $idVille";
        if (mysqli_query($conn, $sqlUpdate)) {
            // Supprimer les anciens enregistrements de site pour cette ville
            mysqli_query($conn, "DELETE FROM site WHERE idville = $idVille");
            mysqli_query( $conn,"DELETE FROM necessaire WHERE idville = $idVille" );
          
       

            // Insérer le nouveau site avec l'image
            mysqli_query($conn, "INSERT INTO site (idville, nomsite, cheminphoto) VALUES ($idVille, '$site', '')");
            mysqli_query($conn, "INSERT INTO necessaire (idville,nomnec , typenec) VALUES ($idVille, '$resto', 'restaurant')");
            mysqli_query($conn, "INSERT INTO necessaire (idville,nomnec , typenec) VALUES ($idVille, '$gare', 'gare')");
            mysqli_query($conn, "INSERT INTO necessaire (idville,nomnec , typenec) VALUES ($idVille, '$hotel', 'hotel')");
            mysqli_query($conn, "INSERT INTO necessaire (idville,nomnec , typenec) VALUES ($idVille, '$aeroport', 'aeroport')");

            echo "Mise à jour effectuée avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de la récupération de l'ID du pays.";
    }

    // Redirection vers la page de détails de la ville modifiée ou vers la liste des villes
    header("Location: ville.php?id=$idVille");
    exit();
}

// Affichage du formulaire de modification
$idVille = isset($_GET['id']) ? $_GET['id'] : null;

if ($idVille) {
    $sql = "SELECT ville.*, pays.nompays AS nom_pays, site.*
    FROM ville
    JOIN pays ON ville.idpays = pays.idpays
    JOIN site ON ville.idville = site.idville
    WHERE ville.idville = $idVille";
    $rslt = mysqli_query($conn, $sql);
    $ville = mysqli_fetch_assoc($rslt);
    mysqli_free_result($rslt);
    mysqli_close($conn);

    if ($ville) {
        echo '<form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" enctype="multipart/form-data">';

        echo '<input type="hidden" name="idVille" value="' . $ville['idville'] . '">';
        echo 'Nom : <input type="text" name="nomVille" value="' . $ville['nomville'] . '"><br>';
        echo 'pays : <input type="text" name="pays" value="' . $ville['nom_pays'] . '"><br>';
        echo 'site : <input type="text" name="site" value="' . $ville['nomsite'] . '"><br>';
        echo 'image : <input type="file" name="image"><br>';
        echo 'resto : <input type="text" name="resto" value=""> <br>';
        echo 'gare : <input type="text" name="gare" value=""> <br>';
        echo 'hotel : <input type="text" name="hotel" value=""> <br>';
        echo 'aeroport : <input type="text" name="aeroport" value=""> <br>';
        echo 'Description : <textarea name="descVille">' . $ville['descville'] . '</textarea><br>';
        echo '<input type="submit" value="Modifier">';
        echo '</form>';
    } else {
        echo 'Ville non trouvée.';
    }
} else {
    echo 'Identifiant de ville non spécifié.';
}
?>
