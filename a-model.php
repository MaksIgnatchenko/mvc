<?php
require_once 'connection.php';


abstract class AModel {
	static public $_table;
	static public $_pk;
	static public $_fields = [];

	static public $con;

	static public function get_table(){
		return static::$_table;
	}
	

	public function create() {

		try {
			$sql = 
				"INSERT INTO " . self::$_table  . " (" .
				implode(", ", self::$_fields) . ") VALUES (" . 
				implode(", ", 
					array_map(function($x) {
						return ":" . $x;
					},
					self::$_fields))
				. ")";

	        $query = self::$con->prepare($sql);

	        $execute = [];
	        foreach (self::$_fields as $field) {
	        	$execute[':' . $field] = $this->{$field};
	        }

	        $query->execute($execute);

		} catch(PDOException $e) {
			 print "Error!:" . $e->getMessage() . "<br/>";
			 die();

		}

		return true;
	}

	public function __construct(){
		self::$con = Connection::get_instance()->dbh;
	}

	static public function add_records($records){
		 return array_map(
			function($record) {
				return $record->create();
			},
			$records );
	}

	static public function get_all(){
		$records = [];
		//add select * from table using PDO
	 	return $records;
	} 

	// abstract public function get_one($id);

}

