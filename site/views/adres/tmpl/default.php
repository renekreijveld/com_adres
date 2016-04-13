<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Adres
 * @author     Rene Kreijveld <email@renekreijveld.nl>
 * @copyright  Copyright Rene Kreijveld (C) 2016. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;
?>

<?php if ($this->item) : ?>
	<div class="item_fields">
		<table class="table">
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_STATE'); ?></th>
				<td><i class="icon-<?php echo ($this->item->state == 1) ? 'publish' : 'unpublish'; ?>"></i></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_CREATED_BY'); ?></th>
				<td><?php echo $this->item->created_by_name; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_NAAM'); ?></th>
				<td><?php echo $this->item->naam; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_ALIAS'); ?></th>
				<td><?php echo $this->item->alias; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_ADRES'); ?></th>
				<td><?php echo $this->item->adres; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_POSTCODE'); ?></th>
				<td><?php echo $this->item->postcode; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_PLAATS'); ?></th>
				<td><?php echo $this->item->plaats; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_LAND'); ?></th>
				<td><?php echo $this->item->land; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_LAT'); ?></th>
				<td><?php echo $this->item->lat; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_ADRES_FORM_LBL_ADRES_LON'); ?></th>
				<td><?php echo $this->item->lon; ?></td>
			</tr>
		</table>
	</div>
	<?php
else:
	echo JText::_('COM_ADRES_ITEM_NOT_LOADED');
endif;