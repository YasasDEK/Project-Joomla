<?php

defined('JPATH_PLATFORM') or die;
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.form.formfield');

class JFormFieldImport extends JFormField
{
    protected $type = 'Import';

    protected function getInput()
    {
        $table = JTable::getInstance('Style', 'TemplatesTable');
        $table->load(JRequest::getInt('id'));

        $themeName = $table->template;
        $themeDir = JPATH_SITE . '/templates/' . $themeName;

        $contentZipFile = JPATH_SITE . '/templates/' . $themeName . '/data/content.json';
        $zipExists = file_exists($contentZipFile ) ? 1 : 0;

        ob_start();
        ?>
        <script>if ('undefined' != typeof jQuery) document._jQuery = jQuery;</script>
        <script src="<?php echo JURI::root() . 'templates/' . $table->template . '/jquery.js' ?>" type="text/javascript"></script>
        <script>jQuery.noConflict();</script>
        <script>
            jQuery(function ($) {
                var importBtn = $('#<?php echo $this->id; ?>'),
                    lblImportBtn = $('#<?php echo $this->id; ?>-lbl'),
                    loc = window.location,
                    path = loc.pathname.replace('/administrator/index.php' , ''),
                    importPath = loc.protocol + '//' + loc.host + path + '/templates/' +  '<?php echo $themeName; ?>' + '/data',
                    replaceStatus = true,
                    zipExists = '<?php echo $zipExists; ?>';

                if (zipExists == '0') {
                    importBtn.hide();
                    lblImportBtn.hide();
                }

                importBtn.attr("disabled", false);

                function log(msg, color) {
                    $('#logImport').append($('<div></div>').text(msg).css('color', color));
                    importBtn.removeAttr("disabled");
                }

                importBtn.click(function (event) {
                    event.preventDefault();
                    $('#logImport').html('');
                    importBtn.attr("disabled", true);
                    $.ajax({
                        url : importPath + '/install.php',
                        data : { 'template' : '<?php echo $themeName;?>', 'replaceContent' : replaceStatus },
                        dataType : 'text',
                        success : function (data) {
                            if (data.match(/^result:/)) {
                                log(data.substring('result:'.length));
                            } else if (data.match(/^error:/)) {
                                log(data.split(':').pop(), 'red');
                            } else {
                                log(data, 'red');
                            }
                        },
                        error : function (xhr, textStatus, errorThrown) {
                            log('Request failed: ' + xhr.status, 'red');
                        }
                    });
                });
            });
        </script>
        <script>if (document._jQuery) jQuery = document._jQuery;</script>
        <button type="button" name="<?php echo $this->name; ?>"
                id="<?php echo $this->id; ?>" disabled><?php echo JText::_('TPL_IMPORTCONTENT_TEXT'); ?></button>
        <div id="logImport" style="color: #2762A4; float:left;width:100%;margin-top:5px"></div>
        <?php
        return ob_get_clean();
    }
}