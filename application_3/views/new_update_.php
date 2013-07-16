<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/unit_size.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media2/css/jquery.dataTables.css";
		</style>
<style>
div.input {
  float: left;
    display: block;
    width: 302px;
}
.user{
		width:100px;
	}
	
	.user1{
	width:100px;
	background : none;
	border : none;
	text-align: center;
	}
	.date{
		width:110px;
	}
	
	.label-container
{
    margin: 10px 10px;
}
	
	</style>
	 <script> 
   /************************************calculating the  order values *******/
  
  function calculate_units1 (argument) {
  	
  	var x= argument;
  
  	
    //checking if the quantity is a number 	    
	var num = document.getElementsByName("units1["+x+"]")[0].value.replace(/\,/g,'');
if(!isNaN(num)){
if(num.indexOf('.') > -1) {
alert("Decimals are not allowed.");
document.getElementsByName("units1["+x+"]")[0].value = document.getElementsByName("units1["+x+"]")[0].value.substring(0,document.getElementsByName("units1["+x+"]")[0].value.length-1);
document.getElementsByName("units1["+x+"]")[0].select();
return;
}
} else {
alert('Enter only numbers');
document.getElementsByName("units1["+x+"]")[0].value= document.getElementsByName("units1["+x+"]")[0].value.substring(0,document.getElementsByName("units1["+x+"]")[0].value.length-1);
return;
}
  var actual_unit_size=get_unit_quantity(document.getElementsByName("u_size["+x+"]")[0].value);
    
 var total_units1=actual_unit_size*num;
 
   document.getElementsByName("qreceived["+x+"]")[0].value=total_units1; 
    
    
  }
   
   /*********************getting the last day of the month***********/
  function getLastDayOfYearAndMonth(year, month)
{
    return(new Date((new Date(year, month + 1, 1)) - 1)).getDate();
}
   
  /******************************************data-table set up*********************/
/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			}; 
    </script>   
   <script> 
	
	$(function() {
		
		        $( "#desc" ).combobox({
        	selected: function(event, ui) {
        		
           var data =$("#desc").val();
           
           var data_array=data.split("|");
         
           $('#unit_size').val(data_array[4]);
            $('#kemsa_code').val(data_array[1]);
         
            $( "#desc_hidden" ).val(data);
            
			}
			});
		
				
		json_obj = {
				"url" : "<?php echo base_url().'Images/calendar.gif';?>",
				};
	var baseUrl=json_obj.url;			
		$( "#datepicker" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});
		$( "#expiry_date" ).datepicker({
			beforeShowDay: function(date)
    {
        // getDate() returns the day [ 0 to 31 ]
        if (date.getDate() ==
            getLastDayOfYearAndMonth(date.getFullYear(), date.getMonth()))
        {
            return [true, ''];
        }

        return [false, ''];
    },
			changeMonth: true,
			changeYear: true,
			dateFormat: 'd M, yy'
		});
		
		$( "#rdates" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});

		$( "#dispatch_date" ).datepicker({
			showOn: "button",
			changeMonth: true,
			changeYear: true,
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});
				
		
         
		$( "#IssueNow" ).dialog({
		    autoOpen: true,
			height: 200,
			width:1250,
			modal: true,
			buttons: {
				"Add Commodity": function() {
					
					var details=$("#desc_hidden").val();	
					var details_array=details.split("|");				
						    
          $( "#main" ).dataTable().fnAddData( [
          	"" + details_array[2] + "",
         '<input type="hidden" name="kemsaCode['+count+']" value="'+details_array[0]+'" />'+
         '<input type="hidden" name="drugName['+count+']" value="'+details_array[3]+'" />'+ 
							"" + details_array[1] + "",
							"" + details_array[3] + "",
							'' +'<input class="user1" readonly="readonly" type="text" name="u_size['+count+']" value="'+$('#unit_size').val()+'"/>',
							'' +'<input class="user" type="text" name="batchNo['+count+']" value="'+$('input:text[name=batchNo]').val()+'"/>',
							'' +'<input class="my_date" type="text" name="Exp['+count+']"  value="'+ $('input:text[name=Exp]').val() +'"/>',
							'' +'<input class="user" type="text" name="units1['+count+']"  value="'+ $('#p_units1').val() +'" onkeyup="calculate_units1('+count+')" "/>',
							'' +'<input class="user1" readonly="readonly" type="text" name="qreceived['+count+']"  value="'+ $('#qreceived').val() +'"/> <img class="del" src="<?php echo base_url()?>Images/close.png" />'
							] ); 
						count= count+1;
						$( this ).dialog( "close" );
					refreshDatePickers();
						
        
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				$('#kemsa_code').val('');
				$('#unit_size').val('');
				$('input:text[name=batchNo]').val('');
				$('#p_units1').val('');
				$('#qreceived').val('');
				
			}
						
			});
			
			$( "#NewIssue" )
			.button()
			.click(function() {
				$( "#IssueNow" ).dialog( "open" );
			});
			$( "#finishIssue" )
			.button()
			.click(function() {
				$( "#myform" ).submit();
				 return true;
			});
			// Select all table cells to bind a click event
$('.del').live('click',function(){
    $(this).parent().parent().remove();
});
		
	});
	
		function refreshDatePickers() {
		var counter = 0;
		$('.my_date').each(function() {
			var this_id = $(this).attr("id"); // current inputs id
        var new_id = counter +1; // a new id
        $(this).attr("id", new_id); // change to new id
        $(this).removeClass('hasDatepicker'); // remove hasDatepicker class
        $(this).datepicker({ 
        	dateFormat: 'd M yy', 
        	        		beforeShowDay: function(date)
    {
        // getDate() returns the day [ 0 to 31 ]
        if (date.getDate() ==
            getLastDayOfYearAndMonth(date.getFullYear(), date.getMonth()))
        {
            return [true, ''];
        }

        return [false, ''];
    },
					changeMonth: true,
			        changeYear: true
				});; // re-init datepicker
				counter++;
		});
	}
	
 /************************************document ready**********************************************************/
   $(document).ready(function() {
   
refreshDatePickers();

    	$('#main').dataTable( {
         "bJQueryUI": true,
          "bPaginate": false
				} );
				
				
    
});

   </script>  
   
   	<div id="IssueNow" title="Fill in the details below">
	<table class="table-update" width="100%">
					<thead>
					<tr>
						
						<th><b>Description</b></th>
						<th><b>KEMSA code</b></th>
						<th><b>Unit Size</b></th>
						<th><b>Batch No</b></th>
						<th><b>Expiry Date &nbsp;</b></th>
						<th><b>Quantity Received</b></th>
						<th><b>Total Unit Count</b></th>
							
						    
					</tr>
					</thead>
					<tbody>
						<tr>
							
						<td>
			<input type="hidden" id="desc_hidden"  name="desc_hidden"/>				
        <select id="desc" name="desc">
    <option>-Type Commodity Name-</option>
		<?php 
		foreach ($drugs as $drugs) {
			$id=$drugs->id;
			$id1=$drugs->Kemsa_Code;
			$drug=$drugs->Drug_Name;
			$unit_size=$drugs->Unit_Size;
			foreach($drugs->Category as $cat){
				
			$cat_name=$cat;	
				
			}
			?>
			<option value="<?php echo $id."|".$id1."|".$cat_name."|".$drug."|".$unit_size;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select></td>
	<td >
						<input size="10" type="text" style="border: none" name="kemsa_code" id="kemsa_code"/>
	</td>
	<td width="50">
						<input size="10" type="text" style="border: none" name="u_size[0]" id="unit_size" />
	</td>
						<td >
						<input size="10" type="text" name="batchNo" />
	</td>
	<?php 
$today= date("d M, Y",strtotime("+1 month -1 second",strtotime(date("Y-m-1")))); ?>
	<td width="80">
	<input size="15" type="text" name="Exp" value="<?php echo $today; ?>"  id="expiry_date" />
	</td>
	<td width="80">
						<input size="5" type="text" name="units1[0]" id="p_units1" onkeyup="calculate_units1(0)" />
	</td>
						
	
	<td width="80"><input size="10" type="text" style="border: none" id="qreceived" name="qreceived[0]"/>
		
		
	</td>
						</tr>
					</tbody>
					</table>
					
	 			
						<input type="hidden"id="kemsac" name="kemsac"  readonly="readonly" />
						<input type="hidden" class="user" id="avlb_hide" name="avlb_hide" /> 
						<label></label>
						
</div>
<?php 
$att=array("name"=>'myform','id'=>'myform');
	 echo form_open('stock/submit',$att); ?>
	 <?php foreach($ord as $d):?>
	 	<div>
	 		<p id="notification" style="text-align:center;">* Please enter commodities upon confirmation of the actual counts </p>
		<p id="notification" style="text-align:center;">* Commodoties Received in packs </p>
	 	</div>
	 	<div id="updateord">
	 	<fieldset id="updateOrderleft">
	 		<legend>Order Details</legend>
	 		<div >
	 	<label>Order Date :</label>
	 	<input type="text" name="orderd" readonly="readonly" value="<?php $s= $d->orderDate; echo date('d M, Y', strtotime($s)); ?>"  />
	 	
	 	<label>Order By:</label>
	 	<input type="text" name="orderby" value="<?php $d->orderby?>" />
	 	
	 	<label>Order No:</label>
	 	<input type="text" name="order" readonly="readonly" value="<?php echo $this->uri->segment(3); ?>" />	 	
	 	
	 	 </div>
	 	</fieldset>
	
	 
	 <fieldset id="updateOrder_Centerleft">
	 	<legend>Approval Details</legend>
	 <div >
	 	
	 	<label>Approval Date</label>
	 	<input type="text" name="appd" readonly="readonly" value="<?php  $p=$d->approvalDate; echo date('d M, Y', strtotime($p));?>" />
	 	
	 	<label>Approved By</label>
		<input type="text"  name="appby" value="<?php $d->approveby?>" />
		
		<label>Order Sheet No :</label>
		<input type="text" name="lsn" value=""  />
				
		</div>
	 </fieldset>
	
	 <fieldset id="updateOrder_Centerright">
	 	 <legend>Dispatch Details</legend>
	 <div >
	 			
		<label>Dispatch Date:</label>
		<input type="text" name="dispdate" value="<?php echo $today;?>" id="dispatch_date" />	
			
		<label>Dispatched By:</label>
		<input type="text" name="dispby" value="" />
		
		<label>Delivery Note No:</label>
		<input type="text" name="dno" />
				
		<label>Source</label>
		<input type="text" name="warehouse" />
		</div>
		</fieldset>
		
		<fieldset id="updateOrderright">
	 	<legend>Delivery Details</legend>
	 <div >
	 	
	 	<label>Date Received</label>
	 	<input type="text" readonly="readonly" name="ddate" value="<?php echo date('d M, Y');?>"  id="rdates" class="box" />
	 	
	 	<label>Received By</label>
		<input type="text" readonly="readonly" name="rname" value="<?php echo $this -> session -> userdata('names');?> <?php echo $this -> session -> userdata('inames');?>" />
		
		<label>Receiver's Phone:</label>
		<input type="text" name="rphone" readonly="readonly" value="<?php echo $this -> session -> userdata('phone');?>"  />
		
		<label>District</label>
		<input type="text" name="district" readonly="readonly" value="<?php echo $this -> session -> userdata('district2');?>" />
				
		</div>
	 </fieldset>
  <?php endforeach?> 
 
  </div>		
  
 <div id="demo1" >
		<p id="notification">* Commodities as supplied by KEMSA</p>	
		<table  id="main" width="100%">
					<thead>
					<tr>
						<th><b>Category</b></th>
						<th><b>KEMSA Code</b></th>
						<th><b>Description</b></th>
						<th><b>Unit Size</b></th>
						<th><b>Batch No</b></th>
						<th><b>Expiry Date</b></th>
						<th><b>Quantity Received</b></th>
						<th><b>Total Unit Count</b></th>					   				    
					</tr>
					</thead>
					<tbody>
					<?php 
					$main_count=1;
					foreach ($order_details as $value) {
						$value1=$value->kemsa_code;
						 
					
						foreach($value->Code as $drug1){
						 
							$drug_name=$drug1->Drug_Name;
							$drug_code=$drug1->Kemsa_Code;
							$unit_size=$drug1->Unit_Size;
							$unit_cost=$drug1->Unit_Cost;
							
		
						}
						foreach($drug1->Category as $cat){
				
			$cat_name=$cat;	
				
			}
						echo"
						<tr>
						
						<input type='hidden' name='kemsaCode[$main_count]' value=$value1 />
						<input type='hidden' name='drugName[$main_count]' value=$drug_name />
						<td>$cat</td>
						<td>$drug_code</td>
						<td>$drug_name</td>
						<td><input class='user1' readonly='readonly' type='text' name='u_size[$main_count]' value='$unit_size'/></td>
						<td><input class='user' type='text' name='batchNo[$main_count]' value=''/></td>
						<td><input  class='my_date' type='text' name='Exp[$main_count]'  value=''/></td>
						<td><input class='user' type='text' name='units1[$main_count]'  value='' onkeyup='calculate_units1($main_count)'/></td>
						<td><input class='user1' readonly='readonly'  type='text' name='qreceived[$main_count]' value='' /> </td>
						
						</tr>";
						
					$main_count=$main_count+1;
					}
					
					echo "<script>var count=".($main_count)."</script>";
					?>
					
							
								
						</tbody>
					
				</table>
			
			<br />
			
<input class="button"   id="NewIssue"  value="Add Commodity" >
<input class="button" id="finishIssue"   value="Save " >
		</div>
		