<?php
#########################################################################
ini_set("memory_limit", "-1");
ini_set('max_execution_time', -1);
ini_set('display_errors', '1');
error_reporting(E_STRICT | E_ALL ^ E_DEPRECATED);
#########################################################################

require './vendor/autoload.php';

use Aws\Common\Aws;
use Aws\Common\Enum\Region;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client; // for pre-signed upload file

require_once 'generalPHP.php';
require 'db.php';

// **** NAVIGATION *******
if (isset($_POST['action']))
{
	$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

	switch (sanitizeInput($_POST['action']))
	{
		case "addLawyerFirm": addLawyerFirm($db_server);
		break;
		case "editLawyerFirm": editLawyerFirm($db_server);
		break;
		case "addCompany": addCopmany($db_server);
		break;
		case "editCompany": editCompany($db_server);
		break;
		case "addCourt": addCourt($db_server);
		break;
		case "editCourt": editCourt($db_server);
		break;
		case "addSignature": addSignature($db_server);
		break;
		case "addEvent": addEvent($db_server);
		break;
		case "refreshCourtLocations": refreshCourtLocations($db_server,$_POST['courtType']);
		break;
		case "addEventForm": addEventForm($_POST['eventType']);
		break;
		case "populateTemplateList": populateTemplateList($db_server,$_POST['eventType']);
		break;
		case "deleteAlert": deleteAlert($db_server,sanitizeInput($_POST['alertId']));
		break;
		case "hideAlert": hideAlert($db_server,sanitizeInput($_POST['alertId']));
		break;
		case "mailDocument": mailDocument($db_server,sanitizeInput($_POST['docId']),sanitizeInput($_POST['email']),$clientId);
		break;
		case "deleteSignature": deleteSignature($db_server,sanitizeInput($_POST['id']));
		break;
		case "afterTagAdded": afterTagAdded($db_server);
		break;
		case "afterTagRemoved": afterTagRemoved($db_server);
		break;
		case "loadTagsAddedAjax": loadTagsAddedAjax($db_server);
		break;
		default: exit;
		break;
	}
	
}


// **** FUNCTIONS *******

function aws_s3_getObjectSize($s3_file) {
	
	global $bucket;
	global $aws_key;
	global $aws_secret;

	$awsClient = Aws::factory(array(
					'key' => $aws_key,
					'secret' => $aws_secret,
					'region' => Region::EU_WEST_1,
					'ACL' => CannedAcl::PUBLIC_READ,
	));

	$s3 = $awsClient->get('s3');

	try {
		$result = $s3->getObject(
				  array(
						'Bucket' => $bucket,
						'Key' => $s3_file,
				  )
		);

		if (isset($result)) {
			$body = $result->get('Body');
			$body->rewind();
			$content = $body->read($result['ContentLength']);

			$len = strlen( $content);
			
			return $len ;
		} else {
			// image not found
			return 0;
		}
	} catch (Exception $e) {
		return 0;
	}

}

function addLawyerFirm($db_server)
{
	extract($GLOBALS);
	$name = sanitizeMySQL($_POST['name']);
	$address = sanitizeMySQL($_POST['address']);
	$email = sanitizeMySQL($_POST['email']);
	$phone = sanitizeMySQL($_POST['phone']);
	$fax = sanitizeMySQL($_POST['fax']);

	
	// Add the user
	$addFirmSQL = "INSERT INTO tblawyers 
			(client_id, name, address, email, phone, fax) 
			VALUES (".$clientId.",'".$name."','".$address."','".$email."','".$phone."','".$fax."')"; 
	$addFirmResult = mysqli_query($db_server,$addFirmSQL);
	if (!$addFirmResult) die("Database access failed: " . mysqli_error());
	// Need to retrieve a new user id
	$firmId = mysqli_insert_id($db_server);
	echo $firmId;
	
}

function editLawyerFirm($db_server)
{
	$id = sanitizeMySQL($_POST['id']);
	$name = sanitizeMySQL($_POST['name']);
	$address = sanitizeMySQL($_POST['address']);
	$email = sanitizeMySQL($_POST['email']);
	$phone = sanitizeMySQL($_POST['phone']);
	$fax = sanitizeMySQL($_POST['fax']);

	
	// Add the user
	$addFirmSQL = "UPDATE tblawyers 
			SET name = '".$name."', address = '".$address."', email = '".$email."', phone = '".$phone."', fax = '".$fax."' 
			WHERE id = ".$id;
	$addFirmResult = mysqli_query($db_server,$addFirmSQL);
	if (!$addFirmResult) die("Database access failed: " . mysqli_error());
}

function addCopmany($db_server)
{
	extract($GLOBALS);
	$name = sanitizeMySQL($_POST['name']);
	$address = sanitizeMySQL($_POST['address']);
	$email = sanitizeMySQL($_POST['email']);
	$phone = sanitizeMySQL($_POST['phone']);
	$fax = sanitizeMySQL($_POST['fax']);

	
	// Add the user
	$addFirmSQL = "INSERT INTO tbcompanies 
			(client_id, name, address, email, phone, fax) 
			VALUES (".$clientId.",'".$name."','".$address."','".$email."','".$phone."','".$fax."')"; 
	$addFirmResult = mysqli_query($db_server,$addFirmSQL);
	if (!$addFirmResult) die("Database access failed: " . mysqli_error());
	// Need to retrieve a new user id
	$firmId = mysqli_insert_id($db_server);
	echo $firmId;
}

function editCompany($db_server)
{
	$id = sanitizeMySQL($_POST['id']);
	$name = sanitizeMySQL($_POST['name']);
	$address = sanitizeMySQL($_POST['address']);
	$email = sanitizeMySQL($_POST['email']);
	$phone = sanitizeMySQL($_POST['phone']);
	$fax = sanitizeMySQL($_POST['fax']);

	
	// Add the user
	$addFirmSQL = "UPDATE tbcompanies 
			SET name = '".$name."', address = '".$address."', email = '".$email."', phone = '".$phone."', fax = '".$fax."' 
			WHERE id = ".$id;
	$addFirmResult = mysqli_query($db_server,$addFirmSQL);
	if (!$addFirmResult) die("Database access failed: " . mysqli_error());
}

function addCourt($db_server)
{
	extract($GLOBALS);
	$type = sanitizeMySQL($_POST['type']);
	$address = sanitizeMySQL($_POST['address']);
	$location = sanitizeMySQL($_POST['location']);
	$phone = sanitizeMySQL($_POST['phone']);
	$fax = sanitizeMySQL($_POST['fax']);

	
	// Add the user
	$addCourtSQL = "INSERT INTO tbcourts
			(client_id, type, location, phone, address, fax) 
			VALUES (".$clientId.",'".$type."','".$location."','".$phone."','".$address."','".$fax."')"; 
	$addCourtResult = mysqli_query($db_server,$addCourtSQL);
	if (!$addCourtResult) die("Database access failed: " . mysqli_error());
	// Need to retrieve a new user id
	$CourtId = mysqli_insert_id($db_server);
	echo $CourtId;
}

function editCourt($db_server)
{
	$id = sanitizeMySQL($_POST['id']);
	$type = sanitizeMySQL($_POST['type']);
	$address = sanitizeMySQL($_POST['address']);
	$location = sanitizeMySQL($_POST['location']);
	$phone = sanitizeMySQL($_POST['phone']);
	$fax = sanitizeMySQL($_POST['fax']);

	
	// Add the user
	$addFirmSQL = "UPDATE tbcourts 
			SET type = ".$type.", address = '".$address."', location = '".$location."', phone = '".$phone."', fax = '".$fax."' 
			WHERE id = ".$id;
	$addFirmResult = mysqli_query($db_server,$addFirmSQL);
	if (!$addFirmResult) die("Database access failed: " . mysqli_error());
}

function addSignature($db_server)
{
	extract($GLOBALS);
	$desc = sanitizeMySQL($_POST['desc']);
	$fileName = sanitizeMySQL($_POST['fileName']);

	// Add the signature
	$addCourtSQL = "INSERT INTO tbsignatures
			(client_id, description, image) 
			VALUES (".$clientId.",'".$desc."','".$fileName."')"; 
	$addCourtResult = mysqli_query($db_server,$addCourtSQL);
	if (!$addCourtResult) die("Database access failed: " . mysqli_error());
}

function addEvent($db_server,$parms = array())
{
	extract($GLOBALS);
	//retrieve all post data
	extract($_POST);
	// If called from php - overwrite with the $parms array recieved
	extract($parms);
	$toWhoArray = explode(',',$toWho);
	$ccArray = explode(',',$cc);
	$alertMethodArray = explode(',',$alertMethod);
	
	// check what parms recieved
	if (!isset($parm1)) $parm1 = "NULL";
	if (!isset($parm2)) $parm2 = "NULL";
	if (!isset($parm3)) $parm3 = "NULL";
	if (!isset($parm4)) $parm4 = "NULL";
	else $parm4 = "'".sanitizeMySQL($parm4)."'";
	if (!isset($parm5)) $parm5 = "NULL";
	else $parm5 = "'".sanitizeMySQL($parm5)."'";
	if (!isset($parm6)) $parm6 = "NULL";
	else $parm6 = "'".sanitizeMySQL($parm6)."'";
	if (!isset($parm7)) $parm7 = "NULL";
	else $parm7 = "'".sanitizeMySQL($parm7)."'";
	if (!isset($parm8)) $parm8 = "NULL";
	else $parm8 = "'".sanitizeMySQL($parm8)."'";
	//dudy
	if (!isset($reviewDone)) $reviewDone = false;
	if (!isset($addAlert)) $addAlert = false;
	
	//if (sanitizeMySQL($fileName) != "") {$fileSize = filesize("files/".sanitizeMySQL($fileName)); }
	if (sanitizeMySQL($fileName) != "") {$fileSize = aws_s3_getObjectSize("files/".sanitizeMySQL($fileName)); }
	else {$fileSize = "NULL";}
	
	if ($actionType == "add")
	{
		// Add the event
		$addEventSQL = "INSERT INTO tbevents
						(client_id, case_id, type, file_name, file_size, file_desc, method, timestamp, remarks, parm1, parm2, parm3, parm4, parm5, parm6, parm7, parm8) 
						VALUES (".$clientId.",".$id.",".sanitizeMySQL($type).", '".sanitizeMySQL($fileName)."', ".$fileSize.", '".sanitizeMySQL($fileDesc)."', ".sanitizeMySQL($method).", CURRENT_TIMESTAMP, '".sanitizeMySQL($remarks)."', ".sanitizeMySQL($parm1).", ".sanitizeMySQL($parm2).", ".sanitizeMySQL($parm3).", ".$parm4.", ".$parm5.", ".$parm6.", ".$parm7.", ".$parm8.")";
		$addEventResult = mysqli_query($db_server,$addEventSQL);
		
		if (!$addEventResult) die("Database access failed addEvent(1): " . mysqli_error().",");
		$eventId = mysqli_insert_id($db_server);
		
		// if not review event
		if (sanitizeMySQL($type) != 5)
		{
			echo "eventId:".$eventId.",";
		}
		$caseId = $id;
		
		// updateStatus($caseId,"התקבל מינוי");
	}
	elseif ($actionType == "edit")
	{
		// Add the event
		$editEventSQL = "UPDATE tbevents  
						SET ";
		
		if ($fileName != "")
		{
			$editEventSQL .= "file_name = '".sanitizeMySQL($fileName)."', file_size = ".$fileSize.", file_desc = '".sanitizeMySQL($fileDesc)."',";
		}
		$editEventSQL .= " method = ".sanitizeMySQL($method).", remarks = '".sanitizeMySQL($remarks)."', parm1 = ".sanitizeMySQL($parm1).", parm2 = ".sanitizeMySQL($parm2).", parm3 = ".sanitizeMySQL($parm3).", parm4 = ".$parm4.", parm5 = ".$parm5.", parm6 = ".$parm6.", parm7 = ".$parm7.", parm8 = ".$parm8." 
						WHERE id = ".$id;
		$editEventResult = mysqli_query($db_server,$editEventSQL);
		if (!$editEventResult) die("Database access failed addEvent(2): " . mysqli_error());
		
		//gethe case id
		$caseSQL = "SELECT case_id FROM tbevents   
							WHERE ID = ".$id;
		$caseResult = mysqli_query($db_server,$caseSQL);
		if (!$caseResult) die("Database access failed addEvent(3): " . mysqli_error());
		$row = mysqli_fetch_row($caseResult);
		$caseId = $row[0];	
		
		$eventId = $id;
	}
	
	// materials recieved
	if (sanitizeInput($type) == 1)
	{

		// all materials recieved
		if ($parm3 == 1)
		{
			$caseSQL = "UPDATE tbcases 
								SET all_material_recieved = 1  
								WHERE ID = ".$caseId;

			$caseResult = mysqli_query($db_server,$caseSQL);

			if (!$caseResult) die("Database access failed addEvent(4): " . mysqli_error());
			
			//check whats the status
			$caseSQL = "SELECT status FROM tbcases   
								WHERE ID = ".$caseId;
			$caseResult = mysqli_query($db_server,$caseSQL);
			if (!$caseResult) die("Database access failed addEvent(5): " . mysqli_error());
			$row = mysqli_fetch_row($caseResult);
			// if the status is waiting for material(4) - change it to ready for writing(5)
			if ($row[0] == 4)
			{
				updateStatus($caseId,"מוכן לכתיבה");
			}
		}
		
		//has any medical material arrived? - the patient is ready to be seen (status 2)
		if ($parm1 == 2) 
		{
			//check whats the status
			$caseSQL = "SELECT status FROM tbcases   
								WHERE ID = ".$caseId;
			$caseResult = mysqli_query($db_server,$caseSQL);
			if (!$caseResult) die("Database access failed addEvent(6): " . mysqli_error());
			$row = mysqli_fetch_row($caseResult);
			// if the status is waiting for material(4) - change it to ready for writing(5)
			if ($row[0] == 1)
			{
				updateStatus($caseId,"מוכן לבדיקה");
			}
		}
	}

	// the patient was in
	if (sanitizeInput($type) == 2)
	{	
		updateStatus($caseId,"נבדק");
	}
	
	// the patient was in
	if (sanitizeInput($type) == 4)
	{
		$seenPatientSQL = "UPDATE tbcases 
							SET patient_seen = 1  
							WHERE ID = ".$caseId;
		$seenPatientResult = mysqli_query($db_server,$seenPatientSQL);
		if (!$seenPatientResult) die("Database access failed addEvent(7): " . mysqli_error());
		
		updateStatus($caseId,"מחכה לחומר נוסף");
		
		// check if all materials recieved
		$caseSQL = "SELECT all_material_recieved FROM tbcases   
							WHERE ID = ".$caseId;
		$caseResult = mysqli_query($db_server,$caseSQL);
		if (!$caseResult) die("Database access failed addEvent(8): " . mysqli_error());
		$row = mysqli_fetch_row($caseResult);
		if ($row[0] == 1)
		{
			updateStatus($caseId,"מוכן לכתיבה");
		}
	}
	
	// review written
	if ((sanitizeInput($type) == 5) && ($reviewDone == true))
	{
		// wait for payment
		if (!getSetting('wait_for_payment'))
		{
			// has the case been payed
			$caseSQL = "SELECT payed FROM tbcases   
								WHERE ID = ".$caseId;
			$caseResult = mysqli_query($db_server,$caseSQL);
			if (!$caseResult) die("Database access failed addEvent(9): " . mysqli_error());
			$row = mysqli_fetch_row($caseResult);
			if ($row[0] == 2)
			{
				updateStatus($caseId,"מוכן להפצה");
			}
			else
			{
				updateStatus($caseId,"מחכה לתשלום");
			}
		}
		else
		{
			updateStatus($caseId,"מוכן להפצה");
		}
		
		// get template Id for the document
		$templateSQL = "SELECT id FROM tbletter_template   
							WHERE (event_type = ".$type.") and
							      (client_id = ".$clientId.") 
							ORDER BY description asc";
		$templateResult = mysqli_query($db_server,$templateSQL);
		if (!$templateResult) die("Database access failed addEvent(9): " . mysqli_error());
		$templateRow = mysqli_fetch_row($templateResult);
		$letterTemplate = $templateRow[0];
		$letterMethod = 1;
	}

	// report sent
	if (sanitizeInput($type) == 6)
	{
		// has the case been payed
		$caseSQL = "SELECT payed FROM tbcases   
							WHERE ID = ".$caseId;
		$caseResult = mysqli_query($db_server,$caseSQL);
		if (!$caseResult) die("Database access failed addEvent(10): " . mysqli_error());
		$row = mysqli_fetch_row($caseResult);
		if ($row[0] != 0)
		{
			updateStatus($caseId,"סגור");
		}
		else
		{
			updateStatus($caseId,"מחכה לתשלום");
		}
	}
	
	// send patient to an exam
	if (sanitizeInput($type) == 7)
	{
		updateStatus($caseId,"מחכה לחומר נוסף");
		
		$caseSQL = "UPDATE tbcases 
					SET all_material_recieved = 0  
					WHERE ID = ".$caseId;
		$caseResult = mysqli_query($db_server,$caseSQL);
		if (!$caseResult) die("Database access failed addEvent(11): " . mysqli_error());
	}

	// calrifying questions
	if (sanitizeInput($type) == 8)
	{
		if ($parm1 == 1)
		{
			updateStatus($caseId,"מחכה להבהרות");
		}
		else
		{
			updateStatus($caseId,"מוכן להפצת הבהרות");
		}
	}

	// report canceled
	if (sanitizeInput($type) == 9)
	{
		updateStatus($caseId,"סגור");
	}
	
	// report canceled
	if (sanitizeInput($type) == 10)
	{
		updateStatus($caseId,"מושהה");
	}
	
	// recieved payment
	if (sanitizeInput($type) == 11)
	{
		//how much has been payed so far
		$query = "SELECT sum(parm5) 
					FROM tbevents   
					WHERE case_id = ".$caseId." and type = 11";
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed addEvent(12): " . mysqli_error());
		$row = mysqli_fetch_row($result);
		
		//how much needs to be payed
		$caseSQL = "SELECT payment_amount,with_tax 
					FROM tbcases   
					WHERE id = ".$caseId;
		$caseResult = mysqli_query($db_server,$caseSQL);
		if (!$caseResult) die("Database access failed addEvent(13): " . mysqli_error());
		$caseRow = mysqli_fetch_row($caseResult);
		
		$totalAmount = $caseRow[0] + $caseRow[1]*$caseRow[0]*getSetting("tax");
		
		if ($totalAmount + getSetting("payment_margin") <= $row[0])
		{
			$caseSQL = "UPDATE tbcases 
					SET payed = 2  
					WHERE ID = ".$caseId;
			$caseResult = mysqli_query($db_server,$caseSQL);
			if (!$caseResult) die("Database access failed addEvent(14): " . mysqli_error());
			
			//check whats the status
			$caseSQL = "SELECT status FROM tbcases   
								WHERE ID = ".$caseId;
			$caseResult = mysqli_query($db_server,$caseSQL);
			if (!$caseResult) die("Database access failed addEvent(15): " . mysqli_error());
			$row = mysqli_fetch_row($caseResult);
			// if the status is waiting for payment(6) - change it to ready for sending(7)
			if ($row[0] == 6)
			{
				updateStatus($caseId,"מוכן להפצה");
			}
		}
		else
		{
			$caseSQL = "UPDATE tbcases 
					SET payed = 1  
					WHERE ID = ".$caseId;
			$caseResult = mysqli_query($db_server,$caseSQL);
			if (!$caseResult) die("Database access failed addEvent(16): " . mysqli_error());
		}
	}

	// status change
	if (sanitizeInput($type) == 12)
	{
		$query = "UPDATE tbcases  
				SET status = ".$parm1.", status_last_changed = CURRENT_TIMESTAMP()
				WHERE ID = ".$caseId;
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed addEvent(17): " . mysqli_error());
	}
	
	// generate and save document - if "to" assigned, or event was "write review" and the review is done
	if (($toWho != "") || ((sanitizeInput($type) == 5) && ($reviewDone == true)))
	{
		if ( empty($toOther) ) {
			$toOther = '';
		}
		
		$documentId = generateDocument($db_server,$caseId, $eventId, $letterMethod, $letterTemplate, $toWhoArray, $ccArray, $toOther, $toWho);
		$query = "update tbevents
					SET document_id = ".$documentId."
					WHERE id = ".$eventId;
							
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed addEvent(18): " . mysqli_error());
	}
	
	// add an alret on this event
	if ($addAlert)
	{
		// alert through the website
		if (in_array("website",$alertMethodArray))
		{
			$query = "INSERT INTO tbalerts
						(client_id, to_user, from_user, object_type, object_id, hold_until, creation_date) 
						VALUES (".$clientId.",".$userAlertSelect.", ".$userId.", 1, ".$eventId.", CURRENT_DATE, CURRENT_DATE)";
								
			$result = mysqli_query($db_server,$query);
			if (!$result) die("Database access failed at alert SQL addEvent(19): " . mysqli_error());
		}
		// alert through email
		if (in_array("email",$alertMethodArray))
		{
			// get email address
			$emailQuery = "SELECT t1.email
						FROM tbusers as t1
						WHERE 	(t1.id = ".$userAlertSelect.")";
			$emailResult = mysqli_query($db_server,$emailQuery);
			if (!$emailResult) die("Database access failed: " . mysqli_error());
			if (mysqli_num_rows($emailResult))
			{
				$emailRow = mysqli_fetch_row($emailResult);
				
				if ($emailRow != "")
				{
					// get patient name
					$caseQuery = "SELECT t1.patient_name
								FROM tbcases as t1
								WHERE (t1.id = ".$caseId.")";
					$caseResult = mysqli_query($db_server,$caseQuery);
					if (!$caseResult) die("Database access failed: " . mysqli_error());
					if (mysqli_num_rows($caseResult))
					{
						$caseRow = mysqli_fetch_row($caseResult);
						
						// get current user name
						$userNameQuery = "SELECT t1.first_name,t1.last_name
									FROM tbusers as t1
									WHERE 	(t1.id = ".$userAlertSelect.")";
						$userNameResult = mysqli_query($db_server,$userNameQuery);
						if (!$userNameResult) die("Database access failed: " . mysqli_error());
						if (mysqli_num_rows($userNameResult))
						{
							$userNameRow = mysqli_fetch_row($userNameResult);
							$userRealName = $userNameRow[0]." ".$userNameRow[1];;
						}
						else
						{
							$userRealName = "שם משתמש לא ידוע";	
						}
						$mailSubject = "התקבלה התראה בתיק של ".$caseRow[0];
						$mailContent = "התקבלה התראה מ-".$userRealName.".<br>בתיק של ".$caseRow[0]." עבור אירוע ".$eventTypes[$type]."<br><br>הערות: ".sanitizeMySQL(nl2br($remarks))."<br><br><a href=\"http://www.havot-daat.co.il/showCase.php?id=".$caseId."\">לחץ כאן לתיק של ".$caseRow[0]."</a>";
						sendMail($emailRow[0],$mailSubject,$mailContent);
					}
					else
					{
						echo "שגיאה בשליחת מייל - לא נמצא תיק";
					}
				}
				else
				{
					echo "לא קיימת כתובת מייל למשתמש זה";	
				}
			}
			else
			{
				echo "לא קיימת כתובת מייל למשתמש זה";	
			}
			
		}
	}
	
	
	// dudy - this functionality is closed, after call with Omer 7/6/2016
	//calculate storage
	/*
	if ($fileName != "")
	{
		$query = "SELECT t1.file_name
					FROM tbevents as t1
					WHERE 	(t1.client_id = ".$clientId.") and
							(t1.file_name != \"\") and 
							(t1.file_name is not null)";
		$result = mysqli_query($query);
		
		if (!$result) die("Database access failed: " . mysqli_error());
		if (mysqli_num_rows($result))
		{
			$totalBytes = 0;
			for ($i=0;$i<mysqli_num_rows($result);$i++)
			{
				$row = mysqli_fetch_row($result);
				//$totalBytes += filesize("files/".$row[0]);
				$totalBytes += aws_s3_getObjectSize("files/".$row[0]);
			}
			$updateSQL = "UPDATE tbclients
						SET storage_used = ".$totalBytes." 
						WHERE (id = ".$clientId.")";
			$updateResult = mysqli_query($updateSQL);
			if (!$updateResult) die("Database access failed: ($updateClientStorageAllocation) " . mysqli_error());
		}
	}
	*/
	exit();
}

function refreshCourtLocations($db_server,$typeId)
{
	extract($GLOBALS);
	header('Content-Type: text/xml');
	echo '<?xml version="1.0" ?>';
	echo '<document>';
	
	$query = "SELECT t1.ID,t1.location
				FROM tbcourts as t1
				WHERE (t1.type = ".$typeId.") and 
					  (t1.client_id = ".$clientId.") 
				ORDER BY t1.location desc";
						
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		for ($i=0;$i<mysqli_num_rows($result);$i++)
		{
			$row = mysqli_fetch_row($result);
			echo '<court>';
			echo '<ID>'.$row[0].'</ID>';
			echo '<name>'.$row[1].'</name>';
			echo '</court>';
		}
	}
	echo '</document>';
}

function addEventForm($eventType)
{
	extract($GLOBALS);
	extract($_POST);
	
	//check if adding or editing an exsiting event - if adding, load defaults
	if (!isset($editEvent))
	{
		
	}
	
	echo "<table  class=\"formTable\">";
	
	//parm 1
	if (array_key_exists(1, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][1].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<select name=\"parm1\" size=\"1\">";
				 
				foreach ($eventsOptions[$eventType][1] as $i => $valueName) {
					// dudy 29/3/2016
					// parm1 is from DB (its the value when its define, we need to update the else
					// echo "<script>console.log('eventType=".$eventType.' i='.$i .','.$parm1."')</script>";
					echo "<option ";
					if (isset($parm1)) {
						if ($i==$parm1) {echo "selected";}
					}
					else {
						// dudy 24/1/2016
						if ($eventType == 14 && $i==4) {
							echo "selected"; // set מי שלח:המרפאה as default
						}
						else if ($eventType == 8 && $i==2) {
							echo "selected"; // set שאלות הבהרה:תשובה as default
						}
					} 
					echo " value=\"".$i."\">".$valueName."</option>";
				}
				
				echo "</select>";
			echo "</td>";
			
		echo "</tr>";
	}
	
	//parm 2
	if (array_key_exists(2, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][2].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<select name=\"parm2\" size=\"1\">";
				 
				foreach ($eventsOptions[$eventType][2] as $i => $valueName) {
					echo "<option ";
					if (isset($parm2)) {
						if ($i==$parm2) {
							echo "selected";
						}
					}
					else {
						if ($i==1) {
							echo "selected";
						}
					}
					echo " value=\"".$i."\">".$valueName."</option>";
				}
				
				echo "</select>";
			echo "</td>";
			
		echo "</tr>";
	}
	
	//parm 3
	if (array_key_exists(3, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][3].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<select name=\"parm3\" size=\"1\">";
				 
				foreach ($eventsOptions[$eventType][3] as $i => $valueName) {
					echo "<option ";
					if (isset($parm3)) {if ($i==$parm3) {echo "selected";}}
					
					echo " value=\"".$i."\">".$valueName."</option>";
				}
				
				echo "</select>";
			echo "</td>";
			
		echo "</tr>";
	}
	
	//parm 4
	if (array_key_exists(4, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][4].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<input name=\"parm4\" id=\"parm4\" type=\"text\" ";
				if (isset($parm4)) {echo "value=\"".$parm4."\"";}
				echo " />";

			echo "</td>";
			
		echo "</tr>";
	}
	
	//parm 5
	if (array_key_exists(5, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][5].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<input name=\"parm5\" id=\"parm5\" maxlength=\"100\" type=\"text\" ";
				if (isset($parm5)) {echo "value=\"".$parm5."\"";}
				echo " />";
			echo "</td>";			
		echo "</tr>";
	}
	
	//parm 6
	if (array_key_exists(6, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][6].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"parm6\" cols=\"60\" rows=\"4\" maxlength=\"4500\">";
				if (isset($parm6)) {echo $parm6;}
				echo "</textarea>";
			echo "</td>";			
		echo "</tr>";
	}
	
	//parm 7
	if (array_key_exists(7, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][7].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"parm7\" cols=\"60\" rows=\"4\" maxlength=\"4500\">";
				if (isset($parm7)) {echo $parm7;}
				echo "</textarea>";
			echo "</td>";			
		echo "</tr>";
	}
	
	//parm 8
	if (array_key_exists(8, $eventsParms[$eventType]))
	{
		echo "<tr>";
			echo "<td>";
				echo "<label>".$eventsParms[$eventType][8].": </label>";
			echo "</td>";
			echo "<td>";
				echo "<textarea name=\"parm8\" cols=\"60\" rows=\"4\" maxlength=\"5000\">";
				if (isset($parm8)) {echo $parm8;}
				echo "</textarea>";
			echo "</td>";			
		echo "</tr>";
	}
	
	
	echo "</table>";
}

function populateTemplateList($db_server,$eventType)
{
	extract($GLOBALS);
	header('Content-Type: text/xml');
	echo '<?xml version="1.0" ?>';
	echo '<document>';
	
	$query = "SELECT distinct t1.ID,t1.description
						FROM tbletter_template as t1
						WHERE ((t1.event_type = 0) or (t1.event_type = ".$eventType.")) and
							  (t1.client_id = ".$clientId.") 
						ORDER BY t1.event_type desc";
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		for ($i=0;$i<mysqli_num_rows($result);$i++)
		{
			$row = mysqli_fetch_row($result);
			echo '<template>';
			echo '<ID>'.$row[0].'</ID>';
			echo '<description>'.$row[1].'</description>';
			echo '</template>';
		}
	}
	echo '</document>';
}

function generateDocument($db_server,$caseId, $eventId, $method, $templateId, $toWhoArray, $ccArray, $toDetails, $toWho)
{
	extract($GLOBALS);

	$patientSexText = array("M" => "מר", "F" => "גב'");
	$judgeSexText = array("M" => "שופט", "F" => "שופטת");
	$taxText = array(0 => "בתוספת מע\"מ", 1 => "כולל מע\"מ");
	
	
	// event
	$eventQuery = "SELECT id, case_id, type, file_name, file_desc, method, DATE_FORMAT(date(t1.timestamp),'%d/%m/%Y'), document_id, remarks, parm1, parm2, parm3, parm4, parm5, parm6, parm7, parm8, DATE_FORMAT(date(now()),'%d/%m/%Y') 
					FROM tbevents as t1 
					WHERE id = ".$eventId;
	$eventResult = mysqli_query($db_server,$eventQuery);
	if (!$eventResult) die("Database access failed: " . mysqli_error()." SQL: ".$eventQuery);
	elseif (mysqli_num_rows($eventResult))
	{
		$eventRow = mysqli_fetch_row($eventResult);
	}
	$eventType = $eventRow[2];
	$eventDate =  $eventRow[6];
	$letterDate =  $eventRow[17];
	$eventParm1 = $eventRow[9];
	$eventParm2 = $eventRow[10];
	$eventParm3 = $eventRow[11];
	$eventParm4 = $eventRow[12];
	$eventParm5 = $eventRow[13];
	$eventParm6 = $eventRow[14];
	$eventParm7 = $eventRow[15];
	$eventParm8 = $eventRow[16];
	
	
	// document settings
	$documentSettingsQuery = "SELECT t1.header,t1.footer
								FROM tbdocument_settings as t1
								WHERE (is_default= 1) and 
								      (t1.client_id = ".$clientId.")";
	$documentSettingsResult = mysqli_query($db_server,$documentSettingsQuery);
	if (!$documentSettingsResult) die("Database access failed: " . mysqli_error()." SQL: ".$documentSettingsQuery);
	elseif (mysqli_num_rows($documentSettingsResult))
	{
		$documentSettingsRow = mysqli_fetch_row($documentSettingsResult);
	}
	
	// document template
	$templateQuery = "SELECT t1.subject_court,t1.text,t2.image,t1.subject_no_court
								FROM tbletter_template as t1, tbsignatures as t2
								WHERE (t1.signature = t2.id) and 
									t1.id = ".$templateId;
	$templateResult = mysqli_query($db_server,$templateQuery);
	if (!$templateResult) die("Database access failed: " . mysqli_error()." SQL: ".$templateQuery);
	elseif (mysqli_num_rows($templateResult))
	{
		$templateRow = mysqli_fetch_row($templateResult);
	}
	
	// case details
	$caseQuery = "SELECT t1.ID, t1.patient_seen, t1.court_num, DATE_FORMAT(date(t1.appointment_date),'%d/%m/%Y'), DATE_FORMAT(date(t1.creation_date),'%d/%m/%Y'), t1.appointment_type, t6.type, t6.location, t1.patient_id, t1.patient_name, DATE_FORMAT(date(t1.patient_birthdate),'%d/%m/%Y'), t1.patient_sex, t1.judge_name, t1.judge_sex, t1.defence_lawyer_name, t1.prosecutor_name, t1.payment_amount, t1.with_tax, t1.prosecutor_payment, t1.defence_payment, t1.extra_demands,DATE_FORMAT(date(t1.case_deadline),'%d/%m/%Y') , DATE_FORMAT(date(t1.court_date),'%d/%m/%Y'), t1.payed, t1.all_material_recieved, t1.remarks,".
				 //26,    27,         28,       29
				"t2.name, t2.address, t2.email, t2.phone, t2.fax, t3.name, t3.address, t3.email, t3.phone, t3.fax, t4.name, t5.name, t6.address, t6.fax, t6.phone, (DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(t1.patient_birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(t1.patient_birthdate, '00-%m-%d'))) AS patient_age,".
				//42
				"t1.defence_lawyer_name_2,t1.defence_lawyer_firm_id_2,t7.name, t7.address, t7.email, t7.phone, t7.fax,t1.prosecutor_number,t1.defence_lawyer_number,t1.defence_lawyer_2_number
				FROM tbcases as t1, tblawyers as t2, tblawyers as t3, tbcompanies as t4, tbstatus as t5, tbcourts as t6,tblawyers as t7
				where (t1.prosecutor_firm_id = t2.id) and 
						(t1.defence_lawyer_firm_id = t3.id) and
						(t1.defence_company_id = t4.id) and
						(t1.defence_lawyer_firm_id_2 = t7.id) and
						(t1.status = t5.id) and
						(t1.court_id = t6.id) and
					  	t1.id = ".$caseId; 
				
	$caseResult = mysqli_query($db_server,$caseQuery);
	if (!$caseResult) die("Database access failed: " . mysqli_error()." SQL: ".$caseQuery);
	elseif (mysqli_num_rows($caseResult))
	{
		$caseRow = mysqli_fetch_row($caseResult);
	}
	
	//judge sex
	if ($caseRow[13] == "M") {$judgePrefix = " ";}
	else {$judgePrefix = "ת ";}
				
	//cc
	$ccString = "";
	
	//lawyer's numbers
	if ($caseRow[49] != "")
	{
		$prosecutorNumber = "<br><u>מספרכם:</u> ".$caseRow[49];
	}
	else
	{
		$prosecutorNumber = "";	
	}
	if ($caseRow[50] != "")
	{
		$defenceNumber = "<br><u>מספרכם:</u> ".$caseRow[50];
	}
	else
	{
		$defenceNumber = "";	
	}
	if ($caseRow[51] != "")
	{
		$defence2Number = "<br><u>מספרכם:</u> ".$caseRow[51];
	}
	else
	{
		$defence2Number = "";	
	}
	
	if ( count($ccArray) > 1)
	{
		$ccString = "העתק:";
		foreach ($ccArray as $ccValue)
		{
			if ($ccValue == "prosecutor")
			{
				$ccString .= "<br>עו\"ד ".$caseRow[15].", ".str_replace("<br />",", ",nl2br($caseRow[26])).", ".str_replace("<br />",", ",nl2br($caseRow[27]).$prosecutorNumber);
			}
			if ($ccValue == "defenseLawyer")
			{
				$ccString .= "<br>עו\"ד ".$caseRow[14].", ".str_replace("<br />",", ",nl2br($caseRow[31])).", ".str_replace("<br />",", ",nl2br($caseRow[32]).$defenceNumber);
			}
			if ($ccValue == "court")
			{
				$ccString .= "<br>כב' השופט".$judgePrefix.$caseRow[12].", בית המשפט ה".$courtType[$caseRow[6]]." ב".$caseRow[7].", ".str_replace("<br />",", ",nl2br($caseRow[38]));
			}
		}
	}
	
	// **build document**
	
	//header
	$documentString = $documentSettingsRow[0];
	
	
	//to
	$documentString .= "<table style=\"width:95%;\"><tr>";
	
	if ($toWhoArray != NULL)
	{
	foreach ($toWhoArray as $toWhoValue)
	{
		if ($toWhoValue == "prosecutor")
		{
			$documentString .= "<td style=\"padding:10px;vertical-align:text-top;font-size:12px;\">";	
			$documentString .= "לכבוד<br>עו\"ד ".$caseRow[15]."<br>".$caseRow[26]."<br>";
			switch ($method)
				{
					//mail
					case 1: $documentString .= nl2br($caseRow[27]).$prosecutorNumber;
					break;
					//fax
					case 2: $documentString .= "פקס: ".$caseRow[35].$prosecutorNumber;
					break;
					//email
					case 4: $documentString .= $caseRow[33].$prosecutorNumber;
					break;
					case 5: $documentString .= nl2br($caseRow[27])."<br>"."טלפון: ".$caseRow[34]."<br>"."פקס: ".$caseRow[35]."<br>".$caseRow[33].$prosecutorNumber;
					break;
					default: $documentString .= nl2br($caseRow[27])."<br>"."טלפון: ".$caseRow[34]."<br>"."פקס: ".$caseRow[35]."<br>".$caseRow[33].$prosecutorNumber;
					break;
				}
			$documentString .= "</td>";
		}
		if ($toWhoValue == "defenseLawyer")
		{
			$documentString .= "<td style=\"padding:10px;vertical-align:text-top;font-size:12px;\">";	
			$documentString .= "לכבוד<br>עו\"ד ".$caseRow[14]."<br>".$caseRow[31]."<br>";
			switch ($method)
				{
					//mail
					case 1: $documentString .= nl2br($caseRow[32]).$defenceNumber;
					break;
					//fax
					case 2: $documentString .= "פקס: ".$caseRow[30].$defenceNumber;
					break;
					//email
					case 4: $documentString .= $caseRow[33].$defenceNumber;
					break;
					case 5: $documentString .= nl2br($caseRow[32])."<br>"."טלפון: ".$caseRow[29]."<br>"."פקס: ".$caseRow[30]."<br>".$caseRow[33].$defenceNumber;
					break;
					default: $documentString .= nl2br($caseRow[32])."<br>"."טלפון: ".$caseRow[29]."<br>"."פקס: ".$caseRow[30]."<br>".$caseRow[33].$defenceNumber;
					break;
				}
			$documentString .= "</td>";
			
			// check if there's a second defence lawyer
			if (($caseRow[42] != "") || ($caseRow[43] != 0))
			{
				$documentString .= "<td style=\"padding:10px;vertical-align:text-top;font-size:12px;\">";	
				$documentString .= "לכבוד<br>עו\"ד ".$caseRow[42]."<br>".$caseRow[44]."<br>";
				switch ($method)
					{
						//mail
						case 1: $documentString .= nl2br($caseRow[45]).$defence2Number;
						break;
						//fax
						case 2: $documentString .= "פקס: ".$caseRow[48].$defence2Number;
						break;
						//email
						case 4: $documentString .= $caseRow[46].$defence2Number;
						break;
						case 5: $documentString .= nl2br($caseRow[45])."<br>"."טלפון: ".$caseRow[47]."<br>"."פקס: ".$caseRow[48]."<br>".$caseRow[46].$defence2Number;
						break;
						default: $documentString .= nl2br($caseRow[45])."<br>"."טלפון: ".$caseRow[47]."<br>"."פקס: ".$caseRow[48]."<br>".$caseRow[46].$defence2Number;
						break;
					}
				$documentString .= "</td>";	
			}
		}
		if ($toWhoValue == "court")
		{
			$documentString .= "<td style=\"padding:10px;vertical-align:text-top;font-size:12px;\">";	
			$documentString .= "לכבוד<br>כב' השופט".$judgePrefix.$caseRow[12]."<br> בית המשפט ה".$courtType[$caseRow[6]]." ב".$caseRow[7]."<br>";
			switch ($method)
				{
					//mail
					case 1: $documentString .= nl2br($caseRow[38]);
					break;
					//fax
					case 2: $documentString .= "פקס: ".$caseRow[39];
					break;
					case 5: $documentString .= nl2br($caseRow[38])."<br>"."טלפון: ".$caseRow[40]."<br>"."פקס: ".$caseRow[39];
					break;
					default: $documentString .= nl2br($caseRow[38])."<br>"."טלפון: ".$caseRow[40]."<br>"."פקס: ".$caseRow[39];
					break;
				}
			$documentString .= "</td>";
		}
	}
	}
	$documentString .= "</tr></table>";	
	$documentString .= "<br><br><br>";
	if ($toWho != "")
	{
		$documentString .= "<p>שלום רב,</p><br><br>";
	}
	//subject choose by  - appointementType
	if ($caseRow[5] == 1)
	{
		$documentString .= "<center><u>".$templateRow[0]."</u></center><br><br>";
	}
	else
	{
		$documentString .= "<center><u>".$templateRow[3]."</u></center><br><br>";
	}
	
	//text
	$documentString .= $templateRow[1]."<br><br>";
	
	//signature
	$documentString .= "<img src='file.php?f=".$templateRow[2]."' />";
	
	//footer
	$documentString .= "<br>".$documentSettingsRow[1];
	
	// fill tags
	$documentString = str_replace("[תאריך]", $letterDate, $documentString);
	$documentString = str_replace("[תאריך_אירוע]", $eventDate, $documentString);
	$documentString = str_replace("[תא]", $caseRow[2], $documentString);
	$documentString = str_replace("[סוג_ביהמש]", $courtType[$caseRow[6]], $documentString);
	$documentString = str_replace("[מיקום_ביהמש]", $caseRow[7], $documentString);
	$documentString = str_replace("[מין_פציינט]", $patientSexText[$caseRow[11]], $documentString);
	$documentString = str_replace("[שם_פציינט]", $caseRow[9], $documentString);
	$documentString = str_replace("[שם_חברה]", $caseRow[36], $documentString);
	$documentString = str_replace("[העתק]", $ccString, $documentString);
	$documentString = str_replace("[תאריך_מינוי]", $caseRow[3], $documentString);
	$documentString = str_replace("[סוג_מינוי]", $caseType[$caseRow[5]], $documentString);
	$documentString = str_replace("[תז_פציינט]", $caseRow[8], $documentString);
	$documentString = str_replace("[תאריך_לידה_פציינט]", $caseRow[10], $documentString);
	$documentString = str_replace("[שם_שופט]", $caseRow[12], $documentString);
	$documentString = str_replace("[מין_שופט]", $judgeSexText[$caseRow[13]], $documentString);
	$documentString = str_replace("[עוד_נתבע]", $caseRow[14], $documentString);
	$documentString = str_replace("[עוד_נתבע_2]", $caseRow[44], $documentString);
	$documentString = str_replace("[עוד_תובע]", $caseRow[15], $documentString);
	$documentString = str_replace("[סכום_תשלום]", $caseRow[16], $documentString);
	$documentString = str_replace("[מעמ]", $taxText[$caseRow[17]], $documentString);
	$documentString = str_replace("[מספר_תובע]", $caseRow[49], $documentString);
	$documentString = str_replace("[מספר_נתבע]", $caseRow[50], $documentString);
	$documentString = str_replace("[מספר_נתבע_2]", $caseRow[51], $documentString);
	$documentString = str_replace("[תאריך_תור]", $eventParm4, $documentString);
	$documentString = str_replace("[שעת_תור]", $eventParm5, $documentString);
	
	
	if ($caseRow[11] == "M")
	{
		$documentString = str_replace("[גיל_פציינט]", "בן ".$caseRow[41], $documentString);
		$documentString = str_replace("[ת]", "", $documentString);
	}
	else
	{
		$documentString = str_replace("[גיל_פציינט]", "בת ".$caseRow[41], $documentString);
		$documentString = str_replace("[ת]", "ת", $documentString);
	}
	
	if (strpos($documentString,"[תאריך_ביקור_אחרון]"))
	{
		$parmQuery = "SELECT DATE_FORMAT(date(t1.timestamp),'%d/%m/%Y')
									FROM tbevents as t1
									WHERE t1.type = 2 and
										t1.case_id = ".$caseId." 
									ORDER BY t1.timestamp desc
									LIMIT 0,1";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$parmRow = mysqli_fetch_row($parmResult);
			$documentString = str_replace("[תאריך_ביקור_אחרון]", $parmRow[0], $documentString);
		}
		else
		{
			$documentString = str_replace("[תאריך_ביקור_אחרון]", "(לא נמצא תאריך ביקור)", $documentString);
		}
	}
	
	if (strpos($documentString,"[רשימת_מסמכים]"))
	{
		$parmQuery = "SELECT t1.parm6
							FROM tbevents as t1
							WHERE t1.type = 1 and
								t1.case_id = ".$caseId." 
							ORDER BY t1.timestamp asc";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$documentsList = "";
			for ($i=0;$i<mysqli_num_rows($parmResult);$i++)
			{
				$parmRow = mysqli_fetch_row($parmResult);
				$documentsList .= "<br>".nl2br($parmRow[0]);
			}
			$documentString = str_replace("[רשימת_מסמכים]", $documentsList, $documentString);
		}
		else
		{
			$documentString = str_replace("[רשימת_מסמכים]", "(לא נמצאו מסמכים)", $documentString);
		}
	}
	
	if (strpos($documentString,"[תולדות_התאונה]"))
	{
		$parmQuery = "SELECT t1.parm6
							FROM tbevents as t1
							WHERE t1.type = 2 and
								t1.case_id = ".$caseId." 
							ORDER BY t1.timestamp desc
							LIMIT 0,1";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$parmRow = mysqli_fetch_row($parmResult);
			$documentString = str_replace("[תולדות_התאונה]", $parmRow[0], $documentString);
		}
		else
		{
			$documentString = str_replace("[תולדות_התאונה]", "(לא נמצאו פרטים על תולדות התאונה)", $documentString);
		}
	}
	
	if (strpos($documentString,"[תולדות_המטופל]"))
	{
		$parmQuery = "SELECT t1.parm7
							FROM tbevents as t1
							WHERE t1.type = 2 and
								t1.case_id = ".$caseId." 
							ORDER BY t1.timestamp desc
							LIMIT 0,1";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$parmRow = mysqli_fetch_row($parmResult);
			$documentString = str_replace("[תולדות_המטופל]", $parmRow[0], $documentString);
		}
		else
		{
			$documentString = str_replace("[תולדות_המטופל]", "(לא נמצאו פרטים על תולדות המטופל)", $documentString);
		}
	}
	
	if (strpos($documentString,"[מהלך_הבדיקה]"))
	{
		$parmQuery = "SELECT t1.parm8
							FROM tbevents as t1
							WHERE t1.type = 2 and
								t1.case_id = ".$caseId." 
							ORDER BY t1.timestamp desc
							LIMIT 0,1";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$parmRow = mysqli_fetch_row($parmResult);
			$documentString = str_replace("[מהלך_הבדיקה]", $parmRow[0], $documentString);
		}
		else
		{
			$documentString = str_replace("[מהלך_הבדיקה]", "(לא נמצאו פרטים על תולדות הבדיקה)", $documentString);
		}
	}
	
	if (strpos($documentString,"[בדיקות_עזר]"))
	{
		$parmQuery = "SELECT t1.parm6
							FROM tbevents as t1
							WHERE t1.type = 5 and
								t1.case_id = ".$caseId." 
							ORDER BY t1.timestamp desc
							LIMIT 0,1";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$parmRow = mysqli_fetch_row($parmResult);
			$documentString = str_replace("[בדיקות_עזר]", $parmRow[0], $documentString);
		}
		else
		{
			$documentString = str_replace("[בדיקות_עזר]", "(לא נמצאו פרטים על בדיקות עזר)", $documentString);
		}
	}
	
	if (strpos($documentString,"[דיון_ומסקנות]"))
	{
		$parmQuery = "SELECT t1.parm7
							FROM tbevents as t1
							WHERE t1.type = 5 and
								t1.case_id = ".$caseId." 
							ORDER BY t1.timestamp desc
							LIMIT 0,1";
		$parmResult = mysqli_query($db_server,$parmQuery);
		if (!$parmResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($parmResult))
		{
			$parmRow = mysqli_fetch_row($parmResult);
			$documentString = str_replace("[דיון_ומסקנות]", $parmRow[0], $documentString);
		}
		else
		{
			$documentString = str_replace("[דיון_ומסקנות]", "(לא נמצאו פרטים של דיון ומסקנות)", $documentString);
		}
	}
	
	if ( empty($to) ) {
		$to = '';
	}
	if ( empty($cc) ) {
		$cc = '';
	}
	
	// save the document
	$insertDocumentSQL = "INSERT INTO tbdocuments 
				(client_id, case_id, event_id, date, method, to_who, cc, to_details, document) 
				VALUES (".$clientId.",".$caseId.",".$eventId.",CURRENT_DATE,".$method.",'".$to."','".$cc."','".$toDetails."','".sanitizeMySQL($documentString)."')"; 
		$insertDocumentResult = mysqli_query($db_server,$insertDocumentSQL);
		if (!$insertDocumentResult) die("Database access failed: " . mysqli_error()." SQL: ".$insertDocumentSQL);
		// Need to retrieve a new user id
		$documentId = mysqli_insert_id($db_server);
		return $documentId;
}

function deleteAlert($db_server,$alertId)
{
	$query = "delete from  tbalerts
				WHERE id = ".$alertId;
							
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
}

function hideAlert($db_server,$alertId)
{
	$daysToHide = sanitizeInput($_POST['daysToHide']);
	if ($daysToHide == "") {$daysToHide = 30;}
	$query = "update  tbalerts
				SET hold_until = (DATE(NOW()) + INTERVAL ".$daysToHide." DAY)
				WHERE id = ".$alertId;
							
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
}

function mailDocument($db_server,$id,$email, $clientId)
{
	// get document
	$documentQuery = "SELECT t1.case_id, t1.document
				FROM tbdocuments as t1
				WHERE 	(t1.id = ".$id.")";
	$docResult = mysqli_query($db_server,$documentQuery);
	if (!$docResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($docResult))
	{
		$docRow = mysqli_fetch_row($docResult);
	}
	// get case details
	$caseQuery = "SELECT t1.patient_name, t1.patient_sex, t1.court_num, t2.name
				FROM tbcases as t1
				LEFT JOIN tbcompanies as t2
				ON t1.defence_company_id = t2.id
				WHERE (t1.id = ".$docRow[0].")";
	$caseResult = mysqli_query($db_server,$caseQuery);
	if (!$caseResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($caseResult))
	{
		$caseRow = mysqli_fetch_row($caseResult);
	}
	
	// get cc mail
	$ccMailQuery = "SELECT t1.ccmail
				FROM tbclients as t1
				WHERE 	(t1.id = ".$clientId.")";
	$ccMailResult = mysqli_query($db_server,$ccMailQuery);
	if (!$ccMailResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($ccMailResult))
	{
		$ccMailRow = mysqli_fetch_row($ccMailResult);
		$ccMail = $ccMailRow[0];
	}
	else
	{
		$ccMail = "ccmail@havot-daat.co.il";
	}
	
	
	$mailSubject = "";
	if ($caseRow[2] != "")
	{
		$mailSubject .= "ת.א. ".$caseRow[2]." ";
	}
	if ($caseRow[1] != "M")
	{
		$mailSubject .= "גב' ".$caseRow[0];
	}
	else
	{
		$mailSubject .= "מר ".$caseRow[0];
	}
	if ($caseRow[3] != "")
	{
		$mailSubject .= " נ' ".$caseRow[3];
	}
	
	$mailContent = $docRow[1]."<br><span>בברכה,<br>פרופ' דוד ירניצקי</span>";
	sendMail($email,$mailSubject,$mailContent,$ccMail);

}

function deleteSignature($db_server,$id)
{
	$query = "delete from  tbsignatures
			WHERE id = ".$id;
						
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
}

function afterTagAdded($db_server) {
	
	$case_id  = sanitizeMySQL($_POST['case_id']);
	$tagLabel = sanitizeInput($_POST['tagLabel']);

		/*
	UPDATE `havotdaa_dbclinic`.`tbcases` 
	SET tags = concat( IFNULL( concat(tags, ',' ) ,'') , 'test5' )
	WHERE `ID`=9;
	*/
	
	$tagQuery = "UPDATE tbcases 
					   SET tags = concat( IFNULL( concat(tags, ',' ) ,'') , '".$tagLabel."' )  
					   WHERE ID = ".$case_id ;
					   
	$seenPatientResult = mysqli_query($db_server,$tagQuery);
	if (!$seenPatientResult) die("Database access failed afterTagAdded(): " . mysqli_error());
	
	// Send as JSON
	header("Content-Type: application/json");
	echo 'ok';
	
	exit();
}

function afterTagRemoved($db_server) {
	
	// Send as JSON
	header("Content-Type: application/json");
	
	$case_id  = sanitizeMySQL($_POST['case_id']);
	$tagLabel = sanitizeInput($_POST['tagLabel']);

	/* 1.get all tags as string.
	 * 2.explode string into an array.
	 * 3.find tagLabel in array and unset it.
	 * 4.implode array back to string .
	 * 5.update db.
	*/

    //1
	$tagQuery = "SELECT tags 
				 FROM tbcases  
                 WHERE ID = ".$case_id ;
				 
	$result = mysqli_query($db_server,$tagQuery);
	$tagRow = mysqli_fetch_row($result);
	
	if (!$tagRow) die("Database access failed afterTagRemoved(): " . mysqli_error());
	
	if (!empty($tagRow[0])) {

		
		//2
		$tagsArr = explode(",", $tagRow[0]);  
		//3
		$index = array_search($tagLabel,$tagsArr);
		if($index !== FALSE) unset($tagsArr[$index]);
		//4
		$tagsString = implode(",", array_filter($tagsArr));
		//5
		if ( empty($tagsString) ) {
			$rmTagQuery =  "UPDATE tbcases 
				SET tags = null
				WHERE ID = ".$case_id ;
		} else {
			$rmTagQuery =  "UPDATE tbcases 
							SET tags = '".$tagsString."'
							WHERE ID = ".$case_id ;
		}
		$seenPatientResult = mysqli_query($db_server,$rmTagQuery);
		if (!$seenPatientResult) die("Database access failed afterTagRemoved(): " . mysqli_error());
		//echo 'query: ' . $rmTagQuery . "\n";
	}
	
	
	
	echo 'ok';
	
	exit();
}


function loadTagsAddedAjax($db_server) {
	ini_set('display_errors', '1');
	// Connect to DB
	$case_id  = sanitizeMySQL($_POST['case_id']);

	$tagQuery = "SELECT tags 
				 FROM tbcases  
                 WHERE ID = ".$case_id ;
	
	$result = mysqli_query($db_server,$tagQuery);

	if (!$result) die("Database access failed afterTagRemoved(): " . mysqli_error());
	
	if (mysqli_num_rows($result)) {
		$tagRow = mysqli_fetch_row($result);
		$tagsArr = explode(",", $tagRow[0]);  
	} else {
		$tagsArr = array();
	}
		
	// Send as JSON
	header("Content-Type: application/json");
	$json = json_encode($tagsArr);
	echo $json;
	exit();
}
