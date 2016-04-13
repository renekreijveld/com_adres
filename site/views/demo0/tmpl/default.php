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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
?>

<form action="<?php echo JRoute::_('index.php?option=com_adres&view=demo0'); ?>" method="post" name="adminForm" id="adminForm">
	<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table table-striped" id="adresList">
		<thead>
			<tr>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_NAAM', 'a.naam', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_ADRES', 'a.adres', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_POSTCODE', 'a.postcode', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_PLAATS', 'a.plaats', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_ADRES_ADRESSEN_LAND', 'a.land', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<?php echo $item->id; ?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_adres&view=adres&id='.(int) $item->id); ?>">
						<?php echo $this->escape($item->naam); ?>
					</a>
				</td>
				<td>
					<?php echo $item->adres; ?>
				</td>
				<td>
					<?php echo $item->postcode; ?>
				</td>
				<td>
					<?php echo $item->plaats; ?>
				</td>
				<td>
					<?php echo $item->land; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>