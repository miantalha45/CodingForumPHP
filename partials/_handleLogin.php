<?php
    $showAlert = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '_dbconnect.php';
        $email = $_POST['loginEmail'];
        $pass = $_POST['loginPassword'];

        $sql = "select * from `users` where user_email = '$email'";
        $result = mysqli_query($conn, $sql);

        $numRows = mysqli_num_rows($result);

        if ($numRows == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($pass == $row['user_password']) {
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['sno'] = $row['sno'];
                $_SESSION['username'] = $row['user_name'];
                $_SESSION['user_email'] = $email;
                // echo "Login";
                header("Location: /forum/index.php");
            } else {
                header("Location: /forum/index.php?login=false");
            }
        }
    }
?>