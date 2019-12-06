<?php
include_once "../../app/bootstrap.php";

use entity\Company;
use entity\User;
use Util\Template;

$pageName = "Dashboard | User details";
$templateDir = "public/dashboard"; 

init_dashboard($currentUser, Template::header($pageName, $templateDir));

$userId = isset($_GET['id']) ? $_GET['id'] : $currentUser->get('id');
if (!$currentUser->isColleague($userId)) {
    returnToPage("../forbidden.php");
}
$user = new User($userId);


$icon = $user->get('id') == $currentUser->get('id') ? "user" : "id"

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-<?php echo $icon; ?> icon-gradient bg-sunny-morning">
                        </i>
                    </div>
                    <div>Your details
                        <div class="page-title-subheading">View your details available to everyone who can see your
                            profile.
                        </div>
                    </div>


                </div>
                <div class="page-title-actions">
                    <?php
                        $editButton = '<button type="button" data-toggle="tooltip" title="" data-placement="bottom"
                        class="btn-shadow mr-3 btn btn-dark" data-original-title="Edit details"  onclick="window.open(\'edit-profile.php\', \'_self\');">
                        <i class="fa fa-address-card"></i>
                    </button>';
                        if (!isset($_GET['id']) || $_GET['id'] == $currentUser->get('id')) {
                            echo $editButton;
                        }
                        
                    ?>

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
                                        <img width="100" class="rounded-circle" src="<?php echo $user->get('avatar') ?>"
                                            alt="">
                                    </div>
                                </div>
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading">
                                        <?php
                                            echo $user->get('first_name') . " " . $user->get('last_name');
                                        ?>
                                    </div>
                                    <div class="widget-subheading opacity-7">
                                        <?php 
                                            echo $user->get('email'); 
                                        ?>
                                    </div>
                                    <div class="widget-subheading opacity-7">
                                        <?php 
                                        // show($user);
                                            if ($user->get('user_type_id') == 1) {
                                                echo "Company Owner";
                                            } else {
                                                // show($user->getEmployeeData());
                                                $position = $db->getType("position", $user->getEmployeeData()->get('position_id'));
                                                $company = new Company($user->getEmployeeData()->get('company_id'));
                                                echo $position . " at " . $company->get('name');
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group" style="margin-top: 10px">
                            <li class="list-group-item">Work hours a day:
                                <?php 
                                  echo $user->get('work_hours_a_day'); 
                                ?>
                            </li>
                            <li class="list-group-item">Created at:
                                <?php 
                                    echo $user->get('created_at');
                                ?>
                            </li>
                            <li class="list-group-item">Last update:
                                <?php
                                    $updatedDate = $user->get('updated_at');
                                    $createdDate = $user->get('created_at');
                                    
                                    if (compareStrings($updatedDate, $createdDate)) {
                                        echo "Never";
                                    } else {
                                        echo $updatedDate; 
                                    } 
                                ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
echo Template::footer($templateDir);