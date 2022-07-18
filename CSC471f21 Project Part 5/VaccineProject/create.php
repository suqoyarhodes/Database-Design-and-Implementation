<?php
// Include Database Class file
require_once "DBConfigure.php";
 //call to the database Class instance
$db = new DBConfigure();    

	//patient 
	//Errors
	$firstN_err = ''; 
	$lastN_err = '';
	$weight_err = '';

	//Vaccine 
	$addrCity_err   = '';
	$addrState_err   = '';
	$siteName_err = '';

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST["type1"]) && !empty($_POST["type1"])){
		$type = $_POST["type1"];

		if($type == '1')
		{    

			if (preg_match('/^[a-zA-Z]+$/', (string)$_POST['f_name']) 
			&& preg_match('/^[a-zA-Z]+$/', (string)$_POST['l_name'])  
			&& preg_match('/^[0-9]+$/', (string)$_POST['weight'])) {


				
				// Prepare an insert statement and call to database
				$id = $db->Insert("Insert into patient( id, f_name,  m_initial, l_name,  dob, weight) values ( ? , ?, ? , ? , ? , ? )", [
					$_POST['id'],
					(string)$_POST['f_name'],
					(string)$_POST['m_initial'],
					(string)$_POST['l_name'],
					(string)$_POST['dob'],
					$_POST['weight']
				]);

			} 
			else 
			{
				if(!preg_match('/^[a-zA-Z]+$/', (string)$_POST['f_name']))
					$firstN_error = "Alphabets allowed server side";
				if(!preg_match('/^[a-zA-Z]+$/', (string)$_POST['l_name']))
					$lastN_error = "Alphabets allowed server side";
				if(!preg_match('/^[0-9]+$/', (string)$_POST['weight']))
					$dob_error = "Digits Allowed alphabets";
			}

			// Records created successfully. Redirect to landing page
			echo "Record added successfully.";
			header("location:index.php");
			exit();
		}
		else if($type == '2'){

			// Get hidden input value from the form
			$patientId= trim($_POST["patient_id"]);
			$allergyDesc = trim($_POST["allergy"]);

			// Prepare an insert statement and call to database
			$id = $db->Insert("Insert into allergy(patient_id, allergy) values ( ? , ?)", [
				$patientId,
				$allergyDesc
				
			]);

			// Records created successfully. Redirect to landing page
			echo "Record added successfully.";
			header("location: index.php");
			exit();
		}
		else if($type == '3'){
			
			
			$scientificName = trim($_POST["scient_name"]);
			$disease = trim($_POST["disease"]);
			$noDoses = trim($_POST["no_doses"]);

			$id = $db->Insert("Insert into vaccine(scient_name, disease, no_doses ) values ( ? , ?, ?)", [
				$scientificName,
				$disease,
				$noDoses,

			]);

			// Records created successfully. Redirect to landing page
			echo "Record added successfully.";
			header("location: index.php");
			exit();
		}
		else if($type == '4'){

			// Get hidden input value from the form
			$siteName = trim($_POST["name"]);
			$addrStreet = trim($_POST["addr_street"]);
			$addrCity = trim($_POST["addr_city"]);
			$addrState = trim($_POST["addr_state"]);
			$addrZip = trim($_POST["addr_zip"]);

			
			if (preg_match('/^[a-zA-Z ]+$/', (string)$_POST['name']) 
			&& preg_match('/^[a-zA-Z ]+$/', (string)$_POST['addr_state'])  
			&& preg_match('/^[a-zA-Z]+$/', (string)$_POST['addr_city'])) {

				// Prepare an insert statement and call to database
				$id = $db->Insert("Insert into vaccination_site(name, addr_street, addr_city, addr_state, addr_zip ) values ( ? , ? , ?, ?, ?)", [
					$siteName,
					$addrStreet,
					$addrCity,
					$addrState,
					$addrZip
				]);
			} 
			else 
			{
				if(!preg_match('/^[a-zA-Z]+$/', (string)$_POST['name']))
					$siteName_err = "Alphabets allowed server side";
				if(!preg_match('/^[a-zA-Z ]+$/', (string)$_POST['addr_state']))
					$addrState_err = "Alphabets and numeric allowed server side";
				if(!preg_match('/^[0-9]+$/', (string)$_POST['weight']))
					$addrCity_err = "Digits Allowed alphabets";
			}
			// Records created successfully. Redirect to landing page
			echo "Record added successfully.";
			header("location: index.php");
			exit();
		}
		else if($type == '5'){
			// Get hidden input value from the form
			$patientId = trim($_POST["patient_id"]);
			$siteName = trim($_POST["site_name"]);
			$scientificName = trim($_POST["scient_name"]);
			$id = $db->Insert("Insert into takes(patient_id, site_name, scient_name) values ( ? ,? ,? )", [
				$patientId,
				$siteName,
				$scientificName
			]);

			// Records created successfully. Redirect to landing page
			echo "Record added successfully.";
			header("location: index.php");
			exit();
		}
	}
	else{
			echo "invalid data provided.";
			header("location: error.php");
			exit();
	}
    
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php require_once("header.php");


//patient 
$patientId  = '';
$fName  = '';
$mInitial = '';
$lName   = '';
$dob  = '';
$weight  = '';


//allergy 
$patientId  = '';
$allergyDesc  = '';

//vaccine 
$scientificName  = '';
$disease   = '';
$noDoses   = '';


//VaccineSite 
$siteName  = '';
$addrStreet  = '';
$addrCity   = '';
$addrState   = '';
$addrZip    = '';

//takes 
$patientId  = '';
$siteName   = '';
$scientificName = '';

//patient 
//insuredPatient 
//uninsuredPatient  
//allergy 
//vaccine 
//vaccinationSite 
//lot 
//takes 
//billing 

?>
        <div class="container">
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

					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#patient">patient</a></li>
						<li><a data-toggle="tab" href="#allergy">Allergy</a></li>
						<li><a data-toggle="tab" href="#vaccine">vaccine</a></li>
						<li><a data-toggle="tab" href="#vaccinationSite">vaccination Site</a></li>
						<li><a data-toggle="tab" href="#takes">takes</a></li>
					</ul>
					<div class="tab-content wrapper" style="margin: 0 auto;">

						<div id="patient" class="tab-pane fade in active">
							<h3>patient</h3>

							<div class="page-header">
								<h2>Create Record</h2>
							</div>
							<p>Please fill this form and submit to add VaccineDBrecord record to the database.</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

								<div class="form-group">

									<div class="form-group">
										<label>PatientID</label>
										<input type="text" name="id" class="form-control" value="<?php echo $patientId; ?>" required>
									</div>

									
									<div class="form-group">
										<label>First Name</label>
										<input type="text" name="f_name" class="form-control" value="<?php echo $fName; ?>" required>
										<span class="help-block"><?php echo $firstN_err;?></span>

									</div>

									<div class="form-group">
										<label>Middle Initial</label>
										<input pattern="[a-zA-Z ]+" oninvalid="setCustomValidity('Please enter on alphabets and space only.')" type="text" name="m_initial" class="form-control" value="<?php echo $mInitial; ?>" required>
									</div>

									<div class="form-group">
										<label>last Name</label>
										<input type="text" name="l_name" class="form-control" value="<?php echo $lName; ?>" required>
										<span class="help-block"><?php echo $lastN_err;?></span>

									</div>
									<div class="form-group">
										<label>Date of birth</label>
										<input type="date" name="dob" class="form-control" value="<?php echo date('Y-m-d',strtotime($dob)); ?>" required>

									</div>
									<div class="form-group">
										<label>Weight</label>
										<input type="text" name="weight" class="form-control" value="<?php echo $weight; ?>" required>
										<span class="help-block"><?php echo $weight_err;?></span>
									</div>
								</div>
								<input type="hidden" name="type1" value="1"/>

								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>
						</div>
						
						<div id="allergy" class="tab-pane fade">
							<h3>Allergy</h3>

							<div class="page-header">
								<h2>Create Record</h2>
							</div>

							<p>Please fill this form and submit to add VaccineDBrecord to the database.</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								
								<div class="form-group">

									<div class="form-group">
										<label>patient Id</label>
										<select class="form-control" name="patient_id" required>  
											<?php $result = $db->Select("SELECT id FROM patient"); 
											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['id']; ?>" >
													<?php echo $row['id'];?>  
												</option>
											<?php  
											}  
											?>
										</select>	
									</div>

									<div class="form-group">
										<label>Allergy</label>
										<input pattern="[a-zA-Z ]+" oninvalid="setCustomValidity('Please enter on alphabets only.')"  type="text" name="allergy" class="form-control" value="<?php echo $allergyDesc; ?>" required>
									</div>

								</div>

								<input type="hidden" name="type1" value="2"/>

								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>

							</form>

						</div>
						
						<div id="vaccine" class="tab-pane fade">
							<h3>Vaccine</h3>

							<div class="page-header">
								<h2>Create Record</h2>
							</div>

							<p>Please fill this form and submit to add VaccineDBrecord to the database.</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								
								<div class="form-group">
									<div class="form-group">
										<label>scientificName</label>
										<input type="text" name="scient_name" class="form-control" value="<?php echo $scientificName; ?>" required>
									</div>

									<div class="form-group">
										<label>Disease</label>
										<input type="text" name="disease" class="form-control" value="<?php echo $disease; ?>" required>
									</div>

									<div class="form-group">
										<label>No Doses</label>
										<input type="text" name="no_doses" class="form-control" value="<?php echo $noDoses; ?>" required>
									</div>
								</div>
								<input type="hidden" name="type1" value="3"/>
								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>
						</div>

						<div id="vaccinationSite" class="tab-pane fade">
							<h3>Vaccine Site</h3>
	
							<div class="page-header">
								<h2>Create Record</h2>
							</div>

							<p>Please fill this form and submit to add VaccineDBrecord to the database.</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								
								<div class="form-group">
                         
                            		<div class="form-group <?php echo (!empty($siteName_err)) ? 'has-error' : ''; ?>">
										<label>Site Name</label>
										<input type="text" required="required" class="form-control" name="name" value="<?php echo $siteName; ?>" required>
										<span class="help-block"><?php echo $siteName_err;?></span>
									</div>

                            		<div class="form-group">
										<label>Street</label>
										<input type="text" required="required" class="form-control" name="addr_street" value="<?php echo $addrStreet; ?>" required>
									</div>

                            		<div class="form-group <?php echo (!empty($addrCity_err)) ? 'has-error' : ''; ?>">
										<label>City</label>
										<input type="text" name="addr_city" class="form-control" value="<?php echo $addrCity; ?>" required>
										<span class="help-block"><?php echo $addrCity_err;?></span>
									</div>

									<div class="form-group <?php echo (!empty($addrState_err)) ? 'has-error' : ''; ?>">
										<label>State</label>

										<input type="text" name="addr_state" class="form-control" value="<?php echo $addrState; ?>" required>
										<span class="help-block"><?php echo $addrState_err;?></span>
									</div>

									<div class="form-group">
										<label>Zip code</label>
										<input pattern="[0-9]+" oninvalid="setCustomValidity('Please enter digits only. ')"  type="text" required="required" class="form-control" name="addr_zip" value="<?php echo $addrZip; ?>" required>
									</div>

								</div>

								<input type="hidden" name="type1" value="4"/>
								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>

							</form>

						</div>

						<div id="takes" class="tab-pane fade">
							<h3>Takes</h3>

							<div class="page-header">
								<h2>Create Record</h2>
							</div>

							<p>Please fill this form and submit to add DomainsDB record to the database.</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								
								<div class="form-group">
                         
									<div class="form-group">
										<label>Patient Id</label>
										<select class="form-control" name="patient_id" required>  
											<?php $result = $db->Select("SELECT id FROM patient"); 
											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['id']; ?>" >  
													<?php echo $row['id'];?>  
												</option>
											<?php  
											}  
											?>
										</select>									
									</div>

                            		<div class="form-group">
										<label>Site Name</label>
										<select class="form-control" name="site_name" required>  
											<?php $result = $db->Select("SELECT name FROM vaccination_site"); 
											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['name']; ?>" >  
													<?php echo $row['name'];?>  
												</option>  
											<?php  
											}  
											?>
										</select>									</div>
									
                            		<div class="form-group">
										<label>Scientific Name</label>
										<select class="form-control" name="scient_name" required>  
											<?php $result = $db->Select("SELECT scient_name FROM vaccine"); 
											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['scient_name']; ?>" >  
													<?php echo $row['scient_name'];?>  
												</option>  
											<?php  
											}  
											?>
										</select>									
									</div>
								</div>
								<input type="hidden" name="type1" value="5"/>
								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>

							</form>

						</div>

					</div>

                </div>
            </div>        
        </div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>