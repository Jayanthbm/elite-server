<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include './conn.php';
include('./constants.php');
include('./tokenhelper.php');
include('./bearer_helper.php');

function Update_video_activity($videoId,$storeId){
    global $conn,$date_time;
    $vS = "UPDATE videos
            SET totalPlays = totalPlays + 1
            WHERE videoId =$videoId";
            mysqli_query($conn,$vS);

    $vQ = "INSERT INTO video_activity_log(storeId,VideoId,playedOn)VALUES($storeId,$videoId,'$date_time')";
    mysqli_query($conn,$vQ);
    return true;
}

function checkVideoId($videoId){
    global $conn;
    $cV = "SELECT * FROM videos WHERE videoId =$videoId";
    if(!mysqli_query($conn,$cV)){
        return 0;
    }else{
        if(mysqli_num_rows(mysqli_query($conn,$cV)) > 0){
            return 1;
        }else{
            return 0;
        }
    }
}
$token = getBearerToken();
if($token){
    $id =decode_jwt($token, $secretKey);
    if(isset($_GET['vid'])){
        $videoId = $_GET['vid'];
    if(checkVideoId($videoId) == 0){
        $result = ['message' => "Video Id Doesn't Exist"];
        echo json_encode($result);
        exit();
    }else{
        $r = Update_video_activity($videoId,$id);
        if($r){
            $result = ['message' => 'Success'];
        }else{
            $result = ['message' => 'Error'];
        }
    echo json_encode($result);
exit();
}
}else{
$result = ['message' => 'Missing Video Id'];
echo json_encode($result);
exit();
}
}else {
$result = ['message' => 'Missing Authorization'];
echo json_encode($result);
exit();
}