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
class WurflDisplay extends icms_core_Object
{

    function WurflDisplay($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);		
		$this->initVar('physical_screen_height', XOBJ_DTYPE_INT, null, false);
		$this->initVar('columns', XOBJ_DTYPE_INT, null, false);
		$this->initVar('physical_screen_width', XOBJ_DTYPE_INT, null, false);
		$this->initVar('rows', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_image_width', XOBJ_DTYPE_INT, null, false);
		$this->initVar('resolution_height', XOBJ_DTYPE_INT, null, false);
		$this->initVar('resolution_width', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_image_height', XOBJ_DTYPE_INT, null, false);	
    
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
class WurflDisplayHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "display", 'did', '', '', 'wurfl');
    }
}

?>