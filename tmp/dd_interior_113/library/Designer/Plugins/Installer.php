<?php


class Designer_Plugins_Installer
{
    public function execute($params)
    {
        $template = $params['template'];
        $pluginName  = $params['plugin'];
        $fileName  = $params['fileName'];
        $pluginsFolder = JPATH_SITE . '/templates/' . $template . '/plugins/';

        if (version_compare(JVERSION, '3.0', '<')) {
            jimport('joomla.filesystem.archive');
            $ret = JArchive::extract($pluginsFolder . $fileName . '.zip', $pluginsFolder);
            if ($ret === false) {
                echo 'Could\'n extract the archive';
                return;
            }
        } else {
            jimport('joomla.filesystem.path');
            try {
                JArchive::extract($pluginsFolder . $fileName . '.zip', $pluginsFolder);
            } catch (Exception $e) {
                echo $e->getMessage();
                return;
            }
        }

        $app = JFactory::getApplication('administrator');

        // Load translations
        $lang = JLanguage::getInstance('en-GB');
        $lang->load('lib_joomla', JPATH_ADMINISTRATOR);
        $lang->load('com_installer', JPATH_BASE, null, false, true) ||
        $lang->load('com_installer', JPATH_COMPONENT, null, false, true);

        // Create token
        $session = JFactory::getSession();
        $token = $session::getFormToken();
        define('JPATH_COMPONENT', JPATH_BASE . '/components/com_installer');

        $pluginFolder = $pluginsFolder . $fileName;
        if (version_compare(JVERSION, '3.0', '<')) {
            JRequest::setVar('installtype', 'folder');
            JRequest::setVar('task', 'install.install');
            JRequest::setVar('install_directory', $pluginFolder);
            // Register the language object with JFactory
            JFactory::$language = $lang;
            JRequest::setVar($token, 1, 'post');
        } else {
            $app->input->set('installtype', 'folder');
            $app->input->set('task', 'install.install');
            $app->input->set('install_directory', $pluginFolder);
            // Register the language object with JFactory
            $app->loadLanguage($lang);
            JFactory::$language = $app->getLanguage();
            $app->input->post->set($token, 1);
        }
        // Execute installing
        $controller	= JControllerLegacy::getInstance('Installer');
        $controller->execute(JRequest::getCmd('task'));

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->update('#__extensions');
        $query->set('enabled=1');
        $query->where('type = ' . $db->quote('plugin'));
        $query->where('element = ' . $db->quote($pluginName));
        $db->setQuery($query);
        $db->query();

        jimport('joomla.filesystem.folder');
        JFolder::delete($pluginsFolder . '/' . $fileName);

        $messages = $app->getMessageQueue();
        $successMessage = JText::sprintf('COM_INSTALLER_INSTALL_SUCCESS', JText::_('COM_INSTALLER_TYPE_TYPE_PLUGIN'));
        if (count($messages) == 1 && $messages[0]['message'] == $successMessage) {
            echo 'ok';
        } else {
            $result = '';
            foreach($messages as $msg) {
                $result .= $msg['message'] . "\n";
            }
            echo $result;
        }
        return;
    }
}