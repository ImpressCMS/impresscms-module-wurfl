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
class WurflWta extends icms_core_Object
{

    function WurflWta($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);
		$this->initVar('nokia_voice_call', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wta_pdc', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wta_voice_call', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wta_misc', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wta_phonebook', XOBJ_DTYPE_INT, null, false);	
    
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
class WurflWtaHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "wta", 'did', '', '', 'wurfl');
    }
}

?>