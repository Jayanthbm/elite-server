<?php
    session_start();
    include('./conn.php');

    function deleteVideoAccess($conn,$videoId){
        global $conn;
        $dQ = "DELETE FROM video_disbaled_store WHERE           videoId=$videoId";
        if(!mysqli_query($conn,$dQ)){
            echo mysqli_error($conn);
            return 0;
        }else{
            return 1;
        }
    }
    function updateVideoAccess($conn,$storeIds,$videoId){
        $ops =[];
        for ($i=0;$i<sizeof($storeIds);$i++){
            $vAq = "INSERT INTO video_disbaled_store(videoId,storeId)VALUES($videoId,$storeIds[$i])";
            if(!mysqli_query($conn,$vAq)){
                echo mysqli_error($conn);
                array_push($ops,0);
            }else{
                array_push($ops,1);
            }
        }
        if (in_array(0, $ops)) {
            return 0;
        } else{
            return 1;
        }
    }
    function UpdateDb($conn,$videoId,$categoryId,$locationId){
        $vq = "UPDATE videos SET categoryId = $categoryId,locationId=$locationId WHERE videoId =$videoId ";
        if(!mysqli_query($conn,$vq)){
            return 0;
        }else{
           return 1;
        }
    }

    $userid = $_SESSION['userId'];
    $videoId = $_GET['vid'];
    $categoryId =  $_GET['cat'];
    $locationId = $_GET['loc'];
    $sid = $_GET['sid'];
    if($videoId){
        $ids = explode(",",$_GET['vid']);
        $c = deleteVideoAccess($conn,$videoId);
        if($c == 1){
            if(strlen($_GET['vid'])> 0){
                $c1 = updateVideoAccess($conn,$ids,$videoId);
            }
        }
        $ca = UpdateDb($conn,$videoId,$categoryId,$locationId);
        if($ca){
            echo "Updated";
        }else{
            echo "Error Try Again";
        }
    }else{
        echo "Error";
    }
?>