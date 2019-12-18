<?php
include_once "../../app/bootstrap.php";

use Util\Template;

$pageName = "Dashboard | Add employee";
$templateDir = "public/dashboard"; 

init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-add-user icon-gradient bg-plum-plate">
                        </i>
                    </div>
                    <div>Add a new Employee
                        <div class="page-title-subheading">Have you hired someone new in your company? Register them
                            here.
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                    <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom"
                        class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-star"></i>
                    </button>
                    <div class="d-inline-block dropdown">
                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            class="btn-shadow dropdown-toggle btn btn-info">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-business-time fa-w-20"></i>
                            </span>
                            Buttons
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <i class="nav-link-icon lnr-inbox"></i>
                                        <span>
                                            Inbox
                                        </span>
                                        <div class="ml-auto badge badge-pill badge-secondary">86</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <i class="nav-link-icon lnr-book"></i>
                                        <span>
                                            Book
                                        </span>
                                        <div class="ml-auto badge badge-pill badge-danger">5</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <i class="nav-link-icon lnr-picture"></i>
                                        <span>
                                            Picture
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a disabled href="javascript:void(0);" class="nav-link disabled">
                                        <i class="nav-link-icon lnr-file-empty"></i>
                                        <span>
                                            File Disabled
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Employee Registration Form</h5>
                                <form action="logic/add-employee.php" method="POST" class="needs-validation">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="position-relative form-group">
                                                <label for="firstNameInput" class="">First name</label>
                                                <input name="first_name" id="firstNameInput" type="text" class="form-control" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid first name.
                                                </div>  
                                            </div>
                                            <div class="position-relative form-group">
                                                <label for="lastNameInput" class="">Last name</label>
                                                <input name="last_name" id="lastNameInput" type="text" class="form-control" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid last name.
                                                </div>  
                                            </div>
                                            <div class="position-relative form-group">
                                                <label for="emailInput" class="">Email</label>
                                                <input name="email" id="emailInput" placeholder="user@example.com" type="email"
                                                    class="form-control" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid email.
                                                </div>  
                                            </div>
                                            <div class="position-relative form-group">
                                                <label for="genderInput" class="">Gender</label>
                                                <div>
                                                    <div class="custom-radio custom-control custom-control-inline">
                                                        <input type="radio" name="gender" value="male" id="genderMale" class="custom-control-input">
                                                        <label class="custom-control-label" for="genderMale">Male</label>
                                                    </div>

                                                    <div class="custom-radio custom-control custom-control-inline">
                                                        <input type="radio" name="gender" value="female" id="genderFemale" class="custom-control-input">
                                                        <label class="custom-control-label" for="genderFemale">Female</label>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="position-relative form-group">
                                                <label for="phoneInput" class="">Phone number</label>
                                                <input name="phone" id="phoneInput" type="text" class="form-control">
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="position-relative form-group">
                                                <label for="companyChoice" class="">Company</label>
                                                <select name="company" id="companyChoice" class="form-control" required>
                                                <?php
                                                    $companyOptionTemplate = '<option value="{clu_company_id}"{selected_option}>{clu_company_name}</option>';
                                                    $userCompanies = $currentUser->getCompanies();
                                                    $companyOptionPlaceholders = array(
                                                        "id" => "{clu_company_id}",
                                                        "name" => "{clu_company_name}",
                                                        "selected" => "{selected_option}"
                                                    );
                                                    
                                                    foreach ($userCompanies as $company) {
                                                        $selected = "";
                                                        if (isset($_GET['id']) && $_GET['id'] == $company->get('id')) {
                                                            $selected = "selected";
                                                        }
                                                        $companyInfo = array(
                                                            "id" => $company->get('id'),
                                                            "name" => $company->get('name'),
                                                            "selected" => $selected
                                                        );

                                                        $companyOption = fillTemplateWithData($companyOptionTemplate, $companyOptionPlaceholders, $companyInfo);                                                
                                                        echo $companyOption;
                                                    }
                                                ?>
                                                </select>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid company.
                                                </div> 
                                            </div>

                                            <div class="position-relative form-group">
                                                <label for="positionChoice" class="">Position</label>
                                                <!-- <input name="position" id="position" placeholder="" type="text"
                                                    class="form-control"> -->
                                                <select name="position" id="positionChoice" class="form-control" required>
                                                    <option value="null">-- Not selected --</option>
                                                <?php
                                                    $positionOptionPlaceholder = "<option value={position_id}>{position_name}</option>";
                                                    // $companyPositions = $db->getPositionsForCompany($company->get('id'));
                                                    $positions = $db->listAll("position_types");
                                                    
                                                    foreach ($positions as $position) {
                                                        if ($position['id'] == 1) continue;

                                                        $positionOption = $positionOptionPlaceholder;
                                                        $positionOption = str_replace("{position_id}", $position['id'], $positionOption);
                                                        $positionOption = str_replace("{position_name}", $position['name'], $positionOption);
                                                        echo $positionOption;
                                                    }
                                                ?>
                                                </select>
                                                 <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid position.
                                                </div> 
                                            </div>
                                            <div class="position-relative form-group">
                                                <label for="workHoursInput" class="">Work Hours per Day</label>
                                                <input name="work_hours_per_day" id="workHoursInput" type="number" min="1"
                                                    max="13" class="form-control" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide valid work hours.
                                                </div> 
                                            </div>
                                            <div class="position-relative form-group">
                                                <label for="availableDaysOffInput" class="">Available Days off</label>
                                                <input name="available_days_off" id="availableDaysOffInput" type="number"
                                                    min="0" max="28" class="form-control" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                <div class="invalid-feedback">
                                                    Please provide a valid amount of days off.
                                                </div> 
                                            </div>
                                            <div class="position-relative form-group">
                                                <label for="messageToEmployee" class="">Message to employee (optional)</label>
                                                <textarea name="text" id="messageToEmployee" class="form-control"></textarea>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>

                                    </div>  
                                    <button class="mt-1 btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
        
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                                
                    </script>
                </form>
            </div>
        </div>
    </div>  
    <?php 
echo Template::footer($templateDir);