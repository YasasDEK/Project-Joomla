<?php
/** 
 *------------------------------------------------------------------------------
 * @package       Plazart Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/plazartfw
 * @Link:         http://plazart-framework.org 
 *------------------------------------------------------------------------------
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$javersion = new JVersion;

?>
	<script type="text/javascript">
		!function($){
			var JAFileConfig = window.JAFileConfig || {};

			JAFileConfig.profiles = <?php echo json_encode($jsonData)?>;
			JAFileConfig.mod_url = '<?php echo JURI::base(true) ?>/modules/<?php echo $module; ?>/helper.php';
			JAFileConfig.template = '<?php echo $template ?>';
			JAFileConfig.langs = <?php json_encode(array(
					'confirmCancel' => JText::_('ARE_YOUR_SURE_TO_CANCEL'),
					'enterName' => JText::_('ENTER_PROFILE_NAME'),
					'correctName' => JText::_('PROFILE_NAME_NOT_EMPTY'),
					'confirmDelete' => JText::_('CONFIRM_DELETE_PROFILE')
				)); ?>;
			
			$(window).on('load', function(){
				JAFileConfig.initialize('jformparams<?php echo str_replace('holder', '', $this->fieldname);?>');
				JAFileConfig.changeProfile($('jformparams<?php echo str_replace('holder', '', $this->fieldname);?>').val());
			});

		}(jQuery);
	</script>

	<div class="plazart-profile">
		<label class="hasTip" for="jform_params_<?php echo $this->field_name?>" id="jform_params_<?php echo $this->field_name?>-lbl" title="<?php echo JText::_($this->element['description'])?>"><?php echo JText::_($this->element["label"])?></label>
		<?php echo $profileHTML; ?>
		<div class="profile_action">
			<span class="clone">
				<a href="javascript:void(0)" onclick="JAFileConfig.cloneProfile()" title="<?php echo JText::_('CLONE_DESC')?>"><?php echo JText::_('Clone')?></a>
			</span>
			| 
			<span class="delete">
				<a href="javascript:void(0)" onclick="JAFileConfig.deleteProfile()" title="<?php echo JText::_('DELETE_DESC')?>"><?php echo JText::_('Delete')?></a>
			</span>	
		</div>
	</div>

<?php if($javersion->isCompatible('3.0')) : ?>
	</div>
</div>
<?php else : ?>
</li>
<?php endif; ?>

<?php		
$fieldSets = $plazartform->getFieldsets('params');

foreach ($fieldSets as $name => $fieldSet) :
	if (isset($fieldSet->description) && trim($fieldSet->description)){
		echo '<p class="tip">'.JText::_($fieldSet->description).'</p>';
	}
	
	$hidden_fields = '';
	foreach ($plazartform->getFieldset($name) as $field) :
		if (!$field->hidden) :
			if($javersion->isCompatible('3.0')) : ?>
		<div class="control-group plazart-control-group">
			<div class="control-label plazart-control-label">
			<?php else: ?> 
		<li>
			<?php endif;
				echo $plazartform->getLabel($field->fieldname,$field->group);
			
				if($javersion->isCompatible('3.0')) : ?>
			</div>
			<div class="controls plazart-controls">
				<?php endif;
				echo $plazartform->getInput($field->fieldname,$field->group);
				if($javersion->isCompatible('3.0')) : ?>
			</div>
		</div>
			<?php else: ?> 
		</li>
			<?php endif;
		else : 
			$hidden_fields .= $plazartform->getInput($field->fieldname,$field->group);	
		endif;
	endforeach;
	echo $hidden_fields; 
endforeach; 
?>	
	
<?php 
	if($javersion->isCompatible('3.0')) : ?>
		<div class="control-group plazart-control-group hide">
			<div class="control-label plazart-control-label"></div>
				<div class="controls plazart-controls">
	<?php else: ?> 
		<li>
	<?php endif; ?>
		<script type="text/javascript">
			// <![CDATA[ 
			window.addEvent('load', function(){
				Joomla.submitbutton = function(task){
					if (task == 'module.cancel' || document.formvalidator.isValid(document.id('module-form'))) {	
						if(task != 'module.cancel' && document.formvalidator.isValid(document.id('module-form'))){
							JAFileConfig.saveProfile(task);
						}else if(task == 'module.cancel' || document.formvalidator.isValid(document.id('module-form'))){
							Joomla.submitform(task, document.getElementById('module-form'));
						}
						if (self != top) {
							window.top.setTimeout('window.parent.SqueezeBox.close()', 1000);
						}
					} else {
						alert('Invalid form');
					}
				}
			});
			// ]]> 
		</script>
