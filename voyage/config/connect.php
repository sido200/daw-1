<?php

  $conn = mysqli_connect('localhost', 'root', '', 'voyage');

  if(!$conn ){
    echo 'connection error:' . mysqli_connect_error();
  }
?>