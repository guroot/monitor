<?php

/**
 * helper.php
 * 
 * @author Jonathan Fleury
 * @url http://www.guroot.com
 */

/**
 * Description of helper
 *
 * @author fletch
 */
class helper {

    /**
     * Largely inspired from 
     * http://stackoverflow.com/questions/7121479/listing-all-the-folders-subfolders-and-files-in-a-directory-using-php
     * 
     * @param string $dir
     * @return array List of files (with path)
     */
    static function listFolderFiles($dir) {
        $self = __CLASS__ . '::' . __FUNCTION__;
        $list = [];
        $ffs = scandir($dir);
        foreach ($ffs as $ff) {
            if ($ff != '.' && $ff != '..') {
                if (is_dir($dir . '/' . $ff))
                    $list = array_merge($list
                            , helper::listFolderFiles ($dir . '/' . $ff));
//                    $self($dir . '/' . $ff);
                else
                    array_push($list, $dir . '/' . $ff);
            }
        }
        return $list;
    }

    static function hash($file) {
        return md5_file($file);
    }

    static function readDataFile(){
         $data = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data.json');
         return json_decode($data);
    }
    
    static function createDataFile(array $data = []) {
        $fp = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'data.json', 'w+');
        fwrite($fp, json_encode($data));
        fclose($fp);
    }
    
    static function saveMonitorInfo($data){
        $fp = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'monitor.json', 'w+');
        fwrite($fp, json_encode($data));
        fclose($fp);
    }
    
    

}
