<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM room where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}


date_default_timezone_set("Asia/Manila");
$date_time_now = Date('Y-m-d h:i:s');



?>

<form action="" id="room-frm">
	<div id="msg" class="form-group"></div>

	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>"/>
	<input type="hidden" name='added_by' value="<?php echo $_SESSION['userdata']['id']; ?>"/>
	<input type="hidden" name='status' value="1"/>
	<input type="hidden" name="date_time_added" id="date_time_added" value="<?php echo $date_time_now;?>"/>
	<input type="hidden" name="date_time_last_updated" id="date_time_last_updated" value="<?php echo $date_time_now;?>"/>
	<label for="name" class="control-label">Room Name</label>

	<div class="form-group">	
		<input type="text" class="form-control form-control-sm" name="room_name" id="room_name" value="<?php echo isset($room_name) ? $room_name : '' ?>" required>
	</div>
	
</form>

<script>

  
	
$(document).ready(function(){
		$('.select2').select2();
	
		$('#room-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_room',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
			    dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("an error occured","error")
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