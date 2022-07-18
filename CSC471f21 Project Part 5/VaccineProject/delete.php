<?php
// Process delete operation after confirmation
if(isset($_POST["type1"]) && !empty($_POST["type1"])){
   
    // Include Database Class file
    require_once "DBConfigure.php";

    //call to the database Class instance
    $db = new DBConfigure();    

    // Set parameters
    $type = trim($_POST["type1"]);
	if($type == '1')
	{
	    $param_id = trim($_POST["id"]);
	    $db->Remove("Delete from patient where id = ?",[ $param_id ]);
	}
	else if($type == '2'){
		$param_id = trim($_POST["patient_id"]);
		$param_id2 = trim($_POST["allergy"]);

	    $db->Remove("Delete from allergy where patient_id = ? and allergy = ?",[  $param_id , $param_Id2]);
	}
	else if($type == '3'){
		$param_Id = trim($_POST["scient_name"]);
	    $db->Remove("Delete from vaccine where scient_name = ? ",[ $param_Id ], );
	}
	else if($type == '4'){
		$param_Id = trim($_POST["name"]);
	    $db->Remove("Delete from vaccination_site where name = ? ",[ $param_Id ] );
	}
	else if($type == '5'){
		$param_Id = trim($_POST["patient_id"]);
		$param_i2 = trim($_POST["site_name"]);
		$param_id3 = trim($_POST["scient_name"]);
	    $db->Remove("Delete from takes where patient_id = ? and site_name = ? and scient_name = ?",[ $param_Id, $param_i2, $param_i3 ] );
	}
    // Prepare a delete statement

    // Records deleted successfully. Redirect to landing page. When success going back to the vaccine page.
    header("location: index.php");
    exit();

} else{
    // Check existence of id parameter
    //If no record found or id is invalid then taking back to the error page.
    if(empty(trim($_GET["type"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php require_once("header.php"); ?>
    <div class="wrapper">
        <div class="container-fluid">
			<h2>Vaccine Database information</h2>

			<div class="row">
				<div class="col-md-12">
					<div class="page-header clearfix">
						<h1 class="pull-left">Welcome Vaccine Platform</h1>
					</div>
				</div>
			</div>  
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>

					<?php
					
						$type = trim($_GET["type"]);
						if($type == '1')
						{
							$id = trim($_GET["patientId"]); ?>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="alert alert-danger fade in">
									<input type="hidden" name="id" value="<?php echo trim($_GET["patientId"]); ?>"/>
									<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>

									<p>Are you sure you want to delete this record?</p><br>
									<p>
										<input type="submit" value="Yes" class="btn btn-danger">
										<a href="index.php" class="btn btn-default">No</a>
									</p>
								</div>
							</form>
						<?php }
						else if($type == '2'){
							$patientId = trim($_GET["patientId"]);
							$allergyDesc = trim($_GET["allergyDesc"]); ?>
							
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="alert alert-danger fade in">

									<input type="hidden" name="patient_id" value="<?php echo trim($_GET["patientId"]); ?>"/>
									<input type="hidden" name="allergy" value="<?php echo trim($_GET["allergyDesc"]); ?>"/>
									<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>

									<p>Are you sure you want to delete this record?</p><br>
									<p>
										<input type="submit" value="Yes" class="btn btn-danger">
										<a href="index.php" class="btn btn-default">No</a>
									</p>
								</div>
							</form>
						<?php }
						else if($type == '3'){
							$scientificName = trim($_GET["scient_name"]); ?>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="alert alert-danger fade in">
									<input type="hidden" name="scient_name" value="<?php echo trim($_GET["scient_name"]); ?>"/>
									<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>

									<p>Are you sure you want to delete this record?</p><br>
									<p>
										<input type="submit" value="Yes" class="btn btn-danger">
										<a href="index.php" class="btn btn-default">No</a>
									</p>
								</div>
							</form>
						<?php }
						else if($type == '4'){ ?>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="alert alert-danger fade in">
									<input type="hidden" name="name" value="<?php echo trim($_GET["siteName"]); ?>"/>
									<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>

									<p>Are you sure you want to delete this record?</p><br>
									<p>
										<input type="submit" value="Yes" class="btn btn-danger">
										<a href="index.php" class="btn btn-default">No</a>
									</p>
								</div>
							</form>
						<?php }
						else if($type == '5'){ ?>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="alert alert-danger fade in">
									
									<input type="hidden" name="patient_id" value="<?php echo trim($_GET["patientId"]); ?>"/>
									<input type="hidden" name="site_name" value="<?php echo trim($_GET["siteName"]); ?>"/>
									<input type="hidden" name="scient_name" value="<?php echo trim($_GET["scient_name"]); ?>"/>

									<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>

									<p>Are you sure you want to delete this record?</p><br>
									<p>
										<input type="submit" value="Yes" class="btn btn-danger">
										<a href="index.php" class="btn btn-default">No</a>
									</p>
								</div>
							</form>
					<?php }
					?>
                    
                </div>
            </div>        
        </div>
    </div>
</body>
</html>