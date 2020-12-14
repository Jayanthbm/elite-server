<?php
    if (session_id() == '' || !isset($_SESSION)) {
        session_start();
    }
    if (!$_SESSION) {
        header('Location:login.php');
    } else {
	include_once './conn.php';

	$categoryQuery = "SELECT id,name,slug
					FROM category";
	$categoryResult = mysqli_query($conn,$categoryQuery);

	$locationQuery = "SELECT id,name,slug
					FROM location";
	$locationResult = mysqli_query($conn,$locationQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Elite -Stores</title>

    <!-- custom css -->
    <link href="./css/styles.css" rel="stylesheet">
    <!-- Tailwind css -->
    <link href="./css/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!--Regular Datatables CSS-->
	<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
	<!--Responsive Extension Datatables CSS-->
	<link href="./css/responsive.dataTables.min.css" rel="stylesheet">

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
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-pink-400 hover:border-pink-400">
                            <i class="fas fa-store fa-fw mr-3 text-pink-400"></i><span class="pb-1 md:pb-0 text-sm text-gray-100">Stores</span>
                        </a>
                    </li>
                    <li class="mr-6 my-2 md:my-0">
                        <a href="./videos.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900 hover:border-red-400">
                            <i class="fa fa-video fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Videos</span>
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
			Stores
		</h1>
		<button class="modal-open px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2">Create Store</button>
		<button class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" onclick="loadData()">Refresh</button>
		<div id="results"></div>
		<div id="storelist"></div>
	</div>
	<!--/container-->


	<!--New Store Modal Start-->
		<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-10 left-0 flex items-center justify-center">
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
							<p class="text-2xl font-bold">New Store</p>
							<div class="modal-close cursor-pointer z-50">
								<svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
								<path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
								</svg>
							</div>
						</div>

						<!--Body-->
						<?php  if(mysqli_num_rows($categoryResult) < 1 || mysqli_num_rows($locationResult) < 1) { ?>
							<section>
								<h3 class="font-bold text-2xl">Category/Location Not Created</h3>
								<a href="./categories.php">
									<button class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2">Create Category</button>
								</a>
								<a href="./locations.php">
									<button class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2">Create Location</button>
								</a>
							</section>
						<?php }else{ ?>
							<form class="flex flex-col" method="POST" action="store_action.php" id="createstore">

								<div class="mb-6 pt-3 rounded bg-gray-200">
									<label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="storeid">StoreId</label>
									<input type="text" id="storeid" name="storeid"
										class="bg-white-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3" required>
								</div>
								<div class="mb-6 pt-3 rounded bg-gray-200">
									<label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="storename">Store Name</label>
									<input type="text" id="storename" name="storename"
										class="bg-white-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3" required>
								</div>
								<div class="mb-6 pt-3 rounded bg-gray-200">
									<label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
									<input type="password" id="password" name="password"
										class="bg-white-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3" required>
								</div>
								<div class="mb-6 pt-3 rounded bg-gray-200">
									<label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="category">Select Category</label>
									<select name="category" id="category" required class="bg-white-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
										<?php while($r = mysqli_fetch_array($categoryResult)){
											$id = $r['id'];
											$name = $r['name'];
										?>
										<option value="<?php echo $id;?>"><?php echo $name;?></option>
										<?php } ?>
									</select>
								</div>
								<div class="mb-6 pt-3 rounded bg-gray-200">
									<label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="location">Select Location</label>
									<select name="location" id="location" required class="bg-white-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
										<?php while($r = mysqli_fetch_array($locationResult)){
											$id = $r['id'];
											$name = $r['name'];
										?>
										<option value="<?php echo $id;?>"><?php echo $name;?></option>
										<?php } ?>
									</select>
								</div>
								<button
									class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
									type="submit">Create</button>
							</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	<!--New Store Modal End-->
 	<!-- Jquery -->
	<script src="./js/jquery-3.5.1.min.js"></script>
	<!--Modal JS-->
	<script src="./js/modal.js"></script>
	<!-- Main Js -->
	<script src="./js/main.js"></script>
	<!--Datatables  -->
	<script src="./js/jquery.dataTables.min.js"></script>
	<script src="./js/dataTables.responsive.min.js"></script>


	<!-- Ajax Load Content Start-->
		<script>
		function loadData(){
			let url ="getStores.php";
			$.ajax({
				type: "GET",
				url: url,
				success: function (data) {
					$('#storelist').html(data);
					var table = $('#store').DataTable( {
						responsive: true
					} )
					.columns.adjust()
					.responsive.recalc();
				}

			});
		}
			$(document).ready(function(){
				loadData();
			})
		</script>
	<!-- Ajax Load Content End-->

	<!-- Ajax Form Submission Start-->
		<script type="text/javascript">
			$('#createstore').submit(function (e) {
				$('#results').html('');
				e.preventDefault();
				var form = $(this);
				var url = form.attr('action');
				$.ajax({
					type: "POST",
					url: url,
					data: form.serialize(),
					success: function (data) {
						toggleModal();
						$('#results').html(data);
						loadData();
					}
				});
			})
		</script>
	<!-- Ajax Form Submission End-->


</body>

</html>
<?php } ?>