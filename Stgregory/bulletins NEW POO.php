
<?php

require_once '../../wwb.atimo.us/library/includes/data_cnx.php';

class BulletinReader
{
    private $folder;
    private $pg_variables;

    public function __construct($customer_number, $project_folder)
    {
        $this->folder = $_SERVER['DOCUMENT_ROOT'];
        $this->folder .= '\\ctm\\' . trim($customer_number) . '\\projects\\' . trim($project_folder) . '\\bulletins\\';
        $this->pg_variables = [
            'customer_number' => $customer_number,
            'project_folder' => $project_folder
        ];
    }

    public function readBulletin()
    {
        $directories = glob($this->folder . "*[0-9]", GLOB_ONLYDIR);
        rsort($directories);
        $year = str_replace($this->folder, "", $directories[0]);
        $search = scandir($this->folder . '/' . $year, '0');
        $bulletins = preg_grep('/(.*?)\.(pdf|PDF)/', $search);
        rsort($bulletins);
        $recent_file = pathinfo($bulletins[0], PATHINFO_FILENAME);
        $filename = $this->folder . $year . '\\' . $recent_file . '.txt';

        if (file_exists($filename)) {
            $fileContent = file_get_contents($filename);
            if ($fileContent !== false) {
                return $fileContent;
            } else {
                return "Error!";
            }
        } else {
            $url = "http://feed.evangelizo.org/v2/reader.php?date=$recent_file&type=liturgic_t&lang=AM";
            $h = fopen($url, "r");
            if ($h) {
                $firstLine = fgets($h);
                fclose($h);
                $information = trim($firstLine);
                $file = fopen($filename, "w");
                fwrite($file, $information);
                fclose($file);
                return $information;
            } else {
                return "Error! File";
            }
        }
    }
}

// Uso da classe BulletinReader
$customer_number = $pg_variables['customer_number']; 
$project_folder = $pg_variables['project_folder']; 

$bulletinReader = new BulletinReader($customer_number, $project_folder);
$bulletinContent = $bulletinReader->readBulletin();
echo $bulletinContent;

?>
