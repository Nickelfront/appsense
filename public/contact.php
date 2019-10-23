<?php
include_once "../app/bootstrap.php";

use Util\Template;

$pageName = "Contact";
$templateDir = "public";

echo Template::header($pageName, $templateDir);
?>

    <div class="hero-wrap hero-wrap-2" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container-fluid">
        <div class="row no-gutters d-flex slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-6 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
          	<p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="index.html">Home</a></span> <span>Contact</span></p>
            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">Our Contact</h1>
          </div>
        </div>
      </div>
    </div>

		<section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h4">Contact Information</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <p><span>Address:</span> 198 West 21th Street, Suite 721 New York NY 10016</p>
          </div>
          <div class="col-md-3">
            <p><span>Phone:</span> <a href="tel://1235235598">+ 1235 2355 98</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Email:</span> <a href="mailto:info@appsence.com">info@appsence.com</a></p>
          </div>
        </div>
        <div class="row block-9">
          <div class="col-md-6 pr-md-5">
<!--             <form action="contact.php" method="POST">
              <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Your Name">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="email" placeholder="Your Email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" placeholder="Subject">
              </div>
              <div class="form-group">
                <textarea id="" cols="30" rows="7" class="form-control" name="message" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>
            </form> -->
          <?php
          // TODO FIX ENTIRE STRUCTURE AND LOGIC

            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
            $message = isset($_POST['message']) ? $_POST['message'] : '';

          // name => placeholder
            $fields = array( 'name' => 'Your Name',
              'email' => 'Your Email',
              'subject' => 'Subject');

            $formBegin = "<form action='contact.php' method='POST'>";
            $formEnd = "</form>";

            $formGroupBegin = "<div class='form-group'>";
            $formGroupEnd = "</div>";

            $formHTML = $formBegin;
            foreach ($fields as $key => $value) {
              $input = "<input type='text' class='form-control' name='$key' placeholder='$value' value=''>";
              $formHTML .= $formGroupBegin . $input . $formGroupEnd;
            }

            $formHTML .= $formGroupBegin . "<textarea id='' cols='30' rows='7' class='form-control' name='message' placeholder='Message'></textarea>" . $formGroupEnd . "<input type='submit' value='Send Message' class='btn btn-primary py-3 px-5'>";

            $formHTML .= $formEnd;

            echo $formHTML;

            $validationErrorMessage = "<a style='color: red;'>This field is required.</a>";


            $successHTML = "You have successfully sent us an e-Mail on subject $subject. Please expect a response from us within 72 hours.";

            // echo $successHTML;


            // TODO store in a database; or see how an email system works
          ?>
          </div>

          <div class="col-md-6" id="map"></div>
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

echo Template::footer($templateDir);