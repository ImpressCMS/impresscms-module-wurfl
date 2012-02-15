<?php
// $Autho: wishcraft $

if (!defined('ICMS_ROOT_PATH')) {
	exit();
}
/**
 * Class for wurfl
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 ICMS.org
 * @package kernel
 */
class WurflImage_format extends icms_core_Object
{

    function WurflImage_format($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);	
		$this->initVar('greyscale', XOBJ_DTYPE_INT, null, false);
		$this->initVar('jpg', XOBJ_DTYPE_INT, null, false);
		$this->initVar('gif', XOBJ_DTYPE_INT, null, false);
		$this->initVar('transparent_png_index', XOBJ_DTYPE_INT, null, false);
		$this->initVar('epoc_bmp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('bmp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wbmp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('gif_animated', XOBJ_DTYPE_INT, null, false);
		$this->initVar('colors', XOBJ_DTYPE_INT, 256, false);
		$this->initVar('svgt_1_1', XOBJ_DTYPE_INT, null, false);
		$this->initVar('transparent_png_alpha', XOBJ_DTYPE_INT, null, false);
		$this->initVar('png', XOBJ_DTYPE_INT, null, false);
		$this->initVar('tiff', XOBJ_DTYPE_INT, null, false);	
    
		foreach($this->vars as $key => $data) {
			$this->vars[$key]['persistent'] = true;
		}	
    }
}


/**
* ICMS wurfl handler class.
* This class is responsible for providing data access mechanisms to the data source
* of ICMS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.org.au>
* @package kernel
*/
class WurflImage_formatHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "image_format", 'did', '', '', 'wurfl');
    }
}

?>