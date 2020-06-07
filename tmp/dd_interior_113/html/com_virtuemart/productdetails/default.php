<?php
defined('_JEXEC') or die;
?>

<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';
?>
<?php
echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));

$defaultTmplFile = JPATH_ROOT . '/components/com_virtuemart/views/productdetails/tmpl/default.php';
$themeTmplFile = dirname(__FILE__) . '/default_template.php';
if (file_exists($themeTmplFile)) {
?>
<!--TEMPLATE <?php echo getCurrentTemplateByType('productoverview'); ?> /-->
<?php
    $jsContent = '';
    if (method_exists('vmJsApi', 'writeJS')) {
        $j = <<<EOF
var productOverview = jQuery('div[class*=\"productoverview\"]');
var selector = '';
if (productOverview.length && productOverview.eq(0).attr('class')) {
   selector = '.' + productOverview.eq(0)
       .attr('class')
       .split(' ')
       .find(function(el, i, array) {
            return el.indexOf('productoverview') !== -1
        });
}
Virtuemart.container = selector ? jQuery(selector) : '';
Virtuemart.containerSelector = selector || '';
EOF;
    vmJsApi::addJScript('ajaxContent', $j);
    $jsContent = vmJsApi::writeJS();
    }
    require_once $themeTmplFile;
} else if (file_exists($defaultTmplFile)) {
    require_once $defaultTmplFile;
}
?>
