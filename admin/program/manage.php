<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM program where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}

$room_name = "";


date_default_timezone_set("Asia/Manila");
$date_time_now = Date('Y-m-d h:i:s');


?>
<form action="" id="program-frm">
	<div id="msg" class="form-group"></div>

	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>"/>
	<input type="hidden" name='added_by' value="<?php echo $_SESSION['userdata']['id']; ?>"/>
	<input type="hidden" name='status' value="1"/>
	<input type="hidden" name="date_time_created" id="date_time_created" value="<?php echo $date_time_now;?>"/>
	<input type="hidden" name="date_time_last_updated" id="date_time_last_updated" value="<?php echo $date_time_now;?>"/>
	
	<div class="form-group">
		<label for="program_name" class="control-label">Program Name</label>		
		<input type="text" class="form-control form-control-sm" name="program_name" id="program_name" value="<?php echo isset($program_name) ? $program_name : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="program_abbrev" class="control-label">Abbreviation</label>		
		<input type="text" class="form-control form-control-sm" name="program_abbrev" id="program_abbrev" value="<?php echo isset($program_abbrev) ? $program_abbrev : '' ?>" required>
	</div>
	
</form>



<script>

  
	
	$(document).ready(function(){
		$('.select2').select2();
	
		$('#program-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_program',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("an error occured "+err.err,"error")
					end_loader()
				},
				success:function(resp){
				if(resp.status == 'success'){				
					location.reload();
				}else{
					alert_toast("An error occured\n"+resp.err+"",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>