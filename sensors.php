<?php

	// Defining global db_connection 
	$db_connection = NULL;


	// Function which returns error inside a JSON formatted text
	function response_error($msg, $error="HTTP/1.1 503 Service Unavailable"){
		header('Content-Type: application/json');
		header($error);
		echo '{"error":"'.$msg.'"}';
		exit(1);
	
	}

	function response_ok($content){
		header('Content-Type: application/json');
		echo $content;
		exit(1);
	}
	

	// Connects to the database and if the connection fails, HTTP Response code 503 (Service Unavailable) is returned.
	// Notice:
	//	The mysql_connect function is deprecated in PHP 5.5.0 and is removed from 7.0.0.
	//  	
	function ConnectToDatabase(){
		global $db_connection;

		// Create connection and select the database
                $db_connection = mysql_connect("localhost", "*****", "*****");
                mysql_select_db("testdb");
	
		// If the connection failed, set response as 503 and exit from the script.		
		if(!$db_connection){
			response_error("Connecting database failed",
				      "HTTP/1.1 503 Service Unavailable");
		}
	}


	// Retrieves sensor's status, timestamp, temperature and humidity
	// Parameters:
	//	sensor_id: Id of the sensor (
	//
	function GetSensor($sensor_id){

		try {
			// ID, Huoneanturi, Tila, Aikaleima, S1lampo, S1kosteus, S2lampo, S2kosteus, S3lampo, S3kosteus, S4lampo, S4kosteus 
			// Create a request for retrieving 
               		$result = mysql_query("SELECT * FROM anturit WHERE huoneanturi='".$sensor_id."' ORDER BY ID DESC LIMIT 1");
	
			if(!$result){ // If no results were found return an error
				response_error("No results for sensor:".$sensor_id,
				      "HTTP/1.1 500 Internal Server Error");
			}
					
			$row = mysql_fetch_array($result);
		

			$ret_values = array(
					"status" => $row["Tila"],
					"timestamp" => $row["Aikaleima"],
					"s1_temp" => $row["S1lampo"],
					"s2_temp" => $row["S2lampo"],
					"s3_temp" => $row["S3lampo"],
					"s4_temp" => $row["S4lampo"],

					"s1_humd" => $row["S1kosteus"],
					"s2_humd" => $row["S2kosteus"],
					"s3_humd" => $row["S3kosteus"],
					"s4_humd" => $row["S4kosteus"]
				);

			return $ret_values;		

		} catch(Exception $ex){
			response_error($ex);
		  	exit(1);
			
		}

	}

	// Retrieves sensors marked supported and returns JSON formatted string
	// Parameters:
	//	room_sensors: array of room sensor id's Ex. array("B1","B2","B3","B4")
	// Returns:
	//	JSON formatted sensor data
	function RetrieveSensors($room_sensors){

		// Supported sensor ids
		$rs_count = count($room_sensors);	
		$res_array = array();
	
		for($idx = 0; $idx < $rs_count; $idx++) {
			$rs_id = $room_sensors[$idx];
			$res_array[$rs_id] = GetSensor($rs_id);
		}	
	
		// Encode the array	
		return json_encode($res_array);
		
	}




	// Connect to database and return requested room sensors as JSON 	
	ConnectToDatabase();		
	response_ok(RetrieveSensors(array("B1","B2","B3","B4")));
		
	

?>
