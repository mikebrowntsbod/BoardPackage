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
      <title>Admin Management</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
      <link href="css/font-awesome.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
      <link href="css/pages/dashboard.css" rel="stylesheet">
      <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
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
      <script>
         $(document).ready(function() {
         $('#editUsers').DataTable(
             
              {     
           "aLengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
             "iDisplayLength": 30
            } 
             );
         } );
         function checkAll(bx) {
         var cbs = document.getElementsByTagName('input');
         for(var i=0; i < cbs.length; i++) {
         if(cbs[i].type == 'checkbox') {
           cbs[i].checked = bx.checked;
         }
         }
         }
      </script>
      <script>
         $(document).ready(function() {
         $('#currentUsers').DataTable( {
          "dom": '<"toolbar">frtip'
         } );
         
         $("div.toolbar").html('<strong>Users</strong>');
         } );
      </script>
      <style>
         .toolbar {
         float: left;
         }
      </style>
   </head>
   <body>
      <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
      <?php
         $userid = $_SESSION['user_id'];
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
                      $firstName = $_POST['firstName'];
                      $lastName = $_POST['lastName'];
                      $email = $_POST['email'];
                      $enabled = $_POST['Enabled'];
                      $errors = "";
                      if (($firstName != "") && ($lastName!="") && ($email != ""))
		      {
			      echo strlen($firstName);
			      echo "<br />";
			      echo strlen($lastName);
			      echo "<br />";
                        if (strlen($firstName) >= 5 && strlen($lastName) >= 5)
                        {
                          if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                          {
                            $errors .= "There was an issue with your e-mail Address<br />";
                            }
                            else
                            {
                              include_once ('include/db-config.php');
                              $addManagement=$db_con->prepare("INSERT INTO management (first_name,last_name,email,fenabled)
                                                                VALUES(:firstName, :lastName, :email, :enabled)");
                              $addManagement->bindParam(':firstName',$firstName);
                              $addManagement->bindParam(':lastName',$lastName);
                              $addManagement->bindParam(':email', $email);
                              $addManagement->bindParam(':enabled',$enabled);
                              
                              $addManagement->execute();
                              $addManagement->closeCursor();
                              echo "Added new management " . $firstName . " " . $lastName . " to the database";

                            }

			}

			else
			{
				$errors .= "Your first Name or last name is not at least 5 characters";
			}
                      }

                      else 
                      {
                        $errors .= "There was an issue with your submission";
                      }
                      
                      if ($errors != "")
                      {
                        echo $errors;
                        }
                      
                     
                  
                  ?>
                  
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
