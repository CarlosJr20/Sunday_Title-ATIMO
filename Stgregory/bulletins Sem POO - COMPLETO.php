<?php
require_once '../../wwb.atimo.us/library/includes/data_cnx.php';

$folder   = $_SERVER['DOCUMENT_ROOT'];
$folder  .= '\\ctm\\'.trim($pg_variables['customer_number']).'\\projects\\'.trim($pg_variables['project_folder']).'\\bulletins\\';

$directories  = glob($folder . "*[0-9]", GLOB_ONLYDIR );
rsort($directories);
$year         = str_replace($folder, "", $directories[0]);  
$search       = scandir($folder.'/'.$year, '0');
$bulletins    = preg_grep('/(.*?)\.(pdf|PDF)/', $search);
rsort($bulletins);
$recent_file  = pathinfo($bulletins[0], PATHINFO_FILENAME);

$filename    = $_SERVER['DOCUMENT_ROOT'] . '\\ctm\\31000\\sunday_title\\' . $recent_file .'.txt';
if (file_exists($filename)) {
    $fileContent = file_get_contents($filename);
    if ($fileContent !== false) {
        echo $fileContent;
    } else {
        echo "Error!";
    }
} else {
    $url = "http://feed.evangelizo.org/v2/reader.php?date=$recent_file&type=all&lang=AM";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Definir o timeout em segundos (neste exemplo, 5 segundos)
    $h = fopen($url,"r");
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code != 200) {
        $firstLine   = fgets($h);
        fclose($h);
        curl_close($ch);
        $information = trim($firstLine);
        $file        = fopen($filename, "w");
        fwrite($file, $information);
        fclose($file);
        echo $information;
    } else {
        echo "Error! File";
    }
}
?>
