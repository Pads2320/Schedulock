<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM users where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}

$departments = $conn->query("SELECT id, program_name FROM program WHERE status = 1");
$departments = $departments->fetch_all(MYSQLI_ASSOC);

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


$date_time_value = Date('Ymd');
$qrcode_user_event_session = "EVENT_SESSION_PROFESSOR_".$date_time_value."_".generate_qrcode_value(35);


?>
<form action="" id="people-frm">
	<div class="row">
		<div class="col-md-6">
			<div id="msg" class="form-group"></div>
			<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<input type="hidden" name='qrcode' value="<?php echo $qrcode_user_event_session ?>" id ="qrcode"/>
				
			<div class="form-group">
				<label for="id_number" class="control-label">Employee ID Number</label>
				<input type="text" class="form-control form-control-sm" name="id_number" id="id_number" value="<?php echo isset($id_number) ? $id_number : '' ?>" required>
			</div>

			<div class="form-group">
				<label for="firstname" class="control-label">First Name</label>
				<input type="text" class="form-control form-control-sm" name="firstname" id="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="firstname" class="control-label">Middle Name</label>
				<input type="text" class="form-control form-control-sm" name="middlename" id="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>" required>
			</div>

			<div class="form-group">
				<label for="lastname" class="control-label">Last Name</label>
				<input type="text" class="form-control form-control-sm" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="username" class="control-label">Username</label>
				<input type="text" class="form-control form-control-sm" name="username" id="username" value="<?php echo isset($username) ? $username : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="email" class="control-label">Email/Gmail</label>
				<input type="email" class="form-control form-control-sm" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
			</div>
		</div>
		<div class="col-md-6">	
			<div  class="form-group"></div>
            <div class="form-group">
                <label for="type" class="control-label">User Type</label>
                <select name="type" id="type" class="custom-select custom-select-sm">
					<option selected>Select</option>
					<option value="3" <?php echo (isset($type) && $type == 3) ? "selected" : '' ?>>Professor</option>                  
                    <option value="1" <?php echo (isset($type) && $type == 1) ? "selected" : '' ?>>School Staff</option>
                </select>
            </div>
			<div id="department-list" class="form-group" style="display: <?php echo (isset($type) && $type == 3) ? 'block' : 'none' ?>">
				<input type="hidden" name="department_id" value="0">
				<label for="department" class="control-label">Department</label>
				<select name="department_id" id="department_id_visible" class="custom-select custom-select-sm">
					<option value="0" selected>Select</option>
					<?php foreach($departments as $dept): ?>
						<option value="<?php echo $dept['id'] ?>" <?php echo (isset($department_id) && $department_id == $dept['id']) ? "selected" : '' ?>><?php echo $dept['program_name'] ?></option>
					<?php endforeach; ?>
                </select>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Image</label>
				<div class="custom-file">
		          <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		          <label class="custom-file-label" for="customFile">Choose file</label>
		        </div>
			</div>
			<div class="form-group d-flex justify-content-center">
				<img src="<?php echo validate_image(isset($avatar) ? $avatar : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>

		

		</div>
	</div>
</form>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>

	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}



	$(document).ready(function(){
		$('.select2').select2();
		$('#city_id').change(function(){
			var id = $(this).val();
			console.log($('#zone_id').find("[data-city='"+id+"']").length)
			$('#zone_id').find("[data-city='"+id+"']").show()
		$('#zone_id').select2();
		})
		$('#people-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Users.php?f=save',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
				error:err=>{
					console.log(err)

				},
				success:function(resp){
				if(resp == 1){
					var qrcode = $('#qrcode').val();					
					add_professor_user_session(qrcode);
					location.reload();
				}else if(resp == 3){
					var _frm = $('#people-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Person already exists.</div>"
					_frm.prepend(_msg)
					_frm.find('input#username').addClass('is-invalid')
					$('[name="code"]').focus()
				}else{
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})

	$('#department_id').on('change', function() {
		$('input[name="department_id"]').val($(this).val());
	});

	// Add Department if type is Professor
	$('#type').on('change', function() {
		if(this.value == 3){
			$('#department-list').show();
			$('select[name="department_id"]').prop('required', true);
		}else if(this.value == 1){
			$('#department_id').val('0').trigger('change'); 
			$('#department-list').hide();
			$('select[name="department_id"]').prop('required', false);
		}else{
			$('#department-list').hide();
			$('#department_id').val('0').trigger('change');
			$('select[name="department_id"]').prop('required', false);
		}
	});

	
	function add_professor_user_session(event_user_id){

		const db = firebase.database();

		var dbref_session = db.ref('door_access_session/'+event_user_id+'/');

		dbref_session.set({

			class_id: '0',
			is_logged_in: '0',
			is_professor: '1',
			qrcode: event_user_id
		});	

	} // add_professor_user_session from firebase realtime db

	

</script>