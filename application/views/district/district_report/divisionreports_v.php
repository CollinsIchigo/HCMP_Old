<?php

	$current_year = date('Y');
	$current_month = date('F');
	$earliest_year = $current_year - 5;

?>
<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script> 
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url(); ?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript">
	$(function() {

		$(document).ready(function() {
		var url = "<?php echo base_url().'report_management/dist_malaria_report'?>";
      //alert (url);
        $.ajax({
          type: "POST",
          //data: {'desc':  $('#desc').val(), 'from': $('#from').val(),'drugname': $('#drugname').val(),'to': $('#to').val() ,'facilitycode': $('#facilitycode').val()},
          url: url,
          beforeSend: function() {
            $(".reportDisplay").html("");
          },
          success: function(msg) {
            $(".reportDisplay").html(msg);
            
             }
         });
			$("#malaria").click(function(){
				
      var url = "<?php echo base_url().'report_management/dist_malaria_report'?>";
      //alert (url);
        $.ajax({
          type: "POST",
          //data: {'desc':  $('#desc').val(), 'from': $('#from').val(),'drugname': $('#drugname').val(),'to': $('#to').val() ,'facilitycode': $('#facilitycode').val()},
          url: url,
          beforeSend: function() {
            $(".reportDisplay").html("");
          },
          success: function(msg) {
            $(".reportDisplay").html(msg);
            
             }
         });
    });
    
    $("#malaria").click(function(){
      var url = "<?php echo base_url().'raw_data/malaria_data'?>";
      var data_1="from= "+$('#from').val()+"&to="+ $('#to').val() +"&facilitycode="+ $('#facilitycode').val();
       ajax_request (url,data_1);
    });
    $("#malaria_data").click(function(){
      var url = "<?php echo base_url().'raw_data/malaria_data_report'?>";
      var data_1="from= "+$('#from').val()+"&to="+ $('#to').val()+"&facilitycode="+ $('#facilitycode').val();
       ajax_request (url,data_1);
    });
    
	$("#districtreport").click(function(){
      var url = "<?php echo base_url().'report_management/dist_contraceptives_consumption_report'?>";
      //alert (url);
        $.ajax({
          type: "POST",
          //data: {'desc':  $('#desc').val(), 'from': $('#from').val(),'drugname': $('#drugname').val(),'to': $('#to').val() ,'facilitycode': $('#facilitycode').val()},
          url: url,
          beforeSend: function() {
            $(".reportDisplay").html("");
          },
          success: function(msg) {
            $(".reportDisplay").html(msg);
            
             }
         });
    });
		
			$.fn.slideFadeToggle = function(speed, easing, callback) {
				return this.animate({
					opacity : 'toggle',
					height : 'toggle'
				}, speed, easing, callback);
			};

			$('.accordion').accordion({
				defaultOpen : 'section1',
				cookieName : 'nav',
				speed : 'medium',
				animateOpen : function(elem, opts) {//replace the standard slideUp with custom function
					elem.next().slideFadeToggle(opts.speed);
				},
				animateClose : function(elem, opts) {//replace the standard slideDown with custom function
					elem.next().slideFadeToggle(opts.speed);
				}
			});
					
			});
				$("#from").datepicker({
				defaultDate : "+1w",
				changeMonth : true,
				changeYear : true,
				numberOfMonths : 1,
				onClose : function(selectedDate) {
					$("#to,#to_order,#tocommodity").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#to").datepicker({
				defaultDate : "+1w",
				changeMonth : true,
				changeYear : true,
				numberOfMonths : 1,
				onClose : function(selectedDate) {
					$("#from,#from_order,#fromcommodity").datepicker("option", "maxDate", selectedDate);
				}
			});
	}); 
</script>
<style>
.content input[type="text"]{
display: inline-block;
margin-top: 0.4em;
width:37%;
margin-right:0.5em;
padding: 0.55em 0.9em;
margin-bottom:2em;

}
.content input[type="radio"]{
display: inline-block;
margin-top: 0.3em;
width:15%;
margin-right:0.1em;
padding: 0.55em 0.9em;
}

.leftpanel{
width: 19%;
height:auto;
float: left;
}
.reportDisplay{
width: 79%;
min-height:500px;
float: left;
margin-left:2em;
}

#accordion {
width: 300px;
margin: 50px auto;
float:left;
margin-left:0.45em;
}
.collapsible,
.page_collapsible,
.accordion {
margin: 0;
padding:5%;
height:15px;
border-top:#f0f0f0 1px solid;
background: #cccccc;
font:normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;
text-decoration:none;
text-transform:uppercase;
background: #29527b; /* Old browsers */
border-radius: 0.5em;
color: #fff; }
.accordion-open,
.collapse-open {
background: #289909; /* Old browsers */
color: #fff; }
.accordion-open span,
.collapse-open span {
display:block;
float:right;
padding:10px; }
.accordion-open span,
.collapse-open span {
background:url('<?php echo base_url()?>Images/minus.jpg') center center no-repeat; }
.accordion-close span,
.collapse-close span {
display:block;
float:right;
background:url('<?php echo base_url()?>
	Images/plus.jpg') center center no-repeat;
	padding:10px; }
	div.container {
		width: auto;
		height: auto;
		padding: 0;
		margin: 0;
	}
	div.content {
		background: #f0f0f0;
		margin: 0;
		padding: 10px;
		font-size: .9em;
		line-height: 1.5em;
		font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
	}
	div.content ul, div.content p {
		padding: 0;
		margin: 0;
		padding: 3px;
	}
	div.content ul li {
		list-style-position: inside;
		line-height: 25px;
	}
	div.content ul li a {
		color: #555555;
	}
	div.content h2 {
		text-align: center;
	}
	code {
		overflow: auto;
	}
	.accordion h3.collapse-open {
	}
	.accordion h3.collapse-close {
	}
	.accordion h3.collapse-open span {
	}
	.accordion h3.collapse-close span {
	}

	.from {
		background-color: #749a02;
		-webkit-box-shadow: 0 0 9px #333; }
		50% { background-color: #91bd09;
		-webkit-box-shadow: 0 0 18px #91bd09;
	}
	.to {
		background-color: #749a02;
		-webkit-box-shadow: 0 0 9px #333;
	}

</style>
<div class="leftpanel">
<h3 class="accordion" id="section1">Division of Malaria Control<span></span><h3>
	 <div class="container">
	     <div class="content">
	     	<h2>Click below to View the Report for <?php echo $current_month?> <?php echo $current_year?></h2>
	     	<button id="malaria" class="awesome blue" style="display: block; margin-left:20%; margin-top: 1em;">View Report</button>
	    
	     </div>
	 </div>

<h3 class="accordion" id="section2">Division of Reproductive Health<span></span><h3>
	 <div class="container">
	 	<div class="content">
	 		<h2>Click below to View the D-CDRR for <?php echo $current_month?> <?php echo $current_year?></h2>
	     	<button id="districtreport" class="awesome blue" style="display: block; margin-left:20%; margin-top: 1em;">View Report</button>
	 </div>
	 </div>
<h3 class="accordion" id="section2">Facility Reports<span></span><h3>
	<div class="content">
		 <select id="desc" name="desc" class="dropdownsize">
		 	
		 	<option>Select Facility</option>
		 	<?php 
				foreach ($facility_name as $facility) 
				{
					$id = $facility -> id;
					$name = $facility -> facility_name;
										
					?>
					<option value="<?php echo $id; ?>" id ="facility_name"><?php echo $name; ?></option>
					
			<?php } ?>		 
		</select>
		
		<h2>Click below to choose date range</h2>
		<input type="text" size="10"  value="" id="from" placeholder="From" />
		<input type="text" size="10"  value="" id="to" placeholder="To"/>
		<button class="awesome blue" id="malaria_data" style="margin-left:0%">Generate Report</button>
		<?php 
			$attributes = array( 'name' => 'myform', 'id'=>'myform');
			echo form_open('/',$attributes); 
			
			?>	
		<button id="downloader" class="btn" >Download PDF<i class="icon-circle-arrow-down" style="margin-left: 3px"></i></button>
		
		<?php  
			echo form_close();
				
			?>
		<input type="hidden"  value="<?php echo $id ?>" id="facilitycode" name="facilitycode" />
    </div>
</div>
 <div class="reportDisplay">
	
 </div>

