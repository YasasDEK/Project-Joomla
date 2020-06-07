<?php
defined('_JEXEC') or die;
?>

<?php
/**
 * Template for Joomla! CMS, created with Designer.
 * See readme.txt for more details on how to use the template.
 */

$themeDir = dirname(__FILE__);

require_once $themeDir . DIRECTORY_SEPARATOR . 'functions.php';
// Create alias for $this object reference:
$document = $this;
$document->head = "<jdoc:include type=\"head\" />";
// Shortcut for template base url:
$templateUrl = $document->baseurl . '/templates/' . (isset($editorDir) ? $editorDir : $document->template);
$document->templateUrl = $templateUrl;
Designer::load("Designer_Page");

// Initialize $view:
$this->view = new DesignerPage($this);
echo $this->view->renderTemplate($themeDir);
?>
