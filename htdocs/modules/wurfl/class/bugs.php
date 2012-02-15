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
class WurflBugs extends icms_core_Object
{

    function WurflBugs($id = null)
    {
	
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);
		$this->initVar('emptyok', XOBJ_DTYPE_INT, null, false);
		$this->initVar('empty_option_value_support', XOBJ_DTYPE_INT, null, false);
		$this->initVar('basic_authentication_support', XOBJ_DTYPE_INT, null, false);
		$this->initVar('post_method_support', XOBJ_DTYPE_INT, null, false);	
    
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
class WurflBugsHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "bugs", 'did', '', '', 'wurfl');
    }
}

?>