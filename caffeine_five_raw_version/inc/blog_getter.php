<?php 
include('inc/config.php');
$url = $_SERVER['REQUEST_URI'];

$parms = explode('?',$url);

//var_dump($parms);

$fixdowork = explode('=', $parms[1]);




if($fixdowork[0] == 'blogid'){

    $a = $data->query("SELECT * FROM beans WHERE category = 'Blog' and active = 'true' AND id = '".$fixdowork[1]."' ORDER BY created DESC");
    if($a->num_rows == 1){
    $b = $a->fetch_array();
    $html .= '<div class="blog-entry">';
    $html .= '<small>'.date('l, F j, Y',$b["created"]).'</small>';
    $html .= '<h3>'.str_replace('-', ' ',$b['bean_name']).'</h3>';
    $html .= $b["bean_content"];
    $html .= '<br><a href="blog" class="btn btn-success btn-sm" style="color: white;">Go Back to List</a>';
    $html .= '</div>';
        $html .= '</br>';
    }else{
        $html .= '<div class="alert alert-danger">Notice - It appears that this blog has been removed..<br><a href="Blog" style="color:#000">Back to blog</a></div>';
    }
}else{

    echo $fixdowork[1];
    $now = time();
    $a = $data->query("SELECT * FROM beans WHERE category = 'Blog' and active = 'true' ORDER BY created DESC");
    while($b = $a->fetch_array()){

        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $b["bean_content"], $image);
        $theImage = $image['src'];

        if($theImage != ''){
            $imgThumb = '<img style="width:20%; margin:5px; float:left" class="img-thumbnail" src="'.$theImage.'">';
        }else{
            $imgThumb = '';
        }


        if($b["start_time"] == 0 && $b["end_time"] == 0){
            $titleName = str_replace(' ','_',$b["bean_name"]);

            $html .= '<div class="blog-entry">';
            $html .= '<small>'.date('l, F j, Y',$b["created"]).'</small>';
            $html .= '<a style="color: #427642;" href="blog?blogid='.$b["id"].'"><h3 style="font-size: 18px;">'.str_replace('-', ' ',$b['bean_name']).'</h3></a>';
            $html .= $imgThumb;
            $html .= substr(strip_tags($b["bean_content"]), 0, 600).'... <a href="blog?blogid='.$b["id"].'">Read More</a>';
            $html .= '</div>';
            $html .= '</br>';
        }else{
            if($b["start_time"] == 0 && time() < $b["end_time"]){
                $titleName = str_replace(' ','_',$b["bean_name"]);
                $html .= '<div class="blog-entry">';
                $html .= '<small>'.date('l, F j, Y',$b["created"]).'</small>';
                $html .= '<a style="color: #427642;" href="blog?blogid='.$b["id"].'"><h3 style="font-size: 18px;">'.str_replace('-', ' ',$b['bean_name']).'</h3></a>';
                $html .= $imgThumb;
                $html .= substr(strip_tags($b["bean_content"]), 0, 600).'... <a href="blog?blogid='.$b["id"].'">Read More</a>';
                $html .= '</div>';
                $html .= '</br>';
            }else{
                if($b["end_time"] == 0 && time() >= $b["start_time"]){
                    $titleName = str_replace(' ','_',$b["bean_name"]);
                    $html .= '<div class="blog-entry">';
                    $html .= '<small>'.date('l, F j, Y',$b["created"]).'</small>';
                    $html .= '<a style="color: #427642;" href="blog?blogid='.$b["id"].'"><h3 style="font-size: 18px;">'.str_replace('-', ' ',$b['bean_name']).'</h3></a>';
                    $html .= $imgThumb;
                    $html .= substr(strip_tags($b["bean_content"]), 0, 600).'... <a href="blog?blogid='.$b["id"].'">Read More</a>';
                    $html .= '</div>';
                    $html .= '</br>';
                }else{
                    if(time() >= $b["start_time"] && time() < $b["end_time"]){
                        $titleName = str_replace(' ','_',$b["bean_name"]);
                        $html .= '<div class="blog-entry">';
                        $html .= '<small>'.date('l, F j, Y',$b["created"]).'</small>';
                        $html .= '<a style="color: #427642;" href="blog?blogid='.$b["id"].'"><h3 style="font-size: 18px;">'.str_replace('-', ' ',$b['bean_name']).'</h3></a>';
                        $html .= $imgThumb;
                        $html .= substr(strip_tags($b["bean_content"]), 0, 600).'... <a href="blog?blogid='.$b["id"].'">Read More</a>';
                        $html .= '</div>';
                        $html .= '</br>';
                    }
                }
            }
        }

    }

}

echo $html;
?>