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
class WurflSound_format extends icms_core_Object
{

    function WurflSound_format($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);		
		$this->initVar('rmf', XOBJ_DTYPE_INT, null, false);
		$this->initVar('qcelp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('awb', XOBJ_DTYPE_INT, null, false);
		$this->initVar('smf', XOBJ_DTYPE_INT, null, false);
		$this->initVar('wav', XOBJ_DTYPE_INT, null, false);
		$this->initVar('nokia_ringtone', XOBJ_DTYPE_INT, null, false);
		$this->initVar('aac', XOBJ_DTYPE_INT, null, false);
		$this->initVar('digiplug', XOBJ_DTYPE_INT, null, false);
		$this->initVar('sp_midi', XOBJ_DTYPE_INT, null, false);
		$this->initVar('compactmidi', XOBJ_DTYPE_INT, null, false);
		$this->initVar('voices', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mp3', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mld', XOBJ_DTYPE_INT, null, false);
		$this->initVar('evrc', XOBJ_DTYPE_INT, null, false);
		$this->initVar('amr', XOBJ_DTYPE_INT, null, false);
		$this->initVar('xmf', XOBJ_DTYPE_INT, null, false);
		$this->initVar('mmf', XOBJ_DTYPE_INT, null, false);
		$this->initVar('imelody', XOBJ_DTYPE_INT, null, false);
		$this->initVar('midi_monophonic', XOBJ_DTYPE_INT, null, false);
		$this->initVar('au', XOBJ_DTYPE_INT, null, false);
		$this->initVar('midi_polyphonic', XOBJ_DTYPE_INT, null, false);	
    
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
class WurflSound_formatHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "sound_format", 'did', '', '', 'wurfl');
    }
}

?>