<?php
include_once "../../app/bootstrap.php";

use Util\Template;

$pageName = "Companies";
$templateDir = "public/dashboard"; 

init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-global icon-gradient bg-happy-fisher">
                        </i>
                    </div>
                    <div>Your companies
                        <div class="page-title-subheading">View and manage all of your companies.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Your Companies
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm btn-group">
                                <button class="active btn btn-focus">Active</button>
                                <button class="btn btn-focus">All</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Company</th>
                                    <th class="text-center">HR</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <?php 
                                    $companiesTableTemplate = '<td class="text-center text-muted">{company_no}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle" src="{clu_company_logo}" alt="{clu_company_name}">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading">{clu_company_name}</div>
                                                    <div class="widget-subheading opacity-7">{clu_business_type}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{clu_company_hr}</td>
                                    <td class="text-center">
                                        <div class="badge badge-{clu_company_activity}">{clu_company_status}</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" onclick="location.href=`company-details.php?id={clu_company_id}`" id="details_{clu_company_id}" class="details-btn btn btn-outline-info btn-sm">Details</button>
                                        <button type="button" onclick="location.href=`calendar.php?id={clu_company_id}`" class="mr-2 btn-icon btn-icon-only btn btn-success"><i class="pe-7s-date btn-icon-wrapper"></i></button>
                                        <button type="button" class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i class="pe-7s-pen btn-icon-wrapper"></i></button>
                                    </td>
                                </tr>'; 
                                
                                $companyIdPlaceHolder = "{clu_company_id}";
                                $companyNamePlaceHolder = "{clu_company_name}";
                                $companyHrPlaceHolder = "{clu_company_hr}";
                                $companyLogoPlaceHolder = "{clu_company_logo}";
                                $companyBusinessTypePlaceHolder = "{clu_business_type}";
                                $companyStatusPlaceHolder = "{clu_company_status}";
                                $companyActivityPlaceHolder = "{clu_company_activity}";

                                $noCompaniesHTML = '<p class="text-center">You have no companies.</p>';

                                $companies = $currentUser->getCompanies();

                                $idCounter = 1;
                                foreach ($companies as $company) {
                                    $companyDetailsHTML = $companiesTableTemplate;
                                    $companyDetailsHTML = str_replace("{company_no}", $idCounter++, $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyIdPlaceHolder, $company->get('id'), $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyNamePlaceHolder, $company->get('name'), $companyDetailsHTML);
                                
                                    $topHR = null;
                                    try {
                                        $topHR = $company->getFirstHR()->getUserData(); 
                                    } catch(Error $e) {
                                    }
                                    if ($topHR != null) $topHRname = $topHR->get('first_name') . " " . $topHR->get('last_name');

                                    $logo = $company->get('logo') ? $company->get('logo') : "https://i-love-png.com/images/not-available_7305.png";
                                    $hrResults = $topHR ? $topHRname : "<i>Not set</i>";
                                    $activityColor = $company->get('status') == "active" ? "success" : "danger";

                                    $companyDetailsHTML = str_replace($companyLogoPlaceHolder, $logo, $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyHrPlaceHolder, $hrResults, $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyBusinessTypePlaceHolder, $company->get('business_type'), $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyStatusPlaceHolder, $company->get('status'), $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyActivityPlaceHolder, $activityColor, $companyDetailsHTML);
                                    
                                    echo $companyDetailsHTML;
                                }

                            ?>

                                </tr>
                            </tbody>
                        </table>
                        <?php
                        if (!$companies) {
                            echo $noCompaniesHTML;
                        }
                    ?>
                    </div>
                    <div class="d-block text-center card-footer">
                        <!-- <button class="mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i class="pe-7s-trash btn-icon-wrapper"> </i></button> -->
                        <button class="btn-wide btn btn-info" onclick="window.open('add-company.php', '_self');">Add new
                            company</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php
echo Template::footer($templateDir);