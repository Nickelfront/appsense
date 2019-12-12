<?php
include_once "../../app/bootstrap.php";

use entity\Company;
use Util\Template;

$pageName = "Dashboard | Company details";
$templateDir = "public/dashboard"; 

if (!isset($_GET['id'])) {
    header("location: index.php");
}

init_dashboard($currentUser, Template::header($pageName, $templateDir));

$company = new Company($_GET['id']);

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-global icon-gradient bg-sunny-morning"></i>
                    </div>
                    <div>Company details
                        <div class="page-title-subheading">View your details available to everyone who can see your
                            profile.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 card">
                    <div class="card-header card-header-tab-animation">
                        <ul class="nav nav-justified">
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-0"
                                    class="nav-link active show">Overview</a></li>
                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-1" class="nav-link">Employees</a>
                            </li>
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
                                                <p>Total employees: <?php echo count($company->getAllEmployees()); ?></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-eg115-1" role="tabpanel">
                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                    <?php
                                        $employeeRecordPlaceholder = '<li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="collapse" id="collapseExample{row_number}" style="">
                                                <div class="widget-content p-20">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <div class="widget-content-left">
                                                                <img width="60" class="rounded-circle" src="{employee_user_img}" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading">{employee_first_name} {employee_last_name}</div>
                                                            <div class="widget-subheading opacity-7">Allowance: {employee_allowance} days.</div>
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
                                                        <button type="button" data-toggle="collapse" href="#collapseExample{row_number}" class="btn btn-primary">Show Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>';

                                        $employees = $company->getAllEmployees();
                                        $employeePlaceholders = array(
                                            "row_number" => "{row_number}", 
                                            "first_name" => "{employee_first_name}",
                                            "last_name" => "{employee_last_name}",
                                            "position" => "{employee_position}",
                                            "allowance" => "{employee_allowance}",
                                            "used_days_off" => "{employee_used_days_off}",
                                            "img" => "{employee_user_img}"
                                        );
                                        
                                        $rowCounter = 1;
                                        foreach ($employees as $employee) {
                                            $employeeId = $employee->get('id');
                                            $employeeUser = $employee->getUserData();

                                            $firstName = $employeeUser->get("first_name");
                                            $lastName = $employeeUser->get("last_name");

                                            $employeePicture = "https://eu.ui-avatars.com/api/?name=$firstName+$lastName";
                                            if ($employeeUser->get("avatar")) {
                                                $employeePicture = $employeeUser->get("avatar");
                                            }
                                            
                                            $employeeInfo = array(
                                                "row_number" => $rowCounter++,
                                                "first_name" => $firstName,
                                                "last_name" => $lastName,
                                                "position" => $db->getType("position", $employee->get('position_id')),
                                                "allowance" => $employee->get('available_days_off'),
                                                "used_days_off" => $employee->get('used_days_off'),
                                                "img" => $employeePicture
                                            );
                                            $employeeRow = fillTemplateWithData($employeeRecordPlaceholder, $employeePlaceholders, $employeeInfo);

                                            // $employeeRow = str_replace("{row_number}", $rowCounter++, $employeeRow);
                                            echo $employeeRow;
                                        }

                                    ?>
                                </ul>
                                <div class="d-block text-center card-footer">
                                    <!-- <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i class="pe-7s-trash btn-icon-wrapper"> </i></button> -->
                                    <button class="btn-wide btn btn-info" onclick="window.open('add-employee.php?id=<?php echo $_GET['id']?>', '_self');">Add new
                                        employee</button>
                                </div>
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