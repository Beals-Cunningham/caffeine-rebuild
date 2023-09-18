<?php include('config.php');
$html = "";
$html .= '
<div id="currentspecials-header" class="container-fluid" style="padding-left: 0px; padding-right: 0px; margin-bottom: 90px;"> <div class="container header-text"> <h1 class="text-center"><span style="color: #ffffff;">CURRENT SPECIALS</span></h1> <h2 class="text-center"><span style="color: #ffffff;">Check out our current</span> <span style="color: #fecf2e;">SPECIALS </span><span style="color: #ffffff;">updated monthly</span></h2> </div> </div> <div class="container-fluid"> <div class="row" align="center">';

// <!-- SERVICE SPECIALS==================== -->

$html .= displaySpecials('img/SpecialsFolder/Service/');

$html .= ' </div>
        </div>
        ';

echo $html;

function displaySpecials($filePath)
{
 include('config.php');

 $files = array_diff(scandir($filePath), array('.', '..'));
 $html1 = "";
 foreach ($files as $file) {
  $fileName = explode("~", $file);
  $starttimeStr = (str_replace('-', '/', $fileName[1])) . " 00:00:00";
  $starttime = strtotime($starttimeStr);
  $endtimeStr1 = explode(".", (str_replace('-', '/', $fileName[2])));
  $endtimeStr = $endtimeStr1[0] . " 23:59:00";
  $endtime = strtotime($endtimeStr);

  if (time() >= $starttime && time() <= $endtime) {
   $imgname = $filePath . $file;
   $a = $data->query("SELECT * FROM media WHERE media_name='$file'");
   if ($a->num_rows > 0) {
    while ($b = $a->fetch_array()) {
     $imageLink = $b["alt_text"];

     $html1 .= '<div class="col-md-6" style="margin-bottom: 20px;">
            <a href="' . $imageLink . '">
              <img src="' . $imgname . '" alt="' . $imgname . '" class="img-responsive">
            </a>
          </div>';
    }
   } else {
    $html1 .= "<div><p>There are no specials available</p></div>";
   }
  }
 }
 return $html1;
}
