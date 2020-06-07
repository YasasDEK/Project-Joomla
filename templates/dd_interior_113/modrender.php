<?php
defined('_JEXEC') or die;
?>

<?php

jimport( 'joomla.application.module.helper' );

$modulename = JRequest::getVar('modulename', '');
$module = JModuleHelper::getModule($modulename);

$attribs['style'] = 'drstyle';
$attribs['drstyle'] = JRequest::getVar('modulestyle', '');
$attribs['id'] = JRequest::getVar('moduleid', '');

echo JModuleHelper::renderModule( $module, $attribs );
?>
