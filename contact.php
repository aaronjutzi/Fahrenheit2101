<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> &#127746; Weather Forecast </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <link href="style.css" rel="stylesheet">

</head>
<style>
  body{
    background-image: url("img/toronto1.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        
  }
  * {
    box-sizing: border-box;
  }
  
  input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
  }
  
  label {
    padding: 12px 12px 12px 0;
    display: inline-block;
  }
  
  input[type=submit] {
    background-color: #04AA6D;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
  }
  
  input[type=submit]:hover {
    background-color: #45a049;
  }
  
  .container {
    border-radius: 10px;
    background-color: #f2f2f2;
    padding: 40px;
  }
  
  .col-25 {
    float: left;
    width: 25%;
    margin-top: 6px;
  }
  
  .col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
  }
  
  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }
  
  /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
  @media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
      width: 100%;
      margin-top: 0;
    }
  }
  </style>
<body>


<!-- Nav bars -->
<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
  <div class="container-fluid">
      <a class="navbar-brand" href="index.html"><img alt ='logo' src="img/rsz_logo_green.png" width="110" height="50"><strong>Ontario</strong> Weather</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarResponsive">
          <span class="navbar-toggler-icon"></span>
      </button>
  </div>
      <div class="navbar-collapse collapse"  id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
     <a class="nav-link" href="index.html"><strong> Home </strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="method.html"><strong> Methodology </strong></a>
          </li>
    <li class="nav-item">
            <a class="nav-link" href="product.html"><strong> Product </strong></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="contact.html"><strong> Contact </strong></a>
          </li>
        </ul>
      </div>
</nav>
<?php
if($_POST && isset($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['phone']))

  $email_to = "toby.chidi@hotmail.com";
  $email_subject = "Project inquiry from Web";
  $fname = $_POST['firstName'];
  $lname = $_POST['lastName'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];
  $email_message .= "First Name: ".( $fname).   " \n";
  $email_message .= "Last Name: ".( $lname).   " \n";
  $email_message .= "Phone number: ".($phone).   " \n";
  $email_message .= "Email: ".( $email).   " \n";
  $email_message .= "Message: ".($message).   " \n";


  $headers .= 'From: <webmaster@example.com>' . "\r\n";
  
  
 if(!$fname){
  $fnameErr = "Please enter your first name";
}
  elseif(!$lname) {
    $lnameErr = "Please enter your first name";
  } 
    elseif(!$email) {
    $mailErr = "Please enter Your Email ";
  }elseif(!$email || !preg_match("/^\S+@\S+$/", $email)) {
    $emailErr = "You entered an Invalid Email";
    } 
  elseif(!$message){
      $messageErr = "Message column cannot be empty";
  }
  elseif(!$phone){
    $phoneErr = "Please input phone number";
}
 
else {
   $response = "Thank you for your Inquiry";
mail($email_to, $email_subject, $email_message, $headers);

      }
 
                          
            
                          
                          
                          ?>









  
  <div style='color:rgb(0, 255, 64);'>
  <h2 style='text-align: center;'>Contact Form</h2>
  <p style='text-align: center;'>If you have any questions on our project, please send us a message by filling in the below form.</br> 
    We will try our best to answer all your inquries!</p>
  </div>
  <div class="container" >
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
      <div class="row">
        <div class="col-25">
        <span class='error'> <?php echo $response;?></span>
          <label for="fname">First Name</label>
        </div>
        <div class="col-75">
          <input type="text" id="fname" name="firstName" placeholder="Your name..">
          <span class='error'> <?php echo $fnameErr;?></span>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="lname">Last Name</label>
        </div>
        <div class="col-75">
          <input type="text" id="lname" name="lastName" placeholder="Your last name..">
          <span class='error'> <?php echo $lnameErr ;?></span>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="lname">Email</label>
        </div>
        <div class="col-75">
          <input type="text" id="email" name="email" placeholder="Your Email..">
          <span class='error'> <?php echo $mailErr;?></span>
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="phonenumber">Phone Number</label>
        </div>
        <div class="col-75">
          <input type="text" id="pnumber" name="phone" placeholder="Your Phone Number..">
          <span class='error'> <?php echo $phoneErr;?></span>
        </div>
      </div>
     
      <div class="row">
        <div class="col-25">
          <label for="subject">Message</label>
        </div>
        <div class="col-75">
          <textarea id="subject" name="message" placeholder="Write something.." style="height:200px"></textarea>
          <span class='error'> <?php echo $messageErr;?></span>
        </div>
      </div>
      <div class="row">
        <input type="submit" value="Submit" >
      </div>
    </form>
  </div>
  
  </body>
  </html>
  

<!--- Footer -->
<footer>
  <div class="footer fixed-bottom"></div>
  <div class="container-fluid padding">
  <div class="row text-center">
    <div class="col-md-4">
      <img alt ='logo' src="img/rsz_logo_green.png" width="110" height="50">
    </div>
    <div class="col-md-4">
      <img alt ='logo' src="img/arubrum.png" width="110" height="50">
    </div>
    <div class="col-md-4">
      <img src="img/fleminglogo.png" alt= "fleming">
    </div>
    <div class="col-12">
      <hr class="light">
      <h5>&copy; Fahrenheit 2021</h5>
    </div>
  </div>
  </div>
  </footer>

</body>
</html>
