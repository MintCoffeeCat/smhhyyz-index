<?php
$dir = "";
if(isset($_POST['dir']))$dir = $_POST['dir'];
$dir = iconv("utf-8","gb2312//IGNORE",$dir);
$dir = $_SERVER['DOCUMENT_ROOT']."/".$dir;
if(!removeDir($dir)){
    unlink($dir);
}

echo json_encode(['status'=>1]);


function removeDir($dirName) {
    if(!is_dir($dirName)){
        return false;
    }     
    $handle = @opendir($dirName);     
    while(($file = @readdir($handle)) !== false){         
        if($file != '.' && $file != '..')         
        {             
            $dir = $dirName . '/' . $file;             
            is_dir($dir) ? removeDir($dir) : @unlink($dir);         
        }     
    }     
    closedir($handle);           
    return rmdir($dirName) ; 
}

 
?>