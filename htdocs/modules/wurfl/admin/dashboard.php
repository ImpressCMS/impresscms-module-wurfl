<?php
	include ('header.php');

	if (file_exists(ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php'))
		require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php');
	else 
		require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.'english'.DS.'forms.php');
		
	$op = (isset($_REQUEST['op']))? $_REQUEST['op'] : "default";
	switch ($op) {
	    case "default":
	    default:
	        icms_cp_header();
	        wurfl_adminMenu(1, 'dashboard.php');
			$indexAdmin = new ModuleAdmin();	
		    $indexAdmin->addInfoBox(_WURFL_FRM_RECORDS);
			foreach(array(	'devices', 'ajax', 'bearer', 'bugs', 'cache', 'chtml_ui', 'css', 'display', 'drm', 'flash_lite', 'image_format', 
				'j2me', 'markup', 'mms', 'object_download', 'pdf', 'playback', 'product_info', 'rss', 'security', 
				'sms', 'sound_format', 'storage', 'streaming', 'transcoding', 'wap_push', 'wml_ui', 'wta', 'xhtml_ui'	) as $class) {
					$class_handler = icms_getModuleHandler($class, 'wurfl');
					$indexAdmin->addInfoBoxLine(_WURFL_FRM_RECORDS, "<label>".defined('_WURFL_FRM_RECORDS_COUNT_'.strtoupper($class))?constant('_WURFL_FRM_RECORDS_COUNT_'.strtoupper($class)):'_WURFL_FRM_RECORDS_COUNT_'.strtoupper($class)."</label>", $class_handler->getCount(), ($class_handler->getCount()>0)?'Green':'Red');
				}	        	        
    		echo $indexAdmin->renderIndex();
	        echo wurfl_footer_adminMenu(false);
	        icms_cp_footer();
	        break;
	}

?>