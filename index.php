

<!DOCTYPE html>
<html lang="en">
<?php 
  session_start();
if (isset($_SESSION['email']) || isset($_SESSION['id'])) {
    header('Location: project.php');
    exit; // Make sure to exit to prevent further script execution
}
    include "headerlink.php";
    ?>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Master Login</title>
    <link rel="stylesheet" href="assets/css/customStyle.css" />
    <link rel="stylesheet" href="Assets/styles/custom-select.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet" />

    <style>
        .saimaColor {
            color: green !important;
        }
    </style>

</head>


<body>
    
<section class="loginWholePage1">
    <main class="loginPageMainContainer1">
        <!-- Form Section -->
        <section class="loginLeftSection">
            <!-- <div class="logoSection1">
                <img src="./images/Logo.png" />
              </div> -->

            <section class="mainLoginSection1">
                <section class="loginBox1">
                    <!-- <h1>Login Your Account</h1> -->
                    <!-- <h1>ADMIN</h1> -->

                    <div class="wenergyLogoDiv">
                        <img src="assets/images/beams_logo.png" alt="" width="80px" />
                        <h2 style="font-weight: normal; font-size: 20px; color: #777; margin-top: 10px;">ELEKEN ASSOCIATES</h2>
                    </div>

                    <form action="Auth.php" method="POST" class="formContainer1">
                        <label for="email">
                            <!-- <p>EMAIL:</p> -->
                            <input type="email" id="email" placeholder="Email" name="email" required />
                        </label>
                        <label for="password">
                            <!-- <p>PASSWORD:</p> -->
                            <input type="password" id="password" style="width:95%" placeholder="Password" name="password" required />
                            <div>
                                <i class="fa-solid fa-eye" onclick="showPassword(this)"></i>
                            </div>
                        </label>
                        <!--                        --><?php
                        //                        include 'Model/masterAdminConnection.php';
                        //                        $output = '';
                        //                        $query = "SELECT * from a_project";
                        //                        $res = mysqli_query($con, $query);
                        //                        if (mysqli_num_rows($res) > 0) {
                        //
                        //                            while ($row = mysqli_fetch_assoc($res)) {
                        //                                $output .= '<option style="color:black;" value="' . $row["id"] . '">' . $row['name'] . '</option>';
                        //                            }
                        //                        }
                        //
                        //                        ?>
                        <!---->
                        <!--                        <div class="custom-select" style="margin-left: 10px; width: 95%;">-->
                        <!--                            <select name="project_id" id="project_id" class="userTypeDropDown" style="width: 100%;" required>-->
                        <!--                                <option value="#" selected disabled>Select Society: </option>-->
                        <!--                                --><?php //echo $output; ?>
                        <!---->
                        <!--                            </select>-->
                        <!--                        </div>-->


                        <div class="loginBtnDiv1">
                            <button type="submit" name="login">Login</button>
                        </div>


                    </form>

                    <div class="loginCopyRightDiv">
                        <small>&#169; 2023 CybernSoft. All rights reserved. </small>
                    </div>
                </section>
            </section>
        </section>



        <!-- Image Section -->
        <section class="loginRightSection">
            <img src="" alt="" class="loginIcon" width="50px" />
        </section>
    </main>
</section>
</body>
<?php 
    include "footlink.php";
    ?>
<script src="assets/js/app.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    var x, i, j, l, ll, selElmnt, a, b, c;
    /* Look for any elements with the class "custom-select": */
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    /* If the user clicks anywhere outside the select box,
    then close all select boxes: */
    document.addEventListener("click", closeAllSelect);
</script>

<!-- <script src="Assets/scripts/jquery/3.6.0/jquery.min.js"></script>
<script>
  // let optionsDiv = document.getElementsByClassName('optionsDiv');
  // for(let i = 0; i < optionsDiv.length; i++) {
  //   optionsDiv[i].nodeValue.replace('Saima', '<span class="saimaColor">Saima</span>');
  // }

  $(".select-items").children().each(function(){
    $(this).html(
      $(this).html().replace(/Saima/g, "<span class='saimaColor'>Saima</span>")
    )
  })
</script> -->

</html>