<?php
include 'includes/create.php';
session_start();

// Check if admin is logged in
if(!isset($_SESSION['ID_Admin'])){
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Profile</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles.css'>
    <script src='main.js'></script>
</head>

<body>
    <!-- Nav Bar -->

    <nav>
        <input id="nav-toggle" type="checkbox">
        <div class="logo"><img src="images/logo_navbar.png" alt="Logo">
        </div>
        <ul class="links">
            <li><a href="index.php" style="color: #3db166;">Home</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="">Curriculum</a></li>
            <li><a href="">Gallery</a></li>
            <li><a href="">Blog</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>

    <!-- End of Nav Bar -->

    <div class="admin-background">
        <!-- Admin Profile -->
        <div class="admin-profile">
            <div class="logout"><a href="includes/logout.php">Logout</a></div>

            <div class="admin-bar">
                <p>Students Records</p>
                <a href="#fill-form"><button>Create Profile</button></a>
            </div>
            <table>
                <tr>
                    <th>Id</th>
                    <th class="hidden-col">Email</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th class="hidden-col">Age</th>
                    <th class="hidden-col">Adress</th>
                    <th class="hidden-col">Parent Phone</th>
                    <th class="hidden-col">Class</th>
                    <th class="hidden-col">Math Mark</th>
                    <th class="hidden-col">English Mark</th>
                    <th>Edit / Delete</th>
                </tr>

                <!-- Collecting student data from database to display in table -->
                <?php

                $result_details = mysqli_query($connection, "SELECT visitor.idV, student.idStu, visitor.email, student.full_name, student.age, student.adress, student.gender, student.parent_phone, student.class, marks.mark FROM visitor, student, subjects, marks WHERE visitor.idV = student.idV AND student.idStu = marks.idStu AND subjects.idSub = marks.idSub AND subjects.subject_name = 'math'");

                $result_english = mysqli_query($connection, "SELECT marks.mark FROM student, subjects, marks WHERE student.idStu = marks.idStu AND subjects.idSub = marks.idSub and subjects.subject_name = 'english'");

                // While Loop to display multiple rows of data from database in table
                while (($row = $result_details->fetch_assoc()) && ($row_english = $result_english->fetch_assoc())) {
                ?>
                    <tr>
                        <td><?php echo $row['idStu']; ?></td>
                        <td class="hidden-col"><?php echo $row['email']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['gender']; ?></td>
                        <td class="hidden-col"><?php echo $row['age']; ?></td>
                        <td class="hidden-col"><?php echo $row['adress']; ?></td>
                        <td class="hidden-col"><?php echo $row['parent_phone']; ?></td>
                        <td class="hidden-col"><?php echo $row['class']; ?></td>
                        <td class="hidden-col"><?php echo $row['mark']; ?></td>
                        <td class="hidden-col"><?php echo $row_english['mark']; ?></td>
                        <td><span>
                                <a href="includes/update.php?update=<?php echo $row['idV']; ?>"><img src="icons/edit-icon.png" alt="Edit profile icon"></a>
                                <a href="includes/delete.php?delete=<?php echo $row['idV']; ?>"><img src="icons/delete-icon.png" alt="Delete profile icon"></a>
                            </span></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- End Admin Profile -->
    </div>
    <!-- Create Student Profile Popup -->

    <div id="fill-form" class="popup-bg">
        <div class="create-edit-popup">
            <a class="close" href="#" class="">Close</a>
            <form action="includes/create.php" method="POST" autocomplete="off">
                <div class="input-row">
                    <input class="std-form" type="text" name="std-email" id="std-email" placeholder="Email" onkeyup="emailValidation()">
                    <img id="email-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="email-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="std-password" id="std-password" placeholder="Password" onkeyup="passwordValidation()">
                    <img id="password-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="password-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="std-name" id="std-name" placeholder="Name" onkeyup="nameValidation()">
                    <img id="name-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="name-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <select class="std-form" type="text" name="std-gender" id="std-gender" placeholder="Gender" onkeyup="genderValidation()">
                        <option disabled selected>Gender</option>
                        <option class="select-gender">Male</option>
                        <option class="select-gender">Female</option>

                    </select>
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="std-age" id="std-age" placeholder="Age" onkeyup="ageValidation()">
                    <img id="age-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="age-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="std-adress" id="std-adress" placeholder="Adress" onkeyup="adressValidation()">
                    <img id="adress-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="adress-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="std-phone" id="std-phone" placeholder="Parent Phone" onkeyup="phoneValidation()">
                    <img id="phone-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="phone-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <select class="std-form" type="text" name="std-class" id="std-class" placeholder="Class" onkeyup="classValidation()">
                        <option disabled selected>Class</option>
                        <option class="select-gender" value="Class 1">Class 1</option>
                        <option class="select-gender" value="Class 2">Class 2</option>
                    </select>
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="math-mark" id="math-mark" placeholder="Math Mark" onkeyup="mathValidation()">
                    <img id="math-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="math-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <div class="input-row">
                    <input class="std-form" type="text" name="english-mark" id="english-mark" placeholder="English Mark" onkeyup="englishValidation()">
                    <img id="english-invalid" src="icons/invalid-icon.png" alt="invalid icon">
                    <img id="english-valid" src="icons/save-popup.png" alt="valid icon">
                </div>
                <button name="save" type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- Edit Student Profile Popup -->

    <div id="fill-form-update" class="popup-bg">
        <div class="create-edit-popup">
            <a class="close" href="#" class="">Close</a>
            <form action="includes/update_details.php" method="POST" autocomplete="off">

                <?php

                $EDIT_Std = $_SESSION['EDIT_Std'];

                $update_details = mysqli_query($connection, "SELECT visitor.email, visitor.login_password , student.idStu, student.full_name, student.age, student.adress, student.gender, student.parent_phone, student.class, marks.mark FROM visitor, student, subjects, marks WHERE visitor.idV = $EDIT_Std AND student.idV = visitor.idV AND student.idStu = marks.idStu AND subjects.idSub = marks.idSub AND subjects.subject_name = 'math'");

                $update_english = mysqli_query($connection, "SELECT marks.mark FROM visitor, student, subjects, marks WHERE visitor.idV = $EDIT_Std AND student.idV = visitor.idV AND student.idStu = marks.idStu AND subjects.idSub = marks.idSub and subjects.subject_name = 'english'");

                // While Loop to display multiple rows of data from database in table
                while (($row = $update_details->fetch_assoc()) && ($row_english = $update_english->fetch_assoc())) {
                ?>

                    <div class="input-row">
                        <input value="<?php echo $row['email']; ?>" class="std-form" type="text" name="std-email" id="std-email-edit" placeholder="Email" onkeyup="emailValidationEdit()">
                        <img id="email-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="email-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row['login_password']; ?>" class="std-form" type="text" name="std-password" id="std-password-edit" placeholder="Password" onkeyup="passwordValidationEdit()">
                        <img id="password-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="password-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row['full_name']; ?>" class="std-form" type="text" name="std-name" id="std-name-edit" placeholder="Name" onkeyup="nameValidationEdit()">
                        <img id="name-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="name-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <select class="std-form" type="text" name="std-gender" id="std-gender-edit" placeholder="Gender" onkeyup="genderValidationEdit()">
                            <option disabled selected>Gender</option>
                            <option <?php if ($row['gender'] == 'Male') {
                                        echo 'selected';
                                    } ?> class="select-gender">Male</option>
                            <option <?php if ($row['gender'] == 'Female') {
                                        echo 'selected';
                                    } ?> class="select-gender">Female</option>

                        </select>
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row['age']; ?>" class="std-form" type="text" name="std-age" id="std-age-edit" placeholder="Age" onkeyup="ageValidationEdit()">
                        <img id="age-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="age-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row['adress']; ?>" class="std-form" type="text" name="std-adress" id="std-adress-edit" placeholder="Adress" onkeyup="adressValidationEdit()">
                        <img id="adress-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="adress-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row['parent_phone']; ?>" class="std-form" type="text" name="std-phone" id="std-phone-edit" placeholder="Parent Phone" onkeyup="phoneValidationEdit()">
                        <img id="phone-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="phone-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <select class="std-form" type="text" name="std-class" id="std-class-edit" placeholder="Class" onkeyup="classValidationEdit()">
                            <option disabled selected>Class</option>
                            <option <?php if ($row['class'] == 'Class 1') {
                                        echo 'selected';
                                    } ?> class="select-gender" value="Class 1">Class 1</option>
                            <option <?php if ($row['class'] == 'Class 2') {
                                        echo 'selected';
                                    } ?> class="select-gender" value="Class 2">Class 2</option>
                        </select>
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row['mark']; ?>" class="std-form" type="text" name="math-mark" id="math-mark-edit" placeholder="Math Mark" onkeyup="mathValidationEdit()">
                        <img id="math-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="math-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>
                    <div class="input-row">
                        <input value="<?php echo $row_english['mark']; ?>" class="std-form" type="text" name="english-mark" id="english-mark-edit" placeholder="English Mark" onkeyup="englishValidationEdit()">
                        <img id="english-invalid-edit" src="icons/invalid-icon.png" alt="invalid icon">
                        <img id="english-valid-edit" src="icons/save-popup.png" alt="valid icon">
                    </div>

                <?php } ?>

                <button name="update" type="submit">Save</button>
            </form>
        </div>
    </div>

    <!-- End of Create Student Profile Popup -->

    <hr class="footer-hr">

    <!-- Footer-->

    <footer>
        <div class="col1">
            <img src="images/logo_footer.png" alt="Mariana School Logo">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                et dolore magna
                aliqua.</p>
            <span class="icon-span">
                <svg class="facebook" viewBox="0 0 512 512">
                    <path class="icon" d="M211.9 197.4h-36.7v59.9h36.7V433.1h70.5V256.5h49.2l5.2-59.1h-54.4c0 0 0-22.1 0-33.7 0-13.9 2.8-19.5 16.3-19.5 10.9 0 38.2 0 38.2 0V82.9c0 0-40.2 0-48.8 0 -52.5 0-76.1 23.1-76.1 67.3C211.9 188.8 211.9 197.4 211.9 197.4z" />
                </svg>
                <svg class="instagram" viewBox="0 0 512 512">
                    <g class="icon">
                        <path d="M256 109.3c47.8 0 53.4 0.2 72.3 1 17.4 0.8 26.9 3.7 33.2 6.2 8.4 3.2 14.3 7.1 20.6 13.4 6.3 6.3 10.1 12.2 13.4 20.6 2.5 6.3 5.4 15.8 6.2 33.2 0.9 18.9 1 24.5 1 72.3s-0.2 53.4-1 72.3c-0.8 17.4-3.7 26.9-6.2 33.2 -3.2 8.4-7.1 14.3-13.4 20.6 -6.3 6.3-12.2 10.1-20.6 13.4 -6.3 2.5-15.8 5.4-33.2 6.2 -18.9 0.9-24.5 1-72.3 1s-53.4-0.2-72.3-1c-17.4-0.8-26.9-3.7-33.2-6.2 -8.4-3.2-14.3-7.1-20.6-13.4 -6.3-6.3-10.1-12.2-13.4-20.6 -2.5-6.3-5.4-15.8-6.2-33.2 -0.9-18.9-1-24.5-1-72.3s0.2-53.4 1-72.3c0.8-17.4 3.7-26.9 6.2-33.2 3.2-8.4 7.1-14.3 13.4-20.6 6.3-6.3 12.2-10.1 20.6-13.4 6.3-2.5 15.8-5.4 33.2-6.2C202.6 109.5 208.2 109.3 256 109.3M256 77.1c-48.6 0-54.7 0.2-73.8 1.1 -19 0.9-32.1 3.9-43.4 8.3 -11.8 4.6-21.7 10.7-31.7 20.6 -9.9 9.9-16.1 19.9-20.6 31.7 -4.4 11.4-7.4 24.4-8.3 43.4 -0.9 19.1-1.1 25.2-1.1 73.8 0 48.6 0.2 54.7 1.1 73.8 0.9 19 3.9 32.1 8.3 43.4 4.6 11.8 10.7 21.7 20.6 31.7 9.9 9.9 19.9 16.1 31.7 20.6 11.4 4.4 24.4 7.4 43.4 8.3 19.1 0.9 25.2 1.1 73.8 1.1s54.7-0.2 73.8-1.1c19-0.9 32.1-3.9 43.4-8.3 11.8-4.6 21.7-10.7 31.7-20.6 9.9-9.9 16.1-19.9 20.6-31.7 4.4-11.4 7.4-24.4 8.3-43.4 0.9-19.1 1.1-25.2 1.1-73.8s-0.2-54.7-1.1-73.8c-0.9-19-3.9-32.1-8.3-43.4 -4.6-11.8-10.7-21.7-20.6-31.7 -9.9-9.9-19.9-16.1-31.7-20.6 -11.4-4.4-24.4-7.4-43.4-8.3C310.7 77.3 304.6 77.1 256 77.1L256 77.1z" />
                        <path d="M256 164.1c-50.7 0-91.9 41.1-91.9 91.9s41.1 91.9 91.9 91.9 91.9-41.1 91.9-91.9S306.7 164.1 256 164.1zM256 315.6c-32.9 0-59.6-26.7-59.6-59.6s26.7-59.6 59.6-59.6 59.6 26.7 59.6 59.6S288.9 315.6 256 315.6z" />
                        <circle cx="351.5" cy="160.5" r="21.5" />
                    </g>
                </svg>
                <svg class="twitter" viewBox="0 0 512 512">
                    <path class="icon" d="M419.6 168.6c-11.7 5.2-24.2 8.7-37.4 10.2 13.4-8.1 23.8-20.8 28.6-36 -12.6 7.5-26.5 12.9-41.3 15.8 -11.9-12.6-28.8-20.6-47.5-20.6 -42 0-72.9 39.2-63.4 79.9 -54.1-2.7-102.1-28.6-134.2-68 -17 29.2-8.8 67.5 20.1 86.9 -10.7-0.3-20.7-3.3-29.5-8.1 -0.7 30.2 20.9 58.4 52.2 64.6 -9.2 2.5-19.2 3.1-29.4 1.1 8.3 25.9 32.3 44.7 60.8 45.2 -27.4 21.4-61.8 31-96.4 27 28.8 18.5 63 29.2 99.8 29.2 120.8 0 189.1-102.1 185-193.6C399.9 193.1 410.9 181.7 419.6 168.6z" />
                </svg>
                <svg class="youtube" viewBox="0 0 512 512">
                    <path class="icon" d="M422.6 193.6c-5.3-45.3-23.3-51.6-59-54 -50.8-3.5-164.3-3.5-215.1 0 -35.7 2.4-53.7 8.7-59 54 -4 33.6-4 91.1 0 124.8 5.3 45.3 23.3 51.6 59 54 50.9 3.5 164.3 3.5 215.1 0 35.7-2.4 53.7-8.7 59-54C426.6 284.8 426.6 227.3 422.6 193.6zM222.2 303.4v-94.6l90.7 47.3L222.2 303.4z" />
                </svg>
                <svg class="linkedin" viewBox="0 0 512 512">
                    <path class="icon" d="M186.4 142.4c0 19-15.3 34.5-34.2 34.5 -18.9 0-34.2-15.4-34.2-34.5 0-19 15.3-34.5 34.2-34.5C171.1 107.9 186.4 123.4 186.4 142.4zM181.4 201.3h-57.8V388.1h57.8V201.3zM273.8 201.3h-55.4V388.1h55.4c0 0 0-69.3 0-98 0-26.3 12.1-41.9 35.2-41.9 21.3 0 31.5 15 31.5 41.9 0 26.9 0 98 0 98h57.5c0 0 0-68.2 0-118.3 0-50-28.3-74.2-68-74.2 -39.6 0-56.3 30.9-56.3 30.9v-25.2H273.8z" />
                </svg>
            </span>
        </div>
        <div class="col2">
            <ul>
                <li class="footer-header">Contact Us</li>
                <li>2750 Quadra St Victoria Road, New York, USA</li>
                <li>+1(123) 456 7890</li>
                <li>contact@mariana.com</li>
            </ul>
        </div>
        <div class="col3">
            <ul>
                <li class="footer-header">Support</li>
                <li>Privacy</li>
                <li>FAQ's</li>
                <li>Terms</li>
                <li>Conditions</li>
                <li>Policy</li>
            </ul>
        </div>
        <div class="col4">
            <ul>
                <li class="footer-header">Newsletter</li>
                <li>To get the latest news and latest updates from us</li>
                <li>
                    <form action="">
                        <input type="text" id="newsletter-email" placeholder="Enter Your Email">
                        <div class="input-margin"></div>
                        <button>Subscribe</button>
                </li>
            </ul>
        </div>
    </footer>

    <!-- End Footer-->
</body>

</html>