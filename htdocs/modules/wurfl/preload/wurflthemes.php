<?php


defined('ICMS_ROOT_PATH') or die('Restricted access');


class IcmsPreloadWurflthemes extends icms_preload_Item
{
	function eventfinishCoreBoot($args)
	{
		$module_handler =& icms::handler('icms_module');
		$GLOBALS['wurflModule'] = $module_handler->getByDirname('wurfl');
		$config_handler =& icms::handler('icms_config');
		$GLOBALS['wurflModuleConfig'] = $config_handler->getConfigList($GLOBALS['wurflModule']->getVar('mid'));	
		if ($GLOBALS['wurflModuleConfig']['postloader']==true) {		
			$wurlf_devices =& icms_getModuleHandler('devices', 'wurfl');
			$theme = $wurlf_devices->testUserAgentForTheme($_SERVER['HTTP_USER_AGENT'], true);
			if ($theme!=false) {
				$GLOBALS['xoopsConfig']['theme_set'] = $theme;
				$GLOBALS['icmsConfig']['theme_set'] = $theme;
			}
		}
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			if (!class_exists('IcmsCache'))
				require_once (dirname(dirname(__FILE__)).DS.'class'.DS.'cache'.DS.'icmscache.php');
			$ret = IcmsCache::read('wurfl_user_agents');
			$out=array();
			if (is_object(icms::$user))
				$out[microtime(true)] = array('useragent'=>$_SERVER['HTTP_USER_AGENT'], 'theme' => $GLOBALS['xoopsConfig']['theme_set'], 'user' => '<a href="'.ICMS_URL.'/userinfo.php?uid='.icms::$user->getVar('uid').'">'.icms::$user->getVar('uname').'</a>');
			else 
				$out[microtime(true)] = array('useragent'=>$_SERVER['HTTP_USER_AGENT'], 'theme' => $GLOBALS['xoopsConfig']['theme_set'], 'user' => _GUESTS);
			foreach($ret as $time => $agent) {
				if (is_array($agent))
					if ($agent['useragent']!=$_SERVER['HTTP_USER_AGENT']) {
						$out[$time] = $agent;
					}
			}
			asort($out, SORT_DESC);
			IcmsCache::write('wurfl_user_agents', $out, 3600*24*7*4);
		}   
	}
	
	function eventstartOutputInit($args)
	{
		if ($GLOBALS['wurflModuleConfig']['postloader']==true) {
			$wurlf_devices =& icms_getModuleHandler('devices', 'wurfl');
			$wurfl_device = $wurlf_devices->testUserAgent($_SERVER['HTTP_USER_AGENT'], true);
			if (is_array($wurfl_device)&&!empty($wurfl_device['did']))
			{
				foreach($wurlf_devices->getProviderVariables($wurfl_device['did']) as $key => $data) {
					$GLOBALS['xoopsTpl']->assign($key, $data);
				}
				$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_associative'], $wurlf_devices->getProviders($wurfl_device['did']));
				if (($type = $wurlf_devices->testUserAgentForType($_SERVER['HTTP_USER_AGENT'], true))==false) {
					$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_mobile_support'], false);
					$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_pad_support'], false);
				} else {
					if ($type!='pad') {
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_mobile_support'], true);
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_pad_support'], false);
					} else {
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_mobile_support'], false);
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_pad_support'], true);
					}
				}
			} else {
				if (($type = $wurlf_devices->testUserAgentForType($_SERVER['HTTP_USER_AGENT'], true))==false) {
					$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_mobile_support'], false);
					$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_pad_support'], false);
				} else {
					if ($type!='pad') {
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_mobile_support'], true);
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_pad_support'], false);
					} else {
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_mobile_support'], false);
						$GLOBALS['xoopsTpl']->assign($GLOBALS['wurflModuleConfig']['var_pad_support'], true);
					}
				}
			}
		}		
	}
	
}

?>