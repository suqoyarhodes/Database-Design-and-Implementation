<style>
    table{
        border: 1px solid;
    }
</style>

<?php

class DatabaseClass{

    private $connection = null;

    // this function is called everytime this class is instantiated
    public function __construct( $dbhost , $dbname , $username, $password ){

        try{
			$serverName = $dbhost;
			$connectionOptions = [
				'Database' => $dbname,
				'Uid' => $username,
				'PWD' => $password,
			];
            //Generating conection string to connect to sql server
			$this->connection  = sqlsrv_connect($serverName, $connectionOptions);

        }catch(Exception $e){
            throw new Exception($e->getMessage());   // Exception handled if any error
        }

    }

    public function Select( $statement = "" , $parameters = [] ){
        try{

			$getResults = sqlsrv_query($this->connection, $statement, $parameters);
            return $getResults;
             //Exception throwing when something happen wrong
        }catch(Exception $e){
            throw new Exception($e->getMessage());   // Exception handled if any error
        }
    }

    // Insert a row/s in a Database Table
    //To add record in the database that is major pillar of the part
    public function Insert( $statement = "" , $parameters = [] ){
        try{

           if(! sqlsrv_query($this->connection, $statement , $parameters ) ){
				die(print_r(sqlsrv_errors(), true));
		   }
			return 1;
            //Exception throwing when something happen wrong
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    // Remove a row/s in a Database Table
    //To Delete records in the database that is also major pillar of the part
    public function Remove( $statement = "" , $parameters = [] ) {
        try{
			$stmt =  sqlsrv_query($this->connection, $statement , $parameters );

           if(! $stmt){
				die(print_r(sqlsrv_errors(), true));
		   }
		   return 1;

        }catch(Exception $e){
            throw new Exception($e->getMessage());   // Exception handled if any error
        }
    }
}

$db = new DatabaseClass(
    "csc471f21rhodessuqoya.database.windows.net", // Replace here your sql server instance name
    "vaccinesf21",                       // Replace here your sql db name
    "",                   // Replace here username of sql server instance
    ""                 //Replace here sql server instance password
);

$resultVaccine = $db->Select("SELECT * FROM Vaccine");
$resultLots = $db->Select("SELECT * FROM Lot");

echo "Data from DB before uploading CSV";
echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th>scient_name</th>";
            echo "<th>disease</th>";
            echo "<th>no_doses</th>";
        echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while( $row = sqlsrv_fetch_array($resultVaccine, SQLSRV_FETCH_ASSOC) ) {
        echo "<tr>";
            echo "<td>" . $row['scient_name'] . "</td>";
            echo "<td>" . $row['disease'] . "</td>";
            echo "<td>" . $row['no_doses'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";

echo "<table class='table table-bordered table-striped'>";
    echo "<thead>";
        echo "<tr>";
            echo "<th>scient_name</th>";
            echo "<th>number</th>";
            echo "<th>mfr_place</th>";
            echo "<th>expirtion</th>";
        echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while( $row = sqlsrv_fetch_array($resultLots, SQLSRV_FETCH_ASSOC) ) {
        echo "<tr>";
            echo "<td>" . $row['scient_name'] . "</td>";
            echo "<td>" . $row['number'] . "</td>";
            echo "<td>" . $row['mfr_place'] . "</td>";
            echo "<td>" . json_encode($row['expirtion']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
echo "</table>";

echo "<h1>Completed </h1>";

if(isset($_POST["Import"])){

    $filename=$_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0)
    {

        $db->Remove("Delete from Lot");
        $db->Remove("alter table Vaccine nocheck constraint all");
        $db->Remove("alter table Takes nocheck constraint all");
        $db->Remove("Delete from Vaccine");

        echo "<h1> started </h1>";

        $row = 0;
        //$file = fopen($filename, "r");
        if (($handle = fopen($filename, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle)) !== FALSE)
            {
                if($row > 0)
                {
                    //var_dump($data);
                    $id = $db->Insert("Insert into Vaccine( scient_name , disease, no_doses ) values ( ? , ? , ? )", [
                        $data[0],
                        $data[1],
                        $data[2]
                    ]);

                    $id = $db->Insert("Insert into Lot( scient_name, number, mfr_place, expirtion ) values ( ? , ? , ? , ? )", [
                        $data[3],
                        $data[4],
                        $data[5],
                        $data[6]
                    ]);

                    // if(!isset($id))
                    // {
                    //     echo "<script type=\"text/javascript\">
                    //     alert(\"Invalid File:Please Upload CSV File.\");
                    //     window.location = \"ReadFileAndWriteToDatabase.php\"
                    //     </script>";
                    // }
                    // else {
                    //     echo "<script type=\"text/javascript\">
                    //     alert(\"CSV File has been successfully Imported.\");
                    //     window.location = \"ReadFileAndWriteToDatabase.php\"
                    //     </script>";
                    // }

                }
            $row++;
            }
            // echo "<h1>Record after csv insertion Records". $row ."</h1>";
            // die();
            fclose($handle);
        }

        echo "<h1>Record after csv insertion Records". $row ."</h1>";
        $resultVaccine = $db->Select("SELECT * FROM Vaccine");
        $resultLots = $db->Select("SELECT * FROM Lot");

        echo "Data from DB before uploading CSV";
        echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>scient_name</th>";
                    echo "<th>disease</th>";
                    echo "<th>no_doses</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while( $row = sqlsrv_fetch_array($resultVaccine, SQLSRV_FETCH_ASSOC) ) {
                echo "<tr>";
                    echo "<td>" . $row['scient_name'] . "</td>";
                    echo "<td>" . $row['disease'] . "</td>";
                    echo "<td>" . $row['no_doses'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
        echo "</table>";

        echo "<table class='table table-bordered table-striped'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>scient_name</th>";
                    echo "<th>number</th>";
                    echo "<th>mfr_place</th>";
                    echo "<th>expirtion</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while( $row = sqlsrv_fetch_array($resultLots, SQLSRV_FETCH_ASSOC) ) {
                echo "<tr>";
                    echo "<td>" . $row['scient_name'] . "</td>";
                    echo "<td>" . $row['number'] . "</td>";
                    echo "<td>" . $row['mfr_place'] . "</td>";
                    echo "<td>" . $row['expirtion'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
        echo "</table>";

    }
    else{ ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

        <div id="wrap">
            <div class="container">
                <div class="row">
                    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="upload_excel" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Form Name -->
                            <legend>Form Name</legend>
                            <!-- File Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="filebutton">Select File</label>
                                <div class="col-md-4">
                                    <input type="file" name="file" id="file" class="input-large">
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                                <div class="col-md-4">
                                    <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

    <?php }

}
else
{ ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <div id="wrap">
        <div class="container">
            <div class="row">
                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
                        <!-- Form Name -->
                        <legend>Form Name</legend>
                        <!-- File Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-4">
                                <input type="file" name="file" id="file" class="input-large">
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                            <div class="col-md-4">
                                <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

<?php }
?>
