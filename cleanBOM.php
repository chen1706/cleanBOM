<!DOCTYPE>
<html>
<head>
<meta charset="utf-8" />
<title>UTF8 BOM 清除器</title>
<style>
body { font-size: 10px; font-family: Arial, Helvetica, sans-serif; background: #FFF; color: #000; }
.found { color: #F30; font-size: 14px; font-weight: bold; }
</style>
</head>
<body>
<?php
$directory = dirname(__FILE__);
$fileNames = array();
recursiveFolder($directory, $fileNames);
echo '<h2>These files had UTF8 BOM, but i cleaned them:</h2><p class="found">';
foreach ($fileNames as $file) {
    echo $file . "<br />";
}
echo '</p>';

// 递归扫描
function recursiveFolder($directory, &$fileNames)
{
    $iterator = new DirectoryIterator($directory);
    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile()) {
            $fileName = $directory . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
            $content = file_get_contents($fileName);
            if (searchBOM($content)) {
                $fileNames[] = $directory . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
            }
        }
        if ($fileInfo->isDir() && !$fileInfo->isDot()) {
            RecursiveFolder($directory . DIRECTORY_SEPARATOR . $fileInfo->getFilename(), $fileNames);
        }
    }
}


function searchBOM($string)
{ 
    if (substr($string,0,3) == pack("CCC",0xef,0xbb,0xbf)) {
        return true;
    }
    return false; 
}
?>
</body>
</html>
