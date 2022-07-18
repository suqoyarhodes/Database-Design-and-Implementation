<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        .wrapper{
            width: 850px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
<?php require_once("header.php");

//You will pass parameters according to your database server configuration.
require_once "DBConfigure.php";

//( $dbhost , $dbname , $username, $password )
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
			<div class="col-sm-12 col-xs-12">
		
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#patient">Patient</a></li>
					<li><a data-toggle="tab" href="#allergy">Allergy</a></li>
					<li><a data-toggle="tab" href="#vaccine">Vaccine</a></li>
					<li><a data-toggle="tab" href="#vaccinationSite">Vaccination Site</a></li>
					<li><a data-toggle="tab" href="#takes">takes</a></li>
				</ul>

				<div class="tab-content">

					<div id="patient" class="tab-pane fade in active">
						<div class="wrapper" style="margin-top:40px;">
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
											<div class="form-group">
												<div class="form-group">
													<input type="Number" name="id" Placeholder="Patient Id" class="form-control" value="<?php echo $patientId; ?>" required>
												</div>
											</div>
											
											<input type="hidden" name="type1" value="1"/>
											<input type="submit" class="btn btn-primary" value="Submit">
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="page-header clearfix">
											<h2 class="pull-left">Our Patients </h2>
											<a href="create.php/#patient" class="btn btn-success pull-right">Add New Patient</a>
										</div>
										<?php

										$condition = '';
										if(isset($_POST['type1'])){
											if($_POST['type1'] == "1")
											{
												if(isset($_REQUEST['id']) and $_REQUEST['id'] != "") {
													$condition	= ' id = ' .$_REQUEST['id']."";
												}
											}
										}

										if($condition == '') {
											$result = $db->Select("SELECT * FROM patient"); 		}
										else {
											$result = $db->Select("SELECT * FROM patient where ".$condition.""); 
										}



										echo "<table class='table table-bordered table-striped'>";
											echo "<thead>";
												echo "<tr>";
													echo "<th>patientId </th>";
													echo "<th>first Name </th>";
													echo "<th>m Initial </th>";
													echo "<th>last Name</th>";
													echo "<th>dob</th>";
													echo "<th>weight</th>";
												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
										if($result){


											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
												echo "<tr>";
													echo "<td>" . $row['id'] . "</td>";
													echo "<td>" . $row['f_name'] . "</td>";
													echo "<td>" . $row['m_initial'] . "</td>";
													echo "<td>" . $row['l_name'] . "</td>";
													echo "<td>" . $row['dob']->format('Y-m-d') . "</td>";
													echo "<td>" . $row['weight'] . "</td>";
													echo "<td>";
														echo "<a href='update.php?patientId=". $row['id'] ."&type=".'1'."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
														echo "<a href='delete.php?patientId=". $row['id'] ."&type=".'1'."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
													echo "</td>";
												echo "</tr>";

											}
										}
			
											echo "</tbody>";                            
										echo "</table>";
										?>
									</div>
								</div>        
							</div>
						</div>
					</div>
					
					<div id="allergy" class="tab-pane fade">

						<div class="wrapper" style="margin-top:40px;">
							<div class="container-fluid">
							<div class="row">
									<div class="col-sm-12 col-md-12">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
											<div class="form-group">
												<div class="form-group">
													<input type="Number" name="patient_id" Placeholder="Patient Id" class="form-control" value="<?php echo $patientId; ?>" required>
												</div>
											</div>
											
											<input type="hidden" name="type1" value="2"/>
											<input type="submit" class="btn btn-primary" value="Submit">
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="page-header clearfix">
											<h2 class="pull-left">Our allergy  </h2>
											<a href="create.php/#allergy" class="btn btn-success pull-right">Add New allergy </a>
										</div>
										<?php

										$condition = '';
										if(isset($_POST['type1'])){
											if($_POST['type1'] == "2")
											{
												if(isset($_REQUEST['patient_id']) and $_REQUEST['patient_id'] != "") {
													$condition	= " patient_id = '" .$_REQUEST['patient_id']."'";
												}
											}
										}
									
										if($condition == '') {
											$result = $db->Select('SELECT * FROM allergy;'); 
										}
										else{
											$sql = "SELECT * FROM allergy where " . $condition ;
											$result = $db->Select($sql); 
										}


										echo "<table class='table table-bordered table-striped'>";
											echo "<thead>";
												echo "<tr>";
													echo "<th>Patient Id</th>";
													echo "<th>Allergy</th>";
												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
											if($result){

											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
												echo "<tr>";
													echo "<td>" . $row['patient_id'] . "</td>";
													echo "<td>" . $row['allergy'] . "</td>";
													echo "<td>";
														echo "<a href='update.php?patientId=". $row['patient_id'] ."&allergy=".$row['allergy'] ."&type=".'2'."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
													echo "</td>";
													echo "<td>";
														echo "<a href='delete.php?patientId=". $row['patient_id'] ."&allergy=".$row['allergy']  ."&type=".'2'."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
													echo "</td>";
												echo "</tr>";
												}
											}
											echo "</tbody>";                            
										echo "</table>";
										?>
									</div>
								</div>        
							</div>
						</div>
					</div>
					
					<div id="vaccine" class="tab-pane fade">

						<div class="wrapper" style="margin-top:40px;">
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
											<div class="form-group">
												<div class="form-group">
													<input type="text" name="scient_name" Placeholder="Scient Name" class="form-control" value="<?php echo $scientificName; ?>" required>
												</div>
											</div>
											
											<input type="hidden" name="type1" value="3"/>
											<input type="submit" class="btn btn-primary" value="Submit">
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="page-header clearfix">
											<h2 class="pull-left">Our Vaccines </h2>
											<a href="create.php/#vaccine" class="btn btn-success pull-right">Add New vaccine</a>
										</div>
										<?php
										
										$condition = '';
										if(isset($_POST['type1'])){
											if($_POST['type1'] == "3")
											{
												if(isset($_REQUEST['scient_name ']) and $_REQUEST['scient_name '] != "") {
													$condition	= ' scient_name  = ' .$_REQUEST['scient_name ']."";
												}
											}
										}
										
										if($condition == ''){
											$result = $db->Select("SELECT * FROM vaccine"); 
										}
										else{
											$result = $db->Select("SELECT * FROM vaccine where ".$condition.""); 
										}

										echo "<table class='table table-bordered table-striped'>";
											echo "<thead>";
												echo "<tr>";

													echo "<th>Scient Name </th>";
													echo "<th>disease</th>";
													echo "<th>no Doses</th>";

												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
											if($result){

											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
												echo "<tr>";
													echo "<td>" . $row['scient_name'] . "</td>";
													echo "<td>" . $row['disease'] . "</td>";
													echo "<td>" . $row['no_doses'] . "</td>";

													echo "<td>";
														echo "<a href='update.php?scient_name=". $row['scient_name']. "&type=".'3'."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
														echo "<a href='delete.php?scient_name=". $row['scient_name']. "&type=".'3'."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
													echo "</td>";
												echo "</tr>";
												}
											}
											echo "</tbody>";                            
										echo "</table>";
										?>
									</div>
								</div>        
							</div>
						</div>
					</div>
					
					<div id="vaccinationSite" class="tab-pane fade">

						<div class="wrapper" style="margin-top:40px;">
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12 col-md-12">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
											<div class="form-group">
												<div class="form-group">
													<input type="text" name="name" Placeholder="site Name" class="form-control" value="<?php echo $siteName; ?>" required>
												</div>
											</div>
											
											<input type="hidden" name="type1" value="4"/>
											<input type="submit" class="btn btn-primary" value="Submit">
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="page-header clearfix">
											<h2 class="pull-left">Our vaccination Site </h2>
											<a href="create.php/#vaccinationSite" class="btn btn-success pull-right">Add New vaccinationSite</a>
										</div>
										<?php
										
										$condition = '';
										if(isset($_POST['type1'])){
											if($_POST['type1'] == "4")
											{
												if(isset($_REQUEST['name']) and $_REQUEST['name'] != "") {
													$condition	= ' name = ' .$_REQUEST['name']."";
												}
											}
										}
										

										if($condition == ''){
										$result = $db->Select("SELECT * FROM vaccination_site"); 
										}
										else{
											$result = $db->Select("SELECT * FROM vaccination_site where ".$condition.""); 
										}


										echo "<table class='table table-bordered table-striped'>";
											echo "<thead>";
												echo "<tr>";

													echo "<th>Name</th>";
													echo "<th>Addr Street</th>";
													echo "<th>Addr City</th>";
													echo "<th>Addr State</th>";
													echo "<th>Addr Zip</th>";
													
												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
											if($result){

											while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
												echo "<tr>";
													echo "<td>" . $row['name'] . "</td>";
													echo "<td>" . $row['addr_street'] . "</td>";
													echo "<td>" . $row['addr_city'] . "</td>";
													echo "<td>" . $row['addr_state'] . "</td>";
													echo "<td>" . $row['addr_zip'] . "</td>";

													echo "<td>";
														echo "<a href='update.php?siteName=". $row['name'] . "&type=".'4'."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
														echo "<a href='delete.php?siteName=". $row['name'] . "&type=".'4'."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
													echo "</td>";
												echo "</tr>";
												}
											}
											echo "</tbody>";                            
										echo "</table>";
										?>
									</div>
								</div>        
							</div>
						</div>
					</div>

					<div id="takes" class="tab-pane fade">

						<div class="wrapper" style="margin-top:40px;">
							<div class="container-fluid">
							<div class="row">
									<div class="col-sm-12 col-md-12">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
											<div class="form-group">
												<div class="form-group">
													<input type="Number" name="patient_id" Placeholder="patient Id" class="form-control" value="<?php echo $patientId; ?>" required>
												</div>
											</div>
											
											<input type="hidden" name="type1" value="4"/>
											<input type="submit" class="btn btn-primary" value="Submit">
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="page-header clearfix">
											<h2 class="pull-left">Our takes </h2>
											<a href="create.php/#takes" class="btn btn-success pull-right">Add New takes</a>
										</div>
										<?php
										
										$condition = '';
										if(isset($_POST['type1'])){
											if($_POST['type1'] == "5")
											{
												if(isset($_REQUEST['patient_id']) and $_REQUEST['patient_id'] != "") {
													$condition	= ' patient_id = ' .$_REQUEST['patient_id']."";
												}
											}
										}
										
										if($condition == ''){
										$result = $db->Select("SELECT * FROM takes"); 
										}
										else{
											$result = $db->Select("SELECT * FROM takes where ".$condition.""); 
										}


										echo "<table class='table table-bordered table-striped'>";
											echo "<thead>";
												echo "<tr>";

													echo "<th>Patient Id</th>";													
													echo "<th>site Name</th>";
													echo "<th>scient Name</th>";

												echo "</tr>";
											echo "</thead>";
											echo "<tbody>";
											if($result){

												while( $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC) ) {
													echo "<tr>";
														echo "<td>" . $row['patient_id'] . "</td>";
														echo "<td>" . $row['site_name'] . "</td>";
														echo "<td>" . $row['scient_name'] . "</td>";

														echo "<td>";
															echo "<a href='update.php?patientId=". $row['patient_id']. "&siteName=". $row['site_name'] . "&scient_name=". $row['scient_name']. "&type=".'5'."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
															echo "<a href='delete.php?patientId=". $row['patient_id']. "&siteName=". $row['site_name'] . "&scient_name=". $row['scient_name']. "&type=".'5'."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
														echo "</td>";
													echo "</tr>";
												}
											}

											echo "</tbody>";                            
										echo "</table>";
										?>
									</div>
								</div>        
							</div>
						</div>
					</div>
				
				</div>
			</div>	
		</div>

	</div>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>




</body>
</html>