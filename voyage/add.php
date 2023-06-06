<?php



include('config/connect.php');

 $nomville = $descville = $nompays = $nomcon = $gare = $hotel = $aeroport = '';

$errors = array('nomville' => '','descville' => '','nompays' => '', 'nomcon' => '', 'gare' => '', 'hotel' => '', 'aeroport' => '');/*on stockes les valeurs d'erreur dans cette array*/



 if (isset($_POST['submit'] )){

  if (empty($_POST['nomville'])){
     $errors['nomville'] ="enter une ville   <br/>";
  }

  }

if (empty($_POST['descville'])){
    $errors['descville'] = "Please enter a descville   <br/>";
  }
  else {
    $descville = $_POST['descville'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $descville)){
        $errors['descville'] = 'desc must be a valid desc'; 
    }
  }



if (empty($_POST['nompays'])){
     $errors['nompays'] ="Please enter nompays   <br/>";
  }
 

if (empty($_POST['nomcon'])){
    $errors['nomcon'] ="Please enter nomcon   <br/>";
 }
 if (empty($_POST['gare'])){
    $errors['gare'] ="Please enter gare   <br/>";
 }
 if (empty($_POST['hotel'])){
    $errors['hotel'] ="Please enter hotel   <br/>";
 }
 if (empty($_POST['aeroport'])){
    $errors['aeroport'] ="Please enter aeroport   <br/>";
 }


if (array_filter($errors)){
    
} else {

   $nomville = mysqli_real_escape_string($conn,$_POST['nomville']);
   $descville = mysqli_real_escape_string($conn,$_POST['descville']);
   $nompays = mysqli_real_escape_string($conn,$_POST['nompays']);
   $nomcon = mysqli_real_escape_string($conn,$_POST['nomcon']);
   $gare = mysqli_real_escape_string($conn,$_POST['gare']);
   $hotel = mysqli_real_escape_string($conn,$_POST['hotel']);
   $aeroport = mysqli_real_escape_string($conn,$_POST['aeroport']);


$sql = "INSERT INTO ville (nomville, descville ) VALUES ('$nomville', '$descville')";
$sql2 = "INSERT INTO pays (nompays ) VALUES ('$nompays')";
$sql3 = "INSERT INTO contient (nomcon ) VALUES ('$nomcon')";
$sql4 = "INSERT INTO necessaire (gare, aeroport, hotel ) VALUES ('$gare', '$aeroport', '$hotel')";
$sql5 = "INSERT INTO site (nomsite ) VALUES ('$nomsite')";





if (mysqli_query($conn,$sql, $sql2,$sql3, $sql4, $sql5 )){

 header('Location: index.php');
}else {
 echo 'query error:' . mysqli_error($conn);
}


}




?>
<html lang="en">
<?php include('template/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">ajouter une ville</h4>
    <form class="white" action="add.php" method="post">
        <label>nom de ville :</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($nomville)  ?>">
        <div class="red-text"><?php echo $errors['nomvi$nomville'] ?></div>
        <label>description de ville:</label>
        <input type="text" name="descville" value="<?php echo htmlspecialchars($descville)  ?>">
        <div class="red-text"><?php echo $errors['desc$descville'] ?></div>
        <label>pays:</label>
        <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays)  ?>">
        <div class="red-text"><?php echo $errors['nompays'] ?></div>
        <label>continent:</label>
        <input type="text" name="nomcon" value="<?php echo htmlspecialchars($nomcon)  ?>">
        <div class="red-text"><?php echo $errors['nomcon'] ?></div>
        <label>gare:</label>
        <input type="text" name="gare" value="<?php echo htmlspecialchars($gare)  ?>">
        <div class="red-text"><?php echo $errors['gare'] ?></div>
        <label>aeroport:</label>
        <input type="text" name="aeroport" value="<?php echo htmlspecialchars($aeroport)  ?>">
        <div class="red-text"><?php echo $errors['aeroport'] ?></div>
        <label>hotel:</label>
        <input type="text" name="hotel" value="<?php echo htmlspecialchars($hotel)  ?>">
        <div class="red-text"><?php echo $errors['hote$hotel'] ?></div>
        <div class="center">
            <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
</html>