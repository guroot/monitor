<?php
/**
 * @author Jonathan Fleury
 * @url http://www.guroot.com
 * 
 * Folder must be writable (at least, data.json and report.html must be..)
 * PHP Version 5.6.12+
 * 
 * Monitor files for modification
 * 
 */

/* include helper functions */
include __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';
include __DIR__ . DIRECTORY_SEPARATOR . 'report.php';

/* Constants */
class constant{
    static $path = '/home/guroot/temporaire';    
}

$files = helper::listFolderFiles(constant::$path);

$actualData = [];
foreach($files as $file)
    $actualData[$file] = helper::hash($file);


$changes = [];
$newFiles = $actualData;
if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'data.json')) {
    /* validate change */
    $oldData = (array)helper::readDataFile();
    foreach ($actualData as $path => $hash) {
        if (key_exists($path, $oldData)) {
            if ($oldData[$path] !== $hash) {
                array_push($changes, $path);
            }
            unset($newFiles[$path]);
        }
    }
}

$hashFiles = [];
foreach($files as $file){
    $hashFiles[$file] = $actualData[$file];
}

helper::createDataFile($hashFiles);


$report = new report([
            "Modified files" => $changes,
            'Created files' => $newFiles
        ]);
$dom = $report->generateReport();

file_put_contents('report.html',$dom->saveHTML());
