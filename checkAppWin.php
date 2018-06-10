<?php
$url='https://www.saskatchewan.ca/residents/moving-to-saskatchewan/immigrating-to-saskatchewan/saskatchewan-immigrant-nominee-program/maximum-number-of-sinp-applications';
$OIDurl='https://www.saskatchewan.ca/residents/moving-to-saskatchewan/immigrating-to-saskatchewan/saskatchewan-immigrant-nominee-program/applicants-international-skilled-workers/international-skilled-worker-occupations-in-demand';
#$client = new MongoDB\Driver\Manager('mongodb://addysinha:Adidas007#@cluster0-shard-00-00-3psj7.mongodb.net:27017,cluster0-shard-00-01-3psj7.mongodb.net:27017,cluster0-shard-00-02-3psj7.mongodb.net:27017/test?ssl=true&replicaSet=Cluster0-shard-0&authSource=admin');

// Multiple recipients
$to = 'abhyudaya.sinha.addy@gmail.com'; // note the comma
$to_success = 'abhyudaya.sinha.addy@gmail.com,aashu.astha@gmail.com'; // note the comma

// Subject
$subject = '';

$OIDCheckStatus="";
$EECheckStatus="";

#print("Before While Loop<BR/>");

#while (true) {
	#print("In While Loop<BR/>");

	$checkDateTime = new DateTime('NOW');
	// using file() function to get content
	$lines_array=file($url);
	// turn array into one variable
	$lines_string=implode('',$lines_array);
	//output, you can also save it locally on the server

	// using file() function to get content
	$lines_array_OID=file($OIDurl);
	// turn array into one variable
	$lines_string_OID=implode('',$lines_array_OID);
	//output, you can also save it locally on the server
	
	#print($lines_string);

	if (preg_match("/Occupations In-Demand sub-category is closed to applications at this time/i", $lines_string)) {
		$OIDCheckStatus="Saskatchewan - OID is closed.";
		if (preg_match("/Occupations In-Demand sub-category is closed to applications at this time/i", $lines_string_OID)) {
			$OIDCheckStatus="Saskatchewan - OID is closed.";
		} else {
			$OIDCheckStatus="Quick! Saskatchewan - OID is open.";
		}
	} else {
		$OIDCheckStatus="Quick! Saskatchewan - OID is open.";
	}

	if (preg_match("/Saskatchewan Express Entry sub-category is closed to applications at this time/i", $lines_string)) {
		$EECheckStatus="Saskatchewan - Express Entry is closed.";
	} else {
		$EECheckStatus="Quick! Saskatchewan - Express Entry is open.";
	}
	
	print($OIDCheckStatus . "<BR/>");
	print($EECheckStatus . "<BR/>");

	if (preg_match("/Quick/i", $EECheckStatus) || preg_match("/Quick/i", $OIDCheckStatus)) {
		$subject = "Quick! Saskatchewan PNP is open. Check ASAP!";
	} else {
		$subject = $OIDCheckStatus . ' - ' . $EECheckStatus;
	}

	$message = 'Date Time: ' . $checkDateTime->format('Y\-m\-d\ h:i:s') . '<BR/>' . $OIDCheckStatus . '<BR/>' . $EECheckStatus;

	// To send HTML mail, the Content-type header must be set
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';

	// Additional headers
	if (preg_match("/Quick/i", $EECheckStatus) || preg_match("/Quick/i", $OIDCheckStatus)) {
		$headers[] = 'To: ' . $to_success;
		print("Emails to: " . $to_success . "<BR/>");
	} else {
		$headers[] = 'To: ' . $to;
		print("Emails to: " . $to . "<BR/>");
	}
	
	$headers[] = 'From: Addy SasCheck <abhyudaya.sinha.addy@gmail.com>';
	$headers[] = 'Cc: ';
	$headers[] = 'Bcc: ';

	// Mail it
	mail($to, $subject, $message, implode("\r\n", $headers));

/*	$document = ['_id' => new MongoDB\BSON\ObjectId, 'sasOIDCheck' => $OIDCheckStatus, 'sasEECheck' => $EECheckStatus, 'checkDateTime' => $checkDateTime->format('Y\-m\-d\ h:i:s')];
	$bulkWrite = new MongoDB\Driver\BulkWrite(['ordered' => true]);
	$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

	$bulkWrite->insert($document);

	try {
		$result = $client->executeBulkWrite('sas_app_win_check_db.sas_app_win_check_coll', $bulkWrite, $writeConcern);
		print("Records written to Mongodb..<BR/>");
	} catch (MongoDB\Driver\Exception\BulkWriteException $e) {
		$result = $e->getWriteResult();

		// Check if the write concern could not be fulfilled
		if ($writeConcernError = $result->getWriteConcernError()) {
			printf("%s (%d): %s\n",
				$writeConcernError->getMessage(),
				$writeConcernError->getCode(),
				var_export($writeConcernError->getInfo(), true)
			);
		}

		// Check if any write operations did not complete at all
		foreach ($result->getWriteErrors() as $writeError) {
			printf("Operation#%d: %s (%d)\n",
				$writeError->getIndex(),
				$writeError->getMessage(),
				$writeError->getCode()
			);
		}
	} catch (MongoDB\Driver\Exception\Exception $e) {
		printf("Other error: %s\n", $e->getMessage());
		exit;
	}
*/	
#	sleep(900);
#}

?>
