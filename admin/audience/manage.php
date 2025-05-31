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
$qrcode_user_event_session = "EVENT_SESSION_USER_".$date_time_value."_".generate_qrcode_value(15);

?>
<form action="" id="audience-frm">
	<div id="msg" class="form-group"></div>
	<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
	<input type="hidden" name= "qrcode_value" value = "<?php echo $qrcode_user_event_session; ?>">
	<div class="form-group">
		<label for="name" class="control-label">Fullname</label>
		<input type="text" class="form-control form-control-sm" name="name" id="name" value="<?php echo isset($firstname) && isset($lastname) ? $firstname . ' ' . $lastname : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="email" class="control-label">Email</label>
		<input type="email" class="form-control form-control-sm" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
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
		<label for="event_id" class="control-label">Event</label>
		<select name="event_id" id="event_id" class="custom-select select2" required>
			<option></option>
			<?php 
				$qry = $conn->query("SELECT id,title,datetime_start,datetime_end FROM event_list order by concat(title) asc ");
				while($row = $qry->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" date_time_start = "<?php echo $row['datetime_start']?>" date_time_end = "<?php echo $row['datetime_end']?>" <?php echo isset($event_id) && $event_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['title']) ?></option>
			<?php endwhile; ?>
		</select>
	</div>
	
</form>

<!-- FIREBASE REALTIME DB START -->   
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-database.js"></script>


<!-- FIREBASE REALTIME DB END -->   

<script type = "module">

  // Import the functions you need from the SDKs you need
  		import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
          
        
		  // TODO: Add SDKs for Firebase products that you want to use
		  // https://firebase.google.com/docs/web/setup#available-libraries
		
		  // Your web app's Firebase configuration
		  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
		  const firebaseConfigApp = {

			apiKey: "AIzaSyB-vDxR2fkGz7BVN6JMA878lBEhWlK72fo",

			authDomain: "scheduled-door-access.firebaseapp.com",

			databaseURL: "https://scheduled-door-access-default-rtdb.firebaseio.com",

			projectId: "scheduled-door-access",

			storageBucket: "scheduled-door-access.firebasestorage.app",

			messagingSenderId: "822705278215",

			appId: "1:822705278215:web:51ca0c11c2c2b416e909a2"

		  };

	

		  const app = firebase.initializeApp(firebaseConfigApp);
		  const db = firebase.database();

		
	  
		  function add_user_event_session(qrcode, date_time_start, date_time_end){

			//var uniqueId = db.ref('door_access_session').push().getKey();
			var dbref = db.ref('door_access_session').child(qrcode);
			
			dbref.set({
			
			 date_time_allowed_start: date_time_start,
			 date_time_expiry: date_time_end,			
			 is_saved_to_esp32: '0',				
			 qrcode: qrcode,		
			 
			});

		  } // add_event
	
	$(document).ready(function(){
		$('.select2').select2();
	
		$('#audience-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_audience',
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
					var date_time_start = $('#event_id option:selected').attr('date_time_start');
					var date_time_end = $('#event_id option:selected').attr('date_time_end');
					add_user_event_session($qrcode_user_event_session, date_time_start, date_time_end);
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