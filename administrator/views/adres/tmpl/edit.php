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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_adres/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {

	});

	Joomla.submitbutton = function (task) {
		if (task == 'adres.cancel') {
			Joomla.submitform(task, document.getElementById('adres-form'));
		}
		else {

			if (task != 'adres.cancel' && document.formvalidator.isValid(document.id('adres-form'))) {

				Joomla.submitform(task, document.getElementById('adres-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_adres&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adres-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_ADRES_TITLE_ADRES', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">
					<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
					<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
					<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
					<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
					<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

					<?php if(empty($this->item->created_by)){ ?>
						<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
					<?php }
					else{ ?>
						<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
					<?php } ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('naam'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('naam'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('adres'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('adres'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('postcode'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('postcode'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('plaats'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('plaats'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('land'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('land'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('lat'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('lat'); ?></div>
					</div>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('lon'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('lon'); ?></div>
					</div>

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>