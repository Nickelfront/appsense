<?php
include_once "../app/bootstrap.php";

use Util\Template;
// use app\DataBase\DB;

// $db = new DB("appsensedb");

// $db->createUser(array("name", "lastname", "email", "pass"));

// $allUsers = $db->fetchAll("users");

// foreach($allUsers as $userData) {
//   echo $userData["first_name"];
// }

$pageName = "Our Team";

echo Template::header($pageName);
?>

    <div class="hero-wrap hero-wrap-2" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container-fluid">
        <div class="row no-gutters d-flex slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-6 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
          	<p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="index.html">Home</a></span> <span>Work</span></p>
            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Work</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-work">
    	<div class="container-fluid">
    		<div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-2">Our Portfolio</h2>
            <span class="subheading">We're Happy to share our complete Projects</span>
          </div>
        </div>
        <div class="row">
        	<div class="col-md-4 ftco-animate">
        		<div class="work-entry">
	        		<a href="#" class="img" style="background-image: url(images/work-1.jpg);">
	        			<div class="text d-flex justify-content-center align-items-center">
		        			<div class="p-3">
		        				<span>Branding</span>
		        				<h3>Work 01</h3>
		        			</div>
	        			</div>
	        		</a>
        		</div>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<div class="work-entry">
	        		<a href="#" class="img" style="background-image: url(images/work-2.jpg);">
	        			<div class="text d-flex justify-content-center align-items-center">
		        			<div class="p-3">
		        				<span>Branding</span>
		        				<h3>Work 02</h3>
		        			</div>
	        			</div>
	        		</a>
        		</div>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<div class="work-entry">
	        		<a href="#" class="img" style="background-image: url(images/work-3.jpg);">
	        			<div class="text d-flex justify-content-center align-items-center">
		        			<div class="p-3">
		        				<span>Branding</span>
		        				<h3>Work 03</h3>
		        			</div>
	        			</div>
	        		</a>
        		</div>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<div class="work-entry">
	        		<a href="#" class="img" style="background-image: url(images/work-4.jpg);">
	        			<div class="text d-flex justify-content-center align-items-center">
		        			<div class="p-3">
		        				<span>Branding</span>
		        				<h3>Work 01</h3>
		        			</div>
	        			</div>
	        		</a>
        		</div>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<div class="work-entry">
	        		<a href="#" class="img" style="background-image: url(images/work-5.jpg);">
	        			<div class="text d-flex justify-content-center align-items-center">
		        			<div class="p-3">
		        				<span>Branding</span>
		        				<h3>Work 02</h3>
		        			</div>
	        			</div>
	        		</a>
        		</div>
        	</div>
        	<div class="col-md-4 ftco-animate">
        		<div class="work-entry">
	        		<a href="#" class="img" style="background-image: url(images/work-6.jpg);">
	        			<div class="text d-flex justify-content-center align-items-center">
		        			<div class="p-3">
		        				<span>Branding</span>
		        				<h3>Work 03</h3>
		        			</div>
	        			</div>
	        		</a>
        		</div>
        	</div>
        </div>
    	</div>
    </section>


    <section class="ftco-section-parallax">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
              <h2>Subcribe to our Newsletter</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
              <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-8">
                  <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                      <input type="text" class="form-control" placeholder="Enter email address">
                      <input type="submit" value="Subscribe" class="submit px-3">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


<?php

echo Template::footer();
