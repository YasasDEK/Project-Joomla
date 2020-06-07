<?php

define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

define('JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))) . DS . 'administrator');

require_once dirname(dirname(__FILE__)) . DS . 'library' . DS . 'Designer.php';

require_once JPATH_BASE . DS . 'includes' . DS . 'defines.php';
require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';
require_once JPATH_BASE . DS . 'includes' . DS . 'helper.php';
$prefix = version_compare(JVERSION, '3.9', '>=') ? 'sub' : '';
require_once JPATH_BASE . DS . 'includes' . DS . $prefix . 'toolbar.php';

$app = JFactory::getApplication('administrator');

// checking user privileges
$user = JFactory::getUser();
$session = JFactory::getSession();
if (!(1 !== (integer)$user->guest && 'active' === $session->getState()))
    exit('Installing content requires administrator privileges.');

Designer::load('Designer_Plugins_Installer');

$installer = new Designer_Plugins_Installer();
echo $installer->execute($_GET);