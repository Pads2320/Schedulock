<?php
$event_id = isset($_GET['eid'])? $_GET['eid'] : '';



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





?>
<style>
.alert{
	border: 1px solid #f9000059;
	background-color: #f9000059
}


</style>
<div class="col-md-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="filter-frm">
			<div class="col-md-12">
				<div class="row">
					<div class="col-sm-5">
						<div class="form-group">
							<label for="event_id">Filter Class/Subject</label>
							<select name="event_id" id="event_id" class="custom-select custom-select-sm select2">
								<?php
									$event= $conn->query("SELECT * FROM event_list order by title asc");
									while($row=$event->fetch_assoc()):
										if(empty($event_id))
										$event_id = $row['id'];
										$has_limit = $row['limit_registration'];
										$room = $row['room'];
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo $event_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['subject_code'];?> | <?php echo(ucwords($row['title'])) ?></option>
							<?php endwhile; ?>
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<button class="btn btn-sm btn-primary mt-4"><i class="fa fa-filter"></i> Filter</button>
						<button class="btn btn-sm btn-success mt-4" onclick="_Print()"><i class="fa fa-print"></i> Print</button>
					</div>
				</div>
			</div>
			</form>
			<hr class="border-primary">
			<div id="report-tbl-holder">
				<h4 class="text-center">Report</h4>
				<hr>
				<?php 
					$qry = $conn->query("SELECT * FROM event_list where id = '$event_id'");
					foreach($qry->fetch_array() as $k => $v){
						if(!is_numeric($k)){
							$$k = $v;
						}
					}
				?>
				<!-- Update add march 14 -->
				<?php 
					$qry = $conn->query("SELECT * FROM room where id = '$room'");
					foreach($qry->fetch_array() as $k => $v){
						if(!is_numeric($k)){
							$$k = $v;
						}
					}
				?>
				<div class="callout">
					<div class="row">
						<div class="col-md-6">
							<dl>
								<dt>Subject Title</dt>
								<dd><?php echo $title ?></dd>
							</dl>							
							<dl>
								<dt>Room</dt>
								<dd><?php echo $room_name ?></dd>
							</dl>
						</div>
						<div class="col-md-6">

								<?php	
						

										
									$assignees = array();
									$professors = array();
									$classes = array();
									$class_sched = array();

									$subject_code = "";
									$professor = "";
									$class_name = "";
									$class_schedule = "";
									
									
									$class_schedule_query = $conn->query("SELECT * FROM class_schedule");

									while($csrow = $class_schedule_query->fetch_assoc()){	

										$string_dates = "";
										$date_range = "";

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
								
								?>

							<dl>
								<dt>Schedule</dt>
								<dd>
										
										<?php
										
										$class_schedule = isset($class_sched[$event_id]) ? $class_sched[$event_id] : "N/A";
										$class_schedule_date_range = isset($class_sched_date[$event_id]) ? $class_sched_date[$event_id] : "N/A";
										
										?>
									
										<b><?php echo $class_schedule; ?></b><br/>

										<?php if($has_limit == "1"): ?>
											<i>Registration Limit: <?php echo $limit_time." min(s)"; ?></i><br/>
										<?php else: ?>
											<i>No Registration Time Limit</i><br/>
										<?php endif; ?>

										<small><i><?php echo $class_schedule_date_range; ?></i></small>

								</dd>
							</dl>
							
							
						</div>
					</div>
				</div>
				<table id="report-tbl" class="table table-stripped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Date/Time</th>
							<th>Name</th>
							<th>Student ID</th>
							<th>Contact</th>
							<!-- <th>Email</th> -->
							<!-- <th>Remarks</th> -->
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						
						$qry = $conn->query("SELECT a.date_created as rdate,a.student_id,b.email,b.contact,b.remarks,b.* FROM registration_history as a, students as b where b.id = a.student_id");
						while($row=$qry->fetch_assoc()):
						?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("M d, Y h:i A",strtotime($row['rdate'])) ?></td>
							<td><?php echo ucwords($row['firstname'] . ' ' . $row['lastname']) ?></td>
							<td><?php echo $row['id_number'] ?></td>
							<td><?php echo ucwords($row['contact']) ?></td>
							<!-- <td><?php echo ucwords($row['email']) ?></td> -->
							<!-- <td><?php echo ucwords($row['remarks']) ?></td> -->
						</tr>
						<?php endwhile; ?>
						<?php if($qry->num_rows <=0): ?>
							<tr>
								<th class="text-center" colspan="6">No Data.</th>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	

	<noscript>
		<style>
			table{
				border-collapse:collapse;
				width: 100%;
			}
			tr,td,th{
				border:1px solid black;
			}
			td,th{
				padding: 3px;
			}
			.text-center{
				text-align: center;
			}
			.text-right{
				text-align: right;
			}
			p{
				margin: unset;
			}
			.alert{
				border: 1px solid #f9000059;
				background-color: #f9000059
			}
		</style>
	</noscript>
	<script>
		function _Print(){
			start_loader();
			var ns = $('noscript').clone()
			var report = $('#report-tbl-holder').clone()
			var head = $('head').clone()

			var _html = report.prepend(ns.html())
				_html.prepend(head)
			var nw = window.open('','_blank',"height=900,width=1200");
			nw.document.write(_html.html())
			nw.document.close()
			nw.print()

			setTimeout(function(){
				nw.close()
				end_loader()
			})
		}
		$(document).ready(function(){
			$('.select2').select2();
			$('#filter-frm').submit(function(e){
				e.preventDefault()
				location.replace(_base_url_+'admin/?page=reports&eid='+$('#event_id').val())
			})
		})
	</script>
</div>