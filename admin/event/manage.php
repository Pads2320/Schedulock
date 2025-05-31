<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT event_list.*, class_schedule.* FROM event_list JOIN class_schedule ON class_schedule.event_id = event_list.id WHERE event_list.id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
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


$date_time_value = Date('Ymd');
$qrcode_value = "EVENT_SESSION_".$date_time_value."_".generate_qrcode_value(15);

?>
<!-- <form action="" id="event-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<input type="hidden" id = "qrcode_id" name = "qrcode_id" value = "<?php echo ""; ?>">
	<div class="form-group">
		<label for="title" class="control-label">Title</label>
		<input type="text" class="form-control form-control-sm" name="title" id="title" value="<?php echo isset($title) ? $title : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="venue" class="control-label">Venue</label>
		<input type="text" class="form-control form-control-sm" name="venue" id="venue" value="<?php echo isset($venue) ? $venue : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="description" class="control-label">Description</label>
		<textarea type="text" class="form-control form-control-sm" name="description" id="description" required ><?php echo isset($description) ? $description : '' ?></textarea>
	</div>
	<div class="form-group">
		<label for="datetime_start" class="control-label">DateTime Start</label>
		<input type="datetime-local" class="form-control form-control-sm" name="datetime_start" id="datetime_start" value="<?php echo isset($date_start) ? date("H:i",strtotime($date_start)) : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="datetime_end" class="control-label">DateTime End</label>
		<input type="datetime-local" class="form-control form-control-sm" name="datetime_end" id="datetime_end" value="<?php echo isset($date_end) ? date("Y-m-d\\TH:i",strtotime($date_end)) : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="user_id" class="control-label">Assign To</label>
		<select name="user_id" id="user_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT id,concat(firstname,' ',lastname) as name FROM users where `type` = 2 order by concat(firstname,' ',lastname) asc ");
				while($row = $qry->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($user_id) && $user_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		<div class="icheck-primary">
			<input type="checkbox" id="limit_registration" name="limit_registration" value="1">
			<label for="limit_registration">
				Limited Time Of Registration Only
			</label>
		</div>
	</div>
	<div class="form-group" style="display:none">
		<label for="limit_time" class="control-label">Limit Registration Time (In Minutes)</label>
		<input type="number" min="0" class="form-control form-control-sm" name="limit_time" id="limit_time" value="<?php echo isset($limit_time) ? $limit_time : '' ?>">
	</div>
</form> -->


<form action="" id="event-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' id="event_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<input type="hidden" name = "description" id = "description" value = "desc"/>
	<input type="hidden" name = "venue" id = "venue" value = "venue"/>	
	<input type="hidden" name = "class_schedule_id" id = "class_schedule_id" value = "<?php echo $class_schedule_id; ?>"/>	

	
	<input type="hidden" name = "added_by" id = "added_by" value = "<?php echo $_SESSION['userdata']['id']; ?>"/>

	<div class="form-group">
		<label for="title" class="control-label">Subject Code</label>
		<input type="text" class="form-control form-control-sm" name="subject_code" id="subject_code" value="<?php echo isset($subject_code) ? $subject_code : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="room" class="control-label">Room</label>
		<select name="room" id="room" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT * FROM room where status = '1'");
				while($row = $qry->fetch_assoc()):
					
					$room_name = $row['room_name'];
					
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($room) && $room == $row['id'] ? "selected" : '' ?>><?php echo ucwords($room_name); ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="description" class="control-label">Subject Title</label>
		<textarea type="text" class="form-control form-control-sm" name="title" id="title" required><?php echo isset($title) ? $title : '' ?></textarea>
	</div>	
	<div class="form-group">
		<label for="professor" class="control-label">Professor</label>
		<select name="professor_id" id="professor_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT * FROM users where type = '3'");
				while($row = $qry->fetch_assoc()):
					$qrcode = $row['qrcode'];
					$username = $row['username'];
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
					$professor_name = ucwords($firstname." ".$lastname);
			?>
				<option value="<?php echo $row['id'] ?>" data-qrcode = "<?php echo $qrcode; ?>" <?php echo isset($professor_id) && $professor_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($professor_name); ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="class_id" class="control-label">Class to Assign</label>
		<select name="class_id" id="class_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT * FROM classes");
				while($row = $qry->fetch_assoc()):
					$class_name = $row['class_name'];
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($class_name); ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	<div class="form-group">
		Weekly Schedule Breakdown<br/>
		<small><i>Specify a time range per day, Select available day of the week only</i></small>
		
			<div class = "row mt-2">

				<div class="col-md-4">
					<div class="icheck-primary">
						<input type="checkbox" id="monday_sched" value="1" <?php echo !empty($monday) ? 'checked' : '' ?>>
						<label for="monday_sched">
							Monday
						</label>
					</div>
				</div>
				<?php
					if (!empty($monday)) {
						$monday_times = explode('-', $monday);
						$time_start_monday = $monday_times[0];
						$time_end_monday = $monday_times[1];
					} else {
						$time_start_monday = '';
						$time_end_monday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type="time" id="time_start_monday" value="<?php echo !empty($monday) ? date("H:i",strtotime($time_start_monday)) : "" ?>" name="monday_start_time"/>
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type="time" id="time_end_monday" value="<?php echo !empty($monday) ? date("H:i",strtotime($time_end_monday)) : "" ?>" name="monday_end_time"/>
				</div>

			</div> <!-- monday -->
		
			<div class = "row mt-2">
				<div class="col-md-4">
					<div class="icheck-primary">
						<input type="checkbox" id="tuesday_sched" value="1" <?php echo !empty($tuesday) ? 'checked' : '' ?>>
						<label for="tuesday_sched">
							Tuesday
						</label>
					</div>

				</div>
				<?php
					if (!empty($tuesday)) {
						$tuesday_times = explode('-', $tuesday);
						$time_start_tuesday = $tuesday_times[0];
						$time_end_tuesday = $tuesday_times[1];
					} else {
						$time_start_tuesday = '';
						$time_end_tuesday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type = "time" id = "time_start_tuesday" value="<?php echo !empty($tuesday) ? date("H:i",strtotime($time_start_tuesday)) : "" ?>" name="tuesday_start_time" />
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type = "time" id = "time_end_tuesday" value="<?php echo !empty($tuesday) ? date("H:i",strtotime($time_end_tuesday)) : "" ?>" name="time_end_tuesday"/>
				</div>

			</div> <!-- tuesday -->

			<div class = "row mt-2">

				<div class="col-md-4">

					<div class="icheck-primary">
						<input type="checkbox" id="wednesday_sched" value="1" <?php echo !empty($wednesday) ? 'checked' : '' ?>>
						<label for="wednesday_sched">
							Wednesday
						</label>
					</div>

				</div>
				<?php
					if (!empty($wednesday)) {
						$wednesday_times = explode('-', $wednesday);
						$time_start_wednesday = $wednesday_times[0];
						$time_end_wednesday = $wednesday_times[1];
					} else {
						$time_start_wednesday = '';
						$time_end_wednesday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type = "time" id = "time_start_wednesday" value="<?php echo !empty($wednesday) ? date("H:i",strtotime($time_start_wednesday)) : "" ?>" name="time_start_wednesday"/>
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type = "time" id = "time_end_wednesday" value="<?php echo !empty($wednesday) ? date("H:i",strtotime($time_end_wednesday)) : "" ?>" name="time_end_wednesday"/>
				</div>

			</div> <!-- wednesday -->

			<div class = "row mt-2">

				<div class="col-md-4">

					<div class="icheck-primary">
						<input type="checkbox" id="thursday_sched" value="1" <?php echo !empty($thursday) ? 'checked' : '' ?>>
						<label for="thursday_sched">
							Thursday
						</label>
					</div>

				</div>
				<?php
					if (!empty($thursday)) {
						$thursday_times = explode('-', $thursday);
						$time_start_thursday = $thursday_times[0];
						$time_end_thursday = $thursday_times[1];
					} else {
						$time_start_thursday = '';
						$time_end_thursday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type = "time" id = "time_start_thursday" value="<?php echo !empty($thursday) ? date("H:i",strtotime($time_start_thursday)) : "" ?>" name="time_start_thursday"/>
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type = "time" id = "time_end_thursday" value="<?php echo !empty($thursday) ? date("H:i",strtotime($time_end_thursday)) : "" ?>" name="time_end_thursday"/>
				</div>

			</div> <!-- thursday -->

			<div class = "row mt-2">

				<div class="col-md-4">

					<div class="icheck-primary">
						<input type="checkbox" id="friday_sched" value="1" <?php echo !empty($friday) ? 'checked' : '' ?>>
						<label for="friday_sched">
							Friday
						</label>
					</div>

				</div>
				<?php
					if (!empty($friday)) {
						$friday_times = explode('-', $friday);
						$time_start_friday = $friday_times[0];
						$time_end_friday = $friday_times[1];
					} else {
						$time_start_friday = '';
						$time_end_friday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type = "time" id = "time_start_friday" value="<?php echo !empty($friday) ? date("H:i",strtotime($time_start_friday)) : "" ?>" name="time_start_friday"/>
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type = "time" id = "time_end_friday" value="<?php echo !empty($friday) ? date("H:i",strtotime($time_end_friday)) : "" ?>" name="time_end_friday"/>
				</div>

			</div> <!-- friday -->

			<div class = "row mt-2">

				<div class="col-md-4">

					<div class="icheck-primary">
						<input type="checkbox" id="saturday_sched" value="1" <?php echo !empty($saturday) ? 'checked' : '' ?>>
						<label for="saturday_sched">
							Saturday
						</label>
					</div>

				</div>
				<?php
					if (!empty($saturday)) {
						$saturday_times = explode('-', $saturday);
						$time_start_saturday = $saturday_times[0];
						$time_end_saturday = $saturday_times[1];
					} else {
						$time_start_saturday = '';
						$time_end_saturday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type = "time" id = "time_start_saturday" value="<?php echo !empty($saturday) ? date("H:i",strtotime($time_start_saturday)) : "" ?>" name="time_start_saturday"/>
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type = "time" id = "time_end_saturday" value="<?php echo !empty($saturday) ? date("H:i",strtotime($time_end_saturday)) : "" ?>" name="time_end_saturday"/>
				</div>

			</div> <!-- saturday -->

			<div class = "row mt-2">

				<div class="col-md-4">

					<div class="icheck-primary">
						<input type="checkbox" id="sunday_sched" value="1" <?php echo !empty($sunday) ? 'checked' : '' ?>>
						<label for="sunday_sched">
							Sunday
						</label>
					</div>

				</div>
				<?php
					if (!empty($sunday)) {
						$sunday_times = explode('-', $sunday);
						$time_start_sunday = $sunday_times[0];
						$time_end_sunday = $sunday_times[1];
					} else {
						$time_start_sunday = '';
						$time_end_sunday = '';
					}
				?>
				<div class="col-md-4">
					<small>From</small>
					<input type = "time" id = "time_start_sunday" value="<?php echo !empty($sunday) ? date("H:i",strtotime($time_start_sunday)) : "" ?>" name="time_start_sunday"/>
				</div>
				<div class="col-md-4">
					<small>To</small>
					<input type = "time" id = "time_end_sunday" value="<?php echo !empty($sunday) ? date("H:i",strtotime($time_end_sunday)) : "" ?>" name="time_end_sunday"/>
				</div>

			</div> <!-- sunday -->

	</div>

	<div class="form-group">
		Date Range<br/>
		<small><i>Select Start and End Date of Student's Access Validity</i></small>
		
		<div class = "row mt-2">

			<div class="col-md-3">

				<div class="icheck-primary">					
					<label for="date_range_sched">
						Validity
					</label>
				</div>

			</div>

			<div class="col-md-5">
				<small>From</small>
				<input type = "date" id = "date_start_sched" value="<?php echo isset($date_start) ? date("Y-m-d",strtotime($date_start)) : '' ?>" />
			</div>
			<div class="col-md-4">
				<small>To</small>
				<input type = "date" id = "date_end_sched" value="<?php echo isset($date_end) ? date("Y-m-d",strtotime($date_end)) : '' ?>" />
			</div>

		</div> <!-- date range -->
		
	</div>

	<div class="form-group">
		Registration Time Limit<br/>
		<small><i>Check if every registration must have a time limit</i></small>
		<div class="icheck-primary">
			<input type="checkbox" id="limit_registration" name="limit_registration" value="1" <?php echo !empty($limit_registration) && $limit_registration == 1 ? 'checked' : '' ?>>
			<label for="limit_registration">
				Limited Time Of Registration Only
			</label>
		</div>
	</div>

	<div class="form-group" style="display:none">
		<label for="limit_time" class="control-label">Limit Registration Time (In Minutes)</label>
		<input type="number" min="0" class="form-control form-control-sm" name="limit_time" id="limit_time" value="<?php echo isset($limit_time) ? $limit_time : '' ?>">
	</div>
</form>

<script>
	
	$(document).ready(function(){
		$('.select2').select2();
		$('#limit_registration').on('change input',function(){
			if($(this).is(":checked") == true || $(this).val() == 1){
				$('#limit_time').parent().show('slow')
				$('#limit_time').attr("required",true);
			}else{
				$('#limit_time').parent().hide('slow')
				$('#limit_time').attr("required",false);
			}
		}).trigger('change')

		function addScheduleDetail(inserted_event_id){

			const db = firebase.database();

			var added_by = "";
			var class_id = "";
			var professor_id = "";
			var professor_qrcode = "";
			var subject_code = "";
			var monday_sched = "";
			var tuesday_sched = "";
			var wednesday_sched = "";
			var thursday_sched = "";
			var friday_sched = "";
			var saturday_sched = "";
			var sunday_sched = "";
			var class_schedule_id = "";
			var has_limit = "";
			var limit_time = "";
			var event_id = "";

			var date_start_range = "0000-00-00";
			var date_end_range = "0000-00-00";

			added_by = $('#added_by').val();
			class_id = $('#class_id').val();
			subject_code = $('#subject_code').val();
			class_schedule_id = $('#class_schedule_id').val();
			event_id = $('#event_id').val();

			var is_checked_monday = $('#monday_sched').prop('checked');
			var is_checked_tuesday = $('#tuesday_sched').prop('checked');
			var is_checked_wednesday = $('#wednesday_sched').prop('checked');
			var is_checked_thursday = $('#thursday_sched').prop('checked');
			var is_checked_friday = $('#friday_sched').prop('checked');
			var is_checked_saturday = $('#saturday_sched').prop('checked');
			var is_checked_sunday = $('#sunday_sched').prop('checked');

			date_start_range = $('#date_start_sched').val();
			date_end_range = $('#date_end_sched').val();

			professor_id = $('#professor_id').val();
			professor_qrcode = $('#professor_id option:selected').attr('data-qrcode');

			if($('#limit_registration').prop("checked") == true){
				has_limit = "1";
				limit_time = $('#limit_time').val();
			}else{
				has_limit = "0";
				limit_time = "0";
			}

			if(is_checked_monday == true){
				monday_sched = $('#time_start_monday').val() + "-" + $('#time_end_monday').val();
			}

			if(is_checked_tuesday == true){
				tuesday_sched = $('#time_start_tuesday').val() + "-" + $('#time_end_tuesday').val();
			}

			if(is_checked_wednesday == true){
				wednesday_sched = $('#time_start_wednesday').val() + "-" + $('#time_end_wednesday').val();
			}

			if(is_checked_thursday == true){
				thursday_sched = $('#time_start_thursday').val() + "-" + $('#time_end_thursday').val();
			}

			if(is_checked_friday == true){
				friday_sched = $('#time_start_friday').val() + "-" + $('#time_end_friday').val();
			}

			if(is_checked_saturday == true){
				saturday_sched = $('#time_start_saturday').val() + "-" + $('#time_end_saturday').val();
			}

			if(is_checked_sunday == true){
				sunday_sched = $('#time_start_sunday').val() + "-" + $('#time_end_sunday').val();
			}

			var dbref = db.ref('class_schedule').child(class_schedule_id);
			dbref.update({
				monday: monday_sched,
				tuesday: tuesday_sched,
				wednesday: wednesday_sched,
				thursday: thursday_sched,
				friday: friday_sched,
				saturday: saturday_sched,
				sunday: sunday_sched,
				class_id: class_id,	
				event_id: event_id,
				class_schedule_id: class_schedule_id,
				subject_code: subject_code,
				date_start: date_start_range,
				date_end: date_end_range,				
				has_limit: has_limit,
				limit_time: limit_time,
				professor_qrcode: professor_qrcode				
			});

			$.post(_base_url_+'classes/Master.php?f=save_schedule_detail',
				{
					"id": class_schedule_id,
					"event_id": event_id,
					"class_id": class_id,
					"subject_code": subject_code,
					"professor_qrcode": professor_qrcode,
					"monday":monday_sched,
					"tuesday":tuesday_sched,
					"wednesday":wednesday_sched,
					"thursday":thursday_sched,
					"friday":friday_sched,
					"saturday":saturday_sched,
					"sunday":sunday_sched,
					"date_start": date_start_range,
					"date_end": date_end_range,
					"has_limit": has_limit,
					"limit_time": limit_time,					
					"added_by": added_by					
				},

				function(resp){
					console.log(resp)
				});
		}
			
		$('#event-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_event',
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

					var inserted_id = resp.inserted_id;
					addScheduleDetail(inserted_id);
					location.reload();

				}else if(resp.status == 'duplicate'){
					var _frm = $('#event-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Title already exists.</div>"
					_frm.prepend(_msg)
					_frm.find('input#title').addClass('is-invalid')
					$('[name="title"]').focus()
				}else{
					alert_toast("An error occured.",'error');
					console.log(resp)
				}
					end_loader()
				}
			})
		})
	})
</script>