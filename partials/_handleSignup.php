<?php
$showError = false;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $username = $_POST['name'];
    $email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $cpassword = $_POST['signupCpassword'];

    $existSql = "select * from `users` where user_email = '$email'";
    $result = mysqli_query($conn, $existSql);
     
    $numRows = mysqli_fetch_row($result);
    if($numRows>0){
        $showError = "Email already in use";
    }
    else{
        if($password == $cpassword){
            $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES ('$username', '$email', '$password')";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "Passwords do not match";
        }
    }
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");
  }
?>