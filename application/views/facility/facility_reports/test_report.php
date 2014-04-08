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
	width: 130px;
	font-size: 12.5px;
	margin: 0px;
	border-bottom: 1px solid #000033;
	}
.col5{
	background:#C9C299;
	}
	.try{
		float: right;
		margin-bottom: 1px auto;
	}
	.whole_report{
	      
    position: relative;
  width: 88%;
  background: #FFFAF0;
  -moz-border-radius: 4px;
  border-radius: 4px;
  padding: 2em 1.5em;
  color: rgba(0,0,0, .8);
  
  line-height: 1.5;
  margin: 20px auto;
   box-shadow: 0px 0px 5px #ccc;
  -moz-box-shadow: 0px 0px 5px #ccc;
  -webkit-box-shadow: 0px 0px 5px #ccc;
	}
	
	.messages{
		background-color: #036;
width: auto;
height: 50px;
line-height: 50px;
color: white;
text-decoration: none;
font-size: 14px;
font-family: helvetica, arial;
font-weight: bold;
display: inline;
padding: 5px;
		
	}

#tbl_body{
	width:100%;
	border-collapse:collapse;
}

#tbl_body th{
	padding: 3px 0px 3px 10px;
	cursor: pointer;
	font-size:1em;
	vertical-align: bottom;
	text-align:left;
}
#tbl_body input{
	width:75%;
	font-size:0.85em;
	height:60%;
}
/*<!--Table Header-->*/
#tbl_header{
	width:100%;
	border-collapse:collapse;
}
#tbl_header th{
	padding: 3px 0px 3px 10px;
	cursor: pointer;
	font-size:1em;
	vertical-align: bottom;
	text-align:left;
}
#tbl_header input{
	width:75%;
	font-size:0.85em;
	height:60%;
}
.reportDisplay{
	height:auto;
}	
</style>
<script>
$(function() {
	$(document).ready(function() {
	
	$(".from_date").datepicker({
	defaultDate : "+1w",
	changeMonth : true,
	changeYear : true,
	numberOfMonths : 1,
	onClose : function(selectedDate) {
		$("#to_date").datepicker("option", "minDate", selectedDate);
		
	}
			});
$(".to_date").datepicker({
	defaultDate : "+1w",
	changeMonth : true,
	changeYear : true,
	numberOfMonths : 1,
	onClose : function(selectedDate) {
		$("#from_date").datepicker("option", "maxDate", selectedDate);
	}
			});
	});
});
	
  
  
</script>
<div class="whole_report">
	<div>
		<img src="<?php echo base_url().'Images/coat_of_arms.png'?>" style="position:absolute;  width:90px; width:90px; top:0px; left:0px; margin-bottom:-100px;margin-right:-100px;"></img>
		<span style="margin-left:100px;  font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 15px;">Ministry of Health</span><br>
		<span style=" font-size: 12px;  margin-left:100px;">Health Commodities Management Platform</span><span style="text-align:center;" >
		<h2 style="text-align:center; font-size: 20px;"><?php echo $facility_data['facility_name'].' MFL '.$facility_data['facility_code']?> Malaria Report</h2>
		<hr/> 
	</div>
<?php 

	$attributes = array('enctype' => 'multipart/form-data');
	echo form_open('report_management/save_report2', $attributes);
	echo validation_errors('
	<p class="error">', '</p>
	');
	?>
<table class="tbl_header" border="0">

	<tr>
		<th>County</th>
		<td><label class="county_name"><?php echo $countyname;?></label></td>
		<th>District</th>
		<td><label class="district_name"><?php print_r($districtname) ;?></label></td>
		
	</tr>
	<tr>
		<th>Full SDP Name</th>
		<td><input type="text" id="f_sdp_name" class="x-large"></td>
		<th>MFL No</th><td><label class="f_code"><?php echo ' MFL '.$facility_data['facility_code'];?></label></td>
	</tr>
	<tr>
		<th>Facility Type</th>
		<td><label class="f_type"><?php echo $facility_type;?></label></td>
	</tr>
	<tr>
		<th>Agency</th>
		<td><label class="owner"><?php echo $owner;?></label></td>
		
	</tr>
	<tr>
		<th>Reporting Period</th>
		<?php
		if (isset($records))
	{
		$to_value = date('d/m/Y', strtotime($records[6]['to_date']));
		$from_value = date('d/m/Y', strtotime($records[6]['from_date']));
		}
	?>
		<td>From <input type="text" name="from" id="from_date" class="from_date" style="background-color:#FFF ;border:1" required="required" value="<?php echo $from_value;?> "/></td>
		<td colspan="2"> To  <input type="text" name="to" id="to_date" class="to_date" style="background-color:#FFF ;border:1" required="required" value="<?php echo $from_value;?> "/></td>
	</tr>
</table>
<table id="tbl_body" class="data-table">
<thead>
  <tr bgcolor="#66CCFF" class="centre">
    <th  height="55" bgcolor="#66CCFF" class="centre_row">Data Elements</td>
    <th  bgcolor="#66CCFF">Beginning Balance</th>
    <th >Quantity Received this Period</th>
    <th  >Total Quantity Dispensed</th>
    <th  >Losses Excluding Expiries</th>
    <th  >Positive Adjustments</th>
    <th  >Negative Adjustments</th>
    <th  >Physical Count</th>
    <th  >Quantity of Expired Drugs</th>
    <th  >Medicines with 6 months to Expiry</th>
    <th  >Days of Out of Stock</th>
    <th  style="width:12%">Total</th>
  </tr>
</thead>
<tbody>
<?php
	$code = "";
	foreach ($malaria_data as $row)
	{
		extract($row, EXTR_OVERWRITE);
		$code .= $kemsa_code. " ";
	
	}
	$code1 = explode(" ", $code);
	$drugs = Malaria_Drugs::getName();
	$counter2 = 0;
	foreach ($drugs as $drug)
	{
		$drugname[$counter2] = $drug['drug_name'];
		$counter2++;
		
	}
	
if (isset($records))
{
	$counter = 0;
	for($x=0; $x<count($records);$x++)
		{
			$id[$x] = $records[$x]['id'];
			$report_time[$x] = $records[$x]['report_time'];
			$beginning_bal[$x] = $records[$x]['beginning_balance']; 
			$kemsa_code[$x] = $records[$x]['kemsa_code']; 
			$amount_near_expiry[$x] = $records[$x]['amount_near_expiry']; 
			$quantity_balance[$x] = $records[$x]['quantity_balance'];
			$quantity_expired[$x] = $records[$x]['quantity_expired'];
			$physical_count[$x] = $records[$x]['physical_count'];
			$days_out_stock[$x] = $records[$x]['days_out_stock'];
			$amount_near_expiry[$x] = $records[$x]['amount_near_expiry'];
			$positive_adjustment[$x] = $records[$x]['positive_adjustment'];
			$negative_adjustments[$x] = $records[$x]['negative_adjustments'];
			$quantity_received[$x] = $records[$x]['quantity_received'];
			$total_quantity_dispensed[$x] = $records[$x]['total_quantity_dispensed'];
			$total[$x] = $records[$x]['total'];
			$losses[$x] = $records[$x]['losses'];
			$total[$x] = $records[$x]['total'];
			$from_date[$x] = $records[$x]['from_date'];
			$to_date[$x] = $records[$x]['to_date'];
			
		echo "<tr>
		<th bgcolor='#66CCFF' >".$drugname[$x]."</th>
		<td><input type='text' class='Beginning_Balance' name='Beginning_Balance[".$x."]' required='required' required='required' value = '".$beginning_bal[$x]."'/></td>
	    <td><input type='text' class='Quantity_Received' name='Quantity_Received[".$x."]'' required='required' required='required' value = '".$quantity_received[$x]."'/></td>
	    <td><input type='text' class='Total_Quantity_Dispensed' name='Total_Quantity_Dispensed[".$x."]'' required='required' required='required' value = '".$total_quantity_dispensed[$x]."'/></td>
	    <td><input type='text' class='Losses_Excluding_Expiries' name='Losses_Excluding_Expiries[".$x."]'' required='required' required='required' value = '".$losses[$x]."'/></td>
	    <td><input type='text' class='Positive_Adjustments' name='Positive_Adjustments[".$x."]'' required='required' required='required' value = '".$positive_adjustment[$x]."'/></td>
	    <td><input type='text' class='Negative_Adjustments' name='Negative_Adjustments[".$x."]'' required='required' required='required' value = '".$negative_adjustments[$x]."'/></td>
	    <td><input type='text' class='Physical_Count' name='Physical_Count[".$x."]'' required='required' value = '".$physical_count[$x]."'/></td>
	    <td><input type='text' class='Quantity_Expired_Drugs' name='Quantity_Expired_Drugs[".$x."]'' required='required' value = '".$quantity_expired[$x]."'/></td>
	    <td><input type='text' class='6Months_To_Expiry' name='6Months_To_Expiry[".$x."]'' required='required' value = '".$amount_near_expiry[$x]."'/></td>
	    <td><input type='text' class='Days_Out_Stock' name='Days_Out_Stock[".$x."]'' required='required' value = '".$days_out_stock[$x]."'/></td>
	    <td><input type='text' class='Report_Total' name='Report_Total[".$x."]'' required='required' value = '".$total[$x]."'/></td>
	    <td><input type='hidden' class='kemsa' name='kemsa[".$x."]'' value='".$kemsa_code[$x]."'/></td>
	    <td><input type='hidden' class='report_time' name='report_time[".$x."]'' value='".$report_time[$x]."'/></td>
	    <td><input type='hidden' class='report_time' name='id_value[".$x."]'' value='".$id[$x]."'/></td></tr>";
	
		$counter++;
	}
}
	echo "
		  </tbody>
		</table>
		<button name='cancel' type='cancel'>Cancel</button>
		<button type='submit' name='Submit' id='btn_submit'>Submit</button>";
	
	 echo form_close();?>
</div>