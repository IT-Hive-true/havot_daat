<?php
#########################################################################
ini_set("memory_limit", "-1");
ini_set('max_execution_time', -1);
ini_set('display_errors', '1');
error_reporting(E_STRICT | E_ALL ^ E_DEPRECATED);
#########################################################################

//require './vendor/autoload.php';
require './vendor/awsv3/aws-autoloader.php';

//use Aws\Common\Aws;
use Aws\AwsClient;
//use Aws\Common\Enum\Region;
//use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client; // for pre-signed upload file

require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

 
function aws_file_get_contents($s3_file) {
	
	global $bucket;
	global $aws_key;
	global $aws_secret;

	$sharedConfig = [
		'region' => 'eu-west-1',
		'version' => 'latest',
		'credentials' => [
			'key' => $aws_key,
			'secret' => $aws_secret,
		]
	];

	$sdk = new Aws\Sdk($sharedConfig);
	$s3Client = $sdk->createS3();

	try {

		$result = $s3Client->getObject([
			'Bucket' => $bucket,
			'Key' => $s3_file
		]);

		if (isset($result)) {

			$content = $result['Body']->getContents();

			return $content;
		} else {
			// image not found
			return null;
		}
	} catch (Exception $e) {
//		 echo "Request failed.<br />";
		return null;
	}


//	$awsClient = AwsClient::factory(array(
//					'key' => $aws_key,
//					'secret' => $aws_secret,
//					'region' => Region::EU_WEST_1,
//					'ACL' => CannedAcl::PUBLIC_READ,
//	));
//	$s3 = $awsClient->get('s3');

//	try {
//
//		$result = $s3->GetObject(
//				  array(
//						'Bucket' => $bucket,
//						'Key' => $s3_file,
//				  )
//		);
//
//		if (isset($result)) {
//			$body = $result->get('Body');
//
//			$body->rewind();
//			$content = $body->read($result['ContentLength']);
//
//			return $content;
//		} else {
//			// image not found
//			return null;
//		}
//	} catch (Exception $e) {
////		 echo "Request failed.<br />";
//		return null;
//	}

}
	
// place this code inside a php file and call it f.e. "download.php"
//$path = $_SERVER['DOCUMENT_ROOT']."/files/"; // change the path to fit your websites document structure
$filename = sanitizeInput($_GET['f']);
//$fullPath = $path.$filename;
$fullPath = $folder.$filename;

$userIp = get_user_ip();

	// Add to log
	$addToLogSQL = "INSERT INTO tbfiles_log 
			(time, filename, user_id, ip) 
			VALUES (CURRENT_TIMESTAMP,'".$filename."','".$userId."','".$userIp."')"; 
	$addToLogResult = mysqli_query($db_server,$addToLogSQL);
	if (!$addToLogResult) die("Database access failed: " . mysqli_error());
	
//if ($fd = fopen ($fullPath, "r")) {
	$content = aws_file_get_contents($fullPath);
    //$fsize = filesize($fullPath);
	$fsize = strlen($content);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        //header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        header("Content-Disposition: inline; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
	
    //while(!feof($fd)) {
    //    $buffer = fread($fd, 2048);
    //    echo $buffer;
    //}
	echo $content;
//}
//fclose ($fd);


exit;
// example: place this kind of link into the document where the file download is offered:
// <a href="download.php?download_file=some_file.pdf">Download here</a>
