<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
include_once APPPATH.'vendor/mpdf/mpdf/src/Mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    {
        $this->param 	= $param;
        $this->pdf 		= new \Mpdf\Mpdf();
    }
}