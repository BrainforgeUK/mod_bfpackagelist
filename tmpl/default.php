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

echo '<div class="bfpackagelist' . $moduleclass_sfx . '">';
echo '<h2>' . $module->title . '</h2>';
if (empty($extensions))
{
	jText::_('MOD_BFPACKAGELIST_NO_PKGEXTENSIONS_FOUND');
}
else
{
	$i = 0;
	?>
	<table class="table table-striped">
		<tr>
			<th class="nowrap">
				<?php echo JText::_('MOD_BFPACKAGELIST_HEADING_TYPE'); ?>
			</th>
			<th class="nowrap">
				<?php echo JText::_('MOD_BFPACKAGELIST_HEADING_FOLDER'); ?>
			</th>
			<th class="nowrap">
				<?php echo JText::_('MOD_BFPACKAGELIST_HEADING_NAME'); ?>
			</th>
			<th class="nowrap">
				<?php echo JText::_('MOD_BFPACKAGELIST_HEADING_ELEMENT'); ?>
			</th>
			<th class="nowrap">
				<?php echo JText::_('MOD_BFPACKAGELIST_HEADING_ID'); ?>
			</th>
		</tr>
		<?php
	foreach($extensions as $extensionObj)
	{
		?>
		<tr class="row<?php echo $i++ % 2; ?>">
			<td>
				<?php
				echo htmlspecialchars($extensionObj->type);
				?>
			</td>
			<td>
				<?php
				echo $extensionObj->folder;
				?>
			</td>
			<td>
				<?php
				echo htmlspecialchars($extensionObj->name);
				?>
			</td>
			<td>
				<?php
				switch($extensionObj->type)
				{
					case 'component':
						echo '<a href="index.php?option=' . $extensionObj->element . '">' .
							$extensionObj->element .
							'</a>';
						break;
					case 'module':
						echo '<a href="index.php?option=com_modules&client_id=' . $extensionObj->client_id . '&filter[module]=' . $extensionObj->element . '">' .
							$extensionObj->element .
							'</a>';
						break;
					case 'plugin':
						echo '<a href="index.php?option=com_plugins&view=plugins&filter[search]=' . urlencode($extensionObj->name) . '&filter[folder]=' . $extensionObj->folder . '">' .
							$extensionObj->element;
						'</a>';
						break;
					case 'template':
						echo '<a href="index.php?option=com_templates&view=template&id=' . $extensionObj->extension_id . '">' .
							$extensionObj->element .
							'</a>';
						break;
					default:
						echo $extensionObj->element;
						break;
				}
				?>
			</td>
			<td>
				<?php
				echo '<a href="index.php?option=com_installer&view=manage&filter[search]=' . urlencode($extensionObj->name) . '&filter[type]=' . $extensionObj->type . '">' .
					$extensionObj->extension_id;
				'</a>';
				?>
			</td>
		</tr>
		<?php
	}
		?>
		</table>
	<?php
}
echo '</div>';
