<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');

$regex = '@class="([^"]*)"@';
$lbreg = '@" class="([^"]*)"@';
$label = 'class="$1 col-sm-2 control-label"';
$input = 'class="$1 form-control"';

$phreg = '@name="(.*?)"@';
$prmatch = '@data-content="(.*?)"@';

// Contact Name
preg_match($prmatch, $this->form->getLabel('contact_name'), $match);
$phrep = 'name="$1" placeholder="'.$match[1].'"';
$input_name =   preg_replace($regex, $input, $this->form->getInput('contact_name'));
$input_name =   preg_replace($phreg, $phrep, $input_name);

// Contact Name
preg_match($prmatch, $this->form->getLabel('contact_email'), $match);
$phrep = 'name="$1" placeholder="'.$match[1].'"';
$input_email =   preg_replace($regex, $input, $this->form->getInput('contact_email'));
$input_email =   preg_replace($phreg, $phrep, $input_email);

// Contact Name
preg_match($prmatch, $this->form->getLabel('contact_subject'), $match);
$phrep = 'name="$1" placeholder="'.$match[1].'"';
$input_subject =   preg_replace($regex, $input, $this->form->getInput('contact_subject'));
$input_subject =   preg_replace($phreg, $phrep, $input_subject);

// Contact Name
preg_match($prmatch, $this->form->getLabel('contact_message'), $match);
$phrep = 'name="$1" placeholder="'.$match[1].'"';
$input_message =   preg_replace($regex, $input, $this->form->getInput('contact_message'));
$input_message =   preg_replace($phreg, $phrep, $input_message);

if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
		<div>
			<p><?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?></p>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo $input_name; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo $input_email; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo $input_subject; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<?php echo $input_message; ?>
				</div>
			</div>
			<?php if ($this->params->get('show_email_copy')) { ?>
				<div class="form-group">
					<div class="col-sm-12">
                        <?php echo $this->form->getInput('contact_email_copy'); ?>
                        <?php echo $this->form->getLabel('contact_email_copy'); ?>
					</div>
				</div>
			<?php } ?>
			<?php //Dynamically load any additional fields from plugins. ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
				<?php if ($fieldset->name != 'contact'):?>
					<?php $fields = $this->form->getFieldset($fieldset->name);?>
					<?php foreach ($fields as $field) : ?>
						<div class="form-group">
							<?php if ($field->hidden) : ?>
								<?php echo $field->input;?>
							<?php else:?>
								<?php echo preg_replace($lbreg, '" ' . $label, $field->label); ?>
								<div class="col-sm-10">
								<?php if (!$field->required && $field->type != "Spacer") : ?>
									<span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
								<?php endif; ?>
								<?php echo $field->input;?>
								</div>
							<?php endif;?>
						</div>
					<?php endforeach;?>
				<?php endif ?>
			<?php endforeach;?>
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-success validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
				</div>
				
				<input type="hidden" name="option" value="com_contact" />
				<input type="hidden" name="task" value="contact.submit" />
				<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
				<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</form>
</div>
