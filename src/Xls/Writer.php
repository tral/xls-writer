<?php
/**
 * Class for writing Excel Spreadsheets
 *
*/

namespace Xls;

class Writer extends Writer\Workbook
{
    /**
     * The constructor. It just creates a Workbook
     *
     * @param string $filename The optional filename for the Workbook.
     */
    function __construct($filename = '')
    {
        $this->_filename = $filename;
        parent::__construct($filename);
    }

    /**
     * Send HTTP headers for the Excel file.
     *
     * @param string $filename The filename to use for HTTP headers
     * @access public
     */
    function send($filename)
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
    }

    /**
     * Utility function for writing formulas
     * Converts a cell's coordinates to the A1 format.
     *
     * @param integer $row Row for the cell to convert (0-indexed).
     * @param integer $col Column for the cell to convert (0-indexed).
     *
     * @throws \Exception
     * @return string The cell identifier in A1 format
     */
    public static function rowcolToCell($row, $col)
    {
        if ($col > 255) { //maximum column value exceeded
            throw new \Exception("Maximum column value exceeded: $col");
        }

        $int = (int)($col / 26);
        $frac = $col % 26;
        $chr1 = '';

        if ($int > 0) {
            $chr1 = chr(ord('A') + $int - 1);
        }

        $chr2 = chr(ord('A') + $frac);
        $row++;

        return $chr1 . $chr2 . $row;
    }
}
