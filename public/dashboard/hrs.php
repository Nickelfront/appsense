<?php
include_once "../../app/bootstrap.php";

use entity\User;
use Util\Template;

$pageName = "Dashboard";
$templateDir = "public/dashboard"; 

init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users icon-gradient bg-happy-fisher">
                        </i>
                    </div>
                    <div>Human Resources Departments
                        <div class="page-title-subheading">View and manage HR Departments for each one of your companies.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="accordion" class="accordion-wrapper mb-3">
                    <?php
                        $companyPlaceholder = '<div class="card">
                            <div id="heading{company_id}" class="card-header">
                                <button type="button" data-toggle="collapse" data-target="#collapse{company_id}" aria-expanded="false" aria-controls="collapse{company_id}" class="text-left m-0 p-0 btn btn-link btn-block collapsed">
                                    <h5 class="m-0 p-0">{company_name}</h5>
                                </button>
                            </div>
                            <div data-parent="#accordion" id="collapse{company_id}" aria-labelledby="heading{company_id}" class="collapse" style="">
                                <div class="card-body">
                                    <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                        {hr_data_html}                                
                                    </ul>
                                </div>
                            </div>
                        </div>';
                        $hrPlaceholder = '<li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <img width="42" class="rounded-circle" src="{hr_picture}" alt="">
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">{hr_name}</div>
                                    <div class="widget-subheading">{hr_email}</div>
                                </div>
                                <div class="widget-content-right">
                                    <button type="button" onclick="window.open(`user-details.php?id={hr_id}`, `_self`)" class="btn btn-primary">Open Profile</button>
                                </div>
                            </div>
                        </div>
                    </li>';

                    // $addNewHRHTML = '<div class="d-block text-center card-footer">
                    //     <button class="btn-wide btn btn-primary" onclick="window.open(`assign-hr.php`, `_self`);">Assign new HR</button>
                    // </div>';
                    $companies = $currentUser->getCompanies();
                    $companyPlaceholders = array(
                        "id" => "{company_id}",
                        "name" => "{company_name}",
                        "hr_html" => "{hr_data_html}"
                    );

                    $hrPlaceholders = array(
                        "id" => "{hr_id}",
                        "name" => "{hr_name}",
                        "email" => "{hr_email}",
                        "picture" => "{hr_picture}",
                    );
                   
                    foreach($companies as $company) {
                        $hrsList = $company->getHumanResourcesEmployees();
                        $hrsData = "";
                        if (empty($hrsList)) {
                            $hrsData = "<p class='text-center'><i>Currently you have no HRs for this company.</i></p>";
                        }
                        foreach($hrsList as $hr) {
                            $hrUserId = $hr->get('user_id');
                            $hrUserData = new User($hrUserId);

                            $firstName = $hrUserData->get("first_name");
                            $lastName = $hrUserData->get("last_name");
                            $hrPicture = "https://eu.ui-avatars.com/api/?name=$firstName+$lastName";
                            
                            if ($hrUserData->get("avatar")) {
                                $hrPicture = $hrUserData->get("avatar");
                            }

                            $hrData = array(
                                "id" => $hrUserId,
                                "name" => $firstName . " " . $lastName,
                                "email" => $hrUserData->get('email'),
                                "picture" => $hrPicture
                            );
                            $hrsData .= fillTemplateWithData($hrPlaceholder, $hrPlaceholders, $hrData);
                        }
                        // $hrsData .= $addNewHRHTML;
                        $companyData = array(
                            "id" => $company->get('id'),
                            "name" => $company->get('name'),
                            "hr_html" => $hrsData
                        );
                        $companyInfo = "";
                        $companyInfo = fillTemplateWithData($companyPlaceholder, $companyPlaceholders, $companyData);

                        echo $companyInfo;
                    }
                    ?>
                </div>
            </div>
        </div>
                    

<?php
echo Template::footer($templateDir);