<?php
    if (session_id() == '' || !isset($_SESSION)) {
        session_start();
    }
    if (!$_SESSION) {
        header('Location:login.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Elite -Dashboard</title>

    <!-- custom css -->
    <link href="./css/styles.css" rel="stylesheet">
    <!-- Tailwind css -->
    <link href="./css/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

	<!--Regular Datatables CSS-->
	<link href="./css/jquery.dataTables.min.css" rel="stylesheet">
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
		<button class="modal-open px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2">Upload Video</button>
		<button class="px-4 bg-indigo-500 p-3 rounded-lg text-white text-right hover:bg-indigo-400 mb-2" onclick="loadData()">Refresh</button>
		<div id="results"></div>
		<div id="videolist"></div>
	</div>
	<!--/container-->


 	<!-- Jquery -->
	<script src="./js/jquery-3.5.1.min.js"></script>
	<!--Modal -->
	<script src="./js/modal.js"></script>
	<!-- Main Js -->
	<script src="./js/main.js"></script>
	<!--Datatables  -->
	<script src="./js/jquery.dataTables.min.js"></script>
	<script src="./js/dataTables.responsive.min.js"></script>

	<!-- Ajax Load Content Start-->
		<script>
		function loadData(){
			let url ="getVideos.php";
			$.ajax({
				type: "GET",
				url: url,
				success: function (data) {
					$('#videolist').html(data);
					var table = $('#video').DataTable( {
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

</body>

</html>
<?php } ?>