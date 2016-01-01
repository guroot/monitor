<?php

/**
 * report.php
 * @author Jonathan Fleury
 * @url http://www.guroot.com
 */

/**
 *
 * @author Jonathan Fleury
 * 
 * Generate report
 * 
 */
class report {

    private $_data;

    function __construct($data) {
        $this->_data = $data;
    }

    
    /**
     * Generate skinny html report
     * 
     * @return type
     */
    function generateReport(){        
        $dom = $this->_generateDOMDocument();
        return $this->_writeReport($dom, $this->_data);
    }
    

    
    /**
     * Generate a DOMDocument with an empty table element
     * 
     * @return DOMDocument
     */
    private function _generateDOMDocument() {
        $html = "<table></table>";        
        return DOMDocument::loadHTML($html);        
    }
    
    
    /**
     * Recursive function which add data to first table in $DOMDocument
     * 
     * @param DOMDocument $DOMDocument
     * @param array $data
     * @param int $level
     * @return \DOMDocument
     */
    private function _writeReport(DOMDocument &$DOMDocument, $data, $level = 0) {
        $table = $DOMDocument->getElementsByTagName('table');
        foreach ($data as $key => $value) {
            $row = new DOMElement('tr');
            $table->item(0)->appendChild($row);
            for ($i = 0; $i <= $level; $i++) {
                $row->appendChild(new DOMElement('td'));
            }
            $row->appendChild($DOMDocument->createElement('td', $key));
            if (is_array($value)) {
                $this->_writeReport($DOMDocument, $value, $level + 1);
            } else {
                $row->appendChild($DOMDocument->createElement('td', $value));
            }
        }
        return $DOMDocument;
    }

}
