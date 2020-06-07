<?php

defined('JPATH_PLATFORM') or die;
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

jimport('joomla.form.formfield');

class JFormFieldMenus extends JFormField
{
    protected $type = 'Menus';

    protected function getInput()
    {
        $table = JTable::getInstance('Style', 'TemplatesTable');
        $table->load(JRequest::getInt('id'));

        $themeDir = JPATH_SITE . '/templates/' . $table->template;

        $options = array(
            JHtml::_('select.option', '-1', 'Select Menu Item'),
        );

        $pathToManifest = $themeDir . '/templateDetails.xml';
        if (file_exists($pathToManifest)) {
            $menuModules = array();
            $xml = simplexml_load_file($pathToManifest);
            if (isset($xml->positions[0])) {
                foreach ($xml->positions[0] as $position) {
                    jimport('joomla.application.module.helper');
                    $modules = $this->_getMenuModulesByPosition($position);
                    foreach ($modules as $mod) {
                        $menuModules[] = $mod;
                    }
                }
            }
            foreach($menuModules as $module) {

                $registry = new JRegistry();
                $registry->loadString($module->params);
                $params = $registry->toArray();
                if (count($params) < 1)
                    continue;
                $optGroupTitle = $this->_getMenuTitle($params['menutype']) . ' - ' . $module->position;
                $list = $this->_getItems($params['menutype']);

                $options[] = JHtml::_('select.optgroup', $optGroupTitle);
                foreach($list as $item)
                    $options[] = JHtml::_('select.option', $item->id, $item->title);
                $options[] = JHtml::_('select.optgroup', $optGroupTitle);
            }
        }
        $html = JHtml::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value, $this->id);
        ob_start();
        echo $html;
        ?>
        <script>if ('undefined' != typeof jQuery) document._jQuery = jQuery;</script>
        <script src="<?php echo JURI::root() . 'templates/' . $table->template . '/jquery.js' ?>" type="text/javascript"></script>
        <script>jQuery.noConflict();</script>
        <script>
            jQuery(function ($) {
                var modulesObj = $('#<?php echo $this->id; ?>'),
                    menusOptions = $('#jform_params_menusOptions'),
                    megamenuopt = $('#jform_params_megamenu'),
                    modemenuopt = $('#jform_params_modemenu'),
                    customvalueopt = $('#jform_params_customvalue'),
                    megadesktopsopt = $('#jform_params_megadesktops'),
                    megalaptopsopt = $('#jform_params_megalaptops'),
                    megatabletsopt = $('#jform_params_megatablets'),
                    megaphonesopt = $('#jform_params_megaphones'),

                    list = [modulesObj, megamenuopt, modemenuopt, customvalueopt, megadesktopsopt, megalaptopsopt, megatabletsopt, megaphonesopt],
                    storage = {};

                $.each(list, function(index, object) {
                    object.show();
                    $('#' + object.attr('id') + '_chzn').hide();
                });

                function customValue(mode) {
                    var selector = '#jform_params_customvalue';
                    if (!mode) mode = 'sheet';
                    if (mode == 'custom') {
                        $(selector).show();
                        $(selector + '-lbl').show();
                    } else {
                        $(selector).hide();
                        $(selector + '-lbl').hide();
                    }

                }

                function toObject(str) {
                    return JSON.parse(atob(str));
                }

                function toString(obj) {
                    return btoa(JSON.stringify(obj));
                }

                function save(storage) {
                    menusOptions.val(toString(storage));
                }

                if (menusOptions.val()) {
                    storage = toObject(menusOptions.val());
                }

                modulesObj.change(function () {
                    var value = $(this).val(),
                        defaults = { megamenuopt : '1', mode : '', value : '', desktops : '', laptops : '', tablets : '', phones : ''},
                        options = $.extend({}, defaults, storage[value]);
                    if (options) {
                        megamenuopt.val(options.megamenuopt);
                        modemenuopt.val(options.mode);
                        customvalueopt.val(options.value);
                        customValue(options.mode);

                        megadesktopsopt.val(options.desktops);
                        megalaptopsopt.val(options.laptops);
                        megatabletsopt.val(options.tablets);
                        megaphonesopt.val(options.phones);
                    }
                    storage[value] = options;
                    save(storage);
                });

                megamenuopt.change(function () {
                    storage[modulesObj.val()].megamenuopt = megamenuopt.val();
                    save(storage);
                });
                modemenuopt.change(function () {
                    var mode = modemenuopt.val();
                    storage[modulesObj.val()].mode = mode;
                    save(storage);
                    customValue(mode);
                });
                customvalueopt.change(function () {
                    storage[modulesObj.val()].value = customvalueopt.val();
                    save(storage);
                });

                megadesktopsopt.change(function () {
                    storage[modulesObj.val()].desktops = megadesktopsopt.val();
                    save(storage);
                });
                megalaptopsopt.change(function () {
                    storage[modulesObj.val()].laptops = megalaptopsopt.val();
                    save(storage);
                });
                megatabletsopt.change(function () {
                    storage[modulesObj.val()].tablets = megatabletsopt.val();
                    save(storage);
                });
                megaphonesopt.change(function () {
                    storage[modulesObj.val()].phones = megaphonesopt.val();
                    save(storage);
                });
                modulesObj.change();
            });
        </script>
        <script>if (document._jQuery) jQuery = document._jQuery;</script>
        <?php
        return ob_get_clean();
    }

    private function _getMenuModulesByPosition($position)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__modules'))
            ->where('position = ' . $db->quote($position))
            ->where('module = ' . $db->quote('mod_menu'))
            ->where('client_id = 0');
        $db->setQuery($query);
        return $db->loadObjectList();
    }

    private function _getMenuTitle($menutype)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('title')
            ->from('#__menu_types')
            ->where('menutype = ' . $db->quote($menutype));
        $db->setQuery($query);
        return $db->loadResult();
    }

    private function _getItems($menutype)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('*')
            ->from('#__menu')
            ->where('menutype = ' . $db->quote($menutype))
            ->where('level = 1');
        $db->setQuery($query);
        return $db->loadObjectList();
    }
}