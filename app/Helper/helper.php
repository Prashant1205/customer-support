<?php
use Aws\S3\S3Client;  
use Aws\Exception\AwsException;

function generateUuid(){
  return \App\Helper\UUID::uuid4();
}

/**
 * @param string $filepath
 * @return bool
 *
 * usage : update composer the use function uploadAmazonS() for file upload
 * https://s3-us-west-2.amazonaws.com/testformbhavik1/public/file.txt
 * uploadAmazonS($filepath='public/images',$filename='apple-icon.png'){
 */
function uploadAmazonS($filepath,$name,$ext){
    $newFileName = '/support/'.time() . '-' .$name.'.'.$ext;

    Storage::disk('s3')->put($newFileName, file_get_contents($filepath));
    return $newFileName;
}

function getImageFromS ($request){
		 $file = Storage::disk('s3')->get($request->file);
		 return Storage::put($request->file,$file);
}
function getImageFromSval ($filename){
    if(Storage::disk('s3')->exists($filename)){
        $file = Storage::disk('s3')->get($filename);
        return Storage::put($filename,$file);
    }
    return null;

}

function sendSMS($mobile, $message){
	$mssg = urlencode($message);
	$curl = curl_init();
	$post_fields = array();
	$post_fields["method"] = "sendMessage";
	$post_fields["send_to"] = "$mobile";
	$post_fields["msg"] = "$mssg";
	$post_fields["msg_type"] = "TEXT";
	$post_fields["userid"] = "2000182193";
	$post_fields["password"] = "GuqyK1xzG";
	$post_fields["auth_scheme"] = "PLAIN";
	$post_fields["format"] = "JSON";
	curl_setopt_array($curl, array(CURLOPT_URL => "http://enterprise.smsgupshup.com/GatewayAPI/rest",
	 CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30,
	 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $post_fields));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	return true;
}

function createCSV($header,$records,$filename){
    $csvExporter = new \Laracsv\Export();
    $data = $csvExporter->build($records, $header)->getCsv();
    Storage::put($filename,$data);

    $zip = new ZipArchive();
    $filetopath = storage_path().'/app/'.$filename;
    $zip->open($filetopath.'.zip', ZipArchive::CREATE);
    $zip->addFile($filetopath,$filename);
    $zip->close();
}

function getImageFromFosVal($s3FileName)
{
    if (Storage::disk('fos_s3')->exists($s3FileName)) {
        $file = Storage::disk('fos_s3')->get($s3FileName);
        Storage::put($s3FileName,$file);
        return url($s3FileName);

    }
    return null;
}

function getpresignedS3Image($imagePath){
    $s3Client = new S3Client([
        'region' => env('FOS_AWS_REGION'),
        'version' => 'latest',
        'credentials' => [
            'key'    => env('FOS_AWS_KEY'),
            'secret' => env('FOS_AWS_SECRET'),
        ]
    ]);
    $cmd = $s3Client->getCommand('GetObject', [
        'Bucket' => env('FOS_AWS_BUCKET'),
        'Key' => $imagePath
        ]);

    $requestUrl = $s3Client->createPresignedRequest($cmd, '+5 minutes');
    $presignedUrl = (string)$requestUrl->getUri();
    return url($presignedUrl); 
}