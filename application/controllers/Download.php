<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
	} 

	public function index(){		
		/// cek Hak Akses (security)
		
		if(isset($_REQUEST["file"])){
			// Get parameters
			$file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
			$filepath = $file;
			
			// Process download
			if(file_exists($filepath)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filepath));
				flush(); // Flush system output buffer
				readfile($filepath);
				exit;
			}
		}
		
	}

}

	
	
	
