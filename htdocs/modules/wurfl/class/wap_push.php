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
class WurflWap_push extends icms_core_Object
{

    function WurflWap_push($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);
		$this->initVar('expiration_date', XOBJ_DTYPE_INT, null, false);
		$this->initVar('utf8_support', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionless_cache_operation', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionless_service_load', XOBJ_DTYPE_INT, null, false);
		$this->initVar('iso8859_support', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionoriented_confirmed_service_indication', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionless_service_indication', XOBJ_DTYPE_INT, null, false);
		$this->initVar('ascii_support', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionoriented_confirmed_cache_operation', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionoriented_confirmed_service_load', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wap_push_support', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionoriented_unconfirmed_cache_operation', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionoriented_unconfirmed_service_load', XOBJ_DTYPE_INT, null, false);
		$this->initVar('connectionoriented_unconfirmed_service_indication', XOBJ_DTYPE_INT, null, false);
    
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
class WurflWap_pushHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "wap_push", 'did', '', '', 'wurfl');
    }
}

?>