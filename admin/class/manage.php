<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM classes where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}

$room_name = "";


date_default_timezone_set("Asia/Bangkok");
$date_time_now = date_default_timezone_get();

function numberToOrdinal($number) {
    // Ensure the input is an integer
    $n = (int)$number;
    
    // Special case for 11, 12, 13
    if ($n % 100 >= 11 && $n % 100 <= 13) {
        return $n . 'th';
    }

    // Determine the last digit
    switch ($n % 10) {
        case 1:
            return $n . 'st';
        case 2:
            return $n . 'nd';
        case 3:
            return $n . 'rd';
        default:
            return $n . 'th';
    }
} // numberToOrdinal


?>
<form action="" id="class-frm">
	<div id="msg" class="form-group"></div>

	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>"/>
	<input type="hidden" name='added_by' value="<?php echo $_SESSION['userdata']['id']; ?>"/>	
	<input type="hidden" name="date_time_added" id="date_time_added" value="<?php echo $date_time_now;?>"/>
	<input type="hidden" name="date_time_last_updated" id="date_time_last_updated" value="<?php echo $date_time_now;?>"/>
	
	<div class="form-group">
		<label for="class_name" class="control-label">Class Name</label>		
		<input type="text" class="form-control form-control-sm" name="class_name" id="class_name" value="<?php echo isset($class_name) ? $class_name : '' ?>" required>
	</div>


	<div class="form-group">
		<label for="yearlevel" class="control-label">Year Level</label>
		<select name="yearlevel" id="yearlevel" class="custom-select select2" required>
			<option></option>
			<?php 
				
				for($i = 1;$i<=5;$i++):
				
			?>
				<option value="<?php echo $i ?>" event_id = "<?php echo $yearlevel;?>" <?php echo isset($yearlevel) && $yearlevel ==  $i ? "selected" : '' ?>> <?php echo numberToOrdinal($i);?> Year</option>
			<?php endfor; ?>
		</select>
	</div>
	
</form>



<script>

  
	
	$(document).ready(function(){
		$('.select2').select2();
	
		$('#class-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_class',
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
					alert_toast("An error occured "+resp+"",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>