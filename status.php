<?php
session_start();
$db_host = 'localhost';
$db_user = 'root';
$db_password = ''; 
$db_name = 'akademik';

$conn = mysqli_connect($db_host, $db_user, $db_password, 
$db_name);

$sql = "select * from ph order by id desc";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($query);

$ph = $data ['nilai'];
$status;

if (!isset($_SESSION['tempTime'])) {
    $_SESSION['tempTime'] = time(); // Jika belum diset, simpan waktu saat ini
}

$tempTime = $_SESSION['tempTime'];
$nowTime = time(); 

if($ph<7){
    $status = "pH air rendah";
}
else if($ph >= 7 && $ph<8){
    $status = "pH air normal";
}else {
    $status = "pH air tinggi";
}

echo $status;

// send wa
$curl = curl_init();

if($status == "pH air tinggi" || $status == "pH air rendah"){
    if (($nowTime - $tempTime) >= 120) {
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fonnte.com/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
'target' => '081211499250',
'message' => $status, 
'countryCode' => '62', //optional
),
  CURLOPT_HTTPHEADER => array(
    'Authorization: W8LA2NaRgA3Eo#3a!wbc' //change TOKEN to your actual token
  ),
));$_SESSION['tempTime'] = $nowTime;
}}

$response = curl_exec($curl);
if (curl_errno($curl)) {
  $error_msg = curl_error($curl);
}
curl_close($curl);


?>