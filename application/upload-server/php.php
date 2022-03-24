<?php

require '../vendor/autoload.php';

use Aws\Common\Aws;
use Aws\Common\Enum\Region;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client; // for pre-signed upload file

require_once '../generalPHP.php';


function aws_s3_is_file_exists($s3_file) {
	
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
	
	$response = $s3->doesObjectExist($bucket, $s3_file );

	// boolean value
	return $response ;

}

function aws_s3_put_object($SourceFile , $target_s3_file ) {

	global $bucket;
	global $aws_key;
	global $aws_secret;

	try {
		$awsClient = Aws::factory(array(
						'key' => $aws_key,
						'secret' => $aws_secret,
						'region' => Region::EU_WEST_1,
						'ACL' => CannedAcl::PUBLIC_READ,
		));

		$s3 = $awsClient->get('s3');
		
		$result = $s3->putObject(array(
			'Bucket' => $bucket,
			'Key'    => $target_s3_file,
			'Body'   => $SourceFile,
			'ACL'    => 'public-read'
		));

		return 1; // ok
	} catch (S3Exception $e) {
		//"There was an error uploading the file.\n";
		return 0; // error
	}
}









/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {    
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
		        
		// getSize from /tmp file
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        //$target = fopen($path, "w");        
        //fseek($temp, 0, SEEK_SET);
        //stream_copy_to_stream($temp, $target);
        //fclose($target);
		
		aws_s3_put_object($temp , $path);
        
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 104857600; //209715200;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 209715200){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        //if (!is_writable($uploadDirectory)){
        //    return array('error' => "Server error. Upload directory isn't writable.");
        //}
        
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large ('.($this->sizeLimit / 1024 / 1024).'MB)');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        //$filename = $pathinfo['filename'];
        $filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            //while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
            while (aws_s3_is_file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
            return array('success'=>true,'fileName'=>$filename . '.' . $ext);
        } else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}

// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array();
// max file size in bytes
$sizeLimit = 100 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
//$result = $uploader->handleUpload('../files/');
$result = $uploader->handleUpload('files/');

// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);