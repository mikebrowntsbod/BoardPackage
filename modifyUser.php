    
<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Admin Users</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
      <link href="css/font-awesome.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
      <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <style>
         table{
         width:100%;
             border-collapse: separate;
         }
         #example_filter{
         float:right;
         }
         #example_paginate{
         float:right;
         }
         label {
         display: inline-flex;
         margin-bottom: .5rem;
         margin-top: .5rem;
         }
      </style>
    
  
   </head>
   <body>
       <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
          <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
      <?php
$userid = $_SESSION['user_id'];
include_once('include/db-config.php');

?>
    <div class="navbar navbar-fixed-top">
         <div class="navbar-inner">
            <div class="container">
               <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                  class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.php">Tanyard Springs Board Portal</a>
               <!--/.nav-collapse --> 
            </div>
            <!-- /container --> 
         </div>
         <!-- /navbar-inner --> 
      </div>
      <!-- /navbar -->
      <div class="subnavbar">
         <div class="subnavbar-inner">
            <div class="container">
               <ul class="mainnav">
                  <li><a href="dashboard.php"><em class="icon-dashboard"></em><span>Dashboard</span> </a> </li>
                  <li> <a href ="add.php"><em class ="icon-dashboard"></em><span>Add Motion</span></a></li>
                  <li><a href="vote.php"><em class ="icon-dashboard"></em><span>Vote</span></a></li>
                  <li><a href="discussions.php"><em class ="icon-dashboard"></em><span>Discussions</span></a></li>
          <li><a href="userprefs.php"><em class ="icon-dashboard"></em><span>Prefences</span></a></li>
        <li class="active"><a href="users.php"><em class="icon-dashboard"></em><span>Users</span></a></li>
                  <li><a href="logout.php"><em class="icon-dashboard"></em><span>Logout</span></a> </li>
               </ul>
            </div>
            <!-- /container --> 
         </div>
         <!-- /subnavbar-inner --> 
      </div>
      <!-- /subnavbar -->
      <div class="main">
      <div class="main-inner">
      <div class="container">
         <div class="row">
            <!--<div class="alert alert-danger" role="alert">
               <strong>ALERT: </strong>This message is as of October 17, 2018. Please be advised this site will be moved to a new server in the next week
                  </div>-->
            <div class="container">
       <div class="row">
        <?php
	       $usersid=$_POST['usersid'];
if (isset($usersid))
{
    $modifyusersid = htmlspecialchars($usersid);
   
    $modifyUser=$db_con->prepare("SELECT * FROM users WHERE users_id=:usersid");
    $modifyUser->bindParam(':usersid',$modifyusersid);
    $modifyUser->execute();
	
	while ( $row = $modifyUser->fetch(PDO::FETCH_ASSOC))
	{
		$modifyusersid=$row['users_id'];
		$username=$row['username'];
		$firstName=$row['first_name'];
		$lastName=$row['last_name'];
		$emailAddress=$row['email'];
		$enabled=$row['enabled'];

		if ($enabled == "1")
		{
			$enabled="Yes";
		}
		else 
		{
			$enabled="No";
		}
?>
	       <form action="UpdateUser.php" method="post">
		       <fieldset>
			       <legend>Modify User ID <?php echo "$modifyusersid" ?></legend>
			<p><label>User's ID: </label><input type="text" name="modifyUsersID" id="modifyUsersID" readonly value="<?php echo $modifyusersid; ?>"></p>
			<p><label>Username: </label><input type="text" name="modifyUserName" id="modifyUserName" value="<?php echo $username; ?>"></p>
			<p><label>First Name: </label><input type="text" name="modifyFirstName" id="modifyFirstName" value="<?php echo $firstName ?>"></p>
			<p><label>Last Name: </label><input type="text" name="modifyLastName" id="modifyLastName" value="<?php echo $lastName ?>"></p>
			<p><label>Email: </label><input type="text" name="modifyEmail" id="modifyEmail" value="<?php echo $emailAddress ?>"></p>
			<p><label>Enabled: </label><input type="text" name="modifyEnabled" id="modifyEnabled" value="<?php echo $enabled ?>"></p>
			<input type="submit" value="Submit User Update"> <input type="reset">
		       </fieldset>
	       </form>

		<form action="UpdateUser.php" method="post">
		<fieldset>
		<legend>Update password for User ID <?php echo "$modifyusersid" ?></legend>
		<p><label>Password: </label><input type="password" name="modifyUserPassword" id="modifyUserPassword"></p>
		<p><label>Verify: </label><input type="password" name="modifyUserVerifyPassword" id="modifyUserVerifyPassword"></p>
		<input type="hidden" value="<?php echo $modifyusersid ?>" name="modifyUsersID" id="modifyUsersID">
		<input type="hidden" name="updateUsersPassword" id="updateUsersPassword">
		<input type="submit" value="Send Password Update"> <input type="reset">
		</fieldset>
		</form>
	<?php
	}

}
    $addUser=$_POST['addUser'];
if ((!isset($usersid)) && (isset ($addUser)) && ($addUser == "addUser"))
{
?>

<form class="form-horizontal" id="addUser1" id="addUser1" method="post" action="modifyUser.php">
<fieldset>

<!-- Form Name -->
<legend>Add a User</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="fname">First Name</label>  
  <div class="col-md-4">
  <input id="fname" name="fname" type="text" placeholder="First Name" class="form-control input-md" required="">
  <span class="help-block">Please type in the first name of the user</span>  
  </div>
</div>
<br />
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="lname">Last Name</label>  
  <div class="col-md-4">
  <input id="lname" name="lname" type="text" placeholder="Last Name" class="form-control input-md" required="">
  <span class="help-block">Please type in the last name of the user</span>  
  </div>
</div>
<br />
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email Address</label>  
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="E-mail Address" class="form-control input-md" required="">
  <span class="help-block">Enter user's e-mail address</span>  
  </div>
</div>
<br />
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="username">Username</label>  
  <div class="col-md-4">
  <input id="username" name="username" type="text" placeholder="username" class="form-control input-md" required="">
  <span class="help-block">Please type in the desired username</span>  
  </div>
</div>
<br />
    
    
    <!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passcode">Password</label>  
  <div class="col-md-4">
  <input id="passcode" name="passcode" type="password" placeholder="Password" class="form-control input-md" required="">
  <span class="help-block">Enter Password</span>  
  </div>
</div>
    
    <br />
<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passcodeVerify">Verify Password</label>
  <div class="col-md-4">
    <input id="passcodeVerify" name="passcodeVerify" type="password" placeholder="Verify Password" class="form-control input-md" required="">
    <span class="help-block">Please verify the password</span>
  </div>
</div>
<br />
	<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="passcodeVerify">Enable Account?</label>
  <div class="col-md-4">
    <input id="enableAccount" name="enableAccount" type="checkbox" class="form-control input-md" value="enableAccount">
  </div>
</div>

<br />
    <br />
	<input type="hidden" name="addingUser" id="addingUser" value="addingNewUser">
    <input type="submit" value="Send Request"> <input type="reset" value="Reset Form">
</fieldset>
</form>

<?php
}
?>

<?php

if ((isset($_POST['addingUser'])) && ($_POST['addingUser'] == "addingNewUser"))
{
	$first_name = $_POST['fname'];
	$last_name = $_POST['lname'];
	$email_address = $_POST['email'];
	$username = htmlspecialchars($_POST['username']);
	$passcode = $_POST['passcode'];
	$verify = $_POST['passcodeVerify'];
	$errors = "";	
	if ($passcode != $verify)
	{
		$errors .= "Password and verify password do not match";
	}
	else
	{
		if ( ($first_name != "") && ($last_name != "") && ($email_address != "") && ($username != "") && ($passcode != "") )
		{
			$uppercase = preg_match('@[A-Z]@', $passcode);
			$lowercase = preg_match('@[a-z]@', $passcode);
			$number    = preg_match('@[0-9]@', $passcode);
			$specialChars = preg_match('@[^\w]@', $passcode);
			
			if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($passcode) < 8) 
			{
				$errors .= '<br />Password should be at least 8 characters in length and should include at least one upper case 
				letter, one number, and one special character.';
			}
			else
			{
    				 if (!filter_var($email_address, FILTER_VALIDATE_EMAIL))
				 {
					 $errors .= "<br />Invalid E-mail Format";
				 }
				
				else
				{
					$temppw = 0;
					
					if (isset($_POST['enableAccount']))
					{
						$enabled = 1;
					}
					else
					{
						$enabled = 0;
					}
						  
					$saltedpasscode = sha1($passcode);
					include_once ('include/db-config.php');
					$addUser=$db_con->prepare("INSERT INTO users (username,password,first_name,last_name,email,enabled,temppw) 
									VALUES(:username, :passcode, :first_name, :last_name, :email, :enabled, :temppw)");
					$addUser->bindParam(':username',$username);
					$addUser->bindParam(':passcode',$saltedpasscode);
					$addUser->bindParam(':first_name',$first_name);
					$addUser->bindParam(':last_name',$last_name);
					$addUser->bindParam(':email',$email_address);
					$addUser->bindParam(':enabled',$enabled);
					$addUser->bindParam(':temppw',$temppw);
					$addUser->execute();
					$addUser->closeCursor();
					echo "Added User " . $username . " to the database";

				}
			}

		}
		else
		{
			$errors .= "<br />Necessary entries were blank";
		}
	}

	if ($errors != "")
	{
		echo "There were errors in your submission:<br />";
		echo $errors;
	}

}

?>



                <!-- /span6 -->
                  <!-- /span6 --> 
               </div>
               <!-- /row --> 
            </div>
            <!-- /container --> 
         </div>
         <!-- /main-inner --> 
      </div>
      <!-- /main -->
      <!-- /extra -->
      <div class="footer">
         <div class="footer-inner">
            <div class="container">
               <div class="row">
                  <div class="span12"> &copy; 2013 <a href="http://www.egrappler.com/">Bootstrap Responsive Admin Template</a>. </div>
                  <!-- /span12 --> 
               </div>
               <!-- /row --> 
            </div>
            <!-- /container --> 
         </div>
         <!-- /footer-inner --> 
      </div>
      <!-- /footer --> 
      <!-- Le javascript
         ================================================== --> 
      <!-- Placed at the end of the document so the pages load faster --> 
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="js/bootstrap.js"></script>
   </body>
</html>
