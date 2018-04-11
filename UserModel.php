<?php

require_once "a-model.php";

class User extends AModel {
	
	public function __construct($name, $group_id){
		parent::__construct();
		$this->name = $name;
		$this->group_id = $group_id;
		self::$_table = 'student';
		self::$_pk = 'student_id';
		self::$_fields = ['name', 'group_id'];

		var_dump(self::$con);
	}

}

$Kolya = new User("Kolyan", 6);
$Kolya->create();

