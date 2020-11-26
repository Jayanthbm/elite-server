<?php
session_start();
include('./conn.php');
if (!$conn) {
  echo "Error Connecting To Database";
}else{
    if(isset($_POST['storeid']) && isset($_POST['storename'] )&& isset($_POST['category']) && isset($_POST['location']) && isset($_POST['password'])){
        $storeId = $_POST['storeid'];
        $storeName = $_POST['storename'];
        $category = $_POST['category'];
        $location = $_POST['location'];
        $userId = $_SESSION['userId'];
        $password =$_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO stores(storeId,storeName,createdOn,createdBy,isLoggedin,isActive,password,categoryId,locationId)VALUES('$storeId','$storeName','$date_time',$userId,0,1,'$hash',$category,$location)";
        if(mysqli_query($conn,$query)){
            echo '<div class="alert-banner">
                    <input type="checkbox" class="hidden" id="banneralert">
                    <label class="close cursor-pointer flex items-center justify-center w-full p-2 bg-green-500 shadow text-white" title="close" for="banneralert">
                    <span class="items-center">Store Created</span>
                    </label>
                </div>';
            exit();
        }
    }
}
echo '<div class="alert-banner">
                    <input type="checkbox" class="hidden"  id="banneralert">
                    <label class="close cursor-pointer flex items-center justify-center w-full p-2 bg-red-500 shadow text-white" title="close" for="banneralert">
                    <span class="items-center">Error During Category Creation</span>
                    </label>
                </div>';