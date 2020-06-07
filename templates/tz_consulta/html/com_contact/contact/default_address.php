<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * marker_class: Class based on the selection of text, none, or icons
 */
?>
<dl class="contact-address dl-horizontal" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
	<?php if (($this->params->get('address_check') > 0) &&
		($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>
        <div>
            <?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
                <span class="contact-head"><?php echo JText::_('COM_CONTACT_ADDRESS'); ?>:</span><br />
				<span class="contact-street" itemprop="streetAddress">
					<?php echo $this->contact->address .'&nbsp;'; ?>
				</span>
            <?php endif; ?>
            <?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>

				<span class="contact-suburb" itemprop="addressLocality">
					<?php echo $this->contact->suburb .'&nbsp;'; ?>
				</span>
            <?php endif; ?>
            <?php if ($this->contact->state && $this->params->get('show_state')) : ?>

				<span class="contact-state" itemprop="addressRegion">
					<?php echo $this->contact->state . '&nbsp;'; ?>
				</span>
            <?php endif; ?>
            <?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>

				<span class="contact-postcode" itemprop="postalCode">
					<?php echo $this->contact->postcode .'&nbsp;'; ?>
				</span>
            <?php endif; ?>
            <?php if ($this->contact->country && $this->params->get('show_country')) : ?>

                <span class="contact-country" itemprop="addressCountry">
                    <?php echo $this->contact->country .'&nbsp;'; ?>
                </span>
            <?php endif; ?>
        </div>
	<?php endif; ?>

<?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
    <div class="contact-emailto">
        <?php echo '<span class="contact-head">'.JText::_('COM_CONTACT_EMAIL_LABEL').'</span><br/>'.$this->contact->email_to; ?>
    </div>
<?php endif; ?>

<?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
    <div class="contact-telephone" itemprop="telephone">
        <?php echo '<span class="contact-head">'.JText::_('COM_CONTACT_TELEPHONE').'</span><br/>'.nl2br($this->contact->telephone); ?>
    </div>
<?php endif; ?>
<?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
    <div class="contact-fax" itemprop="faxNumber">
		<?php echo '<span class="contact-head">'.JText::_('COM_CONTACT_FAX').'</span><br/>'.nl2br($this->contact->fax); ?>
    </div>
<?php endif; ?>
<?php if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
    <div class="contact-mobile" itemprop="telephone">
        <?php echo '<span class="contact-head">'.JText::_('COM_CONTACT_MOBILE').'</span><br/>'.nl2br($this->contact->mobile); ?>
    </div>
<?php endif; ?>
<?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
    <div class="contact-webpage">
        <a href="<?php echo $this->contact->webpage; ?>" target="_blank" itemprop="url">
                <?php echo $this->contact->webpage; ?></a>
    </div>
<?php endif; ?>
</dl>
