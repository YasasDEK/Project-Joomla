<?php
defined('_JEXEC') or die;
?>
<?php /*BEGIN_EDITOR_OPEN*/
$app = JFactory::getApplication('site');
$templateName = $app->getTemplate();

$ret = false;
$templateDir = JPATH_THEMES . '/' . $templateName;
$editorClass = $templateDir . '/app/' . 'Editor.php';

if (!$app->isAdmin() && file_exists($editorClass)) {
    require_once $templateDir . '/app/' . 'Editor.php';
    $ret = DesignerEditor::override($templateName, __FILE__);
}

if ($ret) {
    $editorDir = $templateName . '/editor';
    require($ret);
    return;
} else {
/*BEGIN_EDITOR_CLOSE*/ ?>

<?php
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'functions.php';

$defaultTmplFile = JPATH_ROOT . '/modules/mod_virtuemart_product/tmpl/default.php';
$themeTmplFile = dirname(__FILE__) . '/default_template.php';
if (file_exists($themeTmplFile)) {
    include $themeTmplFile;
} else if (file_exists($defaultTmplFile)) {
    include $defaultTmplFile;
}
?>
<?php /*END_EDITOR_OPEN*/ } /*END_EDITOR_CLOSE*/ ?>