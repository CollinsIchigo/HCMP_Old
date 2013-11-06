
<script type='text/javascript' src='<?php echo base_url(); ?>Scripts/jquery.easy-confirm-dialog.js'></script>
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

	
</style>
<script>
	$().ready(function(){
	$("#yesno").easyconfirm({locale: { title: 'Are you sure You want to Decommission?', button: ['No','Yes']}});
	$("#yesno").click(function() {
		//alert("You clicked yes");
	});
	});
	
	
</script>
<div class="messages">
	
	*Decommision-This sends an email with an attachment of all expired drugs to the DPP. (<?php echo $dpp_array[0]['fname'].' '.$dpp_array[0]['lname'] ?>)
</div>
<div class="whole_report">
	<?php $attributes = array( 'name' => 'myform', 'id'=>'myform');
	 echo form_open('stock_expiry_management/Decommission',$attributes); ?>
	<div class="try">
<button id="yesno" class="button">Decomission</button>
</div>

<?php  echo form_close();
		?>
<div class="try">
<button class="button">Download PDF</button>
</div>

<div>
	<img src="<?php echo base_url().'Images/coat_of_arms.png'?>" style="position:absolute;  width:90px; width:90px; top:0px; left:0px; margin-bottom:-100px;margin-right:-100px;"></img>
       
       <span style="margin-left:100px;  font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 15px;">
     Ministry of Health</span><br>
       <span style=" font-size: 12px;  margin-left:100px;">Health Commodities Management Platform</span><span style="text-align:center;" >
       	<h2 style="text-align:center; font-size: 20px;">Expired Commodities as of <?php 
					
					$today= ( date('d M, Y')); 
					echo $today;					
				?></h2>
       
       
      
       	<hr/> 
        
        	
</div>
<table class="data-table">
	
	<tr>
		<th>KEMSA Code</th>
		<th>Description</th>
		<th>Batch No Affected</th>
		<th>Manufacturer</th>
		<th>Expiry Date</th>
		<th>Unit size</th>
		<th>Stock Expired(Unit Size)</th>
	</tr>
	
			
		<tbody>
		
		<?php 
				foreach ($expired as $drug ) { ?>
					
					<?php foreach($drug->Code as $d){ 
								$name=$d->Drug_Name;
								$code=$d->Kemsa_Code;
					            $unitS=$d->Unit_Size; 
								$unitC=$d->Unit_Cost;
								$calc=$drug->balance;
								$thedate=$drug->expiry_date;
								$formatme = new DateTime($thedate);
								 $myvalue= $formatme->format('d M Y');
								?>
				
						<tr>
							
							<td><?php echo $code;?> </td>
							<td><?php echo $name;?></td>
							<td><?php echo $drug->batch_no;?> </td>
							<td><?php echo $drug->manufacture;?> </td>
							<td><?php echo $myvalue;?></td>
							<td><?php echo $unitS;?></td>
							<td><?php echo $drug->quantity;?></td>
							
							
						</tr>
					<?php }
							?>		
		</tbody>
		
		<?php }
					?>	
			
		
	 
</table>
</div>