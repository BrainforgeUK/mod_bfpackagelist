<?php
/**
 * Joomla! Content Management System
 *
 * @author    https://www.brainforge.co.uk
 * @copyright  Copyright (C) 2018 Jonathan Brain, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Form\FormHelper;

FormHelper::loadFieldClass('predefinedlist');

/**
 * Form Field to load a list of states
 *
 * @since  3.2
 */
class JFormFieldBfpackagelist extends \JFormFieldPredefinedList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  3.2
	 */
	public $type = 'Bfpackagelist';

	/**
	 * Available packages
	 *
	 * @var  array
	 * @since  3.2
	 */
	protected $predefinedOptions = array("" => "");

	protected function getInput()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('e.extension_id, e.name')
			->from('`#__extensions` AS e')
			->where("e.`type` = 'package'")
			->order('e.`name` ASC');
		$db->setQuery($query);
		$packageList = $db->loadAssocList('extension_id', 'name');
		if (!empty($packageList)) {
			$this->predefinedOptions += $packageList;
		}

		return parent::getInput();
	}
}
