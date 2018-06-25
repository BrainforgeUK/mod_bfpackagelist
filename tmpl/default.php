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
	foreach($extensions as $extension)
	{
		?>
		<tr class="row<?php echo $i % 2; ?>">
			<td>
				<?php
				echo htmlspecialchars($extension->type);
				?>
			</td>
			<td>
				<?php
				echo $extension->folder;
				?>
			</td>
			<td>
				<?php
				if (strtolower($extension->name) == $extension->element ||
					strtolower($extension->name) == 'plg_' . $extension->folder . '_' . $extension->element)
				{
					echo '&nbsp;';
				}
				else
				{
					echo htmlspecialchars($extension->name);
				}
				?>
			</td>
			<td>
				<?php
				echo $extension->element;
				?>
			</td>
			<td>
				<?php
				echo $extension->extension_id;
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
