<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

if ($this->params->get('presentation_style')=='sliders'):?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#slide-contact" href="#display-links">
			<?php echo JText::_('COM_CONTACT_LINKS');?>
			</a>
		</h4>
	</div>
	<div id="display-links" class="panel-collapse collapse">
		<div class="panel-body">
<?php endif; ?>
<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
<div id="display-links" class="tab-pane">
<?php endif; ?>
<?php if  ($this->params->get('presentation_style')=='plain'):?>
<?php echo '<h3>'. JText::_('COM_CONTACT_LINKS').'</h3>'; ?>
<?php endif; ?>

			<div class="contact-links">
				<ul class="nav nav-stacked">
					<?php
					foreach (range('a', 'e') as $char) :// letters 'a' to 'e'
						$link = $this->contact->params->get('link'.$char);
						$label = $this->contact->params->get('link'.$char.'_name');

						if (!$link) :
							continue;
						endif;

						// Add 'http://' if not present
						$link = (0 === strpos($link, 'http')) ? $link : 'http://'.$link;

						// If no label is present, take the link
						$label = ($label) ? $label : $link;
						?>
						<li>
							<a href="<?php echo $link; ?>">
								<?php echo $label; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

<?php if ($this->params->get('presentation_style')=='sliders'):?>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
</div>
<?php endif; ?>
