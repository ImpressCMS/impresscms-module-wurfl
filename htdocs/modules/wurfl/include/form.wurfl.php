<?php
	
	include_once( 'form.objects.php' );
	
	function wurfl_form_import_xml(){
		if (file_exists(ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php'))
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php');
		else 
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.'english'.DS.'forms.php');
			
		$cform = new icms_form_Theme(_WURFL_FRM_FILEIMPORT_FORM, 'import', $_SERVER['PHP_SELF'], 'post');

		$cform->addElement(new icms_form_elements_Text(_WURFL_FRM_FILEIMPORT, 'xmlfile', 70, 255, ICMS_ROOT_PATH.'/modules/wurfl/resource/wurfl.xml'));
		$cform->addElement(new icms_form_elements_Button('', 'checkout_submit', _WURFL_FRM_FILEIMPORT_BTTN, "submit"));
		$cform->addElement(new icms_form_elements_Hidden('op', 'import'));
		$cform->addElement(new icms_form_elements_Hidden('fct', 'go'));		
		
		return $cform->render();
	}
	
	function wurfl_devices_buttons($object, $as_array=false) {
		if (file_exists(ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php'))
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php');
		else 
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.'english'.DS.'forms.php');
			
		if (!is_object($object)) {
			$handler = icms_getModuleHandler('devices', 'wurfl');
			$object = $handler->create(); 
		}
		$placement = "&limit=".(isset($_REQUEST['limit'])?$_REQUEST['limit']:'30')."&start=".(isset($_REQUEST['start'])?$_REQUEST['start']:'0')."&sort=".(isset($_REQUEST['sort'])?$_REQUEST['sort']:'did')."&order=".(isset($_REQUEST['order'])?$_REQUEST['order']:'ASC')."&filter=".(isset($_REQUEST['filter'])?$_REQUEST['filter']:'1,1');
		$id = $object->getVar('did');
		if (empty($id)) $id = '0';
		$ele = array();
		$classes = array(	'ajax', 'bearer', 'bugs', 'cache', 'chtml_ui', 'css', 'display', 'drm', 'flash_lite', 'image_format', 
							'j2me', 'markup', 'mms', 'object_download', 'pdf', 'playback', 'product_info', 'rss', 'security', 
							'sms', 'sound_format', 'storage', 'streaming', 'transcoding', 'wap_push', 'wml_ui', 'wta', 'xhtml_ui'	);
		foreach($classes as $class) {
			$class_handler = icms_getModuleHandler($class, 'wurfl');
			$criteria = new icms_db_criteria_Item('`did`', $id);
			if ($class_handler->getCount($criteria)==0) {
				$ele[$class] = new icms_form_elements_Button('', $class, defined('_WURFL_FRM_BUTTON_CREATE_'.strtoupper($class))?constant('_WURFL_FRM_BUTTON_CREATE_'.strtoupper($class)):'_WURFL_FRM_BUTTON_CREATE_'.strtoupper($class));
				$ele[$class]->setExtra("onClick=\"window.open('".dirname($_SERVER['PHP_SELF']).'/'.$class.".php?op=".$class."&fct=create&did=".$id.$placement.'\',\'_self\')"');
			} else {
				$ele[$class] = new icms_form_elements_Button('', $class, defined('_WURFL_FRM_BUTTON_EDIT_'.strtoupper($class))?constant('_WURFL_FRM_BUTTON_EDIT_'.strtoupper($class)):'_WURFL_FRM_BUTTON_EDIT_'.strtoupper($class));
				$ele[$class]->setExtra("onClick=\"window.open('".dirname($_SERVER['PHP_SELF']).'/'.$class.".php?op=".$class."&fct=list&did=".$id.$placement.'\',\'_self\')"');
			}
		}
		return $ele;
	}
	
	function wurfl_devices_form($object, $as_array=false) {
		
		if (file_exists(ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php'))
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php');
		else 
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.'english'.DS.'forms.php');
		
		if (!is_object($object)) {
			$handler = icms_getModuleHandler('devices', 'wurfl');
			$object = $handler->create(); 
		}
		
		if ($object->isNew())
			$sform = new icms_form_Theme(_WURFL_FRM_FORM_ISNEW_DEVICES, 'retweet', 'devices.php', 'post');
		else
			$sform = new icms_form_Theme(_WURFL_FRM_FORM_EDIT_DEVICES, 'retweet', 'devices.php', 'post');
		
		$id = $object->getVar('did');
		if (empty($id)) $id = '0';
		
		$ele = array();	
		$ele['op'] = new icms_form_elements_Hidden('op', 'devices');
		$ele['fct'] = new icms_form_elements_Hidden('fct', 'save');
		if ($as_array==false)
			$ele['did'] = new icms_form_elements_Hidden('did', $id);
		else 
			$ele['did'] = new icms_form_elements_Hidden('did['.$id.']', $id);
		$ele['limit'] = new icms_form_elements_Hidden('limit', !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30);
		$ele['start'] = new icms_form_elements_Hidden('start', !empty($_REQUEST['start'])?intval($_REQUEST['start']):0);
		$ele['order'] = new icms_form_elements_Hidden('order', !empty($_REQUEST['order'])?$_REQUEST['order']:'ASC');
		$ele['sort'] = new icms_form_elements_Hidden('sort', !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'did');
		$ele['filter'] = new icms_form_elements_Hidden('filter', !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1');
		
		$ele['id'] = new icms_form_elements_Text(_WURFL_FRM_FORM_ID_DEVICES, $id.'[id]', 26,255, $object->getVar('id'));
		$ele['id']->setDescription(_WURFL_FRM_FORM_DESC_ID_DEVICES);
		$ele['user_agent'] = new icms_form_elements_Text(_WURFL_FRM_FORM_USERAGENT_DEVICES, $id.'[user_agent]', 26,128, $object->getVar('user_agent'));
		$ele['user_agent']->setDescription(_WURFL_FRM_FORM_DESC_USERAGENT_DEVICES);
		$ele['fallback'] = new icms_form_elements_Text(_WURFL_FRM_FORM_FALLBACK_DEVICES, $id.'[fallback]', 26,128, $object->getVar('fallback'));
		$ele['fallback']->setDescription(_WURFL_FRM_FORM_DESC_FALLBACK_DEVICES);
		$ele['manufacture'] = new icms_form_elements_Text(_WURFL_FRM_FORM_MANUFACTURE_DEVICES, $id.'[manufacture]', 26,128, $object->getVar('manufacture'));
		$ele['manufacture']->setDescription(_WURFL_FRM_FORM_DESC_MANUFACTURE_DEVICES);
		$ele['model'] = new icms_form_elements_Text(_WURFL_FRM_FORM_MODEL_DEVICES, $id.'[model]', 26,128, $object->getVar('model'));
		$ele['model']->setDescription(_WURFL_FRM_FORM_DESC_MODEL_DEVICES);
		$ele['series'] = new icms_form_elements_Text(_WURFL_FRM_FORM_SERIES_DEVICES, $id.'[series]', 26,128, $object->getVar('series'));
		$ele['series']->setDescription(_WURFL_FRM_FORM_DESC_SERIES_DEVICES);
		
		if ($as_array==true) {
			return $ele;
		}
		
		$ele['submit'] = new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit');
		
		$required = array('id', 'user_agent');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
		
		return $sform->render();
		
	}	
	
	function wurfl_form_general($object, $class, $new=false) {
		if (file_exists(ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php'))
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.$GLOBALS['icmsConfig']['language'].DS.'forms.php');
		else 
			require_once (ICMS_ROOT_PATH.''.DS.'modules'.DS.'wurfl'.DS.'language'.DS.'english'.DS.'forms.php');
			
		$handler = icms_getModuleHandler($class, 'wurfl');
		if (!is_object($object)&&$new==true) {
			$object = $handler->create();
			$object->setVar('did', $_REQUEST['did']);
		} elseif (!is_object($object)&&$new==false) {
			$object = $handler->get($_REQUEST['did']);
		}
		$form = new icms_form_Theme(defined('_WURFL_FRM_'.strtoupper($class).'_FORM')?constant('_WURFL_FRM_'.strtoupper($class).'_FORM'):($object->isNew()?_WURLF_FRM_CREATE:_WURLF_FRM_EDIT). ' '. str_replace('_UI', ' '._WURLF_FRM_UI, strtoupper($class)).' '._WURLF_FRM_WITHFORM, $class, $_SERVER['PHP_SELF'], 'post');

		$form->addElement(new icms_form_elements_Hidden('op', $class));
		$form->addElement(new icms_form_elements_Hidden('limit', !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30));
		$form->addElement(new icms_form_elements_Hidden('start', !empty($_REQUEST['start'])?intval($_REQUEST['start']):0));
		$form->addElement(new icms_form_elements_Hidden('order', !empty($_REQUEST['order'])?$_REQUEST['order']:'ASC'));
		$form->addElement(new icms_form_elements_Hidden('sort', !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'did'));
		$form->addElement(new icms_form_elements_Hidden('filter', !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1'));
		if ($new==false)
			$form->addElement(new icms_form_elements_Hidden('fct', 'save'));		
		else 
			$form->addElement(new icms_form_elements_Hidden('fct', 'new'));
		foreach($object->vars as $key => $definition) {
			switch ($key) {
				case 'did':
					$form->addElement(new icms_form_elements_Hidden('did', $_REQUEST['did']));
					break;
				default:
					$field_type = 'yesno';
					foreach(wurfl_text_field_subsets() as $subset) {
						if (strpos(' '.$key, $subset)>0)
							$field_type = 'text';
					}
					switch($field_type) {
						case 'yesno':
							$form->addElement(new icms_form_elements_RadioYN(defined('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key))?constant('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key)):ucfirst($class).' - '.ucfirst(str_ireplace('_', ' ', $key)), $key, $object->getVar($key)));
							break;
						case 'text':
							if ($definition['maxlength']>32)
								$form->addElement(new icms_form_elements_Text(defined('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key))?constant('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key)):ucfirst($class).' - '.ucfirst(str_ireplace('_', ' ', $key)), $key, 45, $definition['maxlength'], $object->getVar($key)));
							elseif ($definition['data_type']==XOBJ_DTYPE_TXTBOX)
								$form->addElement(new icms_form_elements_Text(defined('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key))?constant('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key)):ucfirst($class).' - '.ucfirst(str_ireplace('_', ' ', $key)), $key, 32, $definition['maxlength'], $object->getVar($key)));
							else
								$form->addElement(new icms_form_elements_Text(defined('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key))?constant('_WURFL_FRM_'.strtoupper($class).'_'.strtoupper($key)):ucfirst($class).' - '.ucfirst(str_ireplace('_', ' ', $key)), $key, 15, 20, $object->getVar($key)));
					}
			}
		}
		
		$form->addElement(new icms_form_elements_Button('', 'submit', _SUBMIT, 'submit'));
		
		return $form->render();
	}
?>
