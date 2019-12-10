<?php
include_once "../../app/bootstrap.php";

use Util\Template;

$pageName = "Dashboard | Company details";
$templateDir = "public/dashboard"; 

// if (!isset($_GET['id'])) {
//     header("location: index.php");
// }

if (!isset($_GET['id']) && $currentUser->get('user_type_id') == 1) {
    returnToPage("companies.php");
}
init_dashboard($currentUser, Template::header($pageName, $templateDir));
// $company = $db->getCompany($_GET['id']);

?>
<!-- <script src="assets/scripts/calendar.js"></script> -->

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-display2 icon-gradient bg-sunny-morning"></i>
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
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div id='absence-calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
</div>


<script src="./assets/fullcalendar-4.3.1/packages/core/main.js"></script>
<script src="./assets/fullcalendar-4.3.1/packages/daygrid/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('absence-calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid'],
             defaultView: 'dayGridWeek',
            // defaultView: 'timeGridWeek',
            timeZone: 'local',
            defaultDate: new Date().getTime(), // will be parsed as local

            events: {
                url: '../endpoints/company-absences.php',
                method: 'POST',
                extraParams: {
                    "user-token": "<?php echo $_SESSION['login_token']; ?>",
                    "company-id": "<?php echo (isset($_GET['id']) ? $_GET['id'] : ''); ?>"
                },
                failure: function (event) {
                    console.log(event);
                    alert('there was an error while fetching events!');
                },
                color: 'blue', // a non-ajax option
                textColor: 'white' // a non-ajax option
            }
        });

        calendar.render();
    });
</script>

<?php
echo Template::footer($templateDir);