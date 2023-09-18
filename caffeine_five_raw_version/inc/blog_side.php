<?php 
include('inc/config.php');

$a = $data->query("SELECT * FROM beans WHERE category = 'Blog' and active = 'true' ORDER BY created DESC");
while($b = $a->fetch_array()){
    $html .= '<li class="list-group-item"><a href="blog?blogid='.$b["id"].'">'.str_replace('-', ' ',$b['bean_name']).'</a></li>';
}


echo $html;
?>