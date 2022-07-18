<?php

//This is necessary based on this classs we are answering the Part C.
class DBConfigure{	
	
    private $connection = null;

    // this function is called everytime this class is instantiated		
    public function __construct(){
        
        try{
			$serverName = "csc471f21rhodessuqoya.database.windows.net";
			$connectionOptions = [
				'Database' => "vaccinesf21",
				'Uid' => "sjrhodes",
				'PWD' => "Flossy$1997",
			];
            //Generating conection string to connect to sql server
			$this->connection  = sqlsrv_connect($serverName, $connectionOptions);

        }catch(Exception $e){
            throw new Exception($e->getMessage());   // Exception handled if any error
        }			
        
    }

    public function Select( $statement = "" , $parameters = [] ){
        try{
            
            if($this->connection){
                $getResults = sqlsrv_query($this->connection, $statement, $parameters);
                return $getResults;
            }

             //Exception throwing when something happen wrong
        }catch(Exception $e){
            throw new Exception($e->getMessage());   // Exception handled if any error
        }		
    }

    // Insert a row/s in a Database Table
    //To add record in the database that is major pillar of the part
    public function Insert( $statement = "" , $parameters = [] ){ 
        try{
        if($this->connection){

           if(! sqlsrv_query($this->connection, $statement , $parameters ) ){
				die(print_r(sqlsrv_errors(), true));  
		   }
			return 1;
        }
            //Exception throwing when something happen wrong
        }catch(Exception $e){
            throw new Exception($e->getMessage());   
        }		
    }


    
    // Update a row/s in a Database Table
    //To Update records in the database that is also major pillar of the part
    public function Update( $statement = "" , $parameters = [] ){
        try{
            
           if(! sqlsrv_query($this->connection, $statement , $parameters ) ){
				die(print_r(sqlsrv_errors(), true));  
		   }
		   return 1;
        }catch(Exception $e){
            throw new Exception($e->getMessage());   // Exception handled if any error
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
?>