<?php
class BulletinReader {
    private $today;
    private $folder;
    private $files;
    private $recent_file;
    private $recent_file_year;
    private $url;

    public function __construct() {
        $this->today = date('Y');
        $this->folder = '../../bulletins/'.$this->today.'/';
        $this->files = scandir($this->folder);
        $this->files = array_diff($this->files, array('.', '..'));
        usort($this->files, function($a, $b) {
            return filemtime($this->folder . $a) < filemtime($this->folder . $b);
        });
        $this->recent_file = reset($this->files);
        $this->recent_file = pathinfo($this->recent_file, PATHINFO_FILENAME);
        $this->recent_file_year = substr($this->recent_file, 0, 4); 
        $this->url = "http://feed.evangelizo.org/v2/reader.php?date={$this->recent_file}&type=all&lang=AM";
    }

    public function readBulletin() {
        if ($this->today != $this->recent_file_year || intval(substr($this->recent_file, 4, 2)) < date('m') || (intval(substr($this->recent_file, 4, 2)) == date('m') && intval(substr($this->recent_file, 6, 2)) < date('d'))) {
            foreach ($this->files as $file) {
                $file_year = substr($file, 0, 4);
                if ($file_year == $this->today) {
                    $this->recent_file_year = $file_year;
                    $this->url = "http://feed.evangelizo.org/v2/reader.php?date={$file}&type=all&lang=AM";
                    $h = fopen($this->url,"r");
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
        } else {
            $h = fopen($this->url,"r");
            if ($h) {
                $firstLine = fgets($h);
                fclose($h);
                $information = trim($firstLine);
                echo $information;
            } else {
                echo  "Erro ao abrir o arquivo.";
            }
        }
    }
}

$bulletinReader = new BulletinReader();
$bulletinReader->readBulletin();
?>
