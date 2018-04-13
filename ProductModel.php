<?php

require_once "a-model.php";

class Product extends AModel 
{	
	static public $_table = 'product';
	static public $_pk = 'id';
	static public $_fields = ['name', 'price', 'description'];

	public function __construct($name, $price, $description, $id = NULL)
	{	
		parent::__construct();	
		$this->name = $name;
		$this->price = $price;
		$this->description = $description;
		$this->id = $id;				
	}

	static public function get_one($id)
	{
		$con = Connection::get_instance();		
		$sql = "SELECT * from " . self::$_table . " where id = " . $id;		
		$query = $con->prepare($sql);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);		
		$name = $result['name'];
		$price = $result['price'];
		$description = $result['description'];
		$id = $result['id'];
		return new self($name, $price, $description, $id);
	}

	static public function get_all()
	{
		$allProducts = [];
		$con = Connection::get_instance();		
		$sql = "SELECT * from " . static::$_table;		
		$query = $con->prepare($sql);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);		
		foreach ($result as $product) {
			$id = $product['id'];			
			$name = $product['name'];
			$price = $product['price'];
			$description = $product['description'];
			$allProducts[] = new self($name, $price, $description, $id);		
		}
		return $allProducts;
	}

	public function delete()
	{
		$sql = "DELETE from " . static::$_table . " where id = :id";
		$query = self::$con->prepare($sql);
		$query->execute([':id' => $this->id]);
	}
}

$phone1 = new Product('Samsung_A7', 700, 'I have it');
$phone1->create();
// var_dump(Product::get_one(1));
// $obj = Product::get_one(2);
// var_dump($obj);
// $obj->delete();
// var_dump($obj);
