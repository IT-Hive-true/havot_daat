<?php
//require_once 'generalPHP.php';
if (!class_exists('S3')) require_once 'S3.php';

// AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAI2UBNUV3JXNBCFOQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');

// place this code inside a php file and call it f.e. "download.php"
$path = $_SERVER['DOCUMENT_ROOT']."/files/"; // change the path to fit your websites document structure
//$filename = sanitizeInput($_GET['f']);
//$fullPath = $path.$filename;

//$userIp = get_user_ip();

	// Add to log
/*	$addToLogSQL = "INSERT INTO tbfiles_log 
			(time, filename, user_id, ip) 
			VALUES (CURRENT_TIMESTAMP,'".$filename."','".$userId."','".$userIp."')"; 
	$addToLogResult = mysqli_query($addToLogSQL);
	if (!$addToLogResult) die("Database access failed: " . mysqli_error());
*/
$s3 = new S3(awsAccessKey, awsSecretKey);
echo $s3->getObject("omer-test", "drop.pdf");
/*
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        //header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
*/
exit;
// example: place this kind of link into the document where the file download is offered:
// <a href="download.php?download_file=some_file.pdf">Download here</a>
?>