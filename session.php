<?php
session_start();
if(!isset($_SESSION['email']) ){?>
    <script>
        // location.replace("https://cybernsoft.com/New-Admin/index.php")
        location.replace("index")

    </script>

    <?php
}else{?>

    <script>
        location.replace("https://eleken.cybernsoft.com")
        window.location.assign("Project.php")

    </script>
    <?php
}


?>