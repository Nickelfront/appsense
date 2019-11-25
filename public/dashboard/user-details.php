<?php
include_once "../../app/bootstrap.php";

use Util\Template;
use Util\User;

$pageName = "Dashboard | User details";
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
                                        <i class="pe-7s-user icon-gradient bg-sunny-morning">
                                        </i>
                                    </div>
                                    <div>Your details
                                        <div class="page-title-subheading">View your details available to everyone who can see your profile.
                                        </div>
                                    </div>

                                    
                                </div>
                                <!-- <div class="page-title-actions">
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
                                </div> -->
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group</h5>
                                            <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <div class="widget-content-left">
                                                                    <img width="100" class="rounded-circle" src="assets/images/avatars/3.jpg" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="widget-content-left flex2">
                                                                <div class="widget-heading"><?php echo $user->get('first_name') . " " . $user->get('last_name');?></div>
                                                                <div class="widget-subheading opacity-7"><?php echo $user->get('email'); ?></div>
                                                                <div class="widget-subheading opacity-7"><?php echo $user->get('position') . " at " . $user->get('company') ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <ul class="list-group" style="margin-top: 10px">
                                                    <li class="list-group-item">Work hours a day: <?php echo $user->get('work_hours_a_day') ?></li>
                                                    <li class="list-group-item">Created at: <?php echo $user->get('created_at') ;?></li>
                                                    <li class="list-group-item">Last update: 
                                                        <?php
                                                            if (strcmp($user->get('updated_at'), $user->get('created_at'))) {
                                                                echo "Never";
                                                            } else {
                                                                echo $user->get('updated_at'); 
                                                            } 
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group buttons</h5>
                                                <div>
                                                    <ul class="list-group">
                                                        <button class="active list-group-item-action list-group-item">Cras justo odio</button>
                                                        <button class="list-group-item-action list-group-item">Dapibus ac facilisis in</button>
                                                        <button class="list-group-item-action list-group-item">Morbi leo risus</button>
                                                        <button class="list-group-item-action list-group-item">Porta ac consectetur ac</button>
                                                        <button class="disabled list-group-item-action list-group-item">Vestibulum at eros</button>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group badges</h5>
                                                <ul class="list-group">
                                                    <li class="justify-content-between list-group-item">Cras justo odio <span class="badge badge-secondary badge-pill">14</span></li>
                                                    <li class="justify-content-between list-group-item">Dapibus ac facilisis in <span class="badge badge-secondary badge-pill">2</span></li>
                                                    <li class="justify-content-between list-group-item">Morbi leo risus <span class="badge badge-secondary badge-pill">1</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group contextual classes</h5>
                                                <ul class="list-group">
                                                    <li class="list-group-item-success list-group-item">Cras justo odio</li>
                                                    <li class="list-group-item-info list-group-item">Dapibus ac facilisis in</li>
                                                    <li class="list-group-item-warning list-group-item">Morbi leo risus</li>
                                                    <li class="list-group-item-danger list-group-item">Porta ac consectetur ac</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group custom content</h5>
                                                <ul class="list-group">
                                                    <li class="active list-group-item"><h5 class="list-group-item-heading">List group item heading</h5>
                                                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p></li>
                                                    <li class="list-group-item"><h5 class="list-group-item-heading">List group item heading</h5>
                                                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p></li>
                                                    <li class="list-group-item"><h5 class="list-group-item-heading">List group item heading</h5>
                                                        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group disabled items</h5>
                                                <ul class="list-group"><a href="javascript:void(0);" class="disabled list-group-item">Cras justo odio</a><a href="javascript:void(0);" class="list-group-item">Dapibus ac facilisis in</a><a
                                                        href="javascript:void(0);" class="list-group-item">Morbi leo risus</a><a href="javascript:void(0);" class="list-group-item">Porta ac consectetur ac</a><a href="javascript:void(0);" class="list-group-item">Vestibulum
                                                    at eros</a></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="main-card mb-3 card">
                                            <div class="card-body"><h5 class="card-title">List group without border</h5>
                                                <ul class="list-group list-group-flush"><a href="javascript:void(0);" class="disabled list-group-item">Cras justo odio</a><a href="javascript:void(0);" class="list-group-item">Dapibus ac facilisis in</a><a
                                                        href="javascript:void(0);" class="list-group-item">Morbi leo risus</a><a href="javascript:void(0);" class="list-group-item">Porta ac consectetur ac</a><a href="javascript:void(0);" class="list-group-item">Vestibulum
                                                    at eros</a></ul>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                    </div>

<?php
echo Template::footer($templateDir);