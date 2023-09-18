<?php
class blog_getter{
    function page($page){
        include('inc/config.php');
        $page = str_replace('_',' ',$page);
        $a = $data->query("SELECT * FROM beans WHERE category = 'Blog' AND bean_name = '$page' AND active = 'true'");


        if($a->num_rows > 0){
            $b = $a->fetch_array();
            $blog .= '<div class="blog-entry">';
            $blog .= '<small>'.date('l, F j, Y',$b["created"]).'</small>';
            $blog .= '<h1 style="font-size: 1.75rem;">'.$b["bean_name"].'</h1>';
            $blog .= $b["bean_content"];
            $blog .= '<br><a href="Blog" class="btn btn-success btn-sm">Go Back to List</a>';
            $blog .= '</div>';

            $beanTitle = $b["bean_name"];

            $aa = $data->query("SELECT * FROM beans WHERE category = 'Blog' and active = 'true' ORDER BY created DESC LIMIT 15");
            while($bb = $aa->fetch_array()){
                $titleName = str_replace(' ','_',$bb["bean_name"]);
                $blogSide .= '<li class="list-group-item"><a href="blog/'.$titleName.'">'.$bb['bean_name'].'</a></li>';
            }

            $beanTitle = str_replace('_',' ', $beanTitle);

            $html .= '<div class="container"> <div class="row" style="margin-top: 30px;"> <div class="col-md-8 helper_column_main"><p>'.$blog.'</p> </div> <div class="col-md-4 helper_column_small"> <ul class="list-group"> <li class="list-group-item active" style="background: #417640; border: solid thin #417640; border-radius: 0px; font-weight: bold; font-size: 20px;">Blog Archive</li> '.$blogSide.' </ul> </div> </div> </div>';

            $content[] = array("page_name" => $page, "page_title" => $beanTitle, "page_content" => $html, "active" => true, "created" => time(), "last_edit" => '', "last_user" => '', "page_lock" => 'none', "page_type" => '', "page_desc" => ''.$b["bean_description"].'', "check_out" => false, "check_out_date" => '', "page_js" => '','dependants' => '');
            return $content;
        }

    }
}