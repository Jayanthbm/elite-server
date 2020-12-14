<?php
session_start();
include('./conn.php');
if (!$conn) {
  echo "Error Connecting To Database";
}else{
    if(isset($_GET['id']) && isset($_GET['global'])){
        $id = $_GET['id'];
        $global = $_GET['global'];
        $query = "UPDATE videos SET isGlobal =$global WHERE videoId =$id";
        if(mysqli_query($conn,$query)){
            echo "Updated";
        }else{
            echo "Error";
        }
    }else{
        echo "Error";
    }


}