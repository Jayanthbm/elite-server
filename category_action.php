<?php
session_start();
include('./conn.php');
if (!$conn) {
  echo "Error Connecting To Database";
}else{
    if(isset($_POST['name']) && isset($_POST['slug'])){
        $name = $_POST['name'];
        $slug = $_POST['slug'];

        $query = "INSERT INTO category(name,slug)VALUES('$name','$slug')";
        if(mysqli_query($conn,$query)){
            echo '<div class="alert-banner">
                    <input type="checkbox" class="hidden" id="banneralert">
                    <label class="close cursor-pointer flex items-center justify-center w-full p-2 bg-green-500 shadow text-white" title="close" for="banneralert">
                    <span class="items-center">Category Created</span>
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