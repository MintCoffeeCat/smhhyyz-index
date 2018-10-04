<?php
$path = "";
if(isset($_POST['path'])){
    $path = $_POST['path'];
}
//网页的utf-8中文转换成系统gb2312中文
$path=iconv("utf-8","gb2312//IGNORE",$path);

$scanpath = "../".$path;
$dir = scandir($scanpath);
 $mydir = [];
 foreach($dir as $d){
    if($d != '.' && $d != ".."){
        if(!json_encode($d)){
            $d = mb_convert_encoding($d,"UTF-8","GBK");
        }
        if($path != "")$fullpath = $path."/".$d;
        else $fullpath = $d;
        array_push($mydir,['name'=>$d]);
    }
 }
 echo json_encode(["status"=>1,"data"=>$mydir]);

 ?>