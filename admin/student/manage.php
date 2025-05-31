<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM students where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}

$class_qry = $conn->query("SELECT * FROM classes");

$classes_array = array();

while($row_class = $class_qry->fetch_assoc()){
	$classes_array[$row_class['id']] = $row_class['class_name'];
}



function generate_qrcode_value($lim){

	$charset = "ABCDEFGHJILKMNOPQRSTUVWXYZ0123456789";
	$charset .= strtolower($charset);
	$charset_length = strlen($charset);
	$random_character = "";

	for($i=0;$i<$lim;$i++){
		$random_character .= $charset[mt_rand(0,$charset_length-1)];
	}

	return $random_character;

}

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


$date_time_value = Date('Ymd');
$qrcode_user_event_session = "EVENT_SESSION_USER_".$date_time_value."_".generate_qrcode_value(35);

?>
<form action="" id="student-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<input type="hidden" name= "qrcode_value" id = "qrcode_value" value = "<?php echo $qrcode_user_event_session; ?>">
	<input type="hidden" name= "added_by" id = "added_by" value = "<?php echo  $_SESSION['userdata']['id']; ?>"/>
	<input type="hidden" name= "status" id = "status" value = "1"/>
	
	<div class="form-group">
		<label for="id_number" class="control-label">Student Number</label>
		<input type="text" class="form-control form-control-sm" name="id_number" id="id_number" value="<?php echo isset($id_number) ? $id_number : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="firstname" class="control-label">First Name</label>
		<input type="text" class="form-control form-control-sm" name="firstname" id="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="middlename" class="control-label">Middle Name</label>
		<input type="text" class="form-control form-control-sm" name="middlename" id="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="lastname" class="control-label">Last Name</label>
		<input type="text" class="form-control form-control-sm" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="email" class="control-label">Email</label>
		<input type="email" class="form-control form-control-sm" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
	</div>

	<div class="form-group">
		<label for="program" class="control-label">Program</label>
			<select name="program" id="program" class="custom-select select2" required>
				<option></option>
				<?php 
					$qry = $conn->query("SELECT id,program_name,program_abbrev FROM program");
					while($row = $qry->fetch_assoc()):
						
						$program_name = $row['program_name'];	
						$id = $row['id'];			
					
				?>
					<option value="<?php echo $id ?>"  <?php echo isset($program) && $program == $row['id'] ? "selected" : '' ?>> <?php echo $program_name; ?></option>
				<?php endwhile; ?>
			</select>		
	</div>

	<div class="form-group">
		<label for="contact" class="control-label">Contact</label>
		<input type="text" class="form-control form-control-sm" name="contact" id="contact" value="<?php echo isset($contact) ? $contact : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="remarks" class="control-label">Remarks</label>
		<textarea type="text" class="form-control form-control-sm" name="remarks" id="remarks" required ><?php echo isset($remarks) ? $remarks : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="yearlevel" class="control-label">Year Level</label>
		<select id="yearlevel" class="custom-select select2" required>
			<option value = ""></option>
			<?php 
				$qry = $conn->query("SELECT id,class_name,yearlevel FROM classes GROUP BY yearlevel");
				while($row = $qry->fetch_assoc()):
					
					$yearlevel_id = $row['yearlevel'];
					$yearlevel_name = numberToOrdinal($yearlevel_id)." Year";
				
			?>
				<option value="<?php echo $yearlevel_id ?>" yearlevel_id = "<?php echo $yearlevel_id;?>" <?php echo isset($yearlevel_id) && $yearlevel_id== $row['id'] ? "selected" : '' ?>> <?php echo $yearlevel_name; ?></option>
			<?php endwhile; ?>
		</select>
	</div>

	<div class="form-group">
		<label for="class_id" class="control-label">Class/Section</label>
		<select name="class_id" id="class_id" class="custom-select select2" required>	
		</select>
	</div>
	
</form>



<script type = "module">

  
		
		function add_user_event_session(qrcode, class_id){

			const db = firebase.database();

			
				var dbref = db.ref('door_access_session').child(qrcode);

				dbref.set({

					class_id: class_id,									
					qrcode: qrcode,
					is_logged_in: '0',
					is_professor: '0',								

				});
				

		} // add_user_event_session

	

		  
	$(document).ready(function(){
		
		$('.select2').select2();


		var option_selected = '';
		var class_ID = '';

		$('#yearlevel').on('change',function(){

			var yearlevel = $(this).val();

			$.post(_base_url_+'classes/Master.php?f=get_class_option',{yearlevel:yearlevel},function(data){

				option_selected += '<option></option>';

				for(var i = 0;i<data.length;i++){

					option_selected += '<option value = "'+data[i].class_id+'">'+data[i].class_name+'</option>';

					$('#class_id').html(option_selected);

				}

			},'json');


		});


		$('#class_id').on('change',function(){
			class_ID=$(this).val();
		});
	

		


	
		$('#student-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_student',
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
					var qrcode = $('#qrcode_value').val();
					//var class_id = $('#class_id option:selected').attr('class_id');
					add_user_event_session(qrcode,class_ID);			
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})

</script>