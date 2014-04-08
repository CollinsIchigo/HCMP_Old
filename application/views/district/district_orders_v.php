<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>

		<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc'] = function(x, y) {
				return ((x < y) ? -1 : ((x > y) ? 1 : 0));
			};

			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x, y) {
				return ((x < y) ? 1 : ((x > y) ? -1 : 0));
			};

			$(document).ready(function() {
				
				//button to post the order
			$( ".delete" )
			.button()
			.click(function() {
				
		var id=$(this).attr("id");
				
	$( "#dialog-confirm" ).dialog({
      resizable: false,
      autoOpen: true,
      height:200,
      modal: true,
      buttons: {
        "Delete all items": function() {
        	window.location="<?php echo site_url('order_management/delete_order');?>/"+id;	
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
			});	
			
			 $( "#dialog-confirm" ).dialog( {autoOpen: false} );

				$("#dialog1").dialog({
					height : 140,
					modal : true
				});

				/* Build the DataTable with third column using our custom sort functions */
				$('#example').dataTable({
					"bJQueryUI" : true,
					"aaSorting" : [[7, 'desc'], [0, 'desc']],
					"aoColumnDefs" : [{
						"sType" : 'string-case',
						"aTargets" : [2]
					}]
				});
			});
		</script> 

			<div id="dialog-confirm" title="Delete facility data?">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
  	<h3 class="text-error">The order will be deleted and cannot be recovered!. Are you sure?</h3></p>
</div>
<div id="notification">Drawing&nbsp;Rights&nbsp;Balance&nbsp;(KSH) = ( Intital Drawing rights - Order Value )</div>
<table width="100%" id="example">
	<thead>
	<tr>
		<th>Order&nbsp;Number</th>
		<th>Kemsa Order No.</th>
		<th>MFL&nbsp;Code</th>
		<th>Facility Name</th>
		<th>Initial&nbsp;Drawing&nbsp;Rights(KSH)</th>
		<th>Order&nbsp;Value&nbsp;(KSH)</th>
		<th>Drawing&nbsp;Rights&nbsp;Balance&nbsp;(KSH)</th>
		<th>Order&nbsp;Date</th>
		<th>Approval&nbsp;Status|Action</th>
		
	</tr>
	</thead>
	<tbody>
	<?php
		foreach($order_list as $rows){
	   $total=$rows->orderTotal;
	   $rights=$rows->drawing_rights;
	   $bal=$rights-$total;
?>
	<tr>
		<td><?php echo $rows -> id; ?></td>
		<td><?php echo $rows -> kemsaOrderid; ?></td>
		<td><?php echo $rows -> facilityCode; ?></td>
		<td><?php
			foreach ($rows->Code as $facility)
				$name = $facility -> facility_name;
			echo $name;
		?></td>
		<td><?php echo number_format($rights, 2, '.', ','); ?></td>
		<td><?php echo number_format($total, 2, '.', ','); ?></td>
		<td><?php echo number_format($bal, 2, '.', ','); ?></td>
		<td><?php
			$datea = $rows -> orderDate;
			$fechaa = new DateTime($datea);
			$datea = $fechaa -> format(' d M Y');
			echo $datea;
		?></td>
		<td><?php
		$order_status = $rows -> orderStatus;
		if (strtolower($order_status) == "pending") {
			$lcol = '"btn btn-warning"';
		} else if (strtolower($order_status) == "approved") {
			$lcol = '"btn btn-info"';
		} else if (strtolower($order_status) == "delivered") {
			$lcol = '"btn btn-success"';
		} else if (strtolower($order_status) == "rejected") {
			$lcol = '"btn btn-danger"';
		}

		echo ' <button style="text-transform:capitalize;width:6em;" class=' . $lcol . ' type="button">' . $order_status . '</button>';
	?>
		
		| <a href="<?php
			if (strtolower($order_status) == "pending" || strtolower($order_status) == "rejected") {

				echo site_url('order_approval/district_order_details/' . $rows -> id . '/');
			} else {
				echo site_url('order_management/moh_order_details/' . $rows -> id . '/' . $rows -> kemsaOrderid);
			}
			
		?>"class="btn btn-inverse" style="margin-right:1em;">View</a> |
		<a id="<?php echo $rows->id;?>" href="#"class="delete"> 
		<button style="text-transform:capitalize;width:6em;" class='btn btn-danger'type="button">
		DELETE</button></a></td>
		
		
	</tr> 
	<?php
	}
	?>
	</tbody>
</table>
