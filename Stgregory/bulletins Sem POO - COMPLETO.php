<?php
$year = date('Y');
$today = date('Ymd');
$folder = '../../bulletins/'.$year.'/';
$files = scandir($folder);
$files = array_diff($files, array('.', '..'));
usort($files, function($a, $b) use ($folder) {
    return filemtime($folder . $a) < filemtime($folder . $b);
});
$recent_file = reset($files);
$recent_file = pathinfo($recent_file, PATHINFO_FILENAME);
$recent_file_year = substr($recent_file, 0, 4); 
$recent_file_month = substr($recent_file, 4, 2); 
$recent_file_day = substr($recent_file, 6, 2); 
$url = "http://feed.evangelizo.org/v2/reader.php?date=$recent_file&type=all&lang=AM";
$today_year = substr($today, 0, 4);
$today_month = substr($today, 4, 2);
$today_day = substr($today, 6, 2);

if ($year != $recent_file_year && ($recent_file_year.$recent_file_month.$recent_file_day < $today_year.$today_month.$today_day)) {

    foreach ($files as $file) {
        $file_year = substr($file, 0, 4);
        $file_month = substr($file, 4, 2);
        $file_day = substr($file, 6, 2);
        if ($file_year == $today_year && ($file_year.$file_month.$file_day > $today_year.$today_month.$today_day)) {
            $recent_file_year = $file_year;
            $recent_file_month = $file_month;
            $recent_file_day = $file_day;
            $h = fopen($url,"r");
            if ($h) {
                $firstLine = fgets($h);
                fclose($h);
                $information = trim($firstLine);
                echo $information;
            } else {
                echo  "Erro ao abrir o arquivo.";
            }
            break;
        }
    }
} elseif($year == $recent_file_year && $recent_file_month.$recent_file_day >= $today_month.$today_day){
    $h = fopen($url,"r");
    if ($h) {
        $firstLine = fgets($h);
        fclose($h);
        $information = trim($firstLine);
        echo $information ;
    } else {
        echo  "Erro ao abrir o arquivo.";
    }
}
?>