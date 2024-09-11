<?php

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])) {
    // Establishing Connection...
    include 'connection.php';

    // Getting Data From Form...
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);

    // Checking if the credentials are right
    $sql = "SELECT * FROM `a_admin` WHERE email = '$email' AND password = '$pass'";
    $res = mysqli_query($con, $sql);

    // Redirection after checking data...
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        if ($row) {
            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $name;
            $_SESSION['id'] = $row['id'];

            // Inserting admin action (if required)
            /*
            $admin_id = $row['id'];
            $action = 'login';
            $sql = "INSERT INTO `admin_action`(`admin_id`, `action`) VALUES ('$admin_id','$action')";
            mysqli_query($con, $sql);
            */

            header("Location: session.php");
        } else {
            echo "<script>alert('LOGIN FAILED'); window.location.assign('index.php')</script>";
        }
    } else {
        // Handle SQL query error
        echo "<script>alert('LOGIN FAILED'); window.location.assign('index.php')</script>";
    }
} else {
    header("location:index.php");
}

        ?>