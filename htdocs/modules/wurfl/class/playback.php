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
class WurflPlayback extends icms_core_Object
{

    function WurflPlayback($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);	
		$this->initVar('playback_oma_size_limit', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_acodec_aac', XOBJ_DTYPE_TXTBOX, null, false, 32);
		$this->initVar('playback_vcodec_h263_3', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_vcodec_mpeg4_asp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_mp4', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_3gpp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_df_size_limit', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_acodec_amr', XOBJ_DTYPE_TXTBOX, null, false, 32);
		$this->initVar('playback_mov', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_wmv', XOBJ_DTYPE_TXTBOX, null, false, 32);
		$this->initVar('playback_acodec_qcelp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('progressive_download', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_directdownload_size_limit', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_real_media', XOBJ_DTYPE_TXTBOX, null, false, 32);
		$this->initVar('playback_3g2', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_vcodec_mpeg4_sp', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_vcodec_h263_0', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_inline_size_limit', XOBJ_DTYPE_INT, null, false);
		$this->initVar('playback_vcodec_h264_bp', XOBJ_DTYPE_INT, null, false);		
    
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
class WurflPlaybackHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "playback", 'did', '', '', 'wurfl');
    }
}

?>