<?php

/*
**	Class to log data in the database
**	1-	We can select the table where to log data when we instantiate the class.
**			new LogSys('database connection','keyword to select the table');
**	2-	With the method setData(columns,values) we can set the data we are going to store.
**			.setData('(column1, column2, column3, ...)','value1, value2, value3, ...');
**		Keep in mind that these strings parameters are alreay substring of the sql query.
**	3-	Execute the query and insert the data into the database.
** 			.execute();
**		This method return false if the query is not executed and there are some mysql errors.
*/

class LogSys
{
	
	var $dbconn;
	var $columns;
	var $values;
	var $table;

	function __construct($dbconn,$log_target){
	
		$this->dbconn = $dbconn;
		
		// Switch between different log targets
		// to select the right log table
		switch ($log_target){
			
			case 'team':
				$this->table = "LogTeam";
				break;

			case 'project':
				$this->table = "LogProject";
				break;
			
			case 'account':
				$this->table = "LogAccount";
				break;

		}

	}

	function __destruct(){

		mysqli_close($this->dbconn);
	
	}

	public function setData($columns, $values){

		$this->columns = $columns;
		$this->values = $values;

	}

	public function execute(){

		$query = "INSERT INTO " . $this->table . " " . $this->columns . " VALUES " . $this->values;

		if (mysqli_query($this->dbconn, $query)){
			return true;	
		} else {
			return mysqli_error($this->dbconn);
		}

	}

}


// DB Tables
/*

	# log helper to store the id and description for each log types
	# es.: 1 -> project title
	# 	   2 -> project description
	#      3 -> team member
	# 	   ...
	CREATE TABLE LogHelper 
	(id INT(11) NOT NULL PRIMARY KEY, 
	 description VARCHAR(30) NOT NULL UNIQUE);

		+-------------+-------------+------+-----+---------+-------+
		| Field       | Type        | Null | Key | Default | Extra |
		+-------------+-------------+------+-----+---------+-------+
		| id          | int(11)     | NO   | PRI | NULL    |       |
		| description | varchar(30) | NO   | UNI | NULL    |       |
		+-------------+-------------+------+-----+---------+-------+


	


	# log table to store all the project's edits
	CREATE TABLE LogProject 
	(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	 account INT(11) NOT NULL,
	 type INT(11) NOT NULL,
	 date DATE NOT NULL,
	 extra VARCHAR(30));
	
		+---------+-------------+------+-----+---------+----------------+
		| Field   | Type        | Null | Key | Default | Extra          |
		+---------+-------------+------+-----+---------+----------------+
		| id      | int(11)     | NO   | PRI | NULL    | auto_increment |
		| account | int(11)     | NO   |     | NULL    |                |
		| type    | int(11)     | NO   |     | NULL    |                |
		| date    | date        | NO   |     | NULL    |                |
		| extra   | varchar(30) | YES  |     | NULL    |                |
		+---------+-------------+------+-----+---------+----------------+






*/


/* SCRIPT NOT OBJECT ORIENTED STYLE

	// Check if the db connection is working
	if (!$dbconn){
		include 'db_connect.php';
	}

	// Switch between different log targets
	// to select the right log table
	switch ($log_target){
		
		case 'team':
			$table = "LogTeam";
			$values = "";
			break;

		case 'project':
			$table = "LogProject";
			$values = "";
			break;
		
		case 'account':
			$table = "LogAccount";
			$values = "";
			break;
	
	}

	$query = "INSERT INTO " . $table . " " . $columns . " VALUES " . $values;

	if (!mysqli_query($dbconn, $query)){
		// Print log error on browser console
		echo "<script>console.log('Error: " . $query . " - " . mysqli_error($dbconn) . "');</script>";
	}

*/

?>