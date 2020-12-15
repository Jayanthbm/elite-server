<?php
    if (session_id() == '' || !isset($_SESSION)) {
        session_start();
    }
    if ($_SESSION) {
        header('Location:dashboard.php');
    } else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Elite -Login</title>
    <!-- custom css -->

    <link href="./css/styles.css" rel="stylesheet">

    <!-- Tailwind css -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" integrity="sha512-+WF6UMXHki/uCy0vATJzyA9EmAcohIQuwpNz0qEO+5UeE5ibPejMRdFuARSrl1trs3skqie0rY/gNiolfaef5w==" crossorigin="anonymous" />

</head>

<body class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0">
<div id="results"></div>
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-4xl font-bold text-white text-center">Elite</h1>
        </a>
    </header>

    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome to Elite</h3>
            <p class="text-gray-600 pt-2">Sign in to your account.</p>
        </section>
        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="login_action.php" id="loginform">
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="username">UserName</label>
                    <input type="text" id="username" name="username"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3" required>
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3" required >
                </div>
                <button
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200"
                    type="submit">Sign In</button>
            </form>
        </section>
    </main>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--
        Ajax Request to Login Action
    -->
    <script type="text/javascript">
        $('#loginform').submit(function (e) {
            $('#results').html('');
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            console.log(url);
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function (data) {
                    if (data === `<span style='color:green;'>Login Successful</span>`) {
                        location.reload();
                    }else{
                        $('#results').html(data);
                    }
                }
            });
        })
    </script>
</body>

</html>
<?php } ?>