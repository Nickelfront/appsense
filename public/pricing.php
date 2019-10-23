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

$pageName = "Prices";

echo Template::header($pageName);
?>

    <div class="hero-wrap hero-wrap-2" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container-fluid">
        <div class="row no-gutters d-flex slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-6 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
          	<p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="index.html">Home</a></span> <span>Pricing</span></p>
            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Pricing</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-3">Our Best Pricing</h2>
            <span class="subheading">Pricing Plans</span>
          </div>
        </div>
    		<div class="row">
	        <div class="col-md-3 ftco-animate">
	          <div class="block-7">
	            <div class="text-center">
	            <h2 class="heading">Free</h2>
	            <span class="price"><sup>$</sup> <span class="number">0</span></span>
	            <span class="excerpt d-block">100% free. Forever</span>
	            <a href="#" class="btn btn-primary d-block px-2 py-3 mb-4">Get Started</a>

	            <h3 class="heading-2 mb-4">Enjoy All The Features</h3>

	            <ul class="pricing-text">
	              <li><strong>150 GB</strong> Bandwidth</li>
	              <li><strong>100 GB</strong> Storage</li>
	              <li><strong>$1.00 / GB</strong> Overages</li>
	              <li>All features</li>
	            </ul>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-3 ftco-animate">
	          <div class="block-7">
	            <div class="text-center">
	            <h2 class="heading">Startup</h2>
	            <span class="price"><sup>$</sup> <span class="number">19</span></span>
	            <span class="excerpt d-block">All features are included</span>
	            <a href="#" class="btn btn-primary btn-outline-primary d-block px-3 py-3 mb-4">Get Started</a>

	            <h3 class="heading-2 mb-4">Enjoy All The Features</h3>

	            <ul class="pricing-text">
	              <li><strong>450 GB</strong> Bandwidth</li>
	              <li><strong>400 GB</strong> Storage</li>
	              <li><strong>$2.00 / GB</strong> Overages</li>
	              <li>All features</li>
	            </ul>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-3 ftco-animate">
	          <div class="block-7">
	            <div class="text-center">
	            <h2 class="heading">Premium</h2>
	            <span class="price"><sup>$</sup> <span class="number">49</span></span>
	            <span class="excerpt d-block">All features are included</span>
	            <a href="#" class="btn btn-primary btn-outline-primary d-block px-3 py-3 mb-4">Get Started</a>

	            <h3 class="heading-2 mb-4">Enjoy All The Features</h3>

	            <ul class="pricing-text">
	              <li><strong>250 GB</strong> Bandwidth</li>
	              <li><strong>200 GB</strong> Storage</li>
	              <li><strong>$5.00 / GB</strong> Overages</li>
	              <li>All features</li>
	            </ul>
	            </div>
	          </div>
	        </div>
	        <div class="col-md-3 ftco-animate">
	          <div class="block-7">
	            <div class="text-center">
	            <h2 class="heading">Pro</h2>
	            <span class="price"><sup>$</sup> <span class="number">99</span></span>
	            <span class="excerpt d-block">All features are included</span>
	            <a href="#" class="btn btn-primary btn-outline-primary d-block px-3 py-3 mb-4">Get Started</a>

	            <h3 class="heading-2 mb-4">Enjoy All The Features</h3>

	            <ul class="pricing-text">
	              <li><strong>450 GB</strong> Bandwidth</li>
	              <li><strong>400 GB</strong> Storage</li>
	              <li><strong>$20.00 / GB</strong> Overages</li>
	              <li>All features</li>
	            </ul>
	            </div>
	          </div>
	        </div>
	      </div>
	      <div class="row  mt-5 justify-conten-center">
        	<div class="col-md-8 ftco-animate">
        		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi vero accusantium sunt sit aliquam ipsum molestias autem perferendis, incidunt cumque necessitatibus cum amet cupiditate, ut accusamus. Animi, quo. Laboriosam, laborum.</p>
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
