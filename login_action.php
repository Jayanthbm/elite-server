<?php
session_start();
include('./conn.php');

if (!$conn) {
  echo "Error Connecting To Database";
} else {
  if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userQuery = "SELECT userId,email,password from users WHERE email='$username' or name ='$username'";

    if (mysqli_query($conn, $userQuery)) {
      $userResult = mysqli_query($conn, $userQuery);
      if (mysqli_num_rows($userResult) > 0) {
        $row = mysqli_fetch_assoc($userResult);
        $userId = $row['userId'];
        $hashPassword = $row['password'];
        if (password_verify($password, $hashPassword)) {
          $uq = "UPDATE users set lastLoginTime = '$date_time' ,isLoggedin =1 WHERE userId =$userId";
          if (mysqli_query($conn, $uq)) {
            $_SESSION['userId'] = $userId;
            echo "<span style='color:green;'>Login Successful</span>";
            exit();
          }
        }
      }
    }
  }
}
echo '<div class="alert-banner w-full fixed top-0">
<input type="checkbox" class="hidden" id="banneralert">
  
<label class="close cursor-pointer flex items-center justify-center w-full p-2 bg-red-500 shadow text-white" title="close" for="banneralert">
  <span class="items-center">Invalid Credentials</span>
</label>
</div>';
