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
class WurflDevices extends icms_core_Object
{

    function WurflDevices($id = null)
    {
		$this->initVar('did', XOBJ_DTYPE_INT, null, false);
		$this->initVar('id', XOBJ_DTYPE_TXTBOX, null, false, 255);	
		$this->initVar('user_agent', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fallback', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('manufacture', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('model', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('series', XOBJ_DTYPE_TXTBOX, null, false, 128);
    
		foreach($this->vars as $key => $data) {
			$this->vars[$key]['persistent'] = true;
		}
		
    }
    
    function getTitle() {
    	$ret = '';
    	$ret .= $this->getVar('manufacture') . (strlen($this->getVar('manufacture'))>0&&(strlen($this->getVar('model'))>0||strlen($this->getVar('series'))>0)? ' - ':'');
    	$ret .= $this->getVar('model') . (strlen($this->getVar('model'))>0&&strlen($this->getVar('series')>0)? ' - ':'');
    	$ret .= $this->getVar('series');
    	if (strlen($ret)==0)
    		$ret .= $this->getVar('user_agent');
    	if (strlen($ret)==0)
    		$ret .= $this->getVar('fallback');
    	return $ret;
    }
    
	function getForm() {
		return wurfl_devices_form($this);
	}
	
	function getValues($keys = '', $format = 's', $maxdepth = 1) {
		$ret = parent::getValues($keys, $format, $maxdepth);
		$form = wurfl_devices_form($this, true);
		foreach($form as $key => $ele) {
			$ret['form'][$key] = $form[$key]->render();	
		}
		$buttons = wurfl_devices_buttons($this, true);
		foreach($buttons as $key => $ele) {
			$ret['buttons'][$key] = $buttons[$key]->render();	
		}
		return $ret;
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
class WurflDevicesHandler extends icms_ipf_Handler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, "devices", 'did', 'user-agent', '', 'wurfl');
    }

	function testUserAgentForType($user_agent){
		if (!isset($user_agent))
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['pad_useragent_android']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return 'pad';
				}
		}
		
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['pad_useragent_apple']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return 'pad';
				}
		}
		
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['mob_useragent_android']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return 'mobile';
				}
		}
		
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['mob_useragent_apple']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return 'mobile';
				}
		}
		
		$criteria = new icms_db_criteria_Item('user_agent', $user_agent);
		if ($this->getCount($criteria)) {
			$device = $this->getObjects($criteria);
			if (is_array($device))
				$device = $device[0];
			if (is_object($device)) {
				$display_handler = icms_getModuleHandler('display', 'wurfl');
				$display = $display_handler->get($device->getVar('did'));
				if (is_object($display)) {
					if ($display->getVar('resolution_width')>=$GLOBALS['wurflModuleConfig']['pad_min_width']&&$display->getVar('resolution_height')>=$GLOBALS['wurflModuleConfig']['pad_min_height']) {
						return 'pad';
					} else {
						return 'mobile';
					}
				} else {
					return 'mobile';
				}
			}
		}
		return false;
	}
	
	function testUserAgentForTheme($user_agent, $as_array = false){
		if (!isset($user_agent))
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['pad_useragent_android']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return $GLOBALS['wurflModuleConfig']['pad_android'];
				}
		}
		
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['pad_useragent_apple']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return $GLOBALS['wurflModuleConfig']['pad_apple'];
				}
		}
		
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['mob_useragent_android']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return $GLOBALS['wurflModuleConfig']['mob_android'];
				}
		}
		
		foreach(explode('|', $GLOBALS['wurflModuleConfig']['mob_useragent_apple']) as $ua) {
			if (!empty($ua))
				if (strpos(' '.strtolower(' '.$ua), strtolower($user_agent))>0||strpos(' '.strtolower($user_agent), strtolower($ua))>0) {
					return $GLOBALS['wurflModuleConfig']['mob_apple'];
				}
		}
		
		$criteria = new icms_db_criteria_Item('user_agent', $user_agent);
		if ($this->getCount($criteria)) {
			$device = $this->getObjects($criteria);
			if (is_array($device))
				$device = $device[0];
			if (is_object($device)) {
				$display_handler = icms_getModuleHandler('display', 'wurfl');
				$display = $display_handler->get($device->getVar('did'));
				$mode='mod_';
				if (is_object($display)) {
					if ($display->getVar('resolution_width')>=$GLOBALS['wurflModuleConfig']['pad_min_width']&&$display->getVar('resolution_height')>=$GLOBALS['wurflModuleConfig']['pad_min_height']) {
						$mode='pad_';
					} else {
						$mode='mod_';
					}
				} else {
					$mode='mod_';
				}
				$java = false;
				$flash = false;
				$css = false;
				$html = false;
				$criteria = new icms_db_criteria_Item('did', $device->getVar('did'));
				$ajax_handler = icms_getModuleHandler('ajax', 'wurfl');
				$j2me_handler = icms_getModuleHandler('j2me', 'wurfl');
				if ($ajax_handler->getCount($criteria)>0||$j2me_handler->getCount($criteria)>0) {
					$java = true;
				}
				$flash_handler = icms_getModuleHandler('flash_lite', 'wurfl');
				if ($flash_handler->getCount($criteria)>0) {
					$flash = true;
				}
				$css_handler = icms_getModuleHandler('css', 'wurfl');
				if ($css_handler->getCount($criteria)>0) {
					$css = true;
				}
				$chtml_handler = icms_getModuleHandler('chtml_ui', 'wurfl');
				$xhtml_handler = icms_getModuleHandler('xhtml_ui', 'wurfl');
				if ($chtml_handler->getCount($criteria)>0||$xhtml_handler->getCount($criteria)>0) {
					$html = true;
				}
				$wml_handler = icms_getModuleHandler('wml_ui', 'wurfl');
				if ($wml_handler->getCount($criteria)>0) {
					$wml = true;
				}
				$wap_handler = icms_getModuleHandler('wap_push', 'wurfl');
				if ($wap_handler->getCount($criteria)>0) {
					$wap = true;
				}
				if ($java==true&&$flash==true&&$css==true&&$html==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'ajaxflashhtmlcss'];
				} elseif ($java==true&&$css==true&&$html==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'ajaxhtmlcss'];
				} elseif ($flash==true&&$css==true&&$html==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'flashhtmlcss'];
				} elseif ($css==true&&$html==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'htmlcss'];
				} elseif ($html==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'html'];
				} elseif ($wml==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'wml'];					
				} elseif ($wap==true) {
					return $GLOBALS['wurflModuleConfig'][$mode.'wap'];
				}
				return false;
			} else
				return false;
		} else
			return false;
	}
    
    function testUserAgent($user_agent, $as_array = false){
		if (!isset($user_agent))
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			
		$criteria = new icms_db_criteria_Item('user_agent', $user_agent);
		if ($this->getCount($criteria)) {
			$device = $this->getObjects($criteria);
			if (is_array($device))
				$device = $device[0];
			if (is_object($device))
				if ($as_array==false)
					return $device;
				else
					return $device->getValues();
			else
				return false;
		} else
			return false;
		
	}
	
	function getProviderVariables($did) {
		$ret = array();
		$chtml_handler =& icms_getModuleHandler('chtml_ui', 'wurfl');
		if ($chtml = $chtml_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_chtml_support']] = $chtml->toArray();
		}
		$xhtml_handler =& icms_getModuleHandler('xhtml_ui', 'wurfl');
		if ($xhtml = $xhtml_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_xhtml_support']] = $xhtml->toArray();
		}
		$wap_handler =& icms_getModuleHandler('wap_push', 'wurfl');
		if ($wap = $wap_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_wap_support']] = $wap->toArray();
		}	
		$wml_handler =& icms_getModuleHandler('wml_ui', 'wurfl');
		if ($wml = $wml_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_wml_support']] = $wml->toArray();
		}
		$css_handler =& icms_getModuleHandler('css', 'wurfl');
		if ($css = $css_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_css_support']] = $css->toArray();
		}		
		$ajax_handler =& icms_getModuleHandler('ajax', 'wurfl');
		if ($ajax = $ajax_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_ajax_support']] = $ajax->toArray();
		}
		$flash_handler =& icms_getModuleHandler('flash_lite', 'wurfl');
		if ($flash = $flash_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_flash_support']] = $flash->toArray();
		}
		$j2me_handler =& icms_getModuleHandler('j2me', 'wurfl');
		if ($j2me = $j2me_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_j2me_support']] = $j2me->toArray();
		}
		$image_handler =& icms_getModuleHandler('image_format', 'wurfl');
		if ($image = $image_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_wbmp_support']] = $image->getVar('wbmp');
			$ret[$GLOBALS['wurflModuleConfig']['var_jpeg_support']] = $image->getVar('jpg');
			$ret[$GLOBALS['wurflModuleConfig']['var_gif_support']] = $image->getVar('gif');
			$ret[$GLOBALS['wurflModuleConfig']['var_png_support']] = $image->getVar('png');
			$ret[$GLOBALS['wurflModuleConfig']['var_tiff_support']] = $image->getVar('tiff');
		}
		$pdf_handler =& icms_getModuleHandler('pdf', 'wurfl');
		if ($pdf = $pdf_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_pdf_support']] = $pdf->getVar('pdf_support');
		}
		$rss_handler =& icms_getModuleHandler('rss', 'wurfl');
		if ($rss = $rss_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_rss_support']] = $rss->getVar('rss_support');
		}
		$sound_handler =& icms_getModuleHandler('sound_format', 'wurfl');
		if ($sound = $sound_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_wav_support']] = $sound->getVar('acc');
			$ret[$GLOBALS['wurflModuleConfig']['var_mp3_support']] = $sound->getVar('mp3');
			$ret[$GLOBALS['wurflModuleConfig']['var_gsm_support']] = $sound->getVar('nokia_ringtone');
			$ret[$GLOBALS['wurflModuleConfig']['var_m4a_support']] = false;
		}
		$streaming_handler =& icms_getModuleHandler('streaming', 'wurfl');
		if ($streaming = $streaming_handler->get($did)) {
			$ret[$GLOBALS['wurflModuleConfig']['var_stream_support']] = $streaming->toArray();
		}
		$display_handler = icms_getModuleHandler('display', 'wurfl');
		$display = $display_handler->get($did);
		if (is_object($display)) {
			if ($display->getVar('resolution_width')>=$GLOBALS['wurflModuleConfig']['pad_min_width']&&$display->getVar('resolution_height')>=$GLOBALS['wurflModuleConfig']['pad_min_height']) {
				$ret[$GLOBALS['wurflModuleConfig']['var_pad_support']] = true;
				$ret[$GLOBALS['wurflModuleConfig']['var_mobile_support']] = false;
			} else {
				$ret[$GLOBALS['wurflModuleConfig']['var_pad_support']] = false;
				$ret[$GLOBALS['wurflModuleConfig']['var_mobile_support']] = true;
			}
		} else {
			$ret[$GLOBALS['wurflModuleConfig']['var_pad_support']] = false;
			$ret[$GLOBALS['wurflModuleConfig']['var_mobile_support']] = true;
		}
		return $ret;	
	}
	
	function getProviders($did) {
		$module_handler =& icms::handler('icms_module');
		$GLOBALS['wurflModule'] = $module_handler->getByDirname('wurfl');
		$config_handler =& icms::handler('icms_config');
		$GLOBALS['wurflModuleConfig'] = $config_handler->getConfigList($GLOBALS['wurflModule']->getVar('mid'));		
		$ret = array();
		foreach($GLOBALS['wurflModuleConfig']['provider'] as $id => $prov) {
			$providerHandler =& icms_getModuleHandler($prov, 'wurfl');
			$criteria = new icms_db_criteria_Item('did', $did);
			if ($providerHandler->getCount($criteria)>0) {
				$provider = $providerHandler->getObjects($criteria);
				if (is_array($provider))
					$provider = $provider[0];
				if (is_object($provider)) {
					$ret[$prov] = $provider->getValues();
				}
			}
		}
		return $ret;
	}
	
    function getFiltericms_db_criteria_Item($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new icms_db_criteria_Compo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new icms_db_criteria_Item('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new icms_db_criteria_Item('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new icms_db_criteria_Item('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new icms_db_criteria_Item('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new icms_db_criteria_Item($var[0], $var[1]));
    		}
    	}
    	return $criteria;
    }
        
    function getFilterForm($filter, $field, $sort='did', $op = 'devices', $fct='list') {
    	$ele = wurfl_getFilterElement($filter, $field, $sort, $op, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
}

?>