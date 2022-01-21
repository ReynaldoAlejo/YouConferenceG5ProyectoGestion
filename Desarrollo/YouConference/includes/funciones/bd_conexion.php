<?php

 





    $conn = new mysqli('localhost', 'root', '', 'youconferencegesconfigg5');

    if($conn->connect_error) {
      echo $conn->connect_error;
      echo $error;
    }