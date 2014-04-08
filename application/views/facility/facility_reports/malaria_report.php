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
if (isset($records))
{
	for($x=0; $x<count($records);$x++)
	{
		$beginning_bal[$x] =$records[$x]['beginning_balance']; 
		
			$QR = $this->input->post('Quantity_Received');
			$TQ = $this->input->post('Total_Quantity_Dispensed');
			$LExcl = $this->input->post('Losses_Excluding_Expiries');
			$PAdj = $this->input->post('Positive_Adjustments');
			$NAdj = $this->input->post('Negative_Adjustments');
			$PC = $this->input->post('Physical_Count');
			$QED = $this->input->post('Quantity_Expired_Drugs');
			$M6M = $this->input->post('6Months_To_Expiry');
			$DOS = $this->input->post('Days_Out_Stock');
			$T = $this->input->post('Report_Total');
			$kemsa = $this->input->post('kemsa');
			$to_date = $this->input->post('to_date');
			$from_date = $this->input->post('from_date');
			$kemsa = $this->input->post('kemsa');
	}
	//print_r($records);
	//exit;
	//foreach($records as $record)
	//{
		//print_r($record);
	//}
	//exit;
}else{
	$records="";
}
	$attributes = array('enctype' => 'multipart/form-data');
	echo form_open('report_management/save_report', $attributes);
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
		<td>From <input type="text" name="from" id="from_date" class="from_date" style="background-color:#FFF ;border:1" required="required"/></td>
		<td colspan="2"> To  <input type="text" name="to" id="to_date" class="to_date" style="background-color:#FFF ;border:1" required="required"/></td>
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
	
	
	?>
	<?php
	$counter = 0;
	foreach($drug_rows as $drug)
	{
		
		echo"<tr><th bgcolor='#66CCFF' >".$drug['drug_name']."</th>
		<td><input type='text' class='Beginning_Balance' name='Beginning_Balance[".$counter."]' required='required' required='required'/></td>
	    <td><input type='text' class='Quantity_Received' name='Quantity_Received[".$counter."]'' required='required' required='required'/></td>
	    <td><input type='text' class='Total_Quantity_Dispensed' name='Total_Quantity_Dispensed[".$counter."]'' required='required' required='required'/></td>
	    <td><input type='text' class='Losses_Excluding_Expiries' name='Losses_Excluding_Expiries[".$counter."]'' required='required' required='required'/></td>
	    <td><input type='text' class='Positive_Adjustments' name='Positive_Adjustments[".$counter."]'' required='required' required='required'/></td>
	    <td><input type='text' class='Negative_Adjustments' name='Negative_Adjustments[".$counter."]'' required='required' required='required'/></td>
	    <td><input type='text' class='Physical_Count' name='Physical_Count[".$counter."]'' required='required'/></td>
	    <td><input type='text' class='Quantity_Expired_Drugs' name='Quantity_Expired_Drugs[".$counter."]'' required='required'/></td>
	    <td><input type='text' class='6Months_To_Expiry' name='6Months_To_Expiry[".$counter."]'' required='required'/></td>
	    <td><input type='text' class='Days_Out_Stock' name='Days_Out_Stock[".$counter."]'' required='required'/></td>
	    <td><input type='text' class='Report_Total' name='Report_Total[".$counter."]'' required='required'/></td>
	    <td><input type='hidden' class='kemsa' name='kemsa[".$counter."]'' value='".$code1[$counter]."'/></td>
	    ";
	    $counter++;
		
	};?>
	</tr>
		  </tbody>
		</table>
		<button name='cancel' type='cancel'>Cancel</button>
		<button type='submit' name='Submit' id='btn_submit'>Submit</button>
	
	
	?>
 <?php echo form_close();?>
</div>