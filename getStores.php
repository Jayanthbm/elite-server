<?php
    include_once './conn.php';
	$storeQuery ="SELECT *
					FROM stores";
    $storeResult = mysqli_query($conn,$storeQuery);

    function getCategoryName($categoryId){
        global $conn;
        $query ="SELECT name
                FROM category
                WHERE id =$categoryId";
        $result = mysqli_query($conn,$query);
        return mysqli_fetch_array($result)[0];
    }
    function getLocationName($locationId){
        global $conn;
        $query ="SELECT name
                FROM location
                WHERE id =$locationId";
        $result = mysqli_query($conn,$query);
        return mysqli_fetch_array($result)[0];
    }
    $output ="<div id='recipients' class=\"p-8 mt-6 lg:mt-0 rounded shadow bg-white\">";
    if(mysqli_num_rows($storeResult) > 0){
        $output.="<table id=\"store\" class=\"stripe hover\">
                    <thead>
                        <tr>
							<th data-priority=\"1\" class=\"text-left\">StoreId</th>
							<th data-priority=\"2\" class=\"text-left\">Name</th>
							<th data-priority=\"3\" class=\"text-left\">Category</th>
							<th data-priority=\"4\" class=\"text-left\">Location</th>
							<th data-priority=\"5\" class=\"text-left\">Is LoggedIn</th>
							<th data-priority=\"6\" class=\"text-left\">Last Login time</th>
						</tr>
					</thead>
                    <tbody>";
        while($r = mysqli_fetch_array($storeResult)){
            $storeId = $r['storeId'];
            $storeName = $r['storeName'];
            $categoryId = $r['categoryId'];
            $locationId = $r['locationId'];
            $isLoggedin = $r['isLoggedin'];
            $lastLoginTime = $r['lastLoginTime'];
            $categoryName = getCategoryName($categoryId);
            $locationName = getLocationName($locationId);
            if($isLoggedin){
                $isLoggedin ='Yes';
            }else{
                $isLoggedin ='No';
            }
            $output.="<tr>";
            $output.="<td class=\"text-left\">$storeId</td>";
            $output.="<td class=\"text-left\">$storeName</td>";
            $output.="<td class=\"text-left\">$categoryName</td>";
            $output.="<td class=\"text-left\">$locationName</td>";
            $output.="<td class=\"text-left\">$isLoggedin</td>";
            $output.="<td class=\"text-left\">$lastLoginTime</td>";
            $output.="</tr>";
        }
         $output.="</tbody></table>";
    }else{
        $output.="<section><h3 class=\"font-bold text-2xl\">No Stores</h3></section>";
    }

    $output.="</div>";

    echo $output;

?>