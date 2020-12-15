<?php
    if (session_id() == '' || !isset($_SESSION)) {
        session_start();
    }
    if (!$_SESSION) {
        header('Location:login.php');
    } else {
		include_once './conn.php';
		//Get all store Ids
		$stores =[];
		$sQ = "SELECT *
				FROM stores";
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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" integrity="sha512-+WF6UMXHki/uCy0vATJzyA9EmAcohIQuwpNz0qEO+5UeE5ibPejMRdFuARSrl1trs3skqie0rY/gNiolfaef5w==" crossorigin="anonymous" />

	<!--font awesome css -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!--Regular Datatables CSS-->

	<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">

	<!--Select 2 css -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

	<!--Upload file css -->
	<link rel="stylesheet" href="./css/uploadfile.css" />
</head>
<body class="body-bg font-sans leading-normal tracking-normal">

	<nav id="header" class="bg-gray-900 fixed w-full z-10 top-0 shadow">


		<div class="w-full container mx-auto flex flex-wrap items-center mt-0 pt-3 pb-3 md:pb-0">

			<div class="w-1/2 pl-2 md:pl-0">
				<a class="text-gray-100 text-base xl:text-xl no-underline hover:no-underline font-bold"  href="#">
					Elite Dashboard
				</a>
            </div>
			<div class="w-1/2 pr-0">
				<div class="flex relative inline-block float-right">

				  <div class="relative text-sm text-gray-100">
					  <button id="userButton" class="flex items-center focus:outline-none mr-3">
						<img class="w-8 h-8 rounded-full mr-4" src="http://i.pravatar.cc/300" alt="Avatar of User"> <span class="hidden md:inline-block text-gray-100">Hi, Admin</span>
						<svg class="pl-2 h-2 fill-current text-gray-100" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129"><g><path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/></g></svg>
					  </button>
					  <div id="userMenu" class="bg-gray-900 rounded shadow-md mt-2 absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
						  <ul class="list-reset">

							<li><a href="logout.php" class="px-4 py-2 block text-gray-100 hover:bg-gray-800 no-underline hover:no-underline">Logout</a></li>
						  </ul>
					  </div>
				  </div>


					<div class="block lg:hidden pr-4">
					<button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-100 hover:border-teal-500 appearance-none focus:outline-none">
						<svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
					</button>
				</div>
				</div>

			</div>


			<div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 bg-gray-900 z-20" id="nav-content">
				<ul class="list-reset lg:flex flex-1 items-center px-4 md:px-0">
					<li class="mr-6 my-2 md:my-0">
                        <a href="./dashboard.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900 hover:border-red-400">
                            <i class="fas fa-home fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Dashboard</span>
                        </a>
                    </li>
					<li class="mr-6 my-2 md:my-0">
                        <a href="./stores.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900 hover:border-pink-400">
                            <i class="fas fa-store fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Stores</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-red-400 hover:border-red-400">
                            <i class="fa fa-video fa-fw mr-3 text-red-400"></i><span class="pb-1 md:pb-0 text-sm text-gray-100">Videos</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="./categories.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-green-400">
                            <i class="fas fa-folder fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Categories</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="./locations.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900  hover:border-yellow-400">
                            <i class="fa fa-location-arrow fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Locations</span>
                        </a>
                    </li>
				</ul>
			</div>

		</div>
	</nav>

	<!--Container-->
	<div class="container w-full mx-auto pt-20">
		<h1 class="flex items-center font-sans font-bold break-normal text-white px-2 py-8 text-xl md:text-2xl">
			Videos
		</h1>
		<button class="modal-open px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" data-toggle="modal" data-target="uploadModal">Upload Video</button>
		<button class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" onclick="loadData()">Refresh</button>
		<div id="results"></div>
		<div id="videolist"></div>
	</div>
	<!--/container-->

	<!--Upload Video Modal Start -->

		<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center" id="uploadModal">
			<div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
				<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

					<div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
						<svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
							<path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
						</svg>
						<span class="text-sm">(Esc)</span>
					</div>

					<!-- Add margin if you want to see some of the overlay behind the modal-->
					<div class="modal-content py-4 text-left px-6">
						<!--Title-->
						<div class="flex justify-between items-center pb-3">
							<p class="text-2xl font-bold">Upload Video</p>
							<div class="modal-close cursor-pointer z-50">
								<svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
								<path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
								</svg>
							</div>
						</div>

						<!--Body-->
						<div id="st">
							<div class="form-group">
								<label for="sel1">Select Store's to disable Access:</label> &nbsp;
								<select class="store-multiple" name="stores[]" multiple="multiple">
									<?php for($i=0;$i<sizeof($stores);$i++){ ?>
										<option value="<?php echo $stores[$i]['id'];?>">
											<?php echo $stores[$i]['name'];?>
										</option>
									<?php } ?>
								</select>
								<br />
								<label for="sel2">Select Category</label> &nbsp;
								<select class="category" name="category">
									<?php for($i=0;$i<sizeof($categories);$i++){ ?>
										<option value="<?php echo $categories[$i]['id'];?>">
											<?php echo $categories[$i]['name'];?>
										</option>
									<?php } ?>
								</select>
								<br/>
								<br/>
								<label for="sel3">Select Location</label> &nbsp;
								<select class="location" name="location">
									<?php for($i=0;$i<sizeof($locations);$i++){ ?>
										<option value="<?php echo $locations[$i]['id'];?>">
											<?php echo $locations[$i]['name'];?>
										</option>
									<?php } ?>
								</select>
								<br/>
								<br/>
								<button id="ssel" class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" type="button">Done</button>
							</div>
                    	</div>
						<div id="vuu">
							<div id="sl"></div>
							<button id="reselect" class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" type="button">Reselect</button>
							<br /><br />
							<div id="mulitplefileuploader">Upload Videos</div>
							<div id="status"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!--Upload Video Modal End -->

 	<!-- Jquery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<!--Modal JS-->
	<script src="./js/modal.js"></script>
	<!-- Main Js -->
	<script src="./js/main.js"></script>
	<!--Datatables  -->
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<script src="./js/jquery.uploadfile.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<!-- Ajax Load Content Start-->
		<script>
		function loadData(){
			let url ="getVideos.php";
			$.ajax({
				type: "GET",
				url: url,
				success: function (data) {
					$('#videolist').html(data);
					$('#video').DataTable();
				}
			});
		}
			$(document).ready(function(){
				let stores = [];
				let category= 0;
				let location=0;
				loadData();
				//Video Uploader
				category = $('.category').val();
				location = $('.location').val();
        		//Intially Hide Video Uploader
       				$('#vuu').hide();
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
					//After Stores Selected
					$('#ssel').click(function() {
						$('#st').hide();
						let url;
						if (stores.length > 0) {
							url = `upload.php?id=${stores.toString()}&cat=${category}&loc=${location}`;
						} else {
							url = `upload.php?&cat=${category}&loc=${location}`;
						}
						var settings = {
							url: url,
							method: "POST",
							allowedTypes: "mp4",
							fileName: "myfile",
							multiple: true,
							sequential: true,
							sequentialCount: 1,
							onSuccess: function(files, data, xhr) {
								console.log(data);
								$('#status').append(`${data}`);
								loadData();
							},
							onError: function(files, status, errMsg) {
								$("#status").html("<font color='red'>Upload is Failed</font>");
							}
						}

						$("#mulitplefileuploader").uploadFile(settings);
						$('#sl').html(`${stores.length} Stores Selected<br />`);
						$('#vuu').show();

						$('#reselect').click(function() {
            				$('#vuu').hide();
            				$('#st').show();
        				});

						$("#vu").click(function() {
							$("#uploadvideo").modal({
								backdrop: 'static',
								keyboard: false
							});
						});
					})
			});
			function globalUpdate(id,status){
				let url = `global_action.php?id=${id}&global=${status}`;
				console.log(url);
				$.ajax({
					type: "GET",
					url: url,
					success: function (data) {
						loadData();
					}
				});
			}
			function UpdateAccess(id){
				let url =`videoAccess.php?id=${id}`;
				popupWindow(url, 'Video Access', window, 600, 500);
			}
			function deleteVideo(id,name){
				let url =`delete_action.php?vid=${id}&vname=${name}`;
				$.ajax({
					type: "GET",
					url: url,
					success: function (data) {
						loadData();
					}

				});
			}
			function popupWindow(url, title, win, w, h) {
            	const y = win.top.outerHeight / 2 + win.top.screenY - (h / 2);
            	const x = win.top.outerWidth / 2 + win.top.screenX - (w / 2);
            	return win.open(url, title, `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no,resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`);
        }
		</script>
	<!-- Ajax Load Content End-->

</body>

</html>
<?php } ?>