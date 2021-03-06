<?php
	ini_set('memory_limit', '256M');
	
	require dirname(__FILE__).'/header.php';
		
	icms_cp_header();
	
	$GLOBALS['op'] = isset($_REQUEST['op'])?(string)($_REQUEST['op']):'import';
	$GLOBALS['fct'] = isset($_REQUEST['fct'])?(string)($_REQUEST['fct']):'form';
	$linenum = isset($_REQUEST['linenum'])?intval($_REQUEST['linenum']):0;
	$bytes = isset($_REQUEST['bytes'])?intval($_REQUEST['bytes']):0;
	$xmlfile = isset($_REQUEST['xmlfile'])?(string)($_REQUEST['xmlfile']):'';
	$rnum = isset($_REQUEST['rnum'])?(string)($_REQUEST['rnum']):0;
	
	switch ($GLOBALS['op']) {
	default:
	case 'import':
		switch ($GLOBALS['fct']) {
		case "go":	
			if ($linenum==0&&$rnum==0) {
			
				$tbl[1] = "wurfl_xhtml_ui";
				$tbl[2] = "wurfl_wta";
				$tbl[3] = "wurfl_wml_ui";
				$tbl[4] = "wurfl_wap_push";
				$tbl[5] = "wurfl_transcoding";
				$tbl[6] = "wurfl_streaming";
				$tbl[7] = "wurfl_storage";
				$tbl[8] = "wurfl_sound_format";
				$tbl[9] = "wurfl_sms";
				$tbl[10] = "wurfl_security";
				$tbl[11] = "wurfl_rss";
				$tbl[12] = "wurfl_product_info";
				$tbl[13] = "wurfl_playback";
				$tbl[14] = "wurfl_pdf";
				$tbl[15] = "wurfl_rss";
				$tbl[16] = "wurfl_object_download";
				$tbl[17] = "wurfl_mms";
				$tbl[18] = "wurfl_markup";
				$tbl[19] = "wurfl_j2me";
				$tbl[20] = "wurfl_image_format";
				$tbl[21] = "wurfl_flash_lite";
				$tbl[22] = "wurfl_drm";
				$tbl[23] = "wurfl_display";
				$tbl[24] = "wurfl_css";
				$tbl[25] = "wurfl_chtml_ui";
				$tbl[26] = "wurfl_cache";
				$tbl[27] = "wurfl_bugs";
				$tbl[26] = "wurfl_bearer";
				$tbl[27] = "wurfl_ajax";
				$tbl[28] = "wurfl_devices";
				
				foreach($tbl as $id => $table) 
					@$GLOBALS['xoopsDB']->queryF("TRUNCATE TABLES ".$GLOBALS['xoopsDB']->prefix($table));
				
			} else {
			
				wurfl_adminMenu(3, 'import.php');
				$GLOBALS['xoopsTpl']->assign('line', $linenum);
				$GLOBALS['xoopsTpl']->assign('redirect', $rnum);
				$GLOBALS['xoopsTpl']->assign('file', $xmlfile);
				$GLOBALS['xoopsTpl']->display('db:admin/wurfl_cpanel_import_redirect.html');
				echo wurfl_footer_adminMenu(false);
				icms_cp_footer();
			
			}
			
			set_time_limit(3600);
			$timer['start'] = time();
			if (file_exists($xmlfile)) {
				$handle = @fopen($xmlfile, "r");
				if ($handle) {
					if ($linenum>0) {
						for($ii=0;$i<$linenum;$ii++) {
							if (!feof($handle)) {
								$skip = fgets($handle, 4096);
							}
						}
					}
					while (!feof($handle)) {
						if (time()-$timer['start']>2400) {
							$rnum++;
							redirect_header("import.php?op=$op&fct=go&xmlfile=".urlencode($xmlfile)."&bytes=$bytes&linenum=$linenum&rnum=$rnum", 3, sprintf(_WURFL_AM_TIMEREDIRECT, $linenum, $rnum));
							exit(0);
						}
							
						$buffer = fgets($handle, 4096);
						$linenum++;
						if (strpos(' '.$buffer, '<device ')>0) 
							$device = array(0=>'<?xml version="1.0" encoding="UTF-8"?>',
											1=>'<wurlf>');
						$device[] = $buffer;
						if (strpos(' '.$buffer, '</device>')>0) 
							{
								$device[] = '</wurlf>';
								$bytes += strlen(implode("\n",$device));
								$xml = wurfl_xml2array(implode("\n",$device), 1, 'tag');
								foreach($xml as $key => $ele) {
									switch($ele['tag']) {
									case "device":
										if ($ele['type']=='open'){
											$deviceHandler =& icms_getModuleHandler('devices', 'wurfl');
											$wdevice = $deviceHandler->create();
											foreach($ele['attributes'] as $field => $value)
												$wdevice->setVar($field, $value);
											$did = $deviceHandler->insert($wdevice);
										}
										break;
									case "group":
										if ($ele['type']=='open'){
											if (file_exists(ICMS_ROOT_PATH."/modules/wurfl/class/".$ele['attributes']['id'].".php")) {
												$skip_group = false;
												$groupHandler =& icms_getModuleHandler($ele['attributes']['id'], 'wurfl');
												$group = $groupHandler->create();
												$group->setVar('did', $did);
											} else {
												$skip_group = true;
											}
										} else {
											if ($skip_group==false) {
												$groupHandler->insert($group);
												unset($group);
												unset($groupHandler);
											}
										}
										break;
									case "capability":
										if ($ele['type']=='complete'&&$skip_group==false){
											if (is_numeric($ele['attributes']['value']))
												$value = intval($ele['attributes']['value']);
											elseif ($ele['attributes']['value']=='true')
												$value = true;
											elseif ($ele['attributes']['value']=='false')
												$value = false;
											else
												$value = $ele['attributes']['value'];
												
											$group->setVar($ele['attributes']['name'], $value);
										}		
										break;
									}
								}
							}
					}
					fclose($handle);
				}
				redirect_header("import.php?op=$op&fct=finished&xmlfile=".urlencode($xmlfile)."&linenum=$linenum&rnum=$rnum&bytes=$bytes", 3, sprintf(_WURFL_AM_TIMEREDIRECT, $linenum, $rnum));
			} else 
				redirect_header("import.php?op=$op&fct=error&xmlfile=".urlencode($xmlfile), 10, _WURFL_AM_FILENOTFOUND);
			break;
		case 'finished':
			wurfl_adminMenu(3, 'import.php');
			$GLOBALS['xoopsTpl']->assign('lines', number_format($linenum,0));
			$GLOBALS['xoopsTpl']->assign('bytes', number_format($bytes,0));
			$GLOBALS['xoopsTpl']->assign('redirects', $rnum);
			$GLOBALS['xoopsTpl']->assign('file', $xmlfile);
			$devices_handler = icms_getModuleHandler('devices', 'wurfl');
			$GLOBALS['xoopsTpl']->assign('devices', $devices_handler->getCount(NULL));
			$GLOBALS['xoopsTpl']->display('db:admin/wurfl_cpanel_import_finished.html');
			break;
		
		case 'error':
			wurfl_adminMenu(3, 'import.php');
			$GLOBALS['xoopsTpl']->assign('file', $xmlfile);
			$GLOBALS['xoopsTpl']->assign('file_exist', file_exists($xmlfile));
			$GLOBALS['xoopsTpl']->assign('xml_parser', function_exists('xml_parser_create'));
			$GLOBALS['xoopsTpl']->display('db:admin/wurfl_cpanel_import_errors.html');
			break;
			
		case 'list':
		default:
			if (!function_exists('xml_parser_create')) {
				redirect_header("import.php?op=$op&fct=error", 10, _WURFL_AM_XMLPARSER_NOTFOUND);
				exit;
			}
			wurfl_adminMenu(3, 'import.php');
			$GLOBALS['xoopsTpl']->assign('form', wurfl_form_import_xml());
			$GLOBALS['xoopsTpl']->display('db:admin/wurfl_cpanel_import.html');
			break;

		}

		break;		
	}
	echo wurfl_footer_adminMenu(false);
	icms_cp_footer();
?>

