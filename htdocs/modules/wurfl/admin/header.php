<?php
	
	define('DS', DIRECTORY_SEPARATOR);
	require dirname(dirname(dirname(dirname(__FILE__)))).'/include/cp_header.php';
	
	if (!defined('_CHARSET'))
		define ("_CHARSET","UTF-8");
	if (!defined('_CHARSET_ISO'))
		define ("_CHARSET_ISO","ISO-8859-1");
		
	$GLOBALS['myts'] = icms_core_Textsanitizer::getInstance();
	
	$module_handler = icms::handler('icms_module');
	$config_handler = icms::handler('icms_config');
	$GLOBALS['wurflModule'] = $module_handler->getByDirname('wurfl');
	$GLOBALS['wurflModuleConfig'] = $config_handler->getConfigList($GLOBALS['wurflModule']->getVar('mid')); 
	
	
	if ( file_exists(dirname(dirname(__FILE__)).DS.'class'.DS.'moduleclasses'.DS.'moduleadmin'.DS.'moduleadmin.php')){
	        include_once (dirname(dirname(__FILE__)).DS.'class'.DS.'moduleclasses'.DS.'moduleadmin'.DS.'moduleadmin.php');
	        //return true;
	    }else{
	        echo icms_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
	        //return false;
	    }
    
	$GLOBALS['wurflImageIcon'] = ICMS_URL .'/'. $GLOBALS['wurflModule']->getInfo('icons16');
	$GLOBALS['wurflImageAdmin'] = ICMS_URL .'/'. $GLOBALS['wurflModule']->getInfo('icons32');
	
	if (icms::$user) {
	    $moduleperm_handler =& icms::handler('icms_member_groupperm');
	    if (!$moduleperm_handler->checkRight('module_admin', $GLOBALS['wurflModule']->getVar( 'mid' ), icms::$user->getGroups())) {
	        redirect_header(ICMS_URL, 1, _NOPERM);
	        exit();
	    }
	} else {
	    redirect_header(ICMS_URL . "/user.php", 1, _NOPERM);
	    exit();
	}
	
	if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
		include_once(ICMS_ROOT_PATH."/class/template.php");
		$GLOBALS['xoopsTpl'] = new icms_view_Tpl();
	}
	
	$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['wurflImageIcon']);
	$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['wurflImageAdmin']);
	
	include(dirname(dirname(__FILE__)).'/include/functions.php');
	include(dirname(dirname(__FILE__)).'/include/form.objects.php');
	include(dirname(dirname(__FILE__)).'/include/form.wurfl.php');
	
	if (!class_exists('IcmsCache'))
		require_once (dirname(dirname(__FILE__)).DS.'class'.DS.'cache'.DS.'icmscache.php');
		
	if (file_exists(ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'admin.php'))
		require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'admin.php');
	else 
		require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.'english'.DS.'admin.php');
			
	$parts = explode('.', strtolower(basename($_SERVER['PHP_SELF'])));
	unset($parts[sizeof($parts)-1]);
	$GLOBALS['op'] = isset($_REQUEST['op'])?$_REQUEST['op']:implode('.', $parts);
	$GLOBALS['fct'] = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
	$GLOBALS['limit'] = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$GLOBALS['start'] = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$GLOBALS['order'] = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$GLOBALS['sort'] = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
	$GLOBALS['filter'] = !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1';

	
?>