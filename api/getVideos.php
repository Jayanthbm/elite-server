<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include './conn.php';
include('./constants.php');
include('./tokenhelper.php');
include('./bearer_helper.php');

function getDisabledVideoIds($storeId){
    global $conn;
    $videoIds =[];
    $dQ ="SELECT videoId
            FROM video_disbaled_store
            WHERE storeId = $storeId";
    if(!mysqli_query($conn,$dQ)){
        return mysqli_error($conn);
    }else{
        $dQR = mysqli_query($conn,$dQ);
        if(mysqli_num_rows($dQR) > 0){
            while($row = mysqli_fetch_array($dQR)){
                $videoId = $row['videoId'];
                array_push($videoIds,$videoId);
            }
        }else{
            return $videoIds;
        }
    return $videoIds;
    }
}

function getVideos($vids){
    global $conn;
    $result = [];
    //Get a list of Videos
    if(sizeof($vids) > 0){
        $v = implode(',', $vids);
        $vq = "SELECT videoId,videoName,videoSize,location,totalPlays
                FROM videos
            WHERE isPublished = 1 AND videoId NOT IN ($v)";
        }else{
            $vq = "SELECT videoId,videoName,videoSize,location,totalPlays
                FROM videos
                WHERE isPublished = 1";
        }
        if(!mysqli_query($conn,$vq)){
            $r = ['message' => 'Error Fetching Videos'];
            array_push($result,$r);
            return $result[0];
        }else{
            $vqR = mysqli_query($conn,$vq);
            if(mysqli_num_rows($vqR) > 0){
            while ($row = mysqli_fetch_array($vqR)) {
                $videoId = $row['videoId'];
                $videoName = $row['videoName'];
                $videoSize = $row['videoSize'];
                $location = $row['location'];
                $totalPlays = $row['totalPlays'];
                $tmparray = ['videoId' => $videoId, 'videoName' => $videoName,'videoSize' => $videoSize, 'location' =>
                $location,'totalPlays' => $totalPlays];
                array_push($result, $tmparray);
            }
        }else{
            $r = ['message' => 'No Videos Available for the store'];
            array_push($result,$r);
            return $result[0];
        }
    }
    return $result;
}

$token = getBearerToken();
if($token){
    $id =decode_jwt($token, $secretKey);
    if($id){
        // Get the list of videoIds disbaled for this store
        $videoIds = getDisabledVideoIds($id);
        $r = getVideos($videoIds);
        echo json_encode($r);
        exit();
    }else{
        $result = ['message' => 'Error Fetching Videos'];
        echo json_encode($result);
        exit();
    }
}else {
    $result = ['message' => 'Missing Authorization'];
    echo json_encode($result);
    exit();
}