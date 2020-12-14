<?php
    include_once './conn.php';
	$videoQuery ="SELECT *
				FROM videos";
    $videoResult = mysqli_query($conn,$videoQuery);

    function getCategoryName($id){
        global $conn;
        $query ="SELECT name
                FROM category
                WHERE id = $id";
        $result = mysqli_query($conn,$query);
        return mysqli_fetch_array($result)[0];
    }

    function getLocationName($id){
        global $conn;
        $query ="SELECT name
                FROM location
                WHERE id = $id";
        $result = mysqli_query($conn,$query);
        return mysqli_fetch_array($result)[0];
    }
    function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) .' '. $suffix[$f_base];
    }
    $output ="<div id='recipients' class=\"p-8 mt-6 lg:mt-0 rounded shadow bg-white\">";
    if(mysqli_num_rows($videoResult) > 0){
        $output.='<table id="video" class="display stripe hover" style="width:100%">
            <thead>
                <tr>
                    <th class="text-left">Name</th>
                    <th class="text-left">Size</th>
                    <th class="text-left">Category</th>
                    <th class="text-left">Location</th>
                    <th class="text-left">Global</th>
                    <th class="text-left">Update</th>
                    <th class="text-left"></th>
                </tr>
		    </thead>
            <tbody>';
        while($r = mysqli_fetch_array($videoResult)){
            $id = $r['videoId'];
            $videoName = $r['videoName'];
            $videoSize = $r['videoSize'];
            $categoryId = $r['categoryId'];
            $locationId = $r['locationId'];
            $isGlobal = $r['isGlobal'];
            $cboxYes='';
            $cboxNo='';
            $yesfunction ='';
            $nofunction ='';
            if($isGlobal == 1){
                $cboxYes='btnn active';
                $cboxNo='btnn inactive';
                $nofunction ='onclick=globalUpdate('.$id.',0)';
            }else{
                $cboxYes='btnn inactive';
                $cboxNo='btnn active';
                $yesfunction ='onclick=globalUpdate('.$id.',1)';
            }
            $updatefunction = "onclick=UpdateAccess($id)";
            $deletefunction = "onclick=deleteVideo($id,'$videoName')";
            $totalPlays = $r['totalPlays'];
            $categoryName = getCategoryName($categoryId);
            $locationName = getLocationName($locationId);
            $size = convertToReadableSize($videoSize);
            $output.='<tr>';
            $output.="<td>$videoName</td>";
            $output.="<td>$size</td>";
            $output.="<td>$categoryName</td>";
            $output.="<td>$locationName</td>";
            $output.="<td>
                        <div class=\"switch-field\">
                            <button class=\"$cboxYes\" $yesfunction>Yes</button>
                            <button class=\"$cboxNo\" $nofunction>No</button>
                        </div>
                    </td>";

            $output.="<td><button class=\"btnn\" $updatefunction>Update Access</button></td>";
            $output.="<td><button class=\"btnn\" $deletefunction>Delete</button></td>";
            $output.='</tr>';
        }
         $output.="</tbody></table>";
    }else{
        $output.="<section><h3 class=\"font-bold text-2xl\">No Videos</h3></section>";
    }

    $output.="</div>";
    echo $output;

?>