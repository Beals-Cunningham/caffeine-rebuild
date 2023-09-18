<?php
include('siteFunctions.php');
$data = mysqli_connect("localhost","sunsouth_dbadmin","Blanket1957!@","sunsouth_new");

$a = new site();
// configure

$to[] = array('email'=> 'christinepp@bealscunningham.com','name'=>'Christine Phung');
$to[] = array('email'=> 'gabbyp@bealscunningham.com','name'=>'Gabby Perez');
//$to[] = array('email'=> 'NStanford@sunsouth.com','name'=>'Neal Standford');
$fromemail = 'dev@bcssdevelop.com';
$fromName = 'Sunsouth Website';
$subject = 'Tractor Package Contact Request';
$fullname = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$zip = $_POST['zip'];
$location = $_POST['location'];
$comment = $_POST['comment'];
$url = $_POST['package-type'];
$attachements = $_POST['checkbox'];

foreach ($attachements as $key){
    $attachement .= $key.', ';
}

$message = '<html>
                <body>
                    <h2>Tractor Package Request</h2>
                    <hr>
                    <p>Package Interest: <br>'.$url.'</p>
                    <p>Attachements: <br>'.$attachement.'</p>
                    <p>Full Name: <br>'.$fullname.'</p>
                    <p>Email: <br>'.$email.'</p>
                    <p>Phone: <br>'.$phone.'</p>
                    <p>Location: <br>'.$location.'</p>
                    <p>Zip: <br>'.$zip.'</p>
                    <p>Comment: <br>'.$comment.'</p>
                </body>
            </html>';

$send = $a->mailIt($to,$fromemail,$fromName,$subject,$message, $replyTo = null, $emailName = null);

if($send == true) {
    echo '<div class="alert alert-success"><strong>Thank You - We have received your message and will get back with you shortly.</strong></div>';
}else{
    echo '<div class="alert alert-danger">Mailer Error: ' . $mail->ErrorInfo . '</div>';
}

$data->query("INSERT INTO package_data SET full_name = '".$data->real_escape_string($fullname)."', email = '".$data->real_escape_string($email)."', phone = '".$data->real_escape_string($phone)."',location = '".$data->real_escape_string($location)."', zip = '".$data->real_escape_string($zip)."',comment = '".$data->real_escape_string($comment)."',package_type = '".$data->real_escape_string($url)."',checkbox = '".json_encode($attachements)."', recieve_time = '".time()."'");
