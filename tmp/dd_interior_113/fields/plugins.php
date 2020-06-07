<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.form.formfield');

class JFormFieldPlugins extends JFormField
{
    protected $type = 'Plugins';

    protected function getInput()
    {
        // Initialize field attributes.
        $text   = $this->element['text'] ? $this->element['text'] : '';
        // Get a table instance.
        $table  = JTable::getInstance("Style", "TemplatesTable");
        // Attempt to load the row.
        $table->load(JRequest::getInt('id'));
        $themeName = $table->template;
        $result = $this->_checkPlugins($themeName);
		
		$canNotInstall = false == $result ? true : false;
        $installed = isset($result['installed']) ? $result['installed'] : false;
        $updated = isset($result['updated']) ? $result['updated'] : false;
        $enabled = isset($result['enabled']) ? $result['enabled'] : false;
		
        ob_start();
        ?>
        <script>if ('undefined' != typeof jQuery) document._jQuery = jQuery;</script>
        <script src="<?php echo JURI::root() . 'templates/' . $themeName . '/jquery.js' ?>" type="text/javascript"></script>
        <script>jQuery.noConflict();</script>
        <script>
            jQuery(function ($) {
                var btnSelector = '#<?php echo $this->id; ?>',
                    loc = window.location,
                    path = loc.pathname.replace('/administrator/index.php', '');
                    installPath = loc.protocol + '//' + loc.host + path + '/templates/' +  '<?php echo $themeName; ?>' + '/library',
                    installed = '<?php echo $installed ? '1' : '0'; ?>',
                    updated = '<?php echo $updated ? '1' : '0'; ?>',
                    enabled = '<?php echo $enabled ? '1' : '0'; ?>',
					canNotInstall = '<?php echo $canNotInstall ? '1' : '0'; ?>';

                if (canNotInstall == '0')
					$(btnSelector).removeAttr("disabled");

                function log(msg, color, enable) {
					if (typeof enable == 'undefined') 
						enable = true;
                    $('#log').append($('<div></div>').text(msg).css('color', color));
					if (enable)
						$(btnSelector).removeAttr("disabled");
                }
				
				if (canNotInstall == '0') {
					if (installed == '1') {
						var updateText = updated !== '1' ? '<?php echo JText::_("TPL_PLUGIN_NOTUPDATED"); ?>' : '';
						if (enabled == '1')
							log('<?php echo JText::_("TPL_PLUGIN_INSTALLED"); ?>' + ' ' + updateText);
						else
							log('<?php echo JText::_("TPL_PLUGIN_INSTALLED_BUT_DISABLED"); ?>' + ' ' + updateText);
					} else {
						log('<?php echo JText::_("TPL_PLUGIN_UNINSTALLED"); ?>', 'red');
					}
				} else {
					log('<?php echo JText::_("Content editor plugins can not be installed"); ?>', 'red', false);
				}

                function request(fileName, pluginName, callback) {
                    $.ajax({
                        url : installPath + '/installer.php',
                        data : { 'template' : '<?php echo $themeName;?>', 'plugin' : pluginName, 'fileName' :  fileName},
                        dataType : 'text',
                        success : function (data) {
                            callback(data);
                        },
                        error : function (xhr, textStatus, errorThrown) {
                            log('Request failed: ' + xhr.status, 'red');
                        }
                    });
                }

                function run() {
                    request('button', 'themlerbutton',function (data) {
                        if (data == 'ok') {
                            request('content', 'themlercontent', function (data) {
                                if (data == 'ok') {
                                    request('exportimport', 'themlerexportimport', function (data) {
                                        if (data == 'ok') {
                                            log('<?php echo JText::_("TPL_PLUGIN_INSTALLED"); ?>');
                                        } else {
                                            log(data, 'red');
                                        }
                                    });
                                } else {
                                    log(data, 'red');
                                }
                            });
                        } else {
                            log(data, 'red');
                        }
                    });
                }

                $(btnSelector).bind('click', function (event) {
                    $(btnSelector).attr("disabled", true);
                    event.preventDefault();
                    // Clear log container
                    $('#log').html('');
                    run();
                });
            });

        </script>
        <script>if (document._jQuery) jQuery = document._jQuery;</script>
        <button name="<?php echo $this->name; ?>"
                id="<?php echo $this->id; ?>" disabled>
            <?php echo JText::_($text); ?>
        </button>
        <div id="log" style="color: #2762A4; float:left;width:100%;margin-top:5px"></div>
        <?php return ob_get_clean();
    }

    private function _checkPlugins($template) {

        $pluginsFolder = JPATH_SITE . '/templates/' . $template . '/plugins/';
		if (!file_exists($pluginsFolder))
			return false;
        $plugins = array(array('button', 'themlerbutton'), array('content', 'themlercontent'),
            array('exportimport', 'themlerexportimport'));
        $installed = true;
        $updated = true;
        $enabled = true;
        foreach($plugins as $value) {
			$zipFile = $pluginsFolder . $value[0] . '.zip';
			if (!file_exists($zipFile))
				return false;
            if (version_compare(JVERSION, '3.0', '<')) {
                jimport('joomla.filesystem.archive');
                $ret = JArchive::extract($zipFile, $pluginsFolder);
                if ($ret === false) {
                    // to do
                }
            } else {
                jimport('joomla.filesystem.path');
                try {
                    JArchive::extract($zipFile, $pluginsFolder);
                } catch (Exception $e) {
                    // to do
                }
            }

            $db = JFactory::getDbo();
            $query = $db->getQuery(true)
                ->select('*')
                ->from($db->quoteName('#__extensions'))
                ->where('type = ' . $db->quote('plugin'))
                ->where('element = ' . $db->quote($value[1]));
            $db->setQuery($query);
            $result = $db->loadObject();
            if ($result) {
                $manifestObject = json_decode($result->manifest_cache);
                jimport('joomla.filesystem.file');
                $xml = simplexml_load_string(JFile::read($pluginsFolder . $value[0] . '/' . $value[1] . '.xml'));
                if (version_compare($manifestObject->version,  $xml->version) == -1)
                    $updated = false;
                else
                    $updated = $updated && true ? true : false;
                $installed = $installed && true ? true : false;
                $enabled = $enabled && ($result->enabled == '1') ? true : false;
            } else {
                $installed = false;
                $updated = false;
                $enabled = false;
            }
            jimport('joomla.filesystem.folder');
            JFolder::delete($pluginsFolder . $value[0]);
        }
        return array('installed' => $installed, 'updated' => $updated, 'enabled' => $enabled);
    }
}