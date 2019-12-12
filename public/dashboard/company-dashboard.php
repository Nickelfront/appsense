<?php
include_once "../../app/bootstrap.php";

use entity\Employee;
use Util\Template;

$pageName = "Dashboard";
$templateDir = "public/dashboard"; 

if (!$_SESSION['loggedIn'] || !isset($_SESSION['loggedIn'])) {
    returnToPage("../forbidden.php");
}

init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-display1 icon-gradient bg-happy-fisher">
                        </i>
                    </div>
                    <div>Dashboard
                        <div class="page-title-subheading">Welcome back! You're all set to start catching up on your companies' activities.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Work Hours</div>
                                <div class="widget-subheading">Time your employees worked</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-success" id="totalWorkHours"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">Total Absences</div>
                                <div class="widget-subheading">All of your employees' time off</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-warning" id="totalAbsences"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card mb-3 widget-content">
                    <div class="widget-content-outer">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="widget-heading">Pending absence requests</div>
                                <div class="widget-subheading">Not yet viewed by your HRs</div>
                            </div>
                            <div class="widget-content-right">
                                <div class="widget-numbers text-danger" id="totalPendingRequests"></div>
                            </div>
                        </div>
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
                                    <button type="button" onclick="location.href=`edit-company.php?id={clu_company_id}`" class="mr-2 btn-icon btn-icon-only btn btn-primary"><i class="pe-7s-pen btn-icon-wrapper"></i></button>
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

                                // $companies = $db->getUserCompanies($user->get("id"));
                                $companies = $currentUser->getCompanies();
                                // show($companies);

                                $idCounter = 1;
                                foreach ($companies as $company) {
                                    $companyDetailsHTML = $companiesTableTemplate;
                                    $companyDetailsHTML = str_replace("{company_no}", $idCounter++, $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyIdPlaceHolder, $company->get('id'), $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyNamePlaceHolder, $company->get('name'), $companyDetailsHTML);
                                
                                    $logo = $company->get('logo') ? $company->get('logo') : "https://i-love-png.com/images/not-available_7305.png";
                                    $hrResults = $company->get('human_resources') ? $company->get('human_resources') : "<i>Not set</i>";
                                    $activityColor = $company->get('status') == "active" ? "success" : "danger";

                                    $companyDetailsHTML = str_replace($companyLogoPlaceHolder, $logo, $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyHrPlaceHolder, $hrResults, $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyBusinessTypePlaceHolder, $company->get('business_type'), $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyStatusPlaceHolder, $company->get('status'), $companyDetailsHTML);
                                    $companyDetailsHTML = str_replace($companyActivityPlaceHolder, $activityColor, $companyDetailsHTML);
                                    
                                    echo $companyDetailsHTML;
                                    if ($idCounter > 6) break;
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
                        <button class="btn-wide btn btn-primary" onclick="window.open('companies.php', '_self');">See all companies</button>
                        <button class="btn-wide btn btn-outline-info" onclick="window.open('add-company.php', '_self');">Add new company</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                            Absence Stats from all Companies
                        </div>
                        <ul class="nav">
                            <!-- <li class="nav-item"><a href="javascript:void(0);" class="active nav-link">Last</a></li> -->
                            <!-- <li class="nav-item"><a href="javascript:void(0);"
                                    class="nav-link second-tab-toggle">Current</a></li> -->
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tabs-eg-77">
                                <div class="card mb-3 widget-chart widget-chart2 text-left w-100">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                                            <canvas id="most-absences"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">Most absences</h6>
                                <div class="scroll-area-sm">
                                    <div class="scrollbar-container">
                                        <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                        <?php
                                                $template = '<li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left mr-3">
                                                            <img width="42" class="rounded-circle"
                                                                src="{employee_avatar}" alt="">
                                                        </div>
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">{employee_name}</div>
                                                            <div class="widget-subheading">{employee_position}</div>
                                                        </div>
                                                        <div class="widget-content-right">
                                                            <div class="font-size-xlg text-muted">
                                                                <span>{employee_absence_count}</span>
                                                                <small class="text-warning pl-2">
                                                                    <i class="fa fa-sun"></i>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>';
                                            $placeholders = array(
                                                "name" => "{employee_name}",
                                                "avatar" => "{employee_avatar}",
                                                "position" => "{employee_position}",
                                                "count" => "{employee_absence_count}",
                                                // "type" => "{absence_type}"
                                            );

                                            $query = "SELECT e.id FROM employees e JOIN companies c ON e.company_id = c.id WHERE c.owner_id = " . $currentUser->get('id') . " ORDER BY used_days_off DESC LIMIT 5";
                                            $results = $db->searchInDB($query);
                                                // show($results);

                                            foreach ($results as $result) {
                                                $employee = new Employee($result['id']);
                                                $userData = $employee->getUserData();
                                                $firstName = $userData->get('first_name');
                                                $lastName = $userData->get('last_name');
                                                $employeeName = $firstName . " " . $lastName;
                                                $employeeData = array(
                                                    "name" => $employeeName,
                                                    "avatar" => "https://eu.ui-avatars.com/api/?name=$firstName+$lastName",
                                                    "position" => $employee->getPosition(),
                                                    "count" => $employee->get('used_days_off'),
                                                );
                                                echo fillTemplateWithData($template, $placeholders, $employeeData);
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-rocket icon-gradient bg-tempting-azure"> </i>
                            Bandwidth Reports
                        </div>
                        <div class="btn-actions-pane-right">
                            <div class="nav">
                                <a href="javascript:void(0);"
                                    class="border-0 btn-pill btn-wide btn-transition active btn btn-outline-alternate">Tab
                                    1</a>
                                <a href="javascript:void(0);"
                                    class="ml-1 btn-pill btn-wide border-0 btn-transition  btn btn-outline-alternate second-tab-toggle-alt">Tab
                                    2</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-eg-55">
                            <div class="widget-chart p-3">
                                <div style="height: 350px">
                                    <canvas id="line-chart"></canvas>
                                </div>
                                <div class="widget-chart-content text-center mt-5">
                                    <div class="widget-description mt-0 text-warning">
                                        <i class="fa fa-arrow-left"></i>
                                        <span class="pl-1">175.5%</span>
                                        <span class="text-muted opacity-8 pl-1">increased server resources</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 card-body">
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var config = {
        headers: {
            "user-token": "<?php echo $_SESSION['login_token']; ?>"
        }
    }
    $(document).ready( () => {

        var absencesChartEl = document.querySelector('#most-absences').getContext('2d');
        var absencesChart = new Chart(absencesChartEl, {
            type: 'bar',
            data: {
                labels: ['Vacations', 'Sickness', 'School', 'Work from Home'],
                datasets: [{
                    
                    data: [],
                    backgroundColor: [
                        'rgba(44, 200, 77, 0.8)',
                        'rgba(205, 0, 26, 0.8)',
                        'rgba(255, 215, 0, 0.8)',
                        'rgba(113, 197, 232, 0.8)'
                    ]
                }],
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            // beginAtZero: true
                            min: 0,
                            stepSize: 1
                        }
                    }]
                }
            }
        });

        getAbsenceStats(absencesChart);
        getStats();

    });


    function getStats() {
        axios.get('../endpoints/totals.php', config)
            .then(function (response) {
                // handle success
                $("#totalAbsences").text(response.data.totalAbsences);
                $("#totalPendingRequests").text(response.data.totalPendingRequests);
                $("#totalWorkHours").text(response.data.totalWorkHours);
                console.log(response.data);
            })
            .catch(function (error) {
                // handle error
                $("#totalAbsences").text("N/A");
                $("#totalPendingRequests").text("N/A");
                $("#totalWorkHours").text("N/A");
                console.log(error);
            })
            .finally(function () {
                setTimeout(getStats, 20000);
            }
        );
    }
    
    function getAbsenceStats(absenceChart) {
        axios.get('../endpoints/absence_types_stats.php', config)
            .then(function (response) {
                // handle success
                var absences = response.data;
                console.log(absences);
                console.log(absenceChart.data.datasets);
                
                absenceChart.data.datasets[0].data.push(absences.vacation);
                absenceChart.data.datasets[0].data.push(absences.sickness);
                absenceChart.data.datasets[0].data.push(absences.school);
                absenceChart.data.datasets[0].data.push(absences.home);
                
                absenceChart.update();
            })
            .catch(function (error) {
                // handle error
                // document.querySelector("#totalAbsences").innerHTML = "N/A";
                // document.querySelector("#totalPendingRequests").innerHTML = "N/A";
                // document.querySelector("#totalWorkHours").innerHTML = "N/A";
                console.log(error);
            })
            .finally(function () {
                setTimeout(getAbsenceStats, 20000);
            }
        );
    }


        // var barChartData = {
        //     labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        //     datasets: [{
        //         label: 'Dataset 1',
        //         backgroundColor: [
        //             window.chartColors.red,
        //             window.chartColors.orange,
        //             window.chartColors.yellow,
        //             window.chartColors.green,
        //             window.chartColors.blue,
        //             window.chartColors.purple,
        //             window.chartColors.red
        //         ],
        //         yAxisID: 'y-axis-1',
        //         data: [
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor()
        //         ]
        //     }, {
        //         label: 'Dataset 2',
        //         backgroundColor: window.chartColors.grey,
        //         yAxisID: 'y-axis-2',
        //         data: [
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor(),
        //             randomScalingFactor()
        //         ]
        //     }]

        // };

        //     var ctx = document.getElementById('canvas').getContext('2d');
        //     window.myBar = new Chart(ctx, {
        //         type: 'bar',
        //         data: barChartData,
        //         options: {
        //             responsive: true,
        //             title: {
        //                 display: true,
        //                 text: 'Chart.js Bar Chart - Multi Axis'
        //             },
        //             tooltips: {
        //                 mode: 'index',
        //                 intersect: true
        //             },
        //             scales: {
        //                 yAxes: [{
        //                     type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
        //                     display: true,
        //                     position: 'left',
        //                     id: 'y-axis-1',
        //                 }, {
        //                     type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
        //                     display: true,
        //                     position: 'right',
        //                     id: 'y-axis-2',
        //                     gridLines: {
        //                         drawOnChartArea: false
        //                     }
        //                 }],
        //             }
        //         }
        //     });
   
    </script>

    <?php
echo Template::footer($templateDir);