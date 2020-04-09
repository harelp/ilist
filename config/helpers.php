<?php 
	include('config/db_connect.php');
	// Creating a new list
	function createNewList(){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();
    
		$pin = randomPin();
		$directTo = "list.php?id=" . $pin;

		// removing any malicios code by turning everything to string
	    $pin = mysqli_real_escape_string($conn, $pin);
	    
	    // create sql query
	    $sql = "INSERT INTO list(pin) VALUES('$pin')";

	    // save to db and check
	    if(mysqli_query($conn, $sql)){
	        // success
	        header("Location: " . $directTo);
	    } else{
	        // error
	        echo 'query error: ' . mysqli_error($conn);
	    }

	    mysqli_close($conn);
	}


	// check pin
	function checkPin($pin){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();

		$isValid = true;
		$p = mysqli_real_escape_string($conn, $pin);
		$sql = "SELECT * FROM list WHERE pin ='". $p . "'";
	    // make query and get result
	    $result = mysqli_query($conn, $sql);
	    	
	    if($result->num_rows === 0) $isValid = false;
	    // fetch the resulting rows as an array
	    $list = mysqli_fetch_assoc($result);

	    // free result from memory
	    mysqli_free_result($result);

	    // close conn
	    mysqli_close($conn);
	    return $isValid;
	}

	// get todos by pin
	function getTodos($pin){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();

		$p = mysqli_real_escape_string($conn, $pin);

		// query to get all the pizza
    	$sql = "SELECT * FROM todo WHERE list_id = '". $p . "'";
	    // make query and get result
	    $result = mysqli_query($conn, $sql);
	    // fetch the resulting rows as an array
	    $todos = mysqli_fetch_all($result, MYSQLI_ASSOC);

	    // free result from memory
	    mysqli_free_result($result);

	    // close conn
	    mysqli_close($conn);
	    return $todos;
	}

	// create new todo
	function createTodo($pin, $todo){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();
    
		$p = mysqli_real_escape_string($conn, $pin);
	    $t = mysqli_real_escape_string($conn, $todo);

	    // create sql query
	    $sql = "INSERT INTO todo(list_id, todo, status) VALUES('$p', '$t', 'true')";

	    // save to db and check
	    if(!mysqli_query($conn, $sql)){
	       echo 'query error: ' . mysqli_error($conn);
	    }

	    mysqli_close($conn);
	}

	// update todo
	function updateTodo($id, $todo){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();
    
		$i = mysqli_real_escape_string($conn, $id);
	    $t = mysqli_real_escape_string($conn, $todo);
	    // create sql query
	    $sql = "UPDATE todo SET todo ='".$t."'"."WHERE todo_id = $i";

	    // save to db and check
	    if(!mysqli_query($conn, $sql)){
	       echo 'query error: ' . mysqli_error($conn);
	    }
	    mysqli_close($conn);
	}

	// update status
	function updateStatus($id, $status){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();
    
		$i = mysqli_real_escape_string($conn, $id);
	    $s = mysqli_real_escape_string($conn, $status);
	    // create sql query
	    $sql = "UPDATE todo SET status ='".$s."'"."WHERE todo_id = $i";

	    // save to db and check
	    if(!mysqli_query($conn, $sql)){
	       echo 'query error: ' . mysqli_error($conn);
	    }
	    mysqli_close($conn);
	}

	// delete a todo
	function deleteTodo($pin, $id){
		global $host, $user, $pass, $database;
		$conn = mysqli_connect($host, $user, $pass, $database);
		if(!$conn) echo 'Connection error: ' . mysqli_connect_error();

		$p = mysqli_real_escape_string($conn, $pin);
		$i = mysqli_real_escape_string($conn, $id);
	
		// query to get all the pizza
    	$sql = "DELETE FROM todo WHERE todo_id = $i AND list_id = '". $p . "'";

	    // // make query and get result
	    if(!mysqli_query($conn, $sql)){
	    	echo 'query error: ' . mysqli_error($conn);
	    }
	    // close conn
	    mysqli_close($conn);
	}

	

	function randomPin() {
		$alphabet = 'ABCDEFGHJKMNOPQRSTUVWXYZ23456789';
		$pass = ""; 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 4; $i++) {
		    $rand = rand(0, $alphaLength);
		    $pass .= $alphabet[$rand];
		}
		return $pass;
	}
?>

