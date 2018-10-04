<?php
$file_name = $_POST['name'];
$mode = $_POST['mode'];//0--文件   1--文件夹
$file_name = iconv("utf-8","gb2312//IGNORE",$file_name);
$file_name = $_SERVER['DOCUMENT_ROOT']."/".$file_name;
if(file_exists($file_name)){
    echo json_encode(['status'=>0]);
}else{
    if($mode == 0)
        fopen($file_name,'w');
    else mkdir($file_name);
    echo json_encode(['status'=>1]);
}
