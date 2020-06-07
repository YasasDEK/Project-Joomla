<?php
defined('_JEXEC') or die;
?>

<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';
?>
<?php
JHtml::_ ('behavior.formvalidation');
$document = JFactory::getDocument ();
$document->addScriptDeclaration ("
//<![CDATA[
	jQuery(document).ready(function($) {
	if ($('#STsameAsBTjs').is(':checked')) {
        $('#output-shipto-display').hide();
	} else {
		$('#output-shipto-display').show();
	}
    $('#STsameAsBTjs').click(function(event) {
        if($(this).is(':checked')){
            $('#STsameAsBT').val('1') ;
            $('#output-shipto-display').hide();
        } else {
            $('#STsameAsBT').val('0') ;
            $('#output-shipto-display').show();
        }
    });
});
//]]>
");
$document->addScriptDeclaration ("
//<![CDATA[
	jQuery(document).ready(function($) {
	    $('#checkoutFormSubmit').click(function(e){
            $(this).attr('disabled', 'true');
            var name = $(this).attr('name');
            $('#checkoutForm').append('<input name=\"' + name + '\" value=\"1\" type=\"hidden\">');
            $(this).fadeIn(400);
            $('#checkoutForm').submit();
        });
	});
//]]>
");

$defaultTmplFile = JPATH_ROOT . '/components/com_virtuemart/views/cart/tmpl/default.php';
$themeTmplFile = dirname(__FILE__) . '/default_template.php';
if (file_exists($themeTmplFile)) {
?>
<!--TEMPLATE <?php echo getCurrentTemplateByType('shoppingcart'); ?> /-->
<?php
    require_once $themeTmplFile;
} else if (file_exists($defaultTmplFile)) {
    require_once $defaultTmplFile;
}
?>
