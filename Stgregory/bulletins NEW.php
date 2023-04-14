<?php
$today = date('Y');
$folder = '../../bulletins/'.$today.'/';
$files = scandir($folder);
$files = array_diff($files, array('.', '..'));
usort($files, function($a, $b) use ($folder) {
    return filemtime($folder . $a) < filemtime($folder . $b);
});
$recent_file = reset($files);
$recent_file = pathinfo($recent_file, PATHINFO_FILENAME);
$recent_file_year = substr($recent_file, 0, 4); 
$url = "http://feed.evangelizo.org/v2/reader.php?date=$recent_file&type=all&lang=AM";

if ($today != $recent_file_year) {
    foreach ($files as $file) {
        $file_year = substr($file, 0, 4);
        if ($file_year == $today) {
            $recent_file_year = $file_year;
            $url = "http://feed.evangelizo.org/v2/reader.php?date=$recent_file&type=all&lang=AM";
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
}else{
    $url = "http://feed.evangelizo.org/v2/reader.php?date=$recent_file&type=liturgic_t&lang=AM";
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
