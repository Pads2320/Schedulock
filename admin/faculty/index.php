<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_faculty" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="10%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Image</th>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Email/Gmail</th>
						<th>Username</th>						
						<th>User Type</th>						
						<th>Department (if Professor)</th>						
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT u.*, p.*, u.id as user_id, p.id as program_id, concat(u.firstname,' ',u.lastname) as name, u.qrcode as QR, p.program_name as department_name FROM `users` u LEFT JOIN `program` p ON p.id = u.department_id WHERE u.id != '{$_settings->userdata('id')}' ORDER BY u.date_added DESC");
					while($row= $qry->fetch_assoc()):

					$qrcode = $row['QR'];
?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td class="text-center">
							<img class="direct-chat-img border" src="<?php echo validate_image($row['avatar']) ?>" alt="Image" style="float:unset;">

							<span><a href="javascript:void(0)" class="view_data" rel = "<?php echo $row['qrcode'];?>" data-id="<?php echo $row['user_id'] ?>"><span class="fa fa-qrcode"></span></a></span>
						
						</td>
						<td><b><?php echo ucwords($row['id_number']) ?></b></td>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo ucwords($row['email']) ?></b></td>
						<td><b><?php echo $row['username'] ?></b></td>
						<td><b>
							<?php
								if ($row['type'] == 3) {
									echo "Professor";
								} else if ($row['type'] == 1 ) {
									echo "School Faculty";
								}
							?>
						</b></td>
						<td><b>
							<?php 
								if ($row['type'] == 3) { 
									echo $row['program_abbrev'] ;
								} else {
									echo "-";
								} 
							?></b></td>
						
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['user_id'] ?>' class="btn btn-primary btn-flat manage_user">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_user" qrcode = "<?php echo $qrcode; ?>" data-id="<?php echo $row['user_id'] ?>">
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
		$('.new_faculty').click(function(){
			uni_modal("New Faculty","./faculty/manage.php",'mid-large')
		})
		$('.manage_user').click(function(){
			uni_modal("Manage User","./faculty/manage.php?id="+$(this).attr('data-id'),'mid-large')
		})
		$('.view_data').click(function(){
			var qrcode = $(this).attr('rel');
			uni_modal("QR","./faculty/view.php?id="+$(this).attr('data-id')+"&qrcode="+qrcode)
		})
		$('.delete_user').click(function(){
			var qrcode_value = "'"+$(this).attr('qrcode')+"'";
			_conf("Are you sure to delete this faculty member?","delete_user",[$(this).attr('data-id'),qrcode_value])
		})
		$('#list').dataTable()
	})

	function delete_professor_user_session(event_user_id){

		const db = firebase.database();

		var dbref_session = db.ref('door_access_session/'+event_user_id+'/');
		dbref_session.remove();


	} // delete_professor_user_session from firebase realtime db


	function delete_user($id,$qrcode){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=delete',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					delete_professor_user_session($qrcode)
					location.reload()
				}
			}
		})
	}
</script>