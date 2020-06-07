<?php
defined('_JEXEC') or die;
?>

<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';

Designer::load("Designer_Content");
$componentCurrentTemplate = getCurrentTemplateByType('blog');
?>
<!--TEMPLATE <?php echo $componentCurrentTemplate; ?> /-->
<?php
require_once 'blog_template.php';
?>
