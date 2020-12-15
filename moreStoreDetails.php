<?php
    include_once './conn.php';
    $storeId = $_GET['id'];

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
        }
        return $videoIds;
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
        }
        return $videoIds;
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
        if(sizeof($vids) > 0){
            $v = implode(',', $vids);
            $vq = "SELECT videoId,videoName
                FROM videos
                WHERE isPublished = 1 AND videoId IN ($v)";
        }else{
            $vq = "SELECT videoId,videoName
                    FROM videos
                    WHERE isPublished = 1";
        }
        $vqR = mysqli_query($conn,$vq);
        return $vqR;
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
    $videoIdArray = array();
    $categoryId = getCategoryIdFromStore($storeId);
    $locationId = getLocationIdFromStore($storeId);
    $globalVideoIds =getGlobalVideoIds();
    $videoIds = getVideoIds($categoryId,$locationId);
    foreach($globalVideoIds as $glo){
        array_push($videoIdArray,$glo);
    }
    foreach($videoIds as $vid){
        array_push($videoIdArray,$vid);
    }
    $videoIdSet = array_unique($videoIdArray);
    $disbaledvideoIds = getDisabledVideoIds($storeId);
    $tmp = array_diff($videoIdSet, $disbaledvideoIds);
    $finalVideoIds = array();
    foreach ($tmp as $value) {
        array_push($finalVideoIds,$value);
    }
    $r = getVideos($finalVideoIds);

    function getTotalPlays($videoId){
        global $storeId,$conn;
        $vq = "SELECT count(videoId) as vc
                FROM video_activity_log
                WHERE storeId =$storeId AND videoId=$videoId";
        if(!mysqli_query($conn,$vq)){
            return 0;
        }else{
            $vqR = mysqli_query($conn,$vq);
            while($row = mysqli_fetch_array($vqR)){
                return $row['vc'];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>More Store Details</title>

    <!-- custom css -->

    <link href="./css/styles.css" rel="stylesheet">

    <!-- Tailwind css -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" integrity="sha512-+WF6UMXHki/uCy0vATJzyA9EmAcohIQuwpNz0qEO+5UeE5ibPejMRdFuARSrl1trs3skqie0rY/gNiolfaef5w==" crossorigin="anonymous" />

	<!--font awesome css -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!--Regular Datatables CSS-->

	<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">

</head>
<body class="body-bg leading-normal tracking-normal">
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
        <?php if (mysqli_num_rows($r) > 0){ ?>
            <table id="video" class="display stripe hover" style="width:100%">
                <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Total Plays</th>
                </tr>
		        </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($r)){
                    $videoName = $row['videoName'];
                    $videoId = $row['videoId'];
                ?>
                <tr>
                    <td><?php echo $videoName;?></td>
                    <td><?php echo getTotalPlays($videoId);?></td>
                </tr>
               <?php } ?>
            </tbody>
        <?php }else { ?>
            <section><h3 class="font-bold text-2xl">No Videos</h3></section>
        <?php } ?>
    </div>
    <!-- Jquery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!-- Main Js -->
	<script src="./js/main.js"></script>
	<!--Datatables  -->
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#video').DataTable();
        });
    </script>
</body>
</html>