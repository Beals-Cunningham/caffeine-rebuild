<?php
include('config.php');
$act = $_REQUEST["action"];

if($act == 'processcats'){
    session_start();

    $a = $data->query("SELECT manufacturer FROM used_equipment WHERE category = '".$data->real_escape_string($_REQUEST["selcat"])."' AND active = 'true' GROUP BY manufacturer ASC")or die($data->error);
    $options .= '<option value="">Select Manufacturer</option>';

    while($b = $a->fetch_array()){
        $options .= '<option value="'.$b["manufacturer"].'">'.$b["manufacturer"].'</option>';
    }

    $prifrm = $_REQUEST["prifrm"];
    $prito = $_REQUEST["prito"];
    $yrfrm = $_REQUEST["yrfrm"];
    $yrto = $_REQUEST["yrto"];
    $hrfrm = $_REQUEST["hrfrm"];
    $hrto = $_REQUEST["hrto"];

    $theJson = '{"filters_saved":[{"category":[{"item":"'.$_REQUEST["selcat"].'"}]},{"manufacturer":[]},{"model":[]},{"city":[]},{"year":[]}],"price_from":"'.$prifrm.'","price_to":"'.$prito.'","hours_from":"'.$hrfrm.'","hours_to":"'.$hrto.'","year_from":"'.$yrfrm.'","year_to":"'.$yrto.'","viewtype":"list","pageon":"1","sorttype":""}
';

    unset($_SESSION['used_filters']);

    $_SESSION["used_filters"] = $theJson;

    echo $options;
}

if($act == 'processmans'){
    session_start();
    $a = $data->query("SELECT model FROM used_equipment WHERE category = '".$data->real_escape_string($_REQUEST["selcat"])."' AND manufacturer = '".$data->real_escape_string($_REQUEST["selman"])."' AND active = 'true' GROUP BY model ASC")or die($data->error);
    $options .= '<option value="">Select Model</option>';

    while($b = $a->fetch_array()){
        $options .= '<option value="'.$b["model"].'">'.$b["model"].'</option>';
    }

    $prifrm = $_REQUEST["prifrm"];
    $prito = $_REQUEST["prito"];
    $yrfrm = $_REQUEST["yrfrm"];
    $yrto = $_REQUEST["yrto"];
    $hrfrm = $_REQUEST["hrfrm"];
    $hrto = $_REQUEST["hrto"];

    $theJson = '{"filters_saved":[{"category":[{"item":"'.$_REQUEST["selcat"].'"}]},{"manufacturer":[{"item":"'.$_REQUEST["selman"].'"}]},{"model":[]},{"city":[]},{"year":[]}],"price_from":"'.$prifrm.'","price_to":"'.$prito.'","hours_from":"'.$hrfrm.'","hours_to":"'.$hrto.'","year_from":"'.$yrfrm.'","year_to":"'.$yrto.'","viewtype":"list","pageon":"1","sorttype":""}
';

    unset($_SESSION['used_filters']);

    $_SESSION["used_filters"] = $theJson;

    echo $options;
}

if($act == 'processmods'){
    session_start();

    $selmod = $_REQUEST["selmod"];
    $selman = $_REQUEST["selman"];

    if($selmod != ''){
        $selmod = '{"item":"'.$_REQUEST["selmod"].'"}';
    }else{
        $selmod = '';
    }

    if($selman != ''){
        $selman = '{"item":"'.$_REQUEST["selman"].'"}';
    }else{
        $selman = '';
    }

    $prifrm = $_REQUEST["prifrm"];
    $prito = $_REQUEST["prito"];
    $yrfrm = $_REQUEST["yrfrm"];
    $yrto = $_REQUEST["yrto"];
    $hrfrm = $_REQUEST["hrfrm"];
    $hrto = $_REQUEST["hrto"];

    $theJson = '{"filters_saved":[{"category":[{"item":"'.$_REQUEST["selcat"].'"}]},{"manufacturer":['.$selman.']},{"model":['.$selmod.']},{"city":[]},{"year":[]}],"price_from":"'.$prifrm.'","price_to":"'.$prito.'","hours_from":"'.$hrfrm.'","hours_to":"'.$hrto.'","year_from":"'.$yrfrm.'","year_to":"'.$yrto.'","viewtype":"list","pageon":"1","sorttype":""}
';

    unset($_SESSION['used_filters']);

    $_SESSION["used_filters"] = $theJson;

    echo $options;
}