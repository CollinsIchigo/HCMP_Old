<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home_Controller extends MY_Controller 
{
	function __construct() 
	{
		parent::__construct();
	}

	public function index($year=null) {

		$this -> home("",$year);
	}


public function get_dash_board_stats($dash_board_indicator)
{

	$county_id = $this -> session -> userdata('county_id');
	$district_id = $this -> session -> userdata('district1');
	$district_id = $this -> session -> userdata('district');
	$base_url=base_url();
	$indicator='';
	switch ($dash_board_indicator) 
	{
		case 'county':
		$indicator ="County";
		$facility_data=facilities::get_no_of_facilities_hcmp($county_id);
		$user_data=user::get_no_of_users_using_hcmp($county_id);
		$pending_orders = Ordertbl::get_pending_o_count($county_id);
		$decommissioned_items=facility_stock::get_decommisioned_count($county_id);
	
	$decommissioned_items[0]['total']=(count($decommissioned_items)==0)?0:$decommissioned_items[0]['total'];
	
	$facility_data='	<tr>
      			<td>Total No of Facilities in The '.$indicator.'</td>
            		
    			<td>
      				<a href="'.$base_url.'report_management/get_county_facility_mapping"><div class="badge" >'.$facility_data['total_no_of_facilities'].'</div></a>
    			</td>
  				</tr>	
  				<tr>
  				<td>Total No of Facilities in The '.$indicator.'  Using HCMP</td>
           <td>  <a href="'.$base_url.'report_management/get_county_facility_mapping"><div class="badge" >'.$facility_data['total_no_of_facilities_using_hcmp'].'</div></a></td>
    		</tr>
    	  <tr>
  				<td>% Coverage</td>
           <td>  <a href="'.$base_url.'report_management/get_county_facility_mapping"><div class="badge" >'.round(($facility_data['total_no_of_facilities_using_hcmp']/$facility_data['total_no_of_facilities'])*100,1).'%</div></a></td>
    		</tr>
    		<tr>
  				<td># of pending orders</td>
           <td> <a href="'.$base_url.'stock_expiry_management/county_deliveries"> <div class="badge" >'.$pending_orders.'</div></a></td>
    		</tr>
    		<tr>
  				<td># of decommissioned items</td>
           <td> <a href="'.$base_url.'stock_expiry_management/county_expiries"> <div class="badge" >'.$decommissioned_items[0]['total'].'</div></a></td>
    		</tr>
    		';
	 break;
	 case 'district':
		 $indicator ='District';
	$facility_data=facilities::get_no_of_facilities_hcmp($county_id,$district_id);
	$user_data=user::get_no_of_users_using_hcmp($county_id,$district_id);	
	$facility_data='	<tr>
      			<td>Total No of Facilities in The '.$indicator.'</td>
            		
    			<td>
      				<div class="badge" >'.$facility_data['total_no_of_facilities'].'</div>
    			</td>
  				</tr>	
  				<tr>
  				<td>Total No of Facilities in The '.$indicator.'  Using HCMP</td>
           <td>  <div class="badge" >'.$facility_data['total_no_of_facilities_using_hcmp'].'</div></td>
    		</tr>';
	
			break;		
		
		default:
			return NULL;
			break;
	}
	$stats_data='<div>
<table class="data-table">
    		'.$facility_data.'
  			<tr>
  			<td>
      			Total No of Users in The '.$indicator.' </td>
           	<td>
      				<div class="badge" >'.$user_data['total_no_of_users'].'</div>
  			</td>
  			
  			<tr>
    	<td>
      			Total No of Users in The '.$indicator.'  Accessing HCMP last 7 days</td>
            <td>
      				<div class="badge" >'.$user_data['total_no_of_users_7_days'].'</div>
      				</td>
      				</tr>
      				<tr>
    				<td>Users online in The '.$indicator.'</td>
            		<td><div class="badge" >'.$user_data['active_users'].'</div></td>
    				</tr>
    				</table>
					
  </div>';		
return $stats_data;
	
}

	public function home($pop_up=NULL,$year=null) 
	{

		$data['title'] = "Home";
		$access_level = $this -> session -> userdata('user_indicator');
		$facility_c = $this -> session -> userdata('news');
		
		if($access_level == "facility" || $access_level =="fac_user")
		{
			
			$data['name_facility'] = User::getUsers($facility_c);	
			$mydate = Dates::getDates();
			$compare = $mydate->toArray();
			$date2 = date("Y-m-d",time());
			$date1 = $compare['district_dl'];	
			$x1 = strtotime($date1);
			$x2 = strtotime($date2);
			//expired products
			$date = date('Y-m-d');
			$difference =($x1-$x2)/86400;
/*****************************************Notifications********************************************/	
            $data['percentage_complete'] = Historical_Stock::historical_stock_rate($facility_c);	
            $data['total_drugs']= count(Drug::getAll());  
		    $data['diff'] = $difference;			
			$data['exp'] = Facility_Stock::get_exp_count($facility_c);
			$data['exp_count'] = Facility_Stock::get_potential_count($facility_c);
			$data['stock'] = Facility_Stock::count_facility_stock_first($facility_c);
		    $data['pending_orders'] = Ordertbl::get_pending_count($facility_c);
			$data['rejected_orders'] = Ordertbl::get_rejected_count($facility_c);
			$count=Ordertbl::getPending_d($facility_c)->count();
			$data['pending_orders_d'] =$count;
			$data['dispatched'] = NULL;//Ordertbl::get_dispatched_count($facility_c);
			$data['incomplete_order'] = Facility_Transaction_Table::get_undated_records($facility_c);
/*************************************************************************************************/			
			$data['content_view'] = "facility/facility_home_v";
			$data['scripts'] = array("FusionCharts/FusionCharts.js"); 

		}
else if($access_level == "super_admin"){
	$data['content_view'] = "super_admin/home_v";
}
else if($access_level == "county_facilitator"){
	  $year=isset($year)?$year : date("Y");
	//$active_logs=Log::get_active_login($option,$option_id);
	$county_id=$this -> session -> userdata('county_id');
	$data['stats']=$this->get_dash_board_stats("county");
	$data['year']=$year;
	$data['content_view'] = "county/county_v_3";
	$data['banner_text'] = "Home";
	$data['link'] = "home";
	$data['coverage_data']=$this->get_county_dash_board_district_coverage();
    $data['max_date']=facility_stock::get_county_max_date($county_id);
	
	
	            if ($lab_count > 0) {
	                //".site_url('rtk_management/get_report/'.$facility_detail['facility_code'])."
	                $table_body .="<span class='label label-success'>Submitted  for    $lastmonth </span> <!--<img src='" . base_url() . "/Images/check_mark_resize.png'></img>--><a href=" . site_url('rtk_management/rtk_orders') . " class='link'>View</a></td>";
	            } else {
	                $table_body .="<span class='label label-important'>  Pending for $lastmonth </span> <a href=" . site_url('rtk_management/get_report/' . $facility_detail['facility_code']) . " class='link'>Report</a></td>";
	            }
	
	            $table_body .="</td>";
	       

		$data['table_body']=$table_body;
		$data['content_view'] = "rtk/dpp/dpp_home_with_table";
		$data['banner_text'] = "Home";
		$data['link'] = "home";
		

	 }
	
	else if($access_level == "rtk_manager")
	{
		$data['content_view'] = "rtk/home_v";
	}
	
	else if($access_level == "allocation_committee")
	{
	$counties=Counties::getAll();
		$table_data="";
		$allocation_rate=0;
		$total_facilities_in_county=1;
		$total_facilities_allocated_in_county=1;
		$total_facilities=0;
		$total_allocated=0;
		
	   foreach( $counties as $county_detail){
	   	
	   	   $countyid=$county_detail->id;
		  // $county_map_id=$county_detail->kenya_map_id;
	   	   $countyname=trim($county_detail->county);
	   	
		   $county_detail=rtk_stock_status::get_allocation_rate_county($countyid);
		   $total_facilities_in_county=$county_detail['total_facilities_in_county'];
		   $total_facilities_allocated_in_county=$county_detail['total_facilities_allocated_in_county'];
	
		  $total_facilities=$total_facilities+$total_facilities_in_county;
		  $total_allocated= $total_allocated+ $total_facilities_allocated_in_county;
	 
		   $table_data .="<tr><td><a href=".site_url()."rtk_management/allocation_county_detail_zoom/$countyid> $countyname</a> </td><td>$total_facilities_in_county | $total_facilities_allocated_in_county</td></tr>";
		   
		   }
	    $table_data .="<tr><td>TOTAL </td><td> $total_facilities | $total_allocated</td><tr>";
	 
	   
		$data['table_data']=$table_data;
		$data['pop_up']=$pop_up;
		$data['counties']= $counties=Counties::getAll();
		$data['content_view'] = "allocation_committee/home_v";
		
	}
	
	else if($access_level == "moh"){
				$data['stocks']=Facility_Stock::Allexpiries();
				$data['content_view'] = "moh/dash_board";
				
				$data['scripts'] = array("FusionCharts/FusionCharts.js"); 
				 $data['drugs'] = Drug::getAll();
				 $data['category'] = Drug_Category::getAll();
				$year=date("Y");
				$month=date('m');
				$drug_id=124;
				$detail= Facility_Issues::get_consumption_per_drug($drug_id,$year);
				$owner_count= Facilities::get_owner_count();
				
				
				
				$array_size=count($owner_count);
				$strXML_owner_count="<chart palette='2' bgColor='#FFFFFF' showBorder='0' caption='Facility Ownership' xAxisName='Owners' yAxisName='Facility Count' showValues='0' decimals='0' formatNumberScale='0' useRoundEdges='1'>";
				
				for($i=0;$i<$array_size;$i++){
					
					
					
					$strXML_owner_count .="<set label='".$owner_count[$i]['owner']."' value='".$owner_count[$i]['count']."' />";
				
	
				
				}
				$strXML_owner_count.="</chart>";
	$data['strXML_owner_count']=$strXML_owner_count;
				
				 
	$strXML_c1="<chart palette='2' bgColor='#FFFFFF' showBorder='0' caption='Consumption per commodity'subcaption='Absolute Ethanol(Methylated spirit)' xAxisName='Month' yAxisName='Units' showValues='0' decimals='0' formatNumberScale='0' useRoundEdges='1'>";
	for($i=0;$i<12;$i++){
	
	switch ($i){
		case 0:
			if(isset($detail[$i]['total']) && $month >=$i){
				$val=$detail[$i]['total'];
				$strXML_c1 .="<set label='Jan' value='$val' />";
				
			}	else{
				$val=0;
				$strXML_c1 .="<set label='Jan' value='$val' />";
			}
			
			break;
			case 1:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}
			$strXML_c1 .="<set label='Feb' value='$val' />";
			break;
			case 2:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Mar' value='$val' />";
			break;
			case 3:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1 .="<set label='Apr' value='$val' />";
			break;
			case 4:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='May' value='$val' />";
			break;
			case 5:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Jun' value='$val' />";
			break;
			case 6:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Jul' value='$val' />";
			break;
			case 7:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Aug' value='$val' />";
			break;
			case 8:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Sep' value='$val' />";
			break;
			case 9:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Oct' value='$val' />";
			break;
			case 10:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Nov' value='$val' />";	
			break;
			case 11:
			if(isset($detail[$i]['total'])){
				$val=$detail[$i]['total'];
				
			}	else{
				$val=0;
			}	
			$strXML_c1.="<set label='Dec' value='$val' />";
			break;
												
			
	}
		
	
	}
	$strXML_c1.="</chart>";
	$data['strXML_c1']=$strXML_c1;
	$strXML_c2 ="<chart caption='Consumption per Category' subcaption='Essential Medicines: External Medicines/Other Items'  numdivlines='9' bgColor='#FFFFFF' showBorder='0'lineThickness='2' showValues='0' anchorRadius='3' anchorBgAlpha='50' showAlternateVGridColor='1' numVisiblePlot='12' animation='0'>";
	$strXML_c2 .="<categories >";
	
	$strXML_c2 .="<category label='Jan'/>";
	$strXML_c2 .="<category label='Feb '/>";
	$strXML_c2 .="<category label='Mar '/>";
	$strXML_c2 .="<category label='Apr '/>";
	$strXML_c2 .="<category label='May '/>";
	$strXML_c2 .="<category label='Jun'/>";
	$strXML_c2 .="<category label='Jul '/>";
	$strXML_c2 .="<category label='Aug '/>";
	$strXML_c2 .="<category label='Sep'/>";
	$strXML_c2 .="<category label='Oct '/>";
	$strXML_c2 .="<category label='Nov'/>";
	$strXML_c2 .="<category label='Dec'/>";
	$strXML_c2 .="</categories>";
	$strXML_c2 .="<dataset seriesName='Drug A' color='800080' anchorBorderColor='800080'>";
	$strXML_c2 .="<set value='54' />";
	$strXML_c2 .="<set value='165' />";
	$strXML_c2 .="<set value='175' />";
	$strXML_c2 .="<set value='190' />";
	$strXML_c2 .="<set value='212' />";
	$strXML_c2 .="<set value='241' />";
	$strXML_c2 .="<set value='308' />";
	$strXML_c2 .="<set value='401' />";
	$strXML_c2 .="<set value='481' />";
	$strXML_c2 .="<set value='851' />";
	$strXML_c2 .="<set value='1250' />";
	$strXML_c2 .="<set value='2415' />";
	$strXML_c2 .="</dataset>";
	$strXML_c2 .="<dataset seriesName='Drug B' color='FF8040' anchorBorderColor='FF8040'>";
	$strXML_c2 .="<set value='111' />";
	$strXML_c2 .="<set value='120' />";
	$strXML_c2 .="<set value='128' />";
	$strXML_c2 .="<set value='140' />";
	$strXML_c2 .="<set value='146' />";
	$strXML_c2 .="<set value='157' />";
	$strXML_c2 .="<set value='190' />";
	$strXML_c2 .="<set value='250' />";
	$strXML_c2 .="<set value='399' />";
	$strXML_c2 .="<set value='691' />";
	$strXML_c2 .="<set value='952' />";
	$strXML_c2 .="<set value='1448' />";
	
	$strXML_c2 .="</dataset>";
	$strXML_c2 .="<dataset seriesName='Drug C' color='FFFF00' anchorBorderColor='FFFF00' >";
	$strXML_c2 .="<set value='115' />";
	$strXML_c2 .="<set value='141' />";
	$strXML_c2 .="<set value='175' />";
	$strXML_c2 .="<set value='189' />";
	$strXML_c2 .="<set value='208' />";
	$strXML_c2 .="<set value='229' />";
	$strXML_c2 .="<set value='252' />";
	$strXML_c2 .="<set value='440' />";
	$strXML_c2 .="<set value='608' />";
	$strXML_c2 .="<set value='889' />";
	$strXML_c2 .="<set value='1334' />";
	$strXML_c2 .="<set value='1637' />";
	
	$strXML_c2 .="</dataset>";
	$strXML_c2 .="<dataset seriesName='Drug D' color='FF0080' anchorBorderColor='FF0080' >";
	$strXML_c2 .="<set value='98' />";
	$strXML_c2 .="<set value='1112' />";
	$strXML_c2 .="<set value='1192' />";
	$strXML_c2 .="<set value='1219' />";
	$strXML_c2 .="<set value='1264' />";
	$strXML_c2 .="<set value='1282' />";
	$strXML_c2 .="<set value='1365' />";
	$strXML_c2 .="<set value='1433' />";
	$strXML_c2 .="<set value='1559' />";
	$strXML_c2 .="<set value='1823' />";
	$strXML_c2 .="<set value='1867' />";
	$strXML_c2 .="<set value='2198' />";
	
	$strXML_c2 .="</dataset>";
	$strXML_c2 .="</chart>";
	$data['strXML_c2']=$strXML_c2;
	
	            
				$detail_e1= Facility_Stock::poo($drug_id);
				$array_size=count($detail_e1);
				$strXML_e1="<chart palette='2' bgColor='#FFFFFF' showBorder='0' caption='Expiries per commodity'subcaption='Absolute Ethanol(Methylated spirit)' xAxisName='Month' yAxisName='Units' showValues='0' decimals='0' formatNumberScale='0' useRoundEdges='1'>";
				if($array_size>0){
				for($i=0;$i<$array_size;$i++){
					$month=date("M",strtotime($detail_e1[$i]['expiry_date']));
					$total=$detail_e1[$i]['total'];
					
					$strXML_e1 .="<set label='$month' value='$total' />";
				}}
	else{
		$strXML_e1 .="<set label='' value='' />";
	}
				$strXML_e1.="</chart>";
	$data['strXML_e1']=$strXML_e1;
			}
			else if($access_level == "kemsa"){
				$data['stocks']=Facility_Stock::Allexpiries();
				$data['content_view'] = "kemsa/kemsa_home_v";
			}
			else if($access_level == "fac_user"){
			$facility_c=$this -> session -> userdata('news');
				$mydate=Dates::getDates();
			
			$compare=$mydate->toArray();
			
			$date2 = date("Y-m-d",time());
				 		
			$date1=$compare['district_dl'];	
			$x1=strtotime($date1);
			$x2=strtotime($date2);
			
			//expired products////
				$date= date('Y-m-d');
	
			$difference=($x1-$x2)/86400;
	/*****************************************Notifications********************************************/		    
			    $data['diff']=$difference;			
				$data['exp']=Facility_Stock::get_exp_count($date,$facility_c);
			
				$data['exp_count']=Facility_Stock::expiries_count($facility_c)->toArray();
				$data['stock']=Facility_Stock::count_facility_stock_first($facility_c);
			    $data['pending_orders'] = Ordertbl::get_pending_count($facility_c);
				$data['dispatched'] = Ordertbl::get_dispatched_count($facility_c);
				$data['content_view'] = "facility_home_v";
				$data['scripts'] = array("FusionCharts/FusionCharts.js"); 
			}
			else if($access_level == "moh_user"){
				
				$data['content_view'] = "moh/moh_user_v";
			}
			else if($access_level == "district"){
				$data['stats']=$this->get_dash_board_stats("district");
				$district =$this -> session -> userdata('district1');
				
		
				$data['pending_orders'] = Ordertbl::get_pending_o_count(null,$district);
				$data['decommisioned'] = Facility_stock::get_decom_count($district);
				$data['drugs_array'] = Drug::getAll();
				$data['facilities']=Facilities::getFacilities($district);
			    $data['active_facilities']=Facility_Issues::get_active_facilities_in_district($district);
				$data['inactive_facilities']=Facility_Issues::get_inactive_facilities_in_district($district);
				$data['content_view'] = "district/district_dash";
			}
			
			$data['banner_text'] = "Home";
			$data['link'] = "home";
			$this -> load -> view("template", $data);

			$data['pending_orders'] = Ordertbl::get_pending_o_count(null,$district);
			$data['decommisioned'] = Facility_stock::get_decom_count($district);
			$data['drugs_array'] = Drug::getAll();
			$data['facilities']=Facilities::getFacilities($district);
		    $data['active_facilities']=Facility_Issues::get_active_facilities_in_district($district);
			$data['inactive_facilities']=Facility_Issues::get_inactive_facilities_in_district($district);
			$data['content_view'] = "district/district_home_v";
		}
		
		function district_lead_time()
		{
	   $strXML  = "";
	   $strXML .= "<chart bgColor='#FFFFFF' showBorder='0' lowerLimit='0' upperLimit='100' numberSuffix='%25' toolTipBgColor='AFD8F8'>";
	   $strXML .= "<colorRange><color minValue='0' maxValue='45' code='FF654F'/><color minValue='45' maxValue='80' code='F6BD0F'/><color minValue='80' maxValue='100' code='8BBA00'/></colorRange>";
	   $strXML .= "<dials><dial value='10' rearExtension='10'/></dials>";
	   $strXML .= "<trendpoints><point value='50' displayValue='Order Fill Rate' fontcolor='FF4400' useMarker='1' dashed='1' dashLen='2' dashGap='2' valueInside='1' /></trendpoints>";
	   $strXML .= "</chart>";
	   
	   /**********************************************/
	    $strXML1 .= "<chart bgColor='#FFFFFF' caption='days' showBorder='0' lowerLimit='0' upperLimit='100' lowerLimitDisplay='order' upperLimitDisplay='deliver' palette='1' chartRightMargin='20'>";
	    $strXML1 .="<colorRange><color minValue='0' maxValue='14' /><color minValue='15' maxValue='44' /><color minValue='45' maxValue='100'/></colorRange>";
	    $strXML1 .="<pointers><pointer value='45' /></pointers>";
		$strXML1 .='</chart>';
		
		echo $strXML;
		}

  function lead_pie_chart(){
  	$strXML="";
  	$strXML .= "<chart palette='2' showBorder='0' bgColor='FFFFFF'>";
   $strXML .= '<set label="order|approval" value="1" isSliced="1" />'; 
   $strXML .= '<set label="approval|dispatch" value="4" isSliced="0" />'; 
   $strXML .= '<set label="dispatch|deliver" value="40" />';
   $strXML .= "</chart>";
   echo $strXML;
  }
	
     function load_stock(){
     	$data['title'] = "Stock level";
     	$data['content_view'] = "stock";
     	$data['scripts'] = array("FusionCharts/FusionCharts.js"); 
		$data['banner_text'] = "Home";
		$data['quick_link'] ="load_stock";
		$data['link'] = "home";
		$this -> load -> view("template", $data);
		
     }
     public function get_county_dash_board_district_coverage()
     {
     	$county_id=$this -> session -> userdata('county_id');
		$district_data=districts::getDistrict($county_id);
		
	$total_facilities=0;	
	$rolled_out_facilities=0;
		
			
     		$table="<table class='data-table'><thead><tr>
     		<th>District</th><th># of Facilities</th><th># using tool</th><th>% coverage</th>
     		</tr></thead><tbody>";
     		
     		  foreach($district_data as $district_detail):
	    
		      $district_id=$district_detail->id;
		      $more_data=districts::get_district_coverage($district_id);
			  $table .="<tr>";
			  foreach($more_data as $data):
				  $coverage=0;	
			
		@$coverage =round((($data['total_2']/$data['total']))*100,1);	
		      $total_facilities=$total_facilities+$data['total'];
	          $rolled_out_facilities=$rolled_out_facilities+$data['total_2'];
			  
				  
			  $table .="<td>$data[district]</td>
			  <td>$data[total]</td>
			  <td>$data[total_2]</td>
			  <td> $coverage %</td>";
			  endforeach;
			   $table .="</tr>";
				  endforeach;
			
     	return $table."<tr>
     	<td>TOTAL</td><td>$total_facilities</td>
     	<td>$rolled_out_facilities</td>
     	<td>
     	".round((($rolled_out_facilities/$total_facilities))*100,1)." %</td></tr></tbody></table>";
     }
 

}
