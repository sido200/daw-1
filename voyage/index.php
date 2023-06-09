<?php
include('config/connect.php');


$villes = [];
if (isset($_POST['submit'])) {

    $continent = $_POST['continent'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $site = $_POST['site'];


$sql = "SELECT ville.idville , ville.nomville, pays.nompays FROM ville
        INNER JOIN pays ON ville.idpays = pays.idpays";



    if (!empty($continent)) {
        $sql .= " INNER JOIN continent ON pays.idcon = continent.idcon
                  WHERE continent.nomcon LIKE '%$continent%'";
    }

    if (!empty($pays)) {
        $sql .= " AND pays.nompays LIKE '%$pays%'";
    }


     if (!empty($ville)) {
        $sql .= " AND ville.nomville LIKE '%$ville%'";
    }

    if (!empty($site)) {
       $sql .= " INNER JOIN site ON ville.idville  = site.idville 
              WHERE site.nomsit LIKE '%$site%'";
    }

  
    $result = mysqli_query($conn, $sql);

 
    if (mysqli_num_rows($result) > 0) {
       
        $villes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
     
        $villes = [];
    }
  
    mysqli_free_result($result);
   
}


?>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>projet daw</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link rel="stylesheet" href="style.css">

   

</head>

<body class="grey lighten-4">
<!DOCTYPE html>
<html lang="en">

<div class="contente">
    <nav>
        <h2>etudiant 1 </h2>
        <ul>
          <li>Nom: Chouiref</li>
          <li>Prenom: Sidali</li>
          <li>Spécialité: informatique</li>
          <li>Section:1</li>
          <li>Groupe:6</li>
          <li>Mail: sidali20012017@outlook.com</li>

        </ul>
        <h2>etudiant 2 </h2>
        <ul>
          <li>Nom: Medjber</li>
          <li>Prenom: Soundous</li>
          <li>Spécialité: informatique</li>
          <li>Section:1</li>
          <li>Groupe:6</li>
          <li>Mail:medjbersoundous@gmail.com</li>

        </ul>
        <hr>
        <ul>
            <li><a href="add.php">Ajouter Ville</a></li>
        </ul>
    </nav>
   <div class="home">
    <header> <h1>voyager avec nous </h1></header>
   
    <section>
        <h2 class="titre-recherche">Recherche</h2>
        <form action="index.php" method="POST">
    <div class="input">
        <span>Continent</span>
        <input type="text" name="continent">
    </div>
    <div class="input">
        <span>Pays</span>
        <input type="text" name="pays">
    </div>
    <div class="input">
        <span>Ville</span>
        <input type="text" name="ville">
    </div>
    <div class="input">
        <span>Site</span>
        <input type="text" name="site">
    </div>
    <div class="btn">
        <button class="btn-submit" type="submit" name="submit">Valider</button>
    </div>
</form>

       
        <hr>
        <h2 class="titre-recherche">Résultat de la recherche</h2>
        <div class="resultat">
            <ul>
            <?php
if ($villes) {
    foreach ($villes as $ville) {
        echo '<li>' . '<a href="ville.php?id=' . $ville['idville'] . '">' . $ville['nomville'] . '</a>' .
            '<a href="modifier.php?id=' . $ville['idville'] . '"><i class="fa-solid fa-pen-to-square"></i></a>' .
            '<span class="icon"><i class="fa-solid fa-trash"></i></span>' .
            '</li>';
    }
} else {
    echo '<li>Aucun résultat trouvé.</li>';
}
?>


              
            </ul>

        </div>
    </section>
   </div>
  </div>

</html>