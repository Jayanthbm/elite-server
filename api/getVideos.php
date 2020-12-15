<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include './conn.php';
include('./constants.php');
include('./tokenhelper.php');
include('./bearer_helper.php');

 $res = (object) null;

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

function getGlobalVideoIds(){
    global $conn;
    $videoIds =[];
    $dQ ="SELECT videoId
            FROM videos
            WHERE isGlobal = 1";
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
function getVideoIds($categoryId,$locationId){
    global $conn;
    $videoIds =[];
    $dQ ="SELECT videoId
            FROM videos
            WHERE categoryId = $categoryId AND locationId=$locationId";
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
    if(sizeof($vids) > 0){
        $v = implode(',', $vids);
        $vq = "SELECT videoId,videoName,videoSize,location,totalPlays
                FROM videos
                WHERE isPublished = 1 AND videoId IN ($v)";
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
function getCategoryIdFromStore($storeId){
    global $conn;
    $query ="SELECT categoryId
            FROM stores
            WHERE id=$storeId";
    $result= mysqli_query($conn,$query);
    return mysqli_fetch_array($result)[0];
}

function getLocationIdFromStore($storeId){
    global $conn;
    $query ="SELECT locationId
            FROM stores
            WHERE id=$storeId";
    $result= mysqli_query($conn,$query);
    return mysqli_fetch_array($result)[0];
}

$token = getBearerToken();
if($token){
    $id =decode_jwt($token, $secretKey);
    if($id){
        $videoIdArray = array();
        $categoryId = getCategoryIdFromStore($id);
        $locationId = getLocationIdFromStore($id);
        $globalVideoIds =getGlobalVideoIds();
        $videoIds = getVideoIds($categoryId,$locationId);
        foreach($globalVideoIds as $glo){
            array_push($videoIdArray,$glo);
        }
        foreach($videoIds as $vid){
            array_push($videoIdArray,$vid);
        }
        $videoIdSet = array_unique($videoIdArray);
        $disbaledvideoIds = getDisabledVideoIds($id);
        $tmp = array_diff($videoIdSet, $disbaledvideoIds);
        $finalVideoIds = array();
        foreach ($tmp as $value) {
            array_push($finalVideoIds,$value);
        }
        $r = getVideos($finalVideoIds);
        $res->videos = $r;
    }else{
        $res->message = 'Missing Authorization';
    }
}else {
    $res->message = 'Missing Authorization';

}
echo json_encode($res);
exit();