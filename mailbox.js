
$( document ).ready(function() {
	get_senders();
	get_letters();
	
	$('#sender_list').change(function() {
		$('#letter_list tr').hide();
		$('#letter_list .'+$(this).val()).show();
		//get_letters(  );
	});
});

function clearForm() {
	$('#letterID').val( '' );
	$('#salutation').val( '' );
	$('#message').val( '' );
	$('#signature').val( '' );
	$('#senders').val( '' );
}

function get_senders() {
	// Get the list of senders and put it in the select list
	$.ajax({
		url: 'mailbox_backend.php',
		type: 'POST',
		cache: false,
		data: {
			action: 'list_senders'
		},
		success: function (response) {
			$('#sender_list').html(response);
		}
	});
}

function get_letters() {
	// Get the list of senders and put it in the select list
	$.ajax({
		url: 'mailbox_backend.php',
		type: 'POST',
		cache: false,
		data: {
			action: 'list_letters'
		},
		success: function (response) {
			$('#letter_list').html(response);
		}
	});
}

function load_letter(id) {
	// Load a specific letter
	$.ajax({
		url: 'mailbox_backend.php',
		type: 'POST',
		cache: false,
		data: {
			action: 'load_letter',
			id: id
		},
		success: function (response) {
			parts = response.split('<-=->');
			
			// Now set all the form fields
			$('#letterID').val( parts[0].trim() );
			$('#salutation').val( parts[1] );
			$('#message').val( parts[2] );
			$('#signature').val( parts[3] );
			$('#senders').val( parts[4].trim() );
		}
	});
}

function save_letter() {
	// Validation
	errors = 0;
	
	errors += validate('salutation', 'You must enter a greeting');
	errors += validate('message', 'You must enter a message');
	errors += validate('signature', 'You must enter a signature');
	errors += validate('senders', 'You must enter at least one sender');
	
	if (errors > 0) { return false; }
	
	$.ajax({
		url: 'mailbox_backend.php',
		type: 'POST',
		cache: false,
		data: {
			action: 'save_letter',
 			letterID: $('#letterID').val(),
			salutation: $('#salutation').val(),
			message: $('#message').val(),
			signature: $('#signature').val(),
			senders: $('#senders').val()
		},
		success: function (response) {
			//console.log( response );

			clearForm();
			get_senders();
			get_letters();
			//console.log( 'Saved' );
		}
	});
	return false;
}

function validate(formID, errmsg) {
	if ($('#'+formID).val() == "") {
		$('#err_'+formID).html( errmsg );
		return 1;
	} else {
		$('#err_'+formID).html( '' );
		return 0;
	}
}


