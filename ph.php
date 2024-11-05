<?php
$db_host = 'localhost';
$db_user = 'siay3578_xeyla';
$db_password = 'v1thr486'; 
$db_name = 'siay3578_controlph';
session_start();
$conn = mysqli_connect($db_host, $db_user, $db_password, 
$db_name);

if (isset($_GET['ph'])){
    $nilaiPh = $_GET['ph']; // Ambil nilai PH dari API/Sensor
    $sql = "insert into ph (nilai) values (". floatval($nilaiPh).")";
    $query = mysqli_query($conn, $sql);
}

// $sql = "create table ph (id int AUTO_INCREMENT PRIMARY KEY, nilai decimal (20,1) NOT NULL )";
// $query = mysqli_query($conn, $sql);

$sql = "select * from ph order by id desc";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($query);

$ph = $data ['nilai'];
echo $ph;

$query = mysqli_query($conn, $sql);



if (!isset($_SESSION['tempTime'])) {
    $_SESSION['tempTime'] = time(); // Set waktu pertama kali
}

if (!isset($_SESSION['lastStatus'])) {
    $_SESSION['lastStatus'] = ''; // Set status pertama kali
}

$tempTime = $_SESSION['tempTime'];
$lastStatus = $_SESSION['lastStatus'];
$nowTime = time();

if($ph < 7){
    $status = "pH air rendah";
}
else if($ph >= 7 && $ph < 8){
    $status = "pH air normal";
}else {
    $status = "pH air tinggi";
}


// send wa
$curl = curl_init();

// Jika status berubah dan bukan pH air normal, kirim langsung
if ($status != $lastStatus && $status != "pH air normal") {
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
        'Authorization: W8LA2NaRgA3Eo#3a!wbc' // Ganti dengan token asli kamu
      ),
    ));

    $_SESSION['tempTime'] = $nowTime; // Update waktu saat status berubah
    $_SESSION['lastStatus'] = $status; // Update status terakhir
}

// Jika status tidak berubah dan bukan pH air normal, cek apakah sudah 120 menit sejak terakhir kirim
else if (($nowTime - $tempTime) >= 5 && $status != "pH air normal") {
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
        'Authorization: W8LA2NaRgA3Eo#3a!wbc' // Ganti dengan token asli kamu
      ),
    ));

    $_SESSION['tempTime'] = $nowTime; // Update waktu terakhir kirim
}

$response = curl_exec($curl);
if (curl_errno($curl)) {
  $error_msg = curl_error($curl);
}
curl_close($curl);
?>
