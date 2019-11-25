<?php
include_once "../../app/bootstrap.php";

use util\Company;
use Util\Template;
use Util\User;

$pageName = "Dashboard | Company details";
$templateDir = "public/dashboard"; 

if (!isset($_GET['id'])) {
    header("location: index.php");
}

init_dashboard(Template::header($pageName, $templateDir));

$user = new User($_SESSION['userData']);

$company = $db->getCompany($_GET['id']);

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <!-- <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-sunny-morning"></i>
                    </div>
                    <div>Your details
                        <div class="page-title-subheading">View your details available to everyone who can see your profile.</div>
                    </div>                         
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 card">
                    <div class="card-header card-header-tab-animation">
                        <ul class="nav nav-justified">
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-0" class="nav-link active show">Overview</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-1" class="nav-link">Employees</a></li>
                            <!-- <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-2" class="nav-link">Absence Calendar</a></li> -->
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-eg115-0" role="tabpanel">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo $company->get('name'); ?>     
                                    </h5>
                                    <h6 class="mb-0 card-subtitle">
                                        <?php 
                                            $businessId = $company->get('business_type_id'); 
                                            echo $db->getType("business", $businessId);
                                        ?>     
                                    </h6>
                                </div>
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left mr-3">
                                            <div class="widget-content-left">
                                            <img width="100" class="rounded-circle" src="<?php 
                                                $noLogo = "https://i-love-png.com/images/not-available_7305.png";
                                                $companyLogoPath = $company->get('logo'); // TODO add logo field
                                                
                                                echo $companyLogoPath ? $companyLogoPath : $noLogo;
                                            ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="widget-content-left flex2">
                                            <div class="widget-content-left flex2">
                                                <p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                                                <!-- <a href="javascript:void(0);" class="card-link">Card Link</a>
                                                <a href="javascript:void(0);" class="card-link">Another Link</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-eg115-1" role="tabpanel">
                                <!-- <div class="card-body">
                                    <h5 class="card-title">Employees working in 
                                        <?php echo $company->get('name'); ?>
                                    </h5>
                                    <table class="mb-0 table table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Days absent this year</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $employeeRecordPlaceholder = '<tr>
                                                    <th scope="row">{row_number}</th>
                                                    <td>{employee_first_name} {employee_last_name}</td>
                                                    <td>{employee_position}</td>
                                                    <td>{employee_used_days_off}</td>
                                                </tr>'; 
                                                
                                                $employees = $db->listAllEmployees($company->get('id'));
                                                $rowCounter = 1;
                                                foreach ($employees as $employee) {
                                                    $employeeUserId = $employee['user_id'];

                                                    $employeeRow = $employeeRecordPlaceholder;
                                                    $employeeRow = str_replace("{row_number}", $rowCounter++, $employeeRow);
                                                    $employeeRow = str_replace("{employee_first_name}", $db->getUserData($employeeUserId, "first_name"), $employeeRow);
                                                    $employeeRow = str_replace("{employee_last_name}", $db->getUserData($employeeUserId, "last_name"), $employeeRow);
                                                    $employeeRow = str_replace("{employee_position}", $db->getType("position", $employee['position_id']), $employeeRow);
                                                    $employeeRow = str_replace("{employee_used_days_off}", "TODO: ADD row with original count of days off", $employeeRow);
                                                    
                                                    echo $employeeRow;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> -->
                                
                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">      
                                    <?php
                                        $employeeRecordPlaceholder = '<li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="collapse" id="collapseExample123" style="">
                                                <div class="widget-content p-20">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="60" class="rounded-circle" src="{employee_user_img}" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">{employee_first_name} {employee_last_name}</div>
                                                            <div class="widget-subheading opacity-7">Allowance: {employee_allowance}</div>
                                                            <div class="widget-subheading opacity-7">Used {employee_used_days_off} days.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="{employee_user_img}" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">{employee_first_name} {employee_last_name}</div>
                                                        <div class="widget-subheading">{employee_position}</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <button type="button" data-toggle="collapse" href="#collapseExample123" class="btn btn-primary">Show Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>';

                                        $employees = $db->listAllEmployees($company->get('id'));
                                        $rowCounter = 1;
                                        foreach ($employees as $employee) {
                                            $employeeUserId = $employee['user_id'];

                                            $employeeRow = $employeeRecordPlaceholder;
                                            $employeeRow = str_replace("{row_number}", $rowCounter++, $employeeRow);
                                            $firstName = $db->getUserData($employeeUserId, "first_name");
                                            $lastName = $db->getUserData($employeeUserId, "last_name");

                                            $employeePicture = "https://eu.ui-avatars.com/api/?name=$firstName+$lastName";
                                            if ($db->getUserData($employeeUserId, "img")) {
                                                $employeePicture =  $db->getUserData($employeeUserId, "img");
                                            }

                                            $employeeRow = str_replace("{employee_user_img}", $employeePicture, $employeeRow);
                                            $employeeRow = str_replace("{employee_first_name}", $firstName, $employeeRow);
                                            $employeeRow = str_replace("{employee_last_name}", $lastName, $employeeRow);
                                            $employeeRow = str_replace("{employee_position}", $db->getType("position", $employee['position_id']), $employeeRow);
                                            $employeeRow = str_replace("{employee_used_days_off}", "TODO: ADD row with original count of days off", $employeeRow);
                                            
                                            echo $employeeRow;
                                        }

                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $company->get('name'); ?>
                        </h5>
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <div class="widget-content-left">
                                        <img width="100" class="rounded-circle" src="assets/images/avatars/3.jpg" alt="">
                                    </div>
                                </div>
                                <div class="widget-content-left flex2">
                                    <div class="widget-heading"><?php echo $company->get('name')?></div>
                                    
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
echo Template::footer($templateDir);