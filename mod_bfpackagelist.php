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
	$query->select('e.`extension_id`, e.`client_id`, e.`name`, e.`type`, e.`folder`, e.`element`')
		->from('`#__extensions` AS e')
		->where('e.`package_id` = ' . $package_id);
	$db->setQuery($query);
	$extensions = $db->loadObjectList();
	if (!empty($extensions))
	{
		foreach($extensions as &$extension)
		{
			$lang = JFactory::getLanguage();
			$path = $extension->client_id ? JPATH_ADMINISTRATOR : JPATH_SITE;
			switch($extension->type) {
				case 'component':
					$source = JPATH_ADMINISTRATOR . '/components/' . $extension->element;
					$lang->load($extension->element.'.sys', JPATH_ADMINISTRATOR, null, false, true)
					||	$lang->load($extension->element.'.sys', $source, null, false, true);
					break;
				case 'file':
					$lang->load('files_' . $extension->element.'.sys', JPATH_SITE, null, false, true);
					break;
				case 'library':
					$lang->load('lib_' . $extension->element.'.sys', JPATH_SITE, null, false, true);
					break;
				case 'module':
					$source = $path . '/modules/' . $extension->element;
					$lang->load($extension->element.'.sys', $path, null, false, true)
					||	$lang->load($extension->element.'.sys', $source, null, false, true);
					break;
				case 'plugin':
					$extensionName = 'plg_' . $extension->folder . '_' . $extension->element;
					$source = JPATH_PLUGINS . '/' . $extension->folder . '/' . $extension->element;
					$lang->load("$extensionName.sys", JPATH_ADMINISTRATOR, null, false, true)
					||	$lang->load("$extensionName.sys", $source, null, false, true);
					break;
				case 'template':
					$extensionName = 'tpl_' . $extension->element;
					$source = $path . '/templates/' . $extension->element;
					$lang->load("$extensionName.sys", $path, null, false, true)
					||	$lang->load("$extensionName.sys", $source, null, false, true);
					break;
				case 'package':
				default:
					$lang->load($extension->element.'.sys', JPATH_SITE, null, false, true);
					break;
			}
			$extension->name = JText::_($extension->name);
		}

		usort( $extensions, function( $a, $b ) {
			if ($a->type < $b->type) return -1;
			if ($a->type > $b->type) return 1;
			if ($a->folder < $b->folder) return -1;
			if ($a->folder > $b->folder) return 1;
			if ($a->name < $b->name) return -1;
			if ($a->name > $b->name) return 1;
			return cmp($a->extension, $b->extension);
		} );
	}
}

require JModuleHelper::getLayoutPath('mod_bfpackagelist', $params->get('layout', 'default'));
