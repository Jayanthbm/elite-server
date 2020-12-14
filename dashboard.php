<?php
    if (session_id() == '' || !isset($_SESSION)) {
        session_start();
    }
    if (!$_SESSION) {
        header('Location:login.php');
    } else {
        include('./conn.php');

        /**
         * Total Videos
         */
        $vq =  "SELECT COUNT(*)
                FROM videos
                where isPublished =1";
        $vqr = mysqli_query($conn,$vq);
        $videos = mysqli_fetch_array($vqr)[0];

        /**
         * Total Video Plays
         */
        $tvq =  "SELECT COUNT(*)
                FROM videos
                where isPublished =1";
        $tvqr = mysqli_query($conn,$tvq);
        $tplays = mysqli_fetch_array($tvqr)[0];

        /**
         * Total Stores
         */
        $sq =  "SELECT COUNT(*)
                FROM stores";
        $sqr = mysqli_query($conn,$sq);
        $stores = mysqli_fetch_array($sqr)[0];

        /**
         * Total Active Stores
         */
        $asq =  "SELECT COUNT(*)
                FROM stores";
        $asqr = mysqli_query($conn,$asq);
        $astores = mysqli_fetch_array($asqr)[0];

        /**
         * Total Categories
         */
        $cq =  "SELECT COUNT(*)
                FROM category";
        $cqr = mysqli_query($conn,$cq);
        $categories = mysqli_fetch_array($cqr)[0];

        /**
         * Total Locations
         */
        $lq =  "SELECT COUNT(*)
                FROM location";
        $lqr = mysqli_query($conn,$lq);
        $locations = mysqli_fetch_array($lqr)[0];
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>

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
                        <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-blue-400 hover:border-blue-400">
                            <i class="fas fa-home fa-fw mr-3 text-blue-400"></i><span class="pb-1 md:pb-0 text-sm text-gray-100">Dashboard</span>
                        </a>
                    </li>
					<li class="mr-6 my-2 md:my-0">
                        <a href="./stores.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-100 border-b-2 border-gray-900 hover:border-pink-400">
                            <i class="fas fa-store fa-fw mr-3"></i><span class="pb-1 md:pb-0 text-sm">Stores</span>
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

		<div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

			<!--Console Content-->

			<div class="bg-white flex flex-wrap">
                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="rounded bg-gray-200 border border-white-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600"><i class="fa fa-video fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-center md:text-center">
                                <h5 class="font-bold text-2xl">Videos</h5>
                                <a href="./videos.php">
                                <h3 class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"><?php echo $videos;?></h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="rounded bg-gray-200 border border-white-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600"><i class="fa fa-wallet fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-center md:text-center">
                                <h5 class="font-bold text-2xl">Stores </h5>
                                <a href="./stores.php">
                                <h3 class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"><?php echo $stores;?></h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="rounded bg-gray-200 border border-white-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600"><i class="fa fa-folder fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-center md:text-center">
                                <h5 class="font-bold text-2xl">Categories</h5>
                                <a href="./categories.php">
                                <h3 class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"><?php echo $categories;?></h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="rounded bg-gray-200 border border-white-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600"><i class="fa fa-chart-line fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-center md:text-center">
                                <h5 class="font-bold text-2xl">Total Plays</h5>
                                <h3 class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"> <?php echo $tplays;?></h3>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="rounded bg-gray-200 border border-white-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600"><i class="fa fa-plug fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-center md:text-center">
                                <h5 class="font-bold text-2xl">Active Stores</h5>
                                <h3 class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"> <?php echo $astores;?></h3>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

                <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                    <!--Metric Card-->
                    <div class="rounded bg-gray-200 border border-white-800 rounded shadow p-2">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded p-3 bg-green-600"><i class="fa fa-location-arrow fa-2x fa-fw fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-center md:text-center">
                                <h5 class="font-bold text-2xl">Locations</h5>
                                <a href="./locations.php">
                                <h3 class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"><?php echo $locations;?></h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>

            </div>

		</div>


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

</body>

</html>
<?php } ?>