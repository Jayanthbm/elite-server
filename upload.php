<?php
session_start();
include('./conn.php');
$userid = $_SESSION['userId'];
$SERVER_LOCATION ='http://localhost/elite/';
$output_dir ='videos/';
$messages =[];
$categoryId =  $_GET['cat'];
$locationId = $_GET['loc'];

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

function UpdateDb($conn,$name,$fileSize,$control,$ids){
    global $userid,$date_time,$SERVER_LOCATION,$categoryId,$locationId,$output_dir;

    $location = $SERVER_LOCATION.$output_dir.$name.'.mp4';

    $vQ = "INSERT INTO videos(videoName,videoSize,location,isPublished,uploadBy,uploadDate,publishBy,publishDate,totalPlays,categoryId,locationId,isGlobal)VALUES('$name',$fileSize,'$location',1,$userid,'$date_time',$userid,'$date_time',0,$categoryId,'$locationId',0)";

    if(!mysqli_query($conn,$vQ)){
        echo mysqli_error($conn);
        return mysqli_error($conn);
    }else{
        if($control == true){
            $last_id = mysqli_insert_id($conn);
            return updateVideoAccess($conn,$ids,$last_id);
        }else{
            return 1;
        }
    }
}

if(isset($_FILES['myfile'])){
    if(!is_array($_FILES['myfile']['name'])){
        $fileName = str_replace(' ', '_', $_FILES['myfile']['name']);
        $fileSize = $_FILES['myfile']['size'];
        $dbFileName = str_replace(".mp4","",$fileName);
        if (file_exists($output_dir.$fileName)){
            $m = "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button>$fileName Already Exits Please Choose Different File Name</div>";
            array_push($messages,$m);
        }else{
            if(isset($_GET['id'])){
                $ids = explode(",",$_GET['id']);
                $up = UpdateDb($conn,$dbFileName,$fileSize,true,$ids);
            }else{
                $up = UpdateDb($conn,$dbFileName,$fileSize,false,null);
            }
            if($up == 1){
                move_uploaded_file($_FILES['myfile']['tmp_name'],$output_dir.$fileName);
                $m = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button>$fileName Uploaded</div>";
                array_push($messages,$m);
            }
        }
    }
    for($i = 0;$i<sizeof($messages);$i++){
        echo $messages[$i];
    }
}
?>