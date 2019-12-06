<?php
include_once "../../app/bootstrap.php";

use app\DataBase\DB;
use Util\Template;

$pageName = "Dashboard | Add company";
$templateDir = "public/dashboard"; 

init_dashboard($currentUser, Template::header($pageName, $templateDir));

?>

<!-- TODO make modal appear if adding failed -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
    <?php if ($_GET['companyAdded'] == 'success') echo "aria-hidden='true'" ?>>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Please fill all fields to procceed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-culture text-success">
                        </i>
                    </div>
                    <div>Add your new Company
                        <div class="page-title-subheading">Add another of your companies to manage through AppSense.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">New Company</h5>
                        <form name="new-company-form" action="logic/add-company.php" method="POST">
                            <!-- <form name="new-company-form"> -->
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="companyName" class="">Company
                                            Name</label><input name="company_name" id="company_name" type="text"
                                            class="form-control"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group"><label for="companyRegistrationNumber"
                                            class="">Registration number</label><input name="registration_number"
                                            id="companyRegistrationNumber" type="text" class="form-control"></div>
                                </div>
                            </div>
                            <div class="position-relative form-group"><label for="companyAddress"
                                    class="">Address</label><input name="company_address" id="companyAddress"
                                    type="text" class="form-control"></div>
                            <label for="businessTypes">Business Type</label>
                            <select name="business_type_id" id="businessTypes" class="form-control">
                                <?php
                                            $businessTypeTemplate = "<option value='{business_type_id}'>{business_type_name}</option>";
                                            $placeholders = array(
                                                "id" => "{business_type_id}",
                                                "name" => "{business_type_name}"
                                            );

                                            $bts = $db->listAll("business_types");                                            
                                            foreach ($bts as $record) {
                                                $data = array(
                                                    "id" => $db->getField($record, "id"),
                                                    "name" => $db->getField($record, "name")
                                                );
                                                $template = fillTemplateWithData($businessTypeTemplate, $placeholders, $data);
                                                echo $template;
                                            }
                                            
                                        ?>
                            </select>
                            <!-- <div class="position-relative form-group"><label for="businessTypes" class="">Business type (may be multiple)</label>
                                        <select multiple="" name="selectMulti" id="businessTypes" class="form-control"></select>
                                    </div>   -->
                            <!-- <div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Check me out</label></div> -->
                            <button id="add-company" class="mt-2 btn btn-primary">Add Company</button>

                            <!-- <script>
                                        document.getElementById("add-company").addEventListener("click", () => {
                                            var inputs = document.forms['new-company-form'].getElementsByTagName("input");
                                            Array.from(inputs).forEach((input) =>  {
                                                if (!input.value) {
                                                    document.getElementById("messageModal").style ='display', 'block';
                                                     // TODO dont let form open PHP script if not everything is filled
                                                    return;
                                                }
                                            }); 
                                        });
                                    </script> -->


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