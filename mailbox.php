<?php
include 'dbcon.php';
?>

<html>
	<head>
		<title>Animal Crossing New Leaf Correspondence Tracker</title>
		<link rel="stylesheet" href="mailbox.css">
		<script src="../common/jquery-3.3.1.min.js"></script>
		<script src="mailbox.js"></script>
	</head>
	<body>
		<div id="app" class="flex flex-column">
			<main class="flex flex-row">
				<div class="flex flex-column section">
					<form class="flex flex-column" method="post" id="letter-form" onsubmit="return save_letter()">
						<input type="hidden" name="letterID" id="letterID" value="">
						<div>Salutation<br>
							<input type="text" name="salutation" id="salutation">
							<div class="error" id="err_salutation"></div></div>
						<div>Message<br>
							<textarea name="message" id="message"></textarea>
							<div class="error" id="err_message"></div></div>
						<div>Signature<br>
							<input type="text" name="signature" id="signature">
							<div class="error" id="err_signature"></div></div>
						<div>Senders<br>
							<textarea name="senders" id="senders"></textarea>
							<div class="error" id="err_senders"></div></div>
						<div class="flex buttons">
							<button class="button-primary" type="submit">Save</button>
							<button class="button-primary" type="reset" onclick="clearForm()">Clear</button>
						</div>
					</form>
				</div>
				<div class="section">
					<b style="text-align:center;">Special<br>Characters</b><br><br>
					<table class="special_chars" border="0" cellpadding="0" cellspacing="0">
						<?php
							foreach (array(9834, 9829, 9733, 8226, 128167, 193, 201, 205, 211, 218, 221, 225, 233, 237, 243, 250, 253) as $charcode) {
								print '<tr><td>&#'. $charcode .';</td><td>&amp;#'. $charcode .';</td></tr>';
							}
						?>
					</table>
				</div>
				<div class="flex flex-column section" style="flex:1;">
					<select class="sender_list" id="sender_list"></select>
					<div class="scrollarea">
						<table class="letter_list" id="letter_list" border="0" cellpadding="0" cellspacing="0"></table>
					</div>
				</div>
			</main>
		</div>
	</body>
</html>

