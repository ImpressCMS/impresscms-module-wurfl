<?php
/**
 * select form element
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The ICMS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.xoops.org/
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: formselect.php 8066 2011-11-06 05:09:33Z beckmi $
 */
defined('ICMS_ROOT_PATH') or die('Restricted access');

/**
 * A select field
 *
 * @author 		Kazumi Ono <onokazu@xoops.org>
 * @author 		Taiwen Jiang <phppp@users.sourceforge.net>
 * @author 		John Neill <catzwolf@xoops.org>
 * @copyright   The ICMS Project http://sourceforge.net/projects/xoops/
 * @package 	kernel
 * @subpackage 	form
 * @access 		public
 */
class WurflFormSelectDevice extends icms_form_elements_Select
{
    /**
     * Options
     *
     * @var array
     * @access private
     */
    var $_options = array();

    /**
     * Allow multiple selections?
     *
     * @var bool
     * @access private
     */
    var $_multiple = false;

    /**
     * Number of rows. "1" makes a dropdown list.
     *
     * @var int
     * @access private
     */
    var $_size;

    /**
     * Pre-selcted values
     *
     * @var array
     * @access private
     */
    var $_value = array();

    /**
     * Constructor
     *
     * @param string $caption Caption
     * @param string $name "name" attribute
     * @param mixed $value Pre-selected value (or array of them).
     * @param int $size Number or rows. "1" makes a drop-down-list
     * @param bool $multiple Allow multiple selections?
     */
    function WurflFormSelectDevice($caption, $name, $value = null, $size = 1, $multiple = false)
    {
        ini_set('memory_limit', '360M');
    	$this->setCaption($caption);
        $this->setName($name);
        $this->_multiple = $multiple;
        $this->_size = intval($size);
        if (isset($value)) {
            $this->setValue($value);
        }
        set_ini('memory_limit', '256M');
        $devices_handler = icms_getModuleHandler('devices', 'wurfl');
        $criteria = new icms_db_criteria_Item('`did`', '0', '<>');
        $criteria->setSort('`manufacture`, `model`, `series`, `user_agent`, `fallback`');
        $criteria->setOrder('ASC');
        $devices = $devices_handler->getObjects($criteria, true);
        foreach($devices as $did => $device) {
        	$this->addOption($did, $device->getTitle());
        }
    }
    
}

?>