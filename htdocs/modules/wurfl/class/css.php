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
class WurflCss extends icms_core_Object
{

    function WurflCss($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);		
		$this->initVar('css_supports_width_as_percentage', XOBJ_DTYPE_INT, null, false);
    
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
class WurflCssHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "css", 'did', '', '', 'wurfl');
    }
}

?>