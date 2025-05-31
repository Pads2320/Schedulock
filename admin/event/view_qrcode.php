<?php 

require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qrcode_value = $_GET['id'];
}

$qry = $conn->query("SELECT * FROM `event_list` WHERE `qrcode_id` = '".$qrcode_value."'");

$fullname_professor = "";
$prof_id = "";

$event_array = [];

while($row = $qry->fetch_assoc()){
	$event_array[] = $row;
}

$prof_id = $event_array[0]['professor_id'];

$qry_users = $conn->query("SELECT * FROM `users` WHERE `id` = '".$prof_id."'");

$users_array = [];

while($row_user = $qry_users->fetch_assoc()){
	$users_array[] = $row_user;
}

if(sizeof($users_array) > 0){
	$fullname_professor = $users_array[0]['firstname'].' '.$users_array[0]['lastname'];
}


?>




<script type="text/javascript" src="<?php echo base_url ?>/libs/jsqrcode/qrcode.js"></script>

<center>

	<div id ="qrcode_content" class = "p-2" style = "height: 225px; width: 250px;">
		<div id="qrcode" height = "100%" width = "100%" style="margin:10px;"></div>
		<small><b>Professor/Instructor: </b><?php echo $fullname_professor; ?></small><br/>
		<b>Subject Title:</b> <?php echo $event_array[0]['title']; ?><br/>
		<b>Subject Code:</b> <?php echo $event_array[0]['subject_code']; ?>
	</div>

	<br>
	<button class = "btn btn-lg btn-success" qrcode_value = "<?php echo $qrcode_value;?>" id="downloadBtn">Download QR Code</button>

<center>

<script>
    document.getElementById('downloadBtn').addEventListener('click', function() {
        // Capture the div element using html2canvas
        html2canvas(document.querySelector("#qrcode_content")).then(function(canvas) {
            // Convert canvas to image data URL (base64 format)
            let image = canvas.toDataURL("image/png");

            // Create a temporary download link
            let link = document.createElement('a');
            link.href = image;
            link.download = '<?php echo $qrcode_value;?>.png';  // Set download filename

            // Programmatically trigger the download
            link.click();
        });
    });
</script>

<script type="text/javascript">

var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 100,
	height : 100
});

function makeCode (elText) {		

	qrcode.makeCode(elText);

}

makeCode('<?php echo $qrcode_value; ?>');

$("#text").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	});
</script>


