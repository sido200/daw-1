
<?php
include('config/connect.php');


$sql = "SELECT * FROM ville ";
$sql2 = "SELECT * FROM pays ";
$sql3 = "SELECT * FROM continent ";
$sql4 = "SELECT * FROM necessaire ";
$sql5 = "SELECT * FROM site ";



$result = mysqli_query($conn,$sql, $sql2, $sql3, $sql4, $sql5 );


$voyage = mysqli_fetch_all($result,MYSQLI_ASSOC);


mysqli_free_result($result);


mysqli_close($conn);


?>


<!DOCTYPE html>
<html lang="en">

<?php include('template/header.php'); ?>
<h4 class="center grey-text">travel</h4>
<div class="container">
    <div class="row">
        <?php foreach($voyage as $voyages): ?>
        <div class="col s6 md3">
            <div class="card z-depth-0">
                <div class="card-content center">
                    <h6><?php echo htmlspecialchars($voyages['descville']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyages['pays']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyages['continent']); ?></h6>
                    
                    <ul>
                        <?php foreach(explode(',',$voyages['hotel'])as $ing): ?>
                        <li> <?php echo htmlspecialchars($ing) ?></li>
                        <?php  
                         endforeach;
                         ?>
                    </ul>
                    <ul>
                        <?php foreach(explode(',',$voyages['gare'])as $ing): ?>
                        <li> <?php echo htmlspecialchars($ing) ?></li>
                        <?php  
                         endforeach;
                         ?>
                    </ul>
                    <ul>
                        <?php foreach(explode(',',$voyages['aeroport'])as $ing): ?>
                        <li> <?php echo htmlspecialchars($ing) ?></li>
                        <?php  
                         endforeach;
                         ?>
                    </ul>
                    
                </div>
                
            </div>
        </div>
        <?php  endforeach; ?>

    </div>
</div>
<?php include('template/footer.php'); ?>
<!---same for footer--->


</html>
