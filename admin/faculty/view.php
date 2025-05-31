<?php
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT qrcode,id,id_number,firstname,lastname FROM users where id = '{$_GET['id']}'");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}

$qrcode_value = "";

if(isset($_GET['qrcode']) && !empty($_GET['qrcode'])){
	$qrcode_value = $_GET['qrcode'];
}

?>

<script type="text/javascript" src="<?php echo base_url ?>/libs/jsqrcode/qrcode.js"></script>
<script type="text/javascript">

var qrcode = new QRCode(document.getElementById("cimg"), {
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


<div class="row">
	<div class="col-md-12 mb-2 justifu-content-end">
		<button class="btn btn-sm btn-success float-right" type="button" id="print-card"><i class="fa fa-print"></i> Print</button>
	</div>
	<div class="col-md-12 mb-2 justifu-content-end">
		<button class="btn btn-sm btn-success float-right" type="button" id="download-card"><i class="fa fa-download"></i> Download</button>
	</div>
</div>
<div class="col-md-12" id="event_qr">
	<div class="form-group">
		<div class="form-group d-flex justify-content-center">
			<div id="cimg" class="img-fluid img-thumbnail">
		</div>
	</div>

	<center>
		<small>
			<?php echo 'QRCODE VALUE: '.$qrcode_value;?>
		</small>
	</center>

	<hr class="border-primary">
	<dl>
		<dt>Professor Full Name</dt>
		<dd><?php echo ucwords($firstname) ?> <?php echo ucwords($lastname) ?></dd>
	</dl>
</div>



<script>
	$('#print-card').click(function(){
		var ccts = $('#event_qr').clone()

		var nw = window.open('','_blank','height=600,width800');
		nw.document.write(ccts.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			window.close()
		},750)
	})

	$('#download-card').click(function(){
		var ccts = $('#event_qr').clone();
		var blob = new Blob([ccts.html()], { type: 'text/html' });
		var link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = 'student_info.html';
		link.click();
		URL.revokeObjectURL(link.href);
	});
	
	$(document).ready(function(){
		if($('#uni_modal .modal-header button.close').length <= 0)
		$('#uni_modal .modal-header').append('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
	})
</script>
<style>
	#uni_modal .modal-footer{
		display: none;
	}
	img#cimg{
		height: 150px;
		width: 150px;
		object-fit: contain;
	}
</style>