<?php //$facility=$this -> session -> userdata('news');?>
<script type="text/javascript">
$(function() {
	$( "#dialog" ).dialog({
			height: 140,
			modal: true
		});
	$(document).ready(function() {
	});	
});
</script>
<div id="main_content">
	<div id="left_content">
		<fieldset>
			<legend>Action</legend>
		    <div class="activity issue">
				<a href="<?php echo site_url('report_management/write_report');?>"><h2>Facility Malaria Reports</h2></a>
			</div>
		</fieldset>
		
		<?php if(isset($popout)){ ?><div id="dialog" title="System Message"><p><?php echo $popout;?></p></div><?php }?>
	</div>
	<div id="right_content">
		<fieldset>
			<legend>Action</legend>			
			<div class="activity ext">
		<a href="#"><h2>TB Reports</h2></a>
		</div>	
		
	    
		<div class="activity ext">
		<a href="#"><h2>RH Reports</h2></a>
		</div>
      </fieldset>
	</div>

