<?php
class Malaria_Data extends Doctrine_Record 
{
	public function setTableDefinition() 
	{
		$this -> hasColumn('id', 'int',11);
		$this -> hasColumn('kemsa_code', 'varchar',30);
		$this -> hasColumn('beginning_balance', 'varchar',100);
		$this -> hasColumn('quantity_balance', 'varchar',30);
		$this -> hasColumn('quantity_expired', 'varchar',10);
		$this -> hasColumn('physical_count', 'varchar',30);
		$this -> hasColumn('days_out_stock', 'varchar',10);
		$this -> hasColumn('amount_near_expiry', 'varchar',30);
		$this -> hasColumn('positive_adjustment', 'varchar',30);
		$this -> hasColumn('negative_adjustments', 'varchar',10);
		$this -> hasColumn('quantity_received', 'varchar',30);
		$this -> hasColumn('total_quantity_dispensed', 'varchar',30);
		$this -> hasColumn('losses', 'varchar',30);
		$this -> hasColumn('total', 'varchar',30);
		$this -> hasColumn('user_id', 'int',11);
		$this -> hasColumn('facility_id', 'varchar',30);
		$this -> hasColumn('from_date', 'date');
		$this -> hasColumn('to_date', 'date');
		$this -> hasColumn('report_time', 'timestamp');
		
		
	}

	public function setUp() 
	{
		
		$this -> setTableName('malaria_data');
		//$this -> hasOne('kemsa_id as Code', array('local' => 'kemsa_code', 'foreign' => 'kemsa_code'));
		//$this -> hasOne('user_id as id', array('local' => 'user_id', 'foreign' => 'user_id'));
		
				
	}
	public static function get_user_data($id)
	{
		$query = Doctrine_Query::create() -> select("*") -> from("malaria_data")->where("user_id='$id'");
		$userdata = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $userdata[0];
			
	}
	public static function getall($id)
	{
		$query = Doctrine_Query::create() -> select("*") -> from("malaria_data")-> where("user_id = '$id' ")->groupBy("report_time");
		$all_data = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $all_data;
			
	}
	public static function getall_time($time)
	{
		$query = Doctrine_Query::create() -> select("*") -> from("malaria_data")-> where("report_time = '$time' ");
		$all_data = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $all_data;
			
	}
	public static function get_malariareport($id, $to_date, $from_date)
	{
		$query = Doctrine_Query::create() -> select("*") -> from("malaria_data")-> where("facility_id = '$id' and to_date < = '$to_date' and from_date >= '$from_date' ");
		$all_data = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $all_data;
			
	}
	
	public static function getreports() 
	{
		
		$from = $_POST['frommalariareport'];
		$to = $_POST['tomalariareport'];
		$facility_Code = $_POST['facilitycode'];
		$convertfrom = date('y-m-d',strtotime($from ));
		$convertto = date('y-m-d',strtotime($to ));
		
		$query = Doctrine_Query::create() -> select("*") 
		-> from("malaria_data")-> where("from_date >='$convertfrom' AND to_date <='$convertto'");
		$stocktake = $query ->execute();
		return $stocktake;
	}
}