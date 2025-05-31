<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>

<?php endif;?>

<?php

	function convert_time($input_time){

		return date("h:i A", strtotime($input_time));

	} // convert_time

	function get_array_value_with_delim($delim,$string,$ndx){

			$array = explode($delim, $string);

			return $array[$ndx];

	} // get_array_value_with_delim

	function convert_time_from_military_date_range($time_input){

		$time_start = get_array_value_with_delim("-",$time_input,0);
		$time_end = get_array_value_with_delim("-",$time_input,1);

		$time_range = convert_time($time_start)." - ".convert_time($time_end);

		return $time_range;

	} // convert_time_from_military_date_range

	function convert_date($input_date){

		return date("M d, Y", strtotime($input_date));

	} // convert_date

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

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_schedule" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th>#</th>
						<th class="text-center">Subject Code</th>
						<th>Subject Title</th>
						<th>Professor</th>
						<th>Room</th>
						<th>Class</th>
						<th>Time and Day</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$users = $conn->query("SELECT id,concat(firstname,' ',lastname) as name FROM users");
					$class_query = $conn->query("SELECT id, class_name,yearlevel FROM classes");
					$room_query = $conn->query("SELECT id,room_name FROM room");
					
					
					$assignees = array();
					$professors = array();
					$classes = array();
					$class_sched = array();
					$class_schedule_event = array();
					$room_array = array();

					$subject_code = "";
					$professor = "";
					$class_name = "";
					$class_schedule = "";
					
					$class_schedule_query = $conn->query("SELECT * FROM class_schedule");
					$event_query = $conn->query("SELECT * FROM event_list");

					

				
					while($room_row = $room_query->fetch_assoc()){

						$room_array[$room_row['id']] = $room_row['room_name'];
						
					}

					while($csrow = $class_schedule_query->fetch_assoc()){	

						$string_dates = "";
						$date_range = "";

						$class_schedule_id = "";
						$event_id = $csrow['event_id'];

						//$class_schedule_id = $class_schedule_event[$event_id];

						$date_range = "Validity: ".convert_date($csrow['date_start'])." - ".convert_date($csrow['date_end']);

						if($csrow['monday'].trim(" ") != ""){
							$monday_time = convert_time_from_military_date_range($csrow['monday']);
							$string_dates .= "Monday | ".$monday_time."<br/>";
						}

						if($csrow['tuesday'].trim(" ") != ""){
							$tuesday_time = convert_time_from_military_date_range($csrow['tuesday']);	
							$string_dates .= "Tuesday | ".$tuesday_time."<br/>";
						}

						if($csrow['wednesday'].trim(" ") != ""){

							$wednesday_time = convert_time_from_military_date_range($csrow['wednesday']);
							$string_dates .= "Wednesday | ".$wednesday_time."<br/>";

						}

						if($csrow['thursday'].trim(" ") != ""){

							$thursday_time = convert_time_from_military_date_range($csrow['thursday']);
							$string_dates .= "Thursday | ".$thursday_time."<br/>";

						}

						if($csrow['friday'].trim(" ") != ""){

							$friday_time = convert_time_from_military_date_range($csrow['friday']);
							$string_dates .= "Friday | ".$friday_time."<br/>";

						}

						if($csrow['saturday'].trim(" ") != ""){

							$saturday_time = convert_time_from_military_date_range($csrow['saturday']);
							$string_dates .= "Saturday | ".$saturday_time."<br/>";

						}

						if($csrow['sunday'].trim(" ") != ""){

							$sunday_time = convert_time_from_military_date_range($csrow['sunday']);			
							$string_dates .= "Sunday | ".$sunday_time."";

						}																										
											

						$class_sched[$csrow['event_id']] = $string_dates;
						$class_sched_date[$csrow['event_id']] = $date_range;

					}

					while($crow = $class_query->fetch_assoc()){						
						$classes[$crow['id']] = ucwords($crow['class_name']);
					}

					while($urow = $users->fetch_assoc()){
						$assignees[$urow['id']] = ucwords($urow['name']);
						$professors[$urow['id']] = ucwords($urow['name']);
					}
					$qry = $conn->query("SELECT * FROM event_list order by title asc  ");
					while($row= $qry->fetch_assoc()):
						$assignee = isset($assignees[$row['user_id']]) ? $assignees[$row['user_id']] : "N/A";
						$class_name = isset($classes[$row['class_id']]) ? $classes[$row['class_id']] : "N/A";
						$professor = isset($professors[$row['professor_id']]) ? $professors[$row['professor_id']] : "N/A";
						$class_schedule = isset($class_sched[$row['id']]) ? $class_sched[$row['id']] : "N/A";
						$class_schedule_date_range = isset($class_sched_date[$row['id']]) ? $class_sched_date[$row['id']] : "N/A";
						$subject_code = $row['subject_code'];
						$limit_time = $row['limit_time'];
						$has_limit = $row['limit_registration'];
					?>
					<tr>
						<th class="text-center"><?php echo $i++; ?></th>
						<th class="text-center"><?php echo $subject_code; ?></th>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td><b><?php echo $professor; ?></b></td>
						<td>
							<b><?php echo $room_array[$row['room']]; ?></b>
						</td>
						<td>
							<b><?php echo $class_name; ?></b>
						</td>
						<td>
							
							<b><?php echo $class_schedule; ?></b><br/>

							<?php if($has_limit == "1"): ?>
								<i>Registration Limit: <?php echo $limit_time." min(s)"; ?></i><br/>
							<?php else: ?>
								<i>No Registration Time Limit</i><br/>
							<?php endif; ?>

							<small><i><?php echo $class_schedule_date_range; ?></i></small>
							
						</td>
						<td class="text-center">
		                    <div class="btn-group">

								<a href="javascript:void(0)" data-id='<?php echo $row['qrcode_id'] ?>' class="d-none btn btn-secondary btn-flat event_qrcode">
		                          <i class="fas fa-qrcode"></i>
		                        </a>

		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_event">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_schedule" data-id="<?php echo $row['id'] ?>" data-class-schedule-id = "<?php echo $class_schedule_id;?>" data-class-id="<?php echo $row['class_id'] ?>" data-subject-code = "<?php echo $subject_code ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>

	                      </div>
						</td>

					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){

		$('.new_event').click(function(){
			uni_modal("New Event","./event/manage.php")
		})

		
		$('.new_schedule').click(function(){
			uni_modal("New Schedule","./event/manage_schedule.php")
		})

		$('.event_qrcode').click(function(){
			uni_modal("View Event QR Code","./event/view_qrcode.php?id="+$(this).attr('data-id'))
		})

		$('.manage_event').click(function(){
			uni_modal("Manage Event","./event/manage.php?id="+$(this).attr('data-id'))
		})
		
		$('.delete_schedule').click(function(){
			var id = $(this).attr('data-id');
			var class_id = $(this).attr('data-class-id');
			var subject_code = "'"+$(this).attr('data-subject-code')+"'";
			var class_schedule_id = "'"+$(this).attr('data-class-schedule-id')+"'";

		_conf("Are you sure to delete this Schedule?","delete_schedule",[id, class_id, subject_code, class_schedule_id])
		})
		$('#list').dataTable()
	})
	function delete_schedule($id,$class_id,$subject_code,$class_schedule_id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_schedule',
			method:'POST',
			data:{id:$id, class_id:$class_id, subject_code:$subject_code},
			dataType:"json",
			error:err=>{
				alert_toast("An error occured");
				end_loader()
			},
			success:function(resp){
				if(resp.status=="success"){
					delete_class_schedule($class_schedule_id)
					location.reload()
				}else{
					alert_toast("Deleting Data Failed");
				}
				end_loader()
			}
		})
	}

	
	function delete_class_schedule(class_schedule_id){

		const db = firebase.database();

		var dbref_class_schedule = db.ref('class_schedule/'+class_schedule_id+'/');

		dbref_class_schedule.remove();	

	} // delete_class_schedule from firebase realtime db

</script>