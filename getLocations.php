<?php
    include_once './conn.php';
	$locationQuery = "SELECT id,name,slug
					FROM location";
	$locationResult = mysqli_query($conn,$locationQuery);
    $output ="<div id='recipients' class=\"p-8 mt-6 lg:mt-0 rounded shadow bg-white\">";
    if(mysqli_num_rows($locationResult) > 0){
        $i = 1;
        $output.="<table id=\"location\" class=\"stripe hover\">
                    <thead>
                        <tr>
							<th data-priority=\"1\" class=\"text-left\">Id</th>
							<th data-priority=\"2\" class=\"text-left\">Name</th>
							<th data-priority=\"2\" class=\"text-left\">Slug</th>
						</tr>
					</thead>
                    <tbody>";
        while($r = mysqli_fetch_array($locationResult)){
            $name = $r['name'];
            $slug = $r['slug'];
            $output.="<tr>";
            $output.="<td class=\"text-left\">$i</td>";
            $output.="<td class=\"text-left\">$name</td>";
            $output.="<td class=\"text-left\">$slug</td>";
            $output.="</tr>";
            $i+=1;
        }
         $output.="</tbody></table>";
    }else{
        $output.="<section><h3 class=\"font-bold text-2xl\">No Locations</h3></section>";
    }

    $output.="</div>";

    echo $output;

?>