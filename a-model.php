<?php
require_once 'connection.php';


abstract class AModel
{
	static public $_table;
	static public $_pk;
	static public $_fields = [];
	static public $con;

	static public function get_table()
	{
		return static::$_table;
	}
	

	public function create()
	{
		try {
			$sql = 
				"INSERT INTO " . static::$_table  . " (" .
				implode(", ", static::$_fields) . ") VALUES (" . 
				implode(", ", 
					array_map(function($x) {
						return ":" . $x;
					},
					static::$_fields))
				. ")";
			var_dump(static::$con->prepare($sql));	
	        $query = static::$con->prepare($sql);

	        $execute = [];
	        foreach (static::$_fields as $field) {
	        	$execute[':' . $field] = $this->{$field};
	        }

	        $query->execute($execute);

		} catch(PDOException $e) {
			 print "Error!:" . $e->getMessage() . "<br/>";
			 die();

		}

		return true;
	}

	public function __construct()
	{
		self::$con = Connection::get_instance();
	}

	static public function add_records($records)
	{
		 return array_map(
			function($record) {
				return $record->create();
			},
			$records );
	}

	abstract static public function get_all();
	abstract static public function get_one($id);
	public function delete();

}

