<?php
include('./conn.php');

function getVideoName($videoId){
    global $conn;
    $vQ = "SELECT videoName from videos WHERE videoId = $videoId";
    $vQR = mysqli_query($conn,$vQ);
    $row = mysqli_fetch_assoc($vQR);
    return $row['videoName'];
}
function getDisabledStores($videoId){
    global $conn;
    $disstores =[];
    $dQ = "SELECT storeId from video_disbaled_store WHERE videoId = $videoId";
    $dQR = mysqli_query($conn,$dQ);
    if(mysqli_num_rows($dQR)> 0){
        while($row = mysqli_fetch_array($dQR)){
            array_push($disstores,$row['storeId']);
        }
    }
    return $disstores;
}
function getAllStores(){
    global $conn;
    $stores =[];
    $sQ = "SELECT id,storeId,storeName FROM stores WHERE isActive = 1";
    $sQR = mysqli_query($conn,$sQ);
    if(mysqli_num_rows($sQR)> 0){
        while($row = mysqli_fetch_array($sQR)){
            $id = $row['id'];
            $storeId = $row['storeId'];
            $storeName = $row['storeName'];
            $s = $storeId.' '.$storeName;
            $tmp = ['id'=>$id,'name'=>$s];
            array_push($stores,$tmp );
        }
    }
    return $stores;
}
    /**
		 * Get All Categories
		 */
		$categories = [];
		$categoryQuery = "SELECT id,name,slug
							FROM category";
		$categoryResult = mysqli_query($conn,$categoryQuery);

		if(mysqli_num_rows($categoryResult)> 0){
			while($row = mysqli_fetch_array($categoryResult)){
				$id = $row['id'];
				$name = $row['name'];
				$tmp = ['id'=>$id,'name'=>$name];
				array_push($categories,$tmp);
			}
		}

		/**
		 * Get All Locations
		 */
		$locations =[];
		$locationQuery = "SELECT id,name,slug
					FROM location";
		$locationResult = mysqli_query($conn,$locationQuery);

		if(mysqli_num_rows($locationResult)> 0){
			while($row = mysqli_fetch_array($locationResult)){
				$id = $row['id'];
				$name = $row['name'];
				$tmp = ['id'=>$id,'name'=>$name];
				array_push($locations,$tmp);
			}
        }
    function getCategoryId($videoId){
        global $conn;
        $query ="SELECT categoryId FROM videos WHERE videoId=$videoId";
        $result = mysqli_query($conn,$query);
        return mysqli_fetch_array($result)[0];
    }
    function getLocationId($videoId){
        global $conn;
        $query ="SELECT locationId FROM videos WHERE videoId=$videoId";
        $result = mysqli_query($conn,$query);
        return mysqli_fetch_array($result)[0];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Elite -Videos</title>

      <!-- custom css -->
    <link href="./css/styles.css" rel="stylesheet">
    <!-- Tailwind css -->
    <link href="./css/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="./css/uploadfile.css" />
</head>
<body>
    <div id="wrapper">
        <?php  if(isset($_GET['id'])){ ?>
            <div>
                Updating Access For Video-<b><?php echo getVideoName($_GET['id']); ?></b>
            </div>
        <?php } ?>
        <?php
            $vid = $_GET['id'];
            $stores = getAllStores();
            $diabledstores = getDisabledStores($_GET['id']);
            $categoryId = getCategoryId($_GET['id']);
            $locationId = getLocationId($_GET['id']);

        ?>
        <div class="form-group">
			<label for="sel1">Select Store's to disable Access:</label> &nbsp;
				<select class="store-multiple" name="stores[]" multiple="multiple">
					<?php for($i=0;$i<sizeof($stores);$i++){ ?>
						<option value="<?php echo $stores[$i]['id'];?>"
                            <?php if (in_array($stores[$i]['id'], $diabledstores)) {
                                echo "selected";
                                } ?>>
								<?php echo $stores[$i]['name'];?>
						</option>
					<?php } ?>
				</select>
				<br />
				<label for="sel2">Select Category</label> &nbsp;
					<select class="category" name="category">
						<?php for($i=0;$i<sizeof($categories);$i++){ ?>
							<option value="<?php echo $categories[$i]['id'];?>" <?php  if($categories[$i]['id']==$categoryId){echo 'selected';} ?>>
								<?php echo $categories[$i]['name'];?>
							</option>
						<?php } ?>
					</select>
					<br/>
					<br/>
					<label for="sel3">Select Location</label> &nbsp;
					    <select class="location" name="location">
							<?php for($i=0;$i<sizeof($locations);$i++){ ?>
								<option value="<?php echo $locations[$i]['id'];?>" <?php  if($locations[$i]['id']==$locationId){echo 'selected';} ?>>
									<?php echo $locations[$i]['name'];?>
								</option>
							<?php } ?>
						</select>
						<br/>
						<br/>
			<button id="ssel" class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" type="button">Update</button>
            <div id="res"></div>
		</div>
    </div>
    <!-- Jquery -->
	<script src="./js/jquery-3.5.1.min.js"></script>
	<!-- Main Js -->
	<script src="./js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            let stores = [];
            let category= 0;
            let location=0;
            category = $('.category').val();
			location = $('.location').val();
            stores = $('.store-multiple').val();
            //MultiSelect
			$('.store-multiple').select2();

			$('select.store-multiple').change(function() {
				stores = $('.store-multiple').val();
			});

			$('select.category').change(function() {
			    category = $('.category').val();
            });

			$('select.location').change(function() {
				location = $('.location').val();
            });
            $('#ssel').click(function(){
                let url;
                let videoId = `<?php echo $vid;?>`;
                if (stores.length > 0) {
					url = `video_access_action.php?vid=${videoId}&sid=${stores.toString()}&cat=${category}&loc=${location}`;
				} else {
					url = `video_access_action.php?vid=${videoId}&sid=${stores.toString()}&cat=${category}&loc=${location}`;
                }

                $.ajax({
					type: "GET",
					url: url,
					success: function (data) {
                        $('#res').html(data);
                        setTimeout(function() {
                            window.close();
                        }, 3000);
					}
				});
            })
        });
    </script>
</body>
</html>