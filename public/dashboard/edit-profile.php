<?php
include_once "../../app/bootstrap.php";

use entity\Company;
use Util\Template;

$pageName = "Dashboard | User details";
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
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="widget-content-left">
                                        <img width="100" class="rounded-circle" src="<?php echo $currentUser->get('avatar') ?>"
                                            alt="">
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
                                <form action="./logic/change-pass.php" method="POST">
                                    <h5 class="card-title">Change your password</h5>
                                    <div class="position-relative row form-group">
                                        <label for="currentPassword" class="col-sm-2 col-form-label">Old password</label>
                                        <div class="col-sm-10"><input name="currentPassword" id="currentPassword" type="password" class="form-control"></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="newPassword" class="col-sm-2 col-form-label">New password</label>
                                        <div class="col-sm-10"><input name="newPassword" id="newPassword" type="password" class="form-control"></div>
                                    </div>
                                    <div class="position-relative row form-group">
                                        <label for="confirmedNewPassword" class="col-sm-2 col-form-label">Confirm new password</label>
                                        <div class="col-sm-10"><input name="confirmedNewPassword" id="confirmedNewPassword" type="password" class="form-control"></div>
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