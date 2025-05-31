<?php if($_settings->chk_flashdata('success')): ?>

<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="col-lg-12">

<?php

	$userdata = array();
	
	$qry = $conn->query("SELECT id,username,firstname,lastname FROM users");
	
	while($row = $qry->fetch_assoc()){
		$userdata[$row['id']] = $row['username'];
	}

?>

	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_room" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
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
						<th>Room Name</th>						
						<th>Details</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					
					$qry = $conn->query("SELECT * FROM room");
					while($row= $qry->fetch_assoc()):
						$status = $row['status'];
						$added_by = $row['added_by'];

						$added_by_username = "";

						foreach($userdata as $k => $v){
							if($k == $added_by){
								$added_by_username = $v;
							}
						}

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>

						<td><b><?php echo ucwords($row['room_name']) ?></b></td>						
						<td>
							<i>Added by: <?php echo $added_by_username;?></i>
						</td>

						<td><?php if($status == "1"): ?> Available <?php else: ?> N/A <?php endif; ?></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_room">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_room" data-id="<?php echo $row['id'] ?>">
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
		$('.new_room').click(function(){
			uni_modal("Create New Room","./room/manage.php")
		})
		$('.manage_room').click(function(){
			uni_modal("Manage Audience","./room/manage.php?id="+$(this).attr('data-id'))
		})
		
		$('.view_data').click(function(){
			var qrcode = $(this).attr('rel');
			uni_modal("QR","./audience/view.php?id="+$(this).attr('data-id')+"&qrcode="+qrcode)
		})
		
		$('.delete_room').click(function(){
		_conf("Are you sure to delete this room?","delete_room",[$(this).attr('data-id')])
		})
		$('#list').dataTable()
	})
	function delete_room($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_room',
			method:'POST',
			data:{id:$id},
			dataType:"json",
			error:err=>{
				alert_toast("An error occured");
				end_loader()
			},
			success:function(resp){
				if(resp.status=="success"){
					location.reload()
				}else{
					alert_toast("Deleting Data Failed");
				}
				end_loader()
			}
		})
	}
</script>