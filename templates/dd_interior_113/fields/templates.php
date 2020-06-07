<?php

defined('JPATH_PLATFORM') or die;
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.form.formfield');

class JFormFieldTemplates extends JFormField
{
    protected $type = 'Templates';

    protected function getInput()
    {
        $table = JTable::getInstance('Style', 'TemplatesTable');
        $table->load(JRequest::getInt('id'));

        $themeDir = JPATH_SITE . '/templates/' . $table->template;
        include_once $themeDir . '/library/Designer/CustomModuleHelper.php';

        $kind = $this->getAttribute('kind');
        $templatesInfo = array();
        include $themeDir . '/templates/' . 'list.php';
        $options = array();
        $defaultName = '';
        foreach($templatesInfo as $name => $templateInfo) {
            if ($templateInfo['kind'] == $kind) {
                if ('false' == $templateInfo['isCustom']) {
                    array_unshift($options, JHtml::_('select.option', $name . ':' .$templateInfo['fileName'],
                        $templateInfo['defaultTemplateCaption']));
                    $defaultName = $name;
                }
                else {
                    $options[] = JHtml::_('select.option', $name . ':' .$templateInfo['fileName'],
                        $templateInfo['caption']);
                }
            }
        }
        $html = JHtml::_('select.genericlist', $options, $this->name, '', 'value', 'text',
            ($this->value ? $this->value : null), $this->id);
        ob_start();
?>
        <script>if ('undefined' != typeof jQuery) document._jQuery = jQuery;</script>
        <script src="<?php echo JURI::root() . 'templates/' . $table->template . '/jquery.js' ?>" type="text/javascript"></script>
        <script>jQuery.noConflict();</script>
        <script>
            jQuery(function ($) {
                var sampleDataField = $('#jform_params_sampleData'),
                    sampleData = sampleDataField.val(),
                    templatesType = '<?php echo $kind; ?>',
                    defaultTemplateName = '<?php echo $defaultName; ?>',
                    templatesObject = $('#<?php echo $this->id; ?>'),
                    templatesValue = templatesObject.val(),
                    inputObj = $('#jform_params_sample_<?php echo $kind; ?>'),
                    sampleDataObject = {};

                function getTemplateName(){
                    var val = templatesObject.val(),
                        parts = val.split(':');
                    return parts.length > 1 ? parts[0] : '<?php echo $defaultName; ?>';
                }
                if (inputObj.length) {
                    inputObj.change(function () {
                        var value = $(this).val(),
                            name = getTemplateName();

                        if (!sampleDataObject[templatesType])
                            sampleDataObject[templatesType] = {};

                        if (!sampleDataObject[templatesType][name])
                            sampleDataObject[templatesType][name] = {};

                        sampleDataObject[templatesType][name] = value;
                        sampleDataField.val(JSON.stringify(sampleDataObject));

                    });
                    templatesObject.change(function () {
                        var templatesValue = $(this).val(),
                            parts = templatesValue.split(':'),
                            name = getTemplateName();
                        if (sampleData) {
                            sampleDataObject = JSON.parse(sampleData);
                            if (sampleDataObject[templatesType] && sampleDataObject[templatesType][name] ) {
                                inputObj.val(sampleDataObject[templatesType][name]);
                            } else {
                                inputObj.val('');
                            }
                        }
                    });
                    templatesObject.change();
                }
            });
        </script>
        <script>if (document._jQuery) jQuery = document._jQuery;</script>
<?php
        echo $html;
        return ob_get_clean();
    }

    public function getAttribute($name, $default = '')
    {
        if ($this->element instanceof SimpleXMLElement)
        {
            $attributes = $this->element->attributes();

            // Ensure that the attribute exists
            if (property_exists($attributes, $name))
            {
                $value = $attributes->$name;

                if ($value !== null)
                {
                    return (string) $value;
                }
            }
        }

        return $default;
    }
}