<?php
    include_once './conn.php';
	$videoQuery ="SELECT *
					FROM videos";
	$videoResult = mysqli_query($conn,$videoQuery);
    $output ="<div id='recipients' class=\"p-8 mt-6 lg:mt-0 rounded shadow bg-white\">";
    if(mysqli_num_rows($videoResult) > 0){
        $i = 1;
        $output.="<table id=\"video\" class=\"stripe hover\">
                    <thead>
                        <tr>
							<th data-priority=\"1\">StoreId</th>
							<th data-priority=\"2\">Name</th>
							<th data-priority=\"3\">Category</th>
							<th data-priority=\"4\">Location</th>
							<th data-priority=\"5\">Is Active</th>
							<th data-priority=\"6\">Last Login time</th>
						</tr>
					</thead>
                    <tbody>";
        while($r = mysqli_fetch_array($videoResult)){
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
        $output.="<section><h3 class=\"font-bold text-2xl\">No Videos</h3></section>";
    }

    $output.="</div>";

    echo $output;

?>