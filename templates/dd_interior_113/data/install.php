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

$data = array_merge($_GET, $_POST);

function isThemlerExportImportPluginInstalled()
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true)
        ->select('*')
        ->from($db->quoteName('#__extensions'))
        ->where('type = ' . $db->quote('plugin'))
        ->where('element = ' . $db->quote('themlerexportimport'));
    $db->setQuery($query);
    $result = $db->loadObject();

    if ($result)
        return true;
    return false;
}
function outputResult($text, $status = 'result') {
    echo $status . ':' . $text;
    exit();
}

if (!isThemlerExportImportPluginInstalled()) {
    outputResult('Please install plugins from template', 'error');
} else {
    $importCoreFile = JPATH_PLUGINS . '/content/themlerexportimport/core/ImportCore.php';
    if (!file_exists($importCoreFile))
        outputResult('Please install plugins from template', 'error');

    $contentFolder = JPATH_SITE . '/templates/' . $data['template'] . '/data';
    $contentJsonFile = $contentFolder . '/content.json';

    if (!file_exists($contentJsonFile))
        outputResult('Content file not found', 'error');

    require_once $importCoreFile;
    $replaceContent = true;//isset($data['replaceContent']) ? ($data['replaceContent'] == 'false' ? false : true ): true;
    $core = new ImportCore(array(
        'replaceContent' => $replaceContent,
        'template' => $data['template'],
        'contentDir' => $contentFolder
    ));
    $result = $core->import();
    if ($result)
        outputResult('The sample data has bees successfully installed.');
    else
        outputResult($result, 'error');
}