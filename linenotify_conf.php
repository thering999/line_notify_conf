<?php
set_time_limit(0);
date_default_timezone_set('Asia/Bangkok');
require_once('simple_html_dom.php');
require_once('la_function.php');

function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}


$datenow = date("Y-m-d");

//echo file_get_contents("http://conf.moph.go.th/showDetailCalenderVDO.php?page=view_detail&day=$datenow");
 $urlgenx = "http://conf.moph.go.th/showDetailCalenderVDO.php?page=view_detail&day=$datenow";

    $scraped_page = curl($urlgenx);    // Downloading
    $page = scrape_between($scraped_page, "<table", "</table>");
    $html ='<table'.$page.'</table>' ;

if($html=="<table</table>" ){
        echo "No";
}else{


$datenow_th =DateThai($datenow);
$css = <<<EOD
.box { 
  border: 4px solid #03B875; 
  padding: 20px; 
  font-family: 'Roboto'; 
}
EOD;

$google_fonts = "Roboto";

$data = array('html'=>$html,
              'css'=>$css,
              'google_fonts'=>$google_fonts);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://hcti.io/v1/image");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST ,0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER ,0);
// Retrieve your user_id and api_key from https://htmlcsstoimage.com/dashboard
curl_setopt($ch, CURLOPT_USERPWD, "User ID" . ":" . "API Key");

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$res = json_decode($result,true);
$imagexxx =  $res['url'];
$mms = "แจ้งเตือน e-Conference วันที่ $datenow_th";

$chOne = curl_init(); 
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
// SSL USE 
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
//POST 
curl_setopt( $chOne, CURLOPT_POST, 1); 
// Message 
//curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=?????"); 
//????????????? ?????? 2 parameter imageThumbnail ???imageFullsize
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms&imageThumbnail=$imagexxx&imageFullsize=$imagexxx"); 
// follow redirects 
curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
//ADD header array 
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer xxxx', ); 
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
//RETURN 
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
$result = curl_exec( $chOne ); 
//Check error 
if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); } 
else { $result_ = json_decode($result, true); 
echo "status : ".$result_['status']; echo "message : ". $result_['message']; } 
//Close connect 
curl_close( $chOne );  
//End	 	


}
?>