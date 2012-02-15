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
class WurflFlash_lite extends icms_core_Object
{

    function WurflFlash_lite($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);	
		$this->initVar('flash_lite_version', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('fl_wallpaper', XOBJ_DTYPE_INT, null, false);
		$this->initVar('fl_browser', XOBJ_DTYPE_INT, null, false);
		$this->initVar('fl_screensaver', XOBJ_DTYPE_INT, null, false);
		$this->initVar('fl_standalone', XOBJ_DTYPE_INT, null, false);
		$this->initVar('fl_sub_lcd', XOBJ_DTYPE_INT, null, false);
    
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
class WurflFlash_liteHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "flash_lite", 'did', '', '', 'wurfl');
    }
}

?>