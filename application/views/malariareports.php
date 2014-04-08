<?php

$from=$this -> session -> userdata('from');
$to=$this -> session -> userdata('to');
$desc=$this -> session -> userdata('desc');
$drugname=$this -> session -> userdata('drugname');
$facilityName=$this -> session -> userdata('full_name');


?>

<style>
table.data-table1 {
	border: 1px solid #000033;
	margin: 10px auto;
	border-spacing: 0px;
	}
	
table.data-table1 th {
	border: none;
	color:#036;
	text-align:center;
	font-size: 13.5px;
	border: 1px solid #000033;
	border-top: none;
	max-width: 600px;
	}
table.data-table1 td, table th {
	padding: 4px;
	}
table.data-table1 td {
	border: none;
	border-left: 1px solid #000033;
	border-right: 1px solid #000033;
	height: 30px;
	
	font-size: 13px;
	margin: 0px;
	border-bottom: 1px solid #000033;
	}
.col5{
	background:#C9C299;
	}
	.figures{
	width:30px;
	}
	.try{
		float: right;
		margin-bottom: 1px auto;
	}
	.whole_report{
	      
    position: relative;
  width: 88%;
  background: #F0FFFF;
  -moz-border-radius: 4px;
  border-radius: 4px;
  padding: 2em 1.5em;
  color: rgba(0,0,0, .8);
  
  line-height: 1.5;
  margin: 20px auto;
  -moz-box-shadow: 0 0 5px 5px #888;
-webkit-box-shadow: 0 0 5px 5px#888;
box-shadow: 0 0 5px 5px #888;
	}
	
</style>
<?php

echo form_open('Raw_data/get_commodityIpdf');
 
?>
<div class="whole_report">
	<div class="try">
<!--<button class="button">Download PDF</button>-->
</div>
<div>
	<img src="<?php echo base_url().'Images/coat_of_arms.png'?>" style="position:absolute;  width:90px; width:90px; top:0px; left:0px; margin-bottom:-100px;margin-right:-100px;"></img>
       
       <span style="margin-left:100px;  font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 15px;">
     Ministry of Public Health and Sanitation/Ministry of Medical Services</span><br>
       <span style=" font-size: 12px;  margin-left:100px;">Health Commodities Management Platform</span><span style="text-align:center;" >
       	<h2 style="text-align:center; font-size: 20px;">Malaria Reports Summary</h2>
      
       <h2 style="text-align:center;"><?php echo $facilityName ?></h2>
       <h2 style="text-align:center;">Between <?php echo $from ?> & <?php echo $to ?> </h2>
       
       	<hr/> 
</div>


		<?php 
		if (isset($reports))
{
	$counter = 0;
	for($x=0; $x<count($reports);$x++)
		{
			$id[$x] = $reports[$x]['id'];
			$report_time[$x] = $reports[$x]['report_time'];
			$beginning_bal[$x] = $reports[$x]['beginning_balance']; 
			$kemsa_code[$x] = $reports[$x]['kemsa_code']; 
			$amount_near_expiry[$x] = $reports[$x]['amount_near_expiry']; 
			$quantity_balance[$x] = $reports[$x]['quantity_balance'];
			$quantity_expired[$x] = $reports[$x]['quantity_expired'];
			$physical_count[$x] = $reports[$x]['physical_count'];
			$days_out_stock[$x] = $reports[$x]['days_out_stock'];
			$amount_near_expiry[$x] = $reports[$x]['amount_near_expiry'];
			$positive_adjustment[$x] = $reports[$x]['positive_adjustment'];
			$negative_adjustments[$x] = $reports[$x]['negative_adjustments'];
			$quantity_received[$x] = $reports[$x]['quantity_received'];
			$total_quantity_dispensed[$x] = $reports[$x]['total_quantity_dispensed'];
			$total[$x] = $reports[$x]['total'];
			$losses[$x] = $reports[$x]['losses'];
			$total[$x] = $reports[$x]['total'];
			$from_date[$x] = $reports[$x]['from_date'];
			$to_date[$x] = $reports[$x]['to_date'];
			
		echo "
		<table class=\"data-table1\">
	
  <tr>
    <th >Data Elements</td>
    <th >Beginning Balance</th>
    <th >Quantity Received this Period</th>
    <th  >Total Quantity Dispensed</th>
    <th  >Losses Excluding Expiries</th>
    <th  >Positive Adjustments</th>
    <th  >Negative Adjustments</th>
    <th  >Physical Count</th>
    <th  >Quantity of Expired Drugs</th>
    <th  >Medicines with 6 months to Expiry</th>
    <th  >Days of Out of Stock</th>
    <th >Total</th>
  </tr>
<tbody>
		<tr>
		<th>".$kemsa_code[$x]."</th>
		<td>".$beginning_bal[$x]."</td>
	    <td>".$quantity_received[$x]."</td>
	    <td>".$total_quantity_dispensed[$x]."</td>
	    <td>".$losses[$x]."</td>
	    <td>".$positive_adjustment[$x]."</td>
	    <td>".$negative_adjustments[$x]."</td>
	    <td>".$physical_count[$x]."</td>
	    <td>".$quantity_expired[$x]."</td>
	    <td>".$amount_near_expiry[$x]."</td>
	    <td>".$days_out_stock[$x]."</td>
	    <td>".$total[$x]."</td>
	   ";
	
		$counter++;
	}
}else
{
	echo "<div class=\"norecord\"></div>";
}
					?>	
	 
</table>

</div>
<input type="hidden" value="<?php echo $from ?>" id="datefromB" name="datefromB" />
<input type="hidden"  value="<?php echo $to ?>" id="datetoB" name="datetoB" />
<input type="hidden" value="<?php echo $facilityName ?>" id="facilitycode1" name="facilitycode1" />

<?php form_close();
?>