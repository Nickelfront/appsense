<?php
include_once "../../app/bootstrap.php";

use Util\Template;

$pageName = "New Absence Request";
$templateDir = "public/dashboard"; 

if ($currentUser->get('user_type_id') == 1) {
    returnToPage("index.php");
}
init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>

<div class="app-main__outer">
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-note2 text-success">
                    </i>
                </div>
                <div>Request absence
                    <div class="page-title-subheading">Request some time off. 
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                    <i class="fa fa-star"></i>
                </button>
                <div class="d-inline-block dropdown">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
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
    <div class="widget-content">
        <div class="widget-content-outer">
            <div class="widget-content-wrapper">
                <div class="widget-content-left">
                    <div class="widget-numbers fsize-3 text-muted">
                    <?php
                        $employeeData = $currentUser->getEmployeeData();
                        $used = $employeeData->get('used_days_off');
                        $total = $employeeData->get('available_days_off');
                        echo $used . " out of " . $total . " days off left.";
                    ?>
                    </div>
                </div>
                <div class="widget-content-right">
                    <!-- <div class="text-muted opacity-6">Submitted Tickers</div> -->
                </div>
            </div>
            <div class="widget-progress-wrapper mt-1">
                <div class="progress-bar-sm progress-bar-animated-alt progress">
                    <?php 
                        $percent = $used * 100 / $total;
                        echo '<div class="progress-bar bg-success" role="progressbar" aria-valuenow="' . $percent . '" aria-valuemin="0" aria-valuemax="100" style="width: '. $percent . '%;"></div>';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">New absence request</h5>
            <?php 
                if (isset($_GET['success'])) {
                    echo '<div class="alert alert-success fade show" role="alert">Successfully sent absence request.</div>';
                } else if (isset($_GET['fail'])) {
                    echo '<div class="alert alert-danger fade show" role="alert">Could not send your request. Please make sure that all fields are correct.</div>'; 
                } 
            ?>
            <form class="" action="logic/absence-request.php" method="POST" enctype="multipart/form-data">
                <div class="position-relative row form-group">
                    <label for="fromDate" class="col-sm-2 col-form-label">From</label>
                    <div class="col-sm-10">
                        <!-- TODO placeholder? -->
                        <input name="fromDate" type="date" class="form-control"> 
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="toDate" class="col-sm-2 col-form-label">To</label>
                    <div class="col-sm-10">
                        <input name="toDate" type="date" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group"><label for="absence_type" class="col-sm-2 col-form-label">Absence type:</label>
                    <div class="col-sm-10">
                        <select name="absence_type" id="absence_type" class="form-control">
                            <option selected>--Not selected--</option>
                            <?php
                                $absenceTypePlaceholder = '<option value="{absence_id}">{absence_type}</option> ';
                                $placeholders = array(
                                    "id" => "{absence_id}",
                                    "name" => "{absence_type}"
                                );
                                $absenceTypes = $db->listAll("absence_types");                                            
                                foreach($absenceTypes as $absenceType) {
                                    $data = array(
                                        "id" => $absenceType['id'],
                                        "name" => $absenceType['name']
                                    );
                                    $absenceTypeOption = fillTemplateWithData($absenceTypePlaceholder, $placeholders, $data);
                                    
                                    echo $absenceTypeOption;
                                }
                                
                            ?>

                        </select>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="substitute" class="col-sm-2 col-form-label">Substitute:</label>
                    <div class="col-sm-10">
                        <select name="substitute" id="substitute" class="form-control">
                            <option value="null" selected>No substitute</option>
                            <?php
                                $substitutePlaceholder = '<option value="{substitute_id}">{substitute_name}</option>';
                                $placeholders = array(
                                    "id" => "{substitute_id}",
                                    "name" => "{substitute_name}",
                                );

                                $userColleagues = $currentUser->getColleaguesWithThisPosition();
                                foreach ($userColleagues as $colleague) {
                                    //TODO also check if employee isnt absent too within given period
                                    $substituteUserData = $db->findRecord("users", "id = '" . $colleague->get('user_id') ."'");
                                    $substituteUserData = array(
                                        "id" => $colleague->get('id'),
                                        "name" => $substituteUserData['first_name'] . " " . $substituteUserData['last_name']
                                    );
                                    $substituteOption = fillTemplateWithData($substitutePlaceholder, $placeholders, $substituteUserData);
                                    echo $substituteOption;
                                }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="exampleText" class="col-sm-2 col-form-label">Additional Comment</label>
                    <div class="col-sm-10"><textarea name="comment" id="exampleText" class="form-control"></textarea></div>
                </div>
                <div class="position-relative row form-group">
                    <label for="checkbox2" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <div class="position-relative form-check">
                            <label class="form-check-label">
                                <input id="docCheckbox" type="checkbox" class="form-check-input">
                                Attach a document</label>
                        </div>
                    </div>
                </div>
                <div class="position-relative row form-group" id="document-input" style="display:none;">
                    <label for="absence-document" class="col-sm-2 col-form-label">Document</label>
                    <div class="col-sm-10">
                        <input name="absence-document" id="absence-document" type="file" class="form-control-file">
                        <small class="form-text text-muted">Attach a document for your HR to work with, e.g. a note from your doctor.</small>
                    </div>
                </div>
                <div class="position-relative row form-check">
                    <div class="col-sm-10 offset-sm-2">
                        <button class="btn btn-secondary">Send request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var docCheck = document.getElementById('docCheckbox');

    docCheck.addEventListener("change", () => {
        var display = "none";
        if (docCheck.checked) {
            display = "flex";            
        } 
        setFileUploadOption(display);
    });
    
    var absenceSelect = document.querySelector("#absence_type");
    absenceSelect.addEventListener('change', () => {
        if (!docCheck.checked) {
            var display = "none";
            if (absenceSelect.options[absenceSelect.selectedIndex].text == "Sickness") {
                display = "flex"; 
                docCheck.closest(".form-check").style.display = "none";
            } else {
                docCheck.closest(".form-check").style.display = "flex";

            }
            setFileUploadOption(display); 
        }
    });

    function setFileUploadOption(display) {
        document.querySelector('#document-input').style.display = display;
    }

</script>

<?php 
echo Template::footer($templateDir);