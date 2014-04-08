<?php
class Commodity_Source extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('source_name',100);		
	}

	public function setUp() {
		$this -> setTableName('commodity_source');
	    $this -> hasMany('Drug as CommoditySourceName', array('local' => 'id', 'foreign' => 'source'));
		
	}
	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("commodity_source");
		$categories = $query -> execute();
		return $categories;
	}
	

	
}