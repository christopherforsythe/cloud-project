<?php
        $host = "cforsythe04.lampt.eeecs.qub.ac.uk";
        $user = "cforsythe04";
        $pw = "VCrwtDnPrlR4vKMF";
        $db = "cforsythe04";

        $conn = new mysqli($host, $user, $pw, $db);

        if ($conn->connect_error) {
            echo "There has been an error ".$conn->connect_error;
        }else{
           // echo "Connection to DB found.";
        }
 ?>
