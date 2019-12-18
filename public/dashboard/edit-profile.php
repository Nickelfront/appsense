<?php
include_once "../../app/bootstrap.php";

use entity\Company;
use Util\Template;

$pageName = "Dashboard | Edit your details";
$templateDir = "public/dashboard"; 

init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-sunny-morning">
                        </i>
                    </div>
                    <div>Edit details
                        <div class="page-title-subheading">Update your picture, your password or the details about you that your colleagues can see.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Your profile</h5>
                        <!-- <div class="alert alert-danger fade show" role="alert">This is a danger alert — check it out!</div> -->
                         <?php 
                            if (isset($_GET['updatedDetails'])) {
                                if ($_GET['updatedDetails'] == 'success') {
                                 echo '<div class="alert alert-success fade show" role="alert">Successfully updated your profile.</div>';
                                } else {
                                    echo '<div class="alert alert-danger fade show" role="alert">Could not update your profile due to empty entries.</div>'; 
                                }
                            } else {
                                echo '<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="close" aria-label="Close"><span aria-hidden="true">×</span></button>There was no data to be updated.</div>';
                            }
                        ?>
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="widget-content-left">
                                        <img width="100" class="rounded-circle" src="<?php echo $currentUser->get('avatar') ? $currentUser->get('avatar') : 'https://eu.ui-avatars.com/api/?name=' . $currentUser->get('first_name') . "+" . $currentUser->get('last_name'); ?>"
                                            alt="">
                                            
                                        <div class="row">
                                            <form action="logic/upload-pic.php" method="POST" enctype="multipart/form-data">
                                                <div class="mt-2 btn-group">
                                                    <button class="btn btn-dark">Change</button>
                                                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-dark">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(52px, 33px, 0px);">
                                                        <button type="button" tabindex="0" class="dropdown-item"id="updatePic" onclick="$('#picInput').click();">Update picture</button>
                                                        <div tabindex="-1" class="dropdown-divider"></div>
                                                        <button type="button" tabindex="0" class="dropdown-item" id="removePic">Remove current picture</button>
                                                    </div>
                                                </div>
                                                <input style="height:0px;display:none;overflow:hidden" type="file" id="picInput" name="user-avatar" accept="image/*"/>
                                                <button class="mt-2 mr-2 btn btn-info" id="update-pic">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading">
                                        <?php
                                            echo $currentUser->get('first_name') . " " . $currentUser->get('last_name');
                                        ?>
                                    </div>
                                    <div class="widget-subheading opacity-7">
                                        <?php 
                                            echo $currentUser->get('email'); 
                                        ?>
                                    </div>
                                    <div class="widget-subheading opacity-7">
                                        <?php 
                                            if ($currentUser->get('user_type_id') == 1) {
                                                echo "Company Owner";
                                            } else {
                                                // show($currentUser);
                                                $position = $db->getType("position", $currentUser->getEmployeeData()->get('position_id'));
                                                $company = new Company($currentUser->getEmployeeData()->get('company_id'));
                                                echo $position . " at " . $company->get('name') ; 
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="card-body">
                            <h5 class="card-title">Personal Details</h5>
                            <div>
                                <form class="" action="./logic/update-user-details.php" method="POST">
                                    <div class="position-relative row form-group">
                                            <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="gender" value="male" type="radio" class="form-check-input" <?php if ($currentUser->get('gender') == 'male') echo "checked"; ?>>Male
                                                    </label>
                                                </div>
                                                <div class="position-relative form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="gender" value="female" type="radio" class="form-check-input" <?php if ($currentUser->get('gender') == 'female') echo "checked"; ?>>Female
                                                    </label>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="new-phone" class="col-sm-2 col-form-label">Phone number</label>
                                        <div class="col-sm-10">
                                            <input name="phone-number" id="new-phone" value="<?php echo $currentUser->get('phone'); ?>" type="text" class="form-control">
                                        </div>
                                    </div>  
                                    <div class="position-relative row form-check">
                                        <div class="col-sm-10 offset-sm-5">
                                            <button class="btn btn-secondary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="divider"></div>
                                <form action="./logic/change-pass.php" id="passwordChange" class="needs-validation" method="POST">
                                    <h5 class="card-title">Change your password</h5>
                                    <?php
                                        if (isset($_GET['changedPassword'])) {
                                            if($_GET['changedPassword'] == 'fail') {
                                                if ($_GET['reason'] == 'wrongPass') $reason = "Incorrect current password.";
                                                if ($_GET['reason'] == 'noMatch') $reason = "The fields for new password did not match.";
                                                if ($_GET['reason'] == 'shortPass') $reason = "The new password must be at least 6 characters long.";
                                                echo '<div class="alert alert-danger fade show" role="alert">' . $reason . '</div>';
                                            } else {
                                                echo '<div class="alert alert-success fade show" role="alert">Successfuly changed password.</div>';
                                            }
                                        }
                                    ?>
                                    <div class="position-relative row form-group">
                                        <label for="currentPassword" class="col-sm-2 col-form-label">Old password</label>
                                        <div class="col-sm-10">
                                            <input name="currentPassword" id="currentPassword" type="password" class="form-control" required>
                                            <div class="invalid-feedback">
                                                You need to type in your current password before changing it.
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="newPassword" class="col-sm-2 col-form-label">New password</label>
                                        <div class="col-sm-10">
                                            <input name="newPassword" id="newPassword" type="password" class="form-control" required>
                                            <div class="invalid-feedback">
                                                New password must not be empty.
                                            </div>  
                                        </div>

                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="confirmedNewPassword" class="col-sm-2 col-form-label">Confirm new password</label>
                                        <div class="col-sm-10">
                                            <input name="confirmedNewPassword" id="confirmedNewPassword" type="password" class="form-control" required>
                                            <div class="invalid-feedback">
                                                Please confirm your new password.
                                            </div>  
                                        </div>
                                    </div>
                                   
                                    <div class="position-relative row form-check">
                                        <div class="col-sm-10 offset-sm-5">
                                            <button class="btn btn-secondary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
echo Template::footer($templateDir);