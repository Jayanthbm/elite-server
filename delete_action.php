<?php
session_start();
include('./conn.php');
function deleteVideoAccess($conn,$videoId){
    $dQ = "DELETE FROM video_disbaled_store WHERE videoId=$videoId";
    if(!mysqli_query($conn,$dQ)){
        echo mysqli_error($conn);
        return 0;
    }else{
        return 1;
    }
}

function deleteVideo($conn,$videoId){
        $dQ = "DELETE FROM videos WHERE videoId=$videoId";
        if(!mysqli_query($conn,$dQ)){
            echo mysqli_error($conn);
            return 0;
        }else{
            return 1;
        }
}

if(isset($_GET['vid']) && isset($_GET['vname'])){
    $vda = deleteVideoAccess($conn,$_GET['vid']);
    if($vda ==1){
        $vd = deleteVideo($conn,$_GET['vid']);
        if($vd == 1){
            $rm = './videos/'.$_GET['vname'].'.mp4';
            unlink($rm);
        }
        echo "Success";
    }
}else{
    echo "Error";
}