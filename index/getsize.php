<?php
$path = "";
if(isset($_POST['path'])){
    $path = $_POST['path'];
}
//网页的utf-8中文转换成系统gb2312中文
$path=iconv("utf-8","gb2312//IGNORE",$path);
$info = getDirSize($path);
echo json_encode(["status"=>1,'info'=>$info]);

function getDirSize($dir)
{
    $size = 0;
    $ori_dir = $dir = $_SERVER['DOCUMENT_ROOT']."/".$dir;
    $dirs = [$dir];
    $section = explode('/',$dir);
    $howmany = explode('.',$section[count($section)-1]);
    if($howmany[0]=="")array_shift($howmany);
    $special_is_dir = (count($howmany)==1 && substr($section[count($section)-1],0,1) == '.');
    if($special_is_dir){
        return "无法查看信息";
    }
    if(!is_dir($dir)){
        $dir=iconv("utf-8","gb2312//IGNORE",$dir);
        if(!json_encode($dir)){
            //$dir = mb_convert_encoding($dir,"UTF-8","GBK");
        }
        $size += filesize($dir);
        return ["size"=>size_setting($size),'createtime'=>date("Y-m-d H:i:s",filectime($dir)),"type"=>filetype($dir)];
    }
    while(@$dir=array_shift($dirs)){
        $fd = opendir($dir);
        while(@$file=readdir($fd)){
            if($file=='.' || $file=='..'){
                continue;
            }
            $file = $dir.DIRECTORY_SEPARATOR.$file;
            if(is_dir($file)){
                array_push($dirs, $file);
            }else{
                $size += filesize($file);
            }
        }
        closedir($fd);
    }
    return ["size"=>size_setting($size),'createtime'=>date("Y-m-d H:i:s",filectime($ori_dir)),"type"=>filetype($ori_dir)];;
}

function size_setting($size){
    if($size>=1024 && $size <1024*1024)return round($size/1024,2)."KB";
    else if($size>=1024*1024 && $size <1024*1024*1024) return  round($size/1024/1024,2)."MB";
    else if ($size>=1024*1024*1024 && $size <1024*1024*1024*1024)return  round($size/1024/1024/1024,2)."GB";
    else if ($size<1024)return $size."B";
}
?>