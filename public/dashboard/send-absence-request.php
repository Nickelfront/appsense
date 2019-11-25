<?php
include_once "../../app/bootstrap.php";

use Util\Template;
use util\User;

$pageName = "New Absence Request";
$templateDir = "public/dashboard"; 

init_dashboard(Template::header($pageName, $templateDir));
$user = new User($_SESSION['userData']);

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
    <div class="main-card mb-3 card">
        <div class="card-body"><h5 class="card-title">Grid</h5>
            <form class="">
                <div class="position-relative row form-group">
                    <label for="fromDate" class="col-sm-2 col-form-label">From</label>
                    <div class="col-sm-10">
                        <input name="fromDate" type="date" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group">
                    <label for="toDate" class="col-sm-2 col-form-label">To</label>
                    <div class="col-sm-10">
                        <input name="toDate" type="date" class="form-control">
                    </div>
                </div>
                <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">Absence type:</label>
                    <div class="col-sm-10">
                        <select name="select" id="exampleSelect" class="form-control">
                            <option selected>--Not selected--</option>
                            <?php
                                $absenceTypePlaceholder = '<option value="{absence_id}">{absence_type}</option> ';
                                
                                $absenceTypes = $db->listAll("absence_types");                                            
                                foreach($absenceTypes as $absenceType) {
                                    $absenceTypeOption = $absenceTypePlaceholder;
                                    $absenceTypeOption = str_replace("{absence_id}", $absenceType['id'], $absenceTypeOption);
                                    $absenceTypeOption = str_replace("{absence_type}", $absenceType['name'], $absenceTypeOption);
                                    
                                    echo $absenceTypeOption;
                                }
                                
                            ?>

                        </select>
                    </div>
                </div>
                <div class="position-relative row form-group"><label for="exampleSelectMulti" class="col-sm-2 col-form-label">Select Multiple</label>
                    <div class="col-sm-10"><select multiple="" name="selectMulti" id="exampleSelectMulti" class="form-control"></select></div>
                </div>
                <div class="position-relative row form-group"><label for="exampleText" class="col-sm-2 col-form-label">Comment</label>
                    <div class="col-sm-10"><textarea name="text" id="exampleText" class="form-control"></textarea></div>
                </div>
                <div class="position-relative row form-group"><label for="exampleFile" class="col-sm-2 col-form-label">File</label>
                    <div class="col-sm-10"><input name="file" id="exampleFile" type="file" class="form-control-file">
                        <small class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                    </div>
                </div>
                <div class="position-relative row form-group"><label for="checkbox2" class="col-sm-2 col-form-label">Checkbox</label>
                    <div class="col-sm-10">
                        <div class="position-relative form-check"><label class="form-check-label"><input id="checkbox2" type="checkbox" class="form-check-input"> Check me out</label></div>
                    </div>
                </div>
                <div class="position-relative row form-check">
                    <div class="col-sm-10 offset-sm-2">
                        <button class="btn btn-secondary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
echo Template::footer($templateDir);