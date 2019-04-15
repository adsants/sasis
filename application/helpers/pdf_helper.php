<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{

	function tcpdf()
	{
		//require_once('tcpdf/config/lang/eng.php');
		require_once('tcpdf/tcpdf.php');
	}
}
