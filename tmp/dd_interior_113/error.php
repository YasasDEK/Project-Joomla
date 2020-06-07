<?php
defined('_JEXEC') or die;
?>

<?php

$themeDir = dirname(__FILE__);

require_once $themeDir . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference:
$documentError = $this;
$document = JFactory::getDocument();

$document->head = "";
// Shortcut for template base url:
$document->templateUrl = $documentError->baseurl . '/templates/' .
    (isset($editorDir) ? $editorDir : $documentError->template);

$templatePath = $themeDir . '/templates/' . getCurrentTemplateByType('error404') . '.php';
if (file_exists($templatePath)) {
    include_once $templatePath;
} else {
    echo 'Template ' . $templatePath . ' not found';
}
?>
