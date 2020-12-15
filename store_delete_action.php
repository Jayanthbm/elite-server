<?php
    session_start();
    include('./conn.php');

    function deleteVideoAccess($storeId){
        global $conn;
        $dQ = "DELETE FROM video_disbaled_store WHERE storeId=$storeId";
        if(!mysqli_query($conn,$dQ)){
            echo mysqli_error($conn);
            return 0;
        }else{
            return 1;
        }
    }
    function deleteStoreActivity($storeId){
        global $conn;
        $dQ = "DELETE FROM store_activity_log WHERE storeId=$storeId";
        if(!mysqli_query($conn,$dQ)){
            echo mysqli_error($conn);
            return 0;
        }else{
            return 1;
        }
    }
    function deleteStore($storeId){
        global $conn;
        deleteStoreActivity($storeId);
        $dQ = "DELETE FROM stores WHERE id=$storeId";
        if(!mysqli_query($conn,$dQ)){
            echo mysqli_error($conn);
            return 0;
        }else{
            return 1;
        }
    }
    $userid = $_SESSION['userId'];
    if(isset($_GET['sid'])){
        $storeId = $_GET['sid'];
        deleteVideoAccess($storeId);
        $c = deleteStore($storeId);
        if($c == 1){
            echo "Store Deleted";
        }else{
            echo "Error During Deletion";
        }

    }else{
        echo "Error";
    }
