<?php
ini_set('display_errors', 1);
include 'dbcon.php';

switch ($_POST['action']) {
	case 'list_senders':
		print '<option value="ShowAll">SHOW ALL</option>';
		$datalist = $db->query( 'SELECT Villager FROM senders GROUP BY Villager ORDER BY Villager ASC' );
		while ($data = $datalist->fetch_array()) {
			$sender_class = str_replace(' ', '_', $data['Villager']);
			print '<option value="'.$sender_class.'">'.$data['Villager'].'</option>';
		}
		break;
	
	case 'list_letters':
		$datalist = $db->query( 'SELECT T1.ID, T1.Message, GROUP_CONCAT(T2.Villager SEPARATOR "^") AS Senders FROM letters AS T1 JOIN senders AS T2 ON T1.ID=T2.LetterID GROUP BY T1.ID ORDER BY T1.Message ASC' );
		while ($data = $datalist->fetch_array()) {
			list($msg) = explode("\n", $data['Message']);
			$class_list = str_replace('^', ' ', $data['Senders']);
			$class_list = str_replace(' ', '_', $class_list);
			$sender_list = str_replace('^', ', ', $data['Senders']);
			print '<tr onclick="load_letter('.$data['ID'].')" class="ShowAll '.$class_list.'"><td>'.$msg.'...</td><td>'.$sender_list.'</td></tr>';
		}
		break;
	
	case 'load_letter':
		$letter_data = $db->query( 'SELECT * FROM letters WHERE ID='.$_POST['id'] )->fetch_array();
		$sender_data = $db->query( 'SELECT GROUP_CONCAT(Villager SEPARATOR "\r") AS Senders FROM senders WHERE LetterID='.$_POST['id'].' ORDER BY Villager ASC' )->fetch_array();
		print $letter_data['ID'].'<-=->'.$letter_data['Greeting'].'<-=->'.$letter_data['Message'].'<-=->'.$letter_data['Signature'].'<-=->'.$sender_data['Senders'];
		break;
	
	case 'save_letter':
		// Save the letter data
		console.log($_POST['letterID']);
		if ($_POST['letterID'] == "") {
			// Save new letter
			$mysql = 'INSERT INTO letters (Greeting, Message, Signature) VALUES ("'.$_POST['salutation'].'", "'.$_POST['message'].'", "'.$_POST['signature'].'")';
			$db->query( $mysql );
			$new_ID = $db->query( 'SELECT ID FROM letters ORDER BY ID DESC LIMIT 1' )->fetch_array();
			$_POST['letterID'] = $new_ID['ID'];
		} else {
			// Make edits to a letter
			$mysql = 'UPDATE letters SET Greeting="'.$_POST['salutation'].'", Message="'.$_POST['message'].'", Signature="'.$_POST['signature'].'" WHERE ID='.$_POST['letterID'];
			$db->query( $mysql );
		}
		
		// Now save the senders
		$db->query( 'DELETE FROM senders WHERE LetterID='.$_POST['letterID'] );
		$sender_list = explode("\n", $_POST['senders']);
		foreach ($sender_list as $sender) {
			if ($sender == "") { continue; }
			$db->query( 'INSERT INTO Senders (LetterID, Villager) VALUES ('.$_POST['letterID'].', "'.chop($sender).'")' );
		}
		
		break;
	
}



?>




