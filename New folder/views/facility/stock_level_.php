<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media2/css/jquery.dataTables.css";
		</style>
<style>
.user{
	width:100px;
	/*background : none;
	border : none;*/
	text-align: center;
	}
/*	.col5{background:#D8D8D8;}*/
	</style>
    
<script>
/******************************************data-table set up*********************/
/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			};

function closing_trigger(counter){
	var i=counter;
	var user_option =($("input[type='radio'][name='group']:checked").val());
	
	if(user_option=="YES"){
	var o_bal=	parseInt($(document.getElementsByName("open["+i+"]")).val());
	var t_rec=	parseInt($(document.getElementsByName("receipts["+i+"]")).val());
	var t_iss=	parseInt($(document.getElementsByName("issues["+i+"]")).val());
	var adj=	parseInt($(document.getElementsByName("adjustments["+i+"]")).val());
	var los=	parseInt($(document.getElementsByName("losses["+i+"]")).val());
	var c_bal=o_bal+t_rec-t_iss+adj-los;
	$(document.getElementsByName("closing["+i+"]")).val(c_bal);
	
	}
	else{
		return;
	}
	
}
 $(function() {
			//button to post the order
			$( "#update" )
			.button()
			.click(function() {
				
	return $myDialog.dialog('open');
			});	
				
				//button to post the order
			$( "#Make-Order" )
			.button()
			.click(function() {
		return $myDialog.dialog('open');
					
			});	
			
			
			var $myDialog = $('<div></div>')
    .html('Please confirm the values before saving')
    .dialog({
        autoOpen: false,
        title: 'Confirmation',
        buttons: { "Cancel": function() {
                      $(this).dialog("close");
                      return false;
                },
                "OK": function() { 
                	var checker=0;
                	$("input[name^=open]").each(function() {
                		checker=checker+1;
                		
                	});
                	
                	if(checker==0){
                		alert("Cannot submit an empty form");
                		$(this).dialog("close"); 
                	}
                	else{
                	$(this).dialog("close"); 
                	$('#main_filter').html(function(){
                		
					$(this).find("input").val("");
					
					var the_table =$('#main').dataTable( {
						
    		"aaSorting": [ [0,'asc'], [1,'asc'] ],
					"bJQueryUI": true,
                   "bPaginate": false,
                   "bDestroy":true
				} );
					});
                      $('#myform').submit();
                      return true;	
                	}
                	
                      
                 }
        }
});

				
		  //popout
$( "#dialog1" ).dialog({
			height: 140,
			modal: true
		});
	});	
 
 		 
  $(document).ready(function() {
  	
  	
     // $("input[name^=open]").each(function(index, value) {
              //closing_trigger(index);
          
                    //});
			
    
    	var the_table =$('#main').dataTable( {
    		"aaSorting": [ [0,'asc'], [1,'asc'] ],
					"bJQueryUI": true,
                   "bPaginate": false
				} );
    
});
</script>
<?php if($msg=="Stock details have been updated"): ?>
<div id="dialog1">    
<?php echo $msg;?>
</div>
<?php endif;  ?>
<?php if(isset($msg)): ?>
<div id="notification">    
<?php echo $msg;?>
<?php echo "<br/>";?>
<?php echo "Your last update was on: ".$max_date[0]['MAX'];?>
</div>
<?php endif;  unset($msg);?>
    <?php $attributes = array( 'name' => 'myform', 'id'=>'myform');
     echo form_open('Order_Management/update_facility_transaction',$attributes); ?>        
        <div id="demo">
            <input type="hidden" name="option" value='<?php if(isset($update))
{echo $update;} else  {?>place_order <?php }  ?>' />
            <table>
            	<tr>
            		<td><label>enable auto calculate ( Closing Stock ) ? </label></td>
            		<td><label>YES</label><input type="radio" name="group"  value="YES" checked="checked"/></td><td><label>NO</label><input type="radio" name="group"  value="NO"/> </td>
            	</tr>
            </table>
            	 
            	
            	
                <table width="100%" id="main">
                    <thead>
                    <tr>
                        <th><b>Category</b></th>
                        <th><b>Description</b></th>
                        <th><b>KEMSA&nbsp;Code</b></th>
                        <th><b>Unit&nbsp;Size</b></th>
                        <th ><b>Opening&nbsp;Balance</b></th>
                        <th ><b>Total&nbsp;Receipts</b></th>
                        <th><b>Total&nbsp;issues</b></th>
                        <th><b>Adjustments</b></th>
                        <th><b>Losses</b></th>
                        <th><b>Days out of stock</b></th>   
                        <th><b>Closing Stock</b></th>
                                     
                    </tr>
                    </thead>
                    
                            <tbody>
                                <?php $count=0;
        foreach($facility_order as $drug){?>
                        <tr>
                            <?php foreach($drug->Code as $d){
                            	 echo form_hidden("drug_id[$count]", $d->id);
                            	$code=$d->Kemsa_Code;
                                $name=$d->Drug_Name; 
                                $ucost=$d->Unit_Cost;
                                $usize=$d->Unit_Size;}
                                foreach($d->Category as $cat){
				
			$cat_name=$cat;	
				
			}
                                ?>
                            <?php echo form_hidden('id['.$count.']', $drug->id);?>
                            <td><?php echo $cat?></td>
                            <td><?php echo $name?></td>
                            <td ><?php echo $code;?></td>
                            <td ><?php echo $usize;?></td>
                            <td><input class="user" type="text" <?php echo 'onkeyup="closing_trigger('.$count.')"' ?> <?php echo ' name="open['.$count.']"'?>  value="<?php echo $drug->Opening_Balance;?>" /></td>
                            <td><input class="user" type="text" <?php echo 'onkeyup="closing_trigger('.$count.')"' ?><?php echo ' name="receipts['.$count.']"'?>  value="<?php echo $drug->Total_Receipts;?>" /></td>
                            <td><input class="user" type="text" <?php echo 'onkeyup="closing_trigger('.$count.')"' ?><?php echo ' name="issues['.$count.']"'?> value="<?php echo $drug->Total_Issues;?>" /></td>
                            <td><input class="user" type="text" <?php echo 'onkeyup="closing_trigger('.$count.')"' ?><?php echo ' name="adjustments['.$count.']"'?> value="<?php echo $drug->Adj;?>"  /></td>
                            <td><input class="user" type="text" <?php echo 'onkeyup="closing_trigger('.$count.')"' ?><?php echo ' name="losses['.$count.']"'?> value="<?php echo $drug->Losses;?>" /></td>
                            <td><input class="user" type="text" <?php echo 'name="days['.$count.']"'?> value="<?php echo $drug->Days_Out_Of_Stock;?>" /></td>  
                            <td><input class="user" type="text" <?php echo 'name="closing['.$count.']" '?>value="<?php echo $drug->Closing_Stock;?>" /></td>
                                        
                        </tr>
                        
                        <?php  $count=$count+1; }?>
                        </tbody>
                </table>
                <?php
     echo form_close(); ?>   
           
        </div>
</div><!-- End demo -->
<br />
<input class="button" id="Make-Order" style="margin-left: 0%" <?php if(isset($update))
{echo 'value=',$update;} else  {?>value="Proceed To Order" <?php }  ?> >