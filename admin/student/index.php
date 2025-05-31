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



	$qry_class = $conn->query("SELECT * FROM classes");
	
	$class_array = array();

	while($row_class = $qry_class->fetch_assoc()){

		$class_array[$row_class['id']] = $row_class['class_name'];

	}
		
?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_student" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
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
						<th class="text-center">#</th>
						
						<th>Student #</th>
						<th>FullName</th>
						<th>Program</th>
						<th>Subject</th>
						<th>Class</th>								
						<th>Details</th>
						<th>Remarks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					
					$qry = $conn->query("SELECT * FROM students");
					while($row= $qry->fetch_assoc()):

						$className = "";
						$program_name = "";
						$class_id = $row['class_id'];
						$program_id = $row['program'];
						$class_schedule_query = $conn->query("SELECT * FROM class_schedule");
						$subject_query = $conn->query("SELECT * FROM event_list where class_id = '{$class_id}'");
						$program_query = $conn->query("SELECT * FROM program where id = '".$program_id."'");
						$classes_query = $conn->query("SELECT * FROM classes where id = '{$class_id}'");


				
						$subject_details = "";
						
						
						while($row_program = $program_query->fetch_assoc()):

							
							$program_name = '<b>'.$row_program['program_name'].'</b>';

						endwhile;

						while($row_sub = $subject_query->fetch_assoc()):

							$subject_details .= '<b>'.$row_sub['subject_code']."</b><br/>".$row_sub['title']."<br/><br/>";

						endwhile;


						while($class_sub = $classes_query->fetch_assoc()):

							$className = $class_sub['class_name'];

						endwhile;

					
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>

						<td><b><?php echo ucwords($row['id_number']) ?></b></td>
						<td><b><?php echo ucwords($row['firstname']) ?> <?php echo ucwords($row['lastname']) ?></b> <span><a href="javascript:void(0)" class="view_data" rel = "<?php echo $row['qrcode_value'];?>" data-id="<?php echo $row['id'] ?>"><span class="fa fa-qrcode"></span></a></span></td>
						
						<td><?php echo $program_name; ?></td>
						<td><?php echo $subject_details; ?></td>
						<td><b><?php echo $className; ?></b></td>

						
						<td>
							<small><b>Email:</b> <?php echo $row['email'] ?></small><br>
							<small><b>Contact #:</b> <?php echo $row['contact'] ?></small>
						</td>
						<td><b><?php echo ($row['remarks']) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_student">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_student" data-id="<?php echo $row['id'] ?>" data-event-user-id="<?php echo $row['qrcode_value'] ?>">
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
		$('.new_audience').click(function(){
			uni_modal("New Audience","./audience/manage.php")
		})

		$('.new_student').click(function(){
			uni_modal("New Student","./student/manage.php")
		})

		$('.manage_student').click(function(){
			uni_modal("Manage Student","./student/manage.php?id="+$(this).attr('data-id'))
		})
		
		$('.view_data').click(function(){
			var qrcode = $(this).attr('rel');
			uni_modal("QR","./student/view.php?id="+$(this).attr('data-id')+"&qrcode="+qrcode)
		})
		
		$('.delete_student').click(function(){
			var eventuserid = $(this).attr('data-event-user-id')
			var dataid = $(this).attr('data-id')
		_conf("Are you sure to delete this student?","delete_student",[dataid,"'"+eventuserid+"'"])
		})
		$('#list').dataTable()
	})

	function delete_student($id,$eventsessionid){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_student',
			method:'POST',
			data:{id:$id},
			dataType:"json",
			error:err=>{
				alert_toast("An error occured");
				end_loader()
			},
			success:function(resp){
				if(resp.status=="success"){
					delete_user($eventsessionid);
					location.reload()
				}else{
					alert_toast("Deleting Data Failed");
				}
				end_loader()
			}
		})
	}

	function delete_user(event_user_id){

		const db = firebase.database();

		var dbref_session = db.ref('door_access_session/'+event_user_id+'/');

		dbref_session.remove();	
		
	} // delete_user from firebase realtime db

</script>