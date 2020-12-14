<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    include './conn.php';
    include './constants.php';
    include './tokenhelper.php';

    $res = (object) null;
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    function Update_store_activity($storeId){
        global $conn,$date_time;
        $uS = "UPDATE stores SET lastLoginTime ='$date_time', isLoggedin=1,isActive=1 WHERE id =$storeId";
        mysqli_query($conn,$uS);
        $uQ = "INSERT INTO store_activity_log(storeId,loginTime)VALUES($storeId,'$date_time')";
        mysqli_query($conn,$uQ);
        return true;
    }
    if(isset($data)){
        $storeId = $data->storeId;
        $password = $data->password;
        if($storeId && $password){
            $sQ = "SELECT id,password
                    FROM stores WHERE storeId = '$storeId' or storeName='$storeId' AND isActive = 1 ";
            if(!mysqli_query($conn,$sQ)){
                $res->status="error";
                $res->message ="Invalid Credentials";
            }else{
                $sQR = mysqli_query($conn,$sQ);
                if(mysqli_num_rows($sQR)> 0){
                    while($row = mysqli_fetch_array($sQR)){
                        $id = $row['id'];
                        $haspass = $row['password'];
                    }
                    if (password_verify($password, $haspass)){
                        Update_store_activity($id);
                        $token = encode_jwt($id, $secretKey);
                        $res->status ="Success";
                        $res->token=$token;
                    }
                }else{
                    $res->status="error";
                    $res->message ="Invalid Credentials";
                }
            }
        }else{
            $res->status="error";
            $res->message ="Invalid Credentials";
        }
    }else{
        $res->status="error";
        $res->message ="Invalid Credentials";
    }

echo json_encode($res);
?>