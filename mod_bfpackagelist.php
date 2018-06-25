<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_bfpackagelist
 *
 * @author    https://www.brainforge.co.uk
 * @copyright   Copyright (C) 2018 Jonathan Brain. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$package_id      = $params->get('package_id');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

if (empty($package_id))
{
	$extensions = null;
}
else {
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('e.`extension_id`, e.`name`, e.`type`, e.`element`')
		->from('`#__extensions` AS e')
		->where('e.`package_id` = ' . $package_id)
		->order('e.`type`, e.`folder`, e.`name` ASC');
	$db->setQuery($query);
	$extensions = $db->loadObjectList();
}

require JModuleHelper::getLayoutPath('mod_bfpackagelist', $params->get('layout', 'default'));
