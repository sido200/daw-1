<?php
include("config/connect.php");

// Vérifier si les données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $idVille = $_POST["idVille"];
    $nomVille = $_POST["nomVille"];
    $descVille = $_POST["descVille"];

    // Effectuer la mise à jour dans la base de données
    $sql = "UPDATE ville SET nomville = '$nomVille', descville = '$descVille' WHERE idville = $idVille";
    mysqli_query($conn, $sql);

    // Redirection vers la page de détails de la ville modifiée ou vers la liste des villes
    header("Location: ville.php?id=$idVille");
    exit();
}

// Affichage du formulaire de modification
$idVille = isset($_GET['id']) ? $_GET['id'] : null;

if ($idVille) {
    $sql = "SELECT * FROM ville WHERE idville = $idVille";
    $rslt = mysqli_query($conn, $sql);
    $ville = mysqli_fetch_assoc($rslt);
    mysqli_free_result($rslt);
    mysqli_close($conn);

    if ($ville) {
        echo '<form method="POST" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<input type="hidden" name="idVille" value="' . $ville['idville'] . '">';
        echo 'Nom : <input type="text" name="nomVille" value="' . $ville['nomville'] . '"><br>';
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
