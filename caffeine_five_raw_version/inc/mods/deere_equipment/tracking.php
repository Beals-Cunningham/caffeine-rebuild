<?php

session_start();
$url = $_SERVER['REQUEST_URI'];


$page = substr($url, strrpos($url, '/') + 1);

if($page == 'Home'){
    echo "<script async src='https://tag.simpli.fi/sifitag/6c170d00-28a6-013b-a52f-0cc47abd0334'></script>";
}elseif($page == 'request'){
    echo "<script async src='https://tag.simpli.fi/sifitag/457cd470-28ab-013b-5aad-0cc47a8ffaac'></script>";
}elseif($page == 'service'){
    echo "<script async src='https://tag.simpli.fi/sifitag/722b15a0-28ab-013b-54cb-0cc47a1f72a4'></script>";
}elseif($page == 'Parts'){
    echo "<script async src='https://tag.simpli.fi/sifitag/8a009600-28ab-013b-54cb-0cc47a1f72a4'></script>";
}elseif($page == 'locations'){
    echo "<script async src='https://tag.simpli.fi/sifitag/c84f1c10-28ab-013b-54cb-0cc47a1f72a4'></script>";
}


?>