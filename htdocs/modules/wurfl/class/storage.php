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
class WurflStorage extends icms_core_Object
{

    function WurflStorage($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_length_of_username', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_url_length_bookmark', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_no_of_bookmarks', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_deck_size', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_url_length_cached_page', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_length_of_password', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_no_of_connection_settings', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_url_length_in_requests', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_object_size', XOBJ_DTYPE_INT, null, false);
		$this->initVar('max_url_length_homepage', XOBJ_DTYPE_INT, null, false);
		
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
class WurflStorageHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "storage", 'did', '', '', 'wurfl');
    }
}

?>