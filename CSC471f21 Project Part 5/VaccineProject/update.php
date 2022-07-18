<?php
// Include Database Class file
require_once "DBConfigure.php";
 
//call to the database Class instance
$db = new DBConfigure();    
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
//Errors
$firstN_err = ''; 
$lastN_err = '';
$weight_err = '';

//Vaccine 
$addrCity_err   = '';
$addrState_err   = '';
$siteName_err = '';

if(isset($_POST["type1"]) && !empty($_POST["type1"])){

		$type = $_POST["type1"];
		if($type == '1')
		{
			//This part execute when user submit the form for updating DomainsDB  subject.
			// Get hidden input value from the form
			$fName = $_POST["f_name"];
			$mInitial = $_POST["m_initial"];
			$lName = $_POST["l_name"];
			$dob = $_POST["dob"];
			$weight = $_POST["weight"];
			$patientId = $_POST["id"];


			if (preg_match('/^[a-zA-Z]+$/', (string)$_POST['f_name']) 
			&& preg_match('/^[a-zA-Z]+$/', (string)$_POST['l_name'])  
			&& preg_match('/^[0-9]+$/', (string)$_POST['weight'])) {

				//Prepared statement to update the table
				$db->Update("Update patient set f_name = ? , m_initial = ? , l_name = ? , dob = ? , weight = ? where id = ?",[
					$fName, $mInitial, $lName, $dob, $weight, $patientId
				]); // Simplest to update the record using the database Class
				// Records updated successfully. Redirect to landing page
				echo "Record updated successfully.";
				header("location: index.php");
				exit();
			} 
			else 
			{
				if(!preg_match('/^[a-zA-Z]+$/', (string)$_POST['f_name']))
					$firstN_err = "Alphabets allowed server side";
				if(!preg_match('/^[a-zA-Z]+$/', (string)$_POST['l_name']))
					$lastN_err = "Alphabets allowed server side";
				if(!preg_match('/^[0-9]+$/', (string)$_POST['weight']))
					$dob_err = "Digits Allowed alphabets";
			}


		}
		else if($type == '2'){

			//This part execute when user submit the form for updating DomainsDB  subject.
			// Get hidden input value from the form
			$patientId = $_POST["patient_id"];
			$allergyDesc = $_POST["allergy"];
			$allergyDescHidden = $_POST["allergyHidden"];

			//Prepared statement to update the table
			$db->Update("Update allergy set allergy = ?  where allergy = ? AND patient_id = ?",[
				$allergyDesc, $allergyDescHidden, $patientId
			]); // Simplest to update the record using the database Class

			// Records updated successfully. Redirect to landing page
			echo "Record updated successfully.";
			header("location: index.php");
			exit();
		}
		else if($type == '3'){

			//This part execute when user submit the form for updating DomainsDB  subject.
			// Get hidden input value from the form
			$scientificName = trim($_POST["scient_name"]);
			$disease = trim($_POST["disease"]);
			$noDoses = trim($_POST["no_doses"]);
			//Prepared statement to update the table
			$db->Update("Update vaccine set disease = ?, no_doses = ?  where scient_name = ?",[
				$disease, $noDoses, $scientificName
			]); // Simplest to update the record using the database Class

			// Records updated successfully. Redirect to landing page
			echo "Record updated successfully.";
			header("location: index.php");
			exit();

		}
		else if($type == '4'){

			// Get hidden input value from the form
			$siteName= trim($_POST["name"]);
			$addrStreet = trim($_POST["addr_street"]);
			$addrCity = trim($_POST["addr_city"]);
			$addrState = trim($_POST["addr_state"]);
			$addrZip = trim($_POST["addr_zip"]);
			
			if (preg_match('/^[a-zA-Z ]+$/', (string)$_POST['name']) 
			&& preg_match( '/^[a-zA-Z ]+$/', (string)$_POST['addr_state'])  
			&& preg_match( '/^[a-zA-Z ]+$/', (string)$_POST['addr_city'])) {

				//Prepared statement to update the table
				$db->Update("Update vaccination_site set addr_street = ?, addr_city = ?, addr_state = ?, addr_zip = ? where name = ? ",[
					$addrStreet,
					$addrCity,
					$addrState,
					$addrZip,
					$siteName
				]); // Simplest to update the record using the database Class
				
			// Records updated successfully. Redirect to landing page
			echo "Record updated successfully.";
			header("location: index.php");
			exit();
			} 
			else 
			{
				if(!preg_match('/^[a-zA-Z ]+$/', (string)$_POST['name']))
					$siteName_err = "Alphabets allowed server side";
				if(!preg_match('/^[a-zA-Z ]+$/', (string)$_POST['addr_state']))
					$addrState_err = "Alphabets and numeric allowed server side";
				if(!preg_match('/^[a-zA-Z ]+$/', (string)$_POST['addr_city']))
					$addrCity_err = "Digits Allowed alphabets";
			}


		}
		else if($type == '5'){

			// Get hidden input value from the form
			$patientId = trim($_POST["patient_id"]);
			$siteName = trim($_POST["site_name"]);
			$scientificName = trim($_POST["scient_name"]);
			$patientIdHidden = trim($_POST["patient_id_hidden"]);
			$siteNameHidden = trim($_POST["site_name_hidden"]);
			$scientificNameHidden = trim($_POST["scient_name_hidden"]);

			//Prepared statement to update the table
			$db->Update("Update takes set patient_id = ?, site_name = ? , scientific_name = ? where patient_id = ? AND site_name = ? AND scient_name = ?",[
				
				$siteName,
				$scientificName,
				$patientId,
				$patientIdHidden,
				$siteNameHidden,
				$scientificNameHidden,
			]); // Simplest to update the record using the database Class

			// Records updated successfully. Redirect to landing page
			echo "Record updated successfully.";
			header("location: index.php");
			exit();
		}
		
} else {


    if(isset($_GET["type"]) && !empty(trim($_GET["type"]))){

		$type = $_GET["type"];
		if($type == '1')
		{
			$param_id = trim($_GET["patientId"]);

		    // Prepare a select statement
			$result = $db->Select("Select * from patient where id = ?",[$param_id]); 

			if($result){

			while( $row= sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
				$dateOfbithe = $row["dob"];
				$datebirth = json_encode($dateOfbithe);
				$dob = $dateOfbithe->date; // for example
				$patientId = $row["id"];
				$fName = $row["f_name"];
				$mInitial = $row["m_initial"];
				$lName = $row["l_name"];
				$weight = $row["weight"];

            } //Read specific VaccineDB  data
		}
		}
		else if($type == '2') {
			
			$param_id = trim($_GET["patientId"]);
			$param_id2 = trim($_GET["allergy"]);

		    // Prepare a select statement
			$result = $db->Select("Select * from allergy where patient_id = ? AND allergy = ? ",[$param_id, param_id2]);

			if($result){

			//Read array that is generated from Database Class
			while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {

			    $patientId = $row["patient_id"];
			    $allergyDesc = $row["allergy"];
            } //Read specific VaccineDB  data
		}
		}
		else if($type == '3'){

			$param_scient_name = trim($_GET["scient_name"]);

			$result = $db->Select("Select * from vaccine where scient_name = ? ",[
				$param_scient_name  ]); // Fetching data like we did in the read part.
			if($result){

				while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

					$scientificName = trim($row["scient_name"]);
					$disease = trim($row["disease"]);
					$noDoses = trim($row["no_doses"]);

				} //Read specific VaccineDB  data
			}
		}
		else if($type == '4'){

			$param_Id = trim($_GET["siteName"]);
			// Prepare a select statement
			$result = $db->Select("Select * from vaccination_site where name = ? ", [ $param_Id ]); 
			if($result){

			while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
				
				$siteName= trim($row["name"]);
				$addrStreet = trim($row["addr_street"]);
				$addrCity = trim($row["addr_city"]);
				$addrState = trim($row["addr_state"]);
				$addrZip = trim($row["addr_zip"]);
            } }
		}
		else if($type == '5'){

			$param_Id1 = trim($_GET["patientId"]);
			$param_Id2 = trim($_GET["siteName"]);
			$param_Id3 = trim($_GET["scient_name"]);

			// Prepare a select statement
			$result = $db->Select("Select * from takes where patient_id = ? AND site_name = ? AND scient_name = ? ", [ $param_Id , $param_Id2, $param_Id3]);
			if($result){

			while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
				$patientId = trim($row["patient_id"]);
				$siteName = trim($row["site_name"]);
				$scientificName = trim($row["scient_name"]);
            }}
		}
		
    } else {
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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


?>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>

						<?php
						$type1 = trim($_GET["type"]);
						if($type1 == '1')
						{	?>		 
							 <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        
								 <div class="form-group">
									<label>Patients </label>
									
									<div class="form-group">
										<label>first Name</label>
										<input type="text" name="f_name" class="form-control" value="<?php echo $fName; ?>" required>
										<span class="help-block"><?php echo $firstN_err;?></span>

									</div>

									<div class="form-group">
										<label>m initial</label>
										<input pattern="[a-zA-Z ]+" oninvalid="setCustomValidity('Please enter on alphabets only. ')" type="text" name="m_initial" class="form-control" value="<?php echo $mInitial; ?>" required>
									</div>
									<div class="form-group">
										<label>last Name</label>
										<input type="text" name="l_name" class="form-control" value="<?php echo $lName; ?>" required>
										<span class="help-block"><?php echo $lastN_err;?></span>

									</div>
									<div class="form-group">
										<label>dob</label>
										<input type="date" name="dob" class="form-control" value="<?php echo date('Y-m-d',strtotime($dob));; ?>" required>

									</div>
									<div class="form-group">
										<label>weight</label>
										<input type="number" name="weight" class="form-control" value="<?php echo $weight; ?>" required>
										<span class="help-block"><?php echo $weight_err;?></span>
									</div>
								</div>
                        		<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>
								<input type="hidden" name="id" value="<?php echo trim($_GET["patientId"]); ?>"/>
								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>

						<?php }
						else if($type1 == '2'){ 
							
							$param_id = trim($_GET["patientId"]);
							$param_id2 = trim($_GET["allergyDesc"]);
						?>

							<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        
								<div class="form-group">

									<div class="form-group">
										<label>Patient Id</label>
										<select class="form-control" name="patient_id" required>  
											<?php $result = $db->Select("SELECT id FROM patient"); 
																					if($result){

											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['id']; ?>" >  
													<?php echo $row['id'];?>  
												</option>  
											<?php  
											}  }
											?>
										</select>
									</div>
                         
									<div class="form-group">
										<label>Allergy</label>
										<input type="text" name="allergy" class="form-control" value="<?php echo $allergyDesc; ?>" required>
									</div>

								</div>
								<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>
								<input type="hidden" name="patientIdHidden" value="<?php echo trim($_GET["patientId"]); ?>"/>
								<input type="hidden" name="allergyHidden" value="<?php echo trim($_GET["allergy"]); ?>"/>

								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>
						<?php }
						else if($type1 == '3'){
							$scientificName = trim($_GET["scient_name"]);
							?>
							<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    
								<div class="form-group">
									<div class="form-group">
										<label>disease</label>
										<input pattern="[a-zA-Z ]+" oninvalid="setCustomValidity('Please enter on alphabets only. ')" type="text" name="disease" class="form-control" value="<?php echo $disease; ?>" required>
									</div>

									<div class="form-group">
										<label>no Doses</label>
										<input type="text" name="no_doses" class="form-control" value="<?php echo $noDoses; ?>" required>
									</div>
								</div>
								<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>
								<input type="hidden" name="scient_name" value="<?php echo $scientificName; ?>"/>

								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>

						<?php }
						else if($type1 == '4'){ ?>
							
							<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    
								<div class="form-group">
									<div class="form-group">
										<label>Address Street</label>
										<input type="text" name="addr_street" class="form-control" value="<?php echo $addrStreet; ?>" required>
									</div>
									<div class="form-group <?php echo (!empty($addrCity_err)) ? 'has-error' : ''; ?>">
										<label>Address City</label>
										<input type="text" name="addr_city" class="form-control" value="<?php echo $addrCity; ?>" required>
										<span class="help-block"><?php echo $addrCity_err;?></span>
									</div>
									<div class="form-group <?php echo (!empty($addrState_err)) ? 'has-error' : ''; ?>">
										<label>Address State</label>

										<input type="text" name="addr_state" class="form-control" value="<?php echo $addrState; ?>" required>
										<span class="help-block"><?php echo $addrState_err;?></span>
									</div>
									<div class="form-group">
										<label>Address Zip</label>
										<input type="text" name="addr_zip" class="form-control" value="<?php echo $addrZip; ?>" required>
									</div>
								</div>

								<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>
								<input type="hidden" name="name" value="<?php echo trim($_GET["siteName"]); ?>"/>
								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>

						<?php }
						else if($type1 == '5'){ ?>
							<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    
								<div class="form-group">


									<div class="form-group">
										<label>Patient Id</label>
										<select class="form-control" name="patient_id" required>  
											<?php $result = $db->Select("SELECT id FROM patient"); 
																					if($result){

											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['id']; ?>" >  
													<?php echo $row['id'];?>  
												</option>  
											<?php  
											}  }
											?>
										</select>									
									</div>

									<div class="form-group">
										<label>Site Name</label>
										<select class="form-control" name="site_name" required>  
											<?php $result = $db->Select("SELECT name FROM vaccination_site"); 
											
											if($result){

											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
											 ?>  
												<option value="<?php echo $row['name']; ?>" >  
													<?php echo $row['name'];?>  
												</option>  
											<?php  
											}  }
											?>
										</select>	
									</div>

									<div class="form-group">
										<label>scientific Name</label>
										<select class="form-control" name="scient_name" required>  
											<?php $result = $db->Select("SELECT scient_name FROM vaccine"); 
											if($result){

												while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) { 
												?>  
													<option value="<?php echo $row['scient_name']; ?>" >  
														<?php echo $row['scient_name'];?>  
													</option>  
												<?php  
												} 
											}
											?>
										</select>											</div>
								</div>

								<input type="hidden" name="patient_id_hidden" value="<?php echo $_GET["patientId"]; ?>"/>
								<input type="hidden" name="site_name_hidden" value="<?php echo $_GET["siteName"]; ?>"/>
								<input type="hidden" name="scient_name_hidden" value="<?php echo $_GET["scient_name"]; ?>"/>

								<input type="hidden" name="type1" value="<?php echo trim($_GET["type"]); ?>"/>

								<input type="submit" class="btn btn-primary" value="Submit">
								<a href="index.php" class="btn btn-default">Cancel</a>
							</form>

						<?php } 
						?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>