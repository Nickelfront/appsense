<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Create an account | AppSense</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/register.css" rel="stylesheet" media="all">
</head>
<body>
<?php
include_once "../app/bootstrap.php";

    session_start();

    $firstName = '';
    $lastName = '';
    $birthDate = '';
    $gender = 'male';
    $email = '';
    $phone = '';

    $warningSign = ''; // nothing if nothing's been submitted
    if (isset($_GET['invalid'])) {
        
        // show($_SESSION['errorMessages']);
        if (isset($_SESSION['oldValues'])) {
            $oldValues = $_SESSION['oldValues'];
            
            $firstName = $oldValues['first_name'];
            $lastName = $oldValues['last_name'];
            $gender = $oldValues['gender'];
            $birthDate = $oldValues['birthday'];
            $email = $oldValues['email'];
            $phone = $oldValues['phone'];
        } 
        $errors = $_SESSION['errorMessages'];
        $warningSign = '<i class="fa fa-exclamation-circle" style="color: red"></i>';
        $errorMessageHTML = "<a style='color:red'>{ERROR_MESSAGE}</a>";

        // if (array_key_exists("/general.*/", $errors)) {
            // TODO alert or some other kind of message that says that all fields are required.
        // }
    }

?>
    <!-- TODO fix padding of forms when displaying error messages -->
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Create an Account</h2>
                    <form method="POST" action="./logic/register.php">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">first name
                                    <?php 
                                        if (isset($errors)) {
                                            if (array_key_exists('general_first_name', $errors)) {
                                                echo $warningSign;
                                    ?>
                                    </label>
                                    <?php
                                                // $html = str_replace("{ERROR_MESSAGE}", $errors['general_first_name'], $errorMessageHTML);
                                                // echo $html; 
                                            }     
                                        }               
                                    ?>
                                    <input class="input--style-4" type="text" name="first_name" value="<?php echo $firstName; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">last name
                                    <?php 
                                        if (isset($errors)) {
                                            if (array_key_exists('general_last_name', $errors)) {
                                                echo $warningSign;
                                    ?>
                                    </label>
                                    <?php
                                                // $html = str_replace("{ERROR_MESSAGE}", $errors['general_last_name'], $errorMessageHTML);
                                                // echo $html; 
                                            }     
                                        }               
                                    ?>
                                    <input class="input--style-4" type="text" name="last_name" value="<?php echo $lastName; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Birthday
                                    <?php 
                                        if (isset($errors)) {
                                            if (array_key_exists('birthday', $errors)) {
                                                echo $warningSign;
                                            ?>
                                        </label>
                                        <?php
                                                $html = str_replace("{ERROR_MESSAGE}", $errors['birthday'], $errorMessageHTML);
                                                echo $html; 
                                            } else if (array_key_exists('general_birthday', $errors)) {
                                                echo $warningSign;
                                            }     
                                        }               
                                        ?>
                                    <div class="input-group-icon">
                                        <input class="input--style-4 js-datepicker" type="text" name="birthday" autocomplete="off" value="<?php echo $birthDate; ?>">
                                        <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" value="male" <?php
                                                if ($gender == "male") {
                                                    echo 'checked="checked"'; // compatibility with older browsers
                                                }
                                            ?> name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" value="female" <?php 
                                                if ($gender == "female") {
                                                    echo 'checked="checked"'; // compatibility with older browsers
                                                }
                                            ?> name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email
                                    <?php 
                                    if (isset($errors)) {
                                        if (array_key_exists('email', $errors)) {
                                            echo $warningSign;
                                        ?>
                                    </label>
                                    <?php
                                            $html = str_replace("{ERROR_MESSAGE}", $errors['email'], $errorMessageHTML);
                                            echo $html; 
                                        } else if (array_key_exists('general_email', $errors)) {
                                            echo $warningSign;
                                        }     
                                    }                    
                                    ?>
                                    <input class="input--style-4" type="text" name="email"  value="<?php echo $email; ?>">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number
                                        <?php 
                                        if (isset($errors)) {    
                                            if (array_key_exists('phone', $errors)) {
                                                echo $warningSign;
                                        ?>
                                        </label>
                                        <?php
                                                $html = str_replace("{ERROR_MESSAGE}", $errors['phone'], $errorMessageHTML);
                                                echo $html; 
                                            } else if (array_key_exists('general_phone', $errors)) {
                                                echo $warningSign;
                                            }     
                                        }                    
                                        ?>
                                    <input class="input--style-4" type="text" name="phone" value="<?php echo $phone; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Password
                                    <?php 
                                        if (isset($errors)) {   
                                            if (array_key_exists('password', $errors)) {
                                                echo $warningSign;
                                        ?>
                                        </label>
                                        <?php
                                                $html = str_replace("{ERROR_MESSAGE}", $errors['password'], $errorMessageHTML);
                                                echo $html; 
                                            } else if (array_key_exists('general_password', $errors)) {
                                                echo $warningSign;
                                            }     
                                        }                    
                                        ?>                        
                                    <input class="input--style-4" type="password" name="password">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Confirm password
                                    <?php 
                                        if (isset($errors)) {    
                                            if (array_key_exists('conf_pass', $errors)) {
                                                echo $warningSign;
                                        ?>
                                        </label>
                                        <?php
                                                $html = str_replace("{ERROR_MESSAGE}", $errors['conf_pass'], $errorMessageHTML);
                                                echo $html; 
                                            } else if (array_key_exists('general_conf_pass', $errors)) {
                                                echo $warningSign;
                                            }     
                                        }                    
                                        ?>                        
                                    <input class="input--style-4" type="password" name="conf_pass">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="input-group">
                            <label class="label">Subject</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="subject">
                                    <option disabled="disabled" selected="selected">Choose option</option>
                                    <option>Subject 1</option>
                                    <option>Subject 2</option>
                                    <option>Subject 3</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div> -->
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global_register.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->