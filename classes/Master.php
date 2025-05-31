<?php
require_once('../config.php');
require_once('../libs/phpqrcode/qrlib.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_event(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM event_list where title = '{$title}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;

		if($check > 0){
			$resp['status'] = "duplicate";
		}else{
			// foreach($_POST as $k =>$v){
			// 	if(!in_array($k,array('id'))){
			// 		if(!empty($data)) $data .= ", ";
			// 		$data .= " `{$k}` = '{$v}' ";
			// 	}
			// }

			$title = isset($_POST['title']) ? $_POST['title'] : '';
			$venue = isset($_POST['venue']) ? $_POST['venue'] : '';
			$description = isset($_POST['description']) ? $_POST['description'] : '';
			$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
			$limit_time = isset($_POST['limit_time']) ? $_POST['limit_time'] : '';
			$professorId = isset($_POST['professor_id']) ? $_POST['professor_id'] : '';
			$subjectCode = isset($_POST['subject_code']) ? $_POST['subject_code'] : '';
			$room = isset($_POST['room']) ? $_POST['room'] : '';

			if(empty($id)){
				$sql = "INSERT INTO event_list (title, venue, description, user_id, limit_time) VALUES ('$title', '$venue', '$description', '$user_id', '$limit_time')";
			}else{
				$sql = "UPDATE event_list SET title = '$title', venue = '$venue', description = '$description', user_id = '$user_id', limit_time = '$limit_time', subject_code = '$subjectCode', professor_id = '$professorId', room = '$room' WHERE id = '$id'";
			}

			$save = $this->conn->query($sql);

			if($save){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success", " Event Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}

	public function save_schedule(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$check = $this->conn->query("SELECT * FROM event_list where title = '{$title}' ".($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
		if($check > 0){
			$resp['status'] = "duplicate";
		}else{

			foreach($_POST as $k =>$v){
				if(!in_array($k,array('id'))){
					if(!empty($data)) $data .= ", ";
					$data .= " `{$k}` = '{$v}' ";
				}
			}
			if(empty($id)){
				$sql = "INSERT INTO event_list set $data";
			}else{
				$sql = "UPDATE event_list set $data where id = '{$id}'";
			}
			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';
				$resp['inserted_id'] = $this->conn->insert_id;
				$this->settings->set_flashdata("success", " Schedule Successfully Saved.");
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
		}


		return json_encode($resp);
	}

	public function save_schedule_detail(){

		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

		
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		
		$check = $this->conn->query("SELECT id FROM class_schedule WHERE event_id = '{$event_id}'");

		
		if($check->num_rows > 0){
			$row = $check->fetch_assoc();
			$id = $row['id'];
			$sql = "UPDATE class_schedule set $data where id = '{$id}'";
			$message = "Schedule Detail Successfully Updated!";

		}else{
			$sql = "INSERT INTO class_schedule set $data";
			$message = "Schedule Detail Successfully Saved!";
		}

		$save = $this->conn->query($sql);

		if($save){
			$resp['status'] = 'success';
			$resp['inserted_id'] = $id;
			$this->settings->set_flashdata("success", $message);
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		if($check > 0){
			//$resp['status'] = "duplicate";
		}else{

			
		}


		return json_encode($resp);
	}

	public function get_class_option(){


		extract($_POST);

		$qry =  $this->conn->query("SELECT a.*, b.*,a.id as EID FROM event_list as a, classes as b WHERE b.id = a.class_id and b.yearlevel = '{$yearlevel}' GROUP BY b.id");
		// $qry =  $this->conn->query("SELECT * FROM classes WHERE yearlevel = '{$yearlevel}' GROUP BY yearlevel");

		$data=array();

		while($row = $qry->fetch_assoc()):
			$classID = $row['class_id'];
			$event_id_value = $row['EID'];
			$subjectCode = $row['subject_code'];
			$className = $row['class_name'];
			$class_yearlevel_id = $row['yearlevel'];

			$data[] = $row;
		
		endwhile;

		return json_encode($data);

	}

	public function get_class_schedule(){
		extract($_POST);

		
	
		$qry = $this->conn->query("SELECT * FROM class_schedule where event_id = '{$event_id}' ");

		$data = array();

		while($row = $qry->fetch_assoc()){
			$data[] = $row;
		}
		
		return json_encode($data);

	}

	function delete_event(){
		extract($_POST);

		$qrcode_value = "";
		$delete = $this->conn->query("DELETE FROM event_list where id = '{$id}'");
		$qry = $this->conn->query("SELECT qrcode_id FROM event_list where id = '{$id}' ");

		while($row=$qry->fetch_assoc()){
			$qrcode_value = $row['qrcode_id'];
		}

		if($delete){
			$resp['status'] = "success";
			$resp['qrcode_value'] = $qrcode_value;
			$this->settings->set_flashdata("success", " Event Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_schedule(){
		extract($_POST);

	
		$delete = $this->conn->query("DELETE FROM event_list where id = '{$id}'");
		$delete_schedule_details = $this->conn->query("DELETE FROM class_schedule where class_id = '{$class_id}' and subject_code = '{$subject_code}'");
		

		if($delete && $delete_schedule_details){
			$resp['status'] = "success";
			
			$this->settings->set_flashdata("success", " Event Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	public function save_program(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

	

		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";			
			}
		}

		$status_error = "";

		
		
		if(empty($id)){

			$sql = "INSERT INTO program set $data";
			$sql_is_exist = "SELECT program_name, program_abbrev from program where program_name = '{$program_name}' or program_abbrev = '{$program_abbrev}'";
		
		}else{

			$sql = "UPDATE program set $data where id = '{$id}'";
			$sql_is_exist = "SELECT program_name, program_abbrev from program where program_name = '{$program_name}' and id != '{$id}' or program_abbrev = '{$program_abbrev}' and id != '{$id}'";
		
		}

		$is_exist_query = $this->conn->query($sql_is_exist);
		$is_exist_count = 0;

		while($row_count = $is_exist_query->fetch_assoc()):
			$is_exist_count += 1;
		endwhile;
		
		if($is_exist_count > 0){
			$status_error .= "Program name or Abbreviation already exist<br/>";
		}

		if(trim($status_error," ") == ""):

			$save = $this->conn->query($sql);
			if($save){
				$resp['status'] = 'success';	
					
				if(empty($id)):
					$this->settings->set_flashdata("success", " New Program Successfully Created!");
				else:
					$this->settings->set_flashdata("success", " Program Successfully Updated!");
				endif;
				
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}

		else:

			$resp['status'] = 'failed';	
			$resp['err'] = $status_error;
			$resp['sql'] = $sql_is_exist;

		endif;

	

		return json_encode($resp);
	}


	public function save_room(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

		$status_error = "";

	
		if(empty($id)){
			$sql = "INSERT INTO room set $data";
			$sql_is_exist = "SELECT room_name FROM room where room_name = '{$room_name}'";
		}else{
			$sql = "UPDATE room set $data where id = '{$id}'";
			$sql_is_exist = "SELECT room_name FROM room where room_name = '{$room_name}' and id != '{$id}'";
		}

		
		$sql_exist_query = $this->conn->query($sql_is_exist);
		$sql_exist_count = 0;

		while($row_count_exist = $sql_exist_query->fetch_assoc()):
			$sql_exist_count += 1;
		endwhile;
		

		if($sql_exist_count > 0):

			$status_error .= "Room Name Already Exist\n";	

		endif;

	
		if(trim($status_error," ") == ""):

			$save = $this->conn->query($sql);


			if($save){
				$resp['status'] = 'success';		

				if(empty($id)){
					$this->settings->set_flashdata("success", " New Room Successfully Created!");
				}else{
					$this->settings->set_flashdata("success", " Room Details Successfully Updated!");
				}
				
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error;
				$resp['sql'] = $sql;
			}

		else:

			$resp['status'] = 'failed';
			$resp['err'] = $status_error;
			$resp['sql'] = $sql_is_exist;

		endif;

			

		return json_encode($resp);
	}

	public function save_class(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

		if(empty($id)){
			$sql = "INSERT INTO classes set $data";
		}else{
			$sql = "UPDATE classes set $data where id = '{$id}'";
		}

		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';		
			$this->settings->set_flashdata("success", " New Class Successfully Created!");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		
		return json_encode($resp);
	}

	public function delete_class(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM classes where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", "Class Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	public function delete_room(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM room where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", "Room Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	public function delete_program(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM program where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", "Program Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	public function save_student(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

	

		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";

			
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO students set $data";
			$save = $this->conn->query($sql);

			$inserted_id = $this->conn->insert_id;
			$sql_registration = "INSERT INTO registration_history (class_id, student_id, added_by) VALUES('$class_id','$inserted_id','$added_by')";

			$save_registration = $this->conn->query($sql_registration);
		}else{
			$sql = "UPDATE students set $data where id = '{$id}'";
			$save = $this->conn->query($sql);
			$save_registration = true;
		}
		

		if($save && $save_registration){
			$resp['status'] = 'success';		
			$this->settings->set_flashdata("success", " Student Successfully Saved!");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		
		return json_encode($resp);
	}

	public function save_audience(){
		$data ="";
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);

		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}

		if(empty($id)){
			$sql = "INSERT INTO event_audience set $data";
		}else{
			$sql = "UPDATE event_audience set $data where id = '{$id}'";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			// $code = empty($id) ? md5($this->conn->insert_id) : md5($id);
			// if(!is_dir('../temp/')) mkdir('../temp/');
			// $tempDir = '../temp/'; 
			// if(!is_file('../temp/'.$code.'.png'))
			// QRcode::png($code, $tempDir.''.$code.'.png', QR_ECLEVEL_L, 5);
			$this->settings->set_flashdata("success", " Event Guest Successfully Saved.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		
		return json_encode($resp);
	}
	function delete_audience(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM event_audience where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Event Guest Successfully Deleted.");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_student(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM students where id = '{$id}'");
		if($delete){
			$resp['status'] = "success";
			$this->settings->set_flashdata("success", " Student Removed Successfully");
		}else{
			$resp['status'] = "failed";
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function load_registration(){
		extract($_POST);
		$qry = $this->conn->query("SELECT a.*,r.id as rid,r.date_created as rdate FROM registration_history r inner join event_audience a on a.id =r.audience_id where r.event_id = '{$event_id}' and r.id > '{$last_id}' order by r.id asc ");
		$data=array();
		while($row=$qry->fetch_assoc()){
			$row['rdate'] = date("M d, Y h:i A",strtotime($row['rdate']));
			$data[]=$row;
		}
		return json_encode($data);
	}
	function register(){
		extract($_POST);
		$query = $this->conn->query("SELECT * FROM event_audience where md5(id) = '{$audience_id}' and md5(event_id)='{$event_id}' ");
		if($query->num_rows > 0){
			$res = $query->fetch_assoc();
			$check = $this->conn->query("SELECT * from registration_history where event_id = '{$res['event_id']}' and  audience_id = '{$res['id']}' ");
			if($check->num_rows > 0){
				$resp['status']=3;
				$resp['name']=$res['name'];
			}else{

				$insert = $this->conn->query("INSERT INTO registration_history set event_id = '{$res['event_id']}',  audience_id = '{$res['id']}',`user_id` = '{$this->settings->userdata('id')}'  ");
				if($insert){
					$resp['status']=1;
					$resp['name']=$res['name'];
				}else{
					$resp['status']=2;
					$resp['error']=$this->conn->error;
				}
			}

		}else{
			$resp['status']=2;
		}
		return json_encode($resp);
	}
}

$main = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save_event':
		echo $main->save_event();
	break;
	case 'delete_event':
		echo $main->delete_event();
	break;
	case 'delete_student':
		echo $main->delete_student();
	break;
	case 'get_class_schedule':
		echo $main->get_class_schedule();
	break;
	case 'get_class_option':
		echo $main->get_class_option();
	break;
	case 'delete_schedule':
		echo $main->delete_schedule();
	break;
	case 'save_audience':
		echo $main->save_audience();
	break;
	case 'save_student':
		echo $main->save_student();
	break;
	case 'save_schedule':
		echo $main->save_schedule();
	break;
	case 'save_schedule_detail':
		echo $main->save_schedule_detail();
	break;
	case 'save_program':
		echo $main->save_program();
	break;
	case 'save_room':
		echo $main->save_room();
	break;
	case 'save_class':
		echo $main->save_class();
	break;
	case 'delete_class':
		echo $main->delete_class();
	break;
	case 'delete_room':
		echo $main->delete_room();
	break;
	case 'delete_program':
		echo $main->delete_program();
	break;
	case 'delete_audience':
		echo $main->delete_audience();
	break;
	case 'load_registration':
		echo $main->load_registration();
	break;
	case 'register':
		echo $main->register();
	break;
	default:
		// echo $sysset->index();
		break;
}