<?php
/**
 * @package      Plazart
 *
 * @author       JoomlArt
 * @copyright    Copyright (C) 2012-2013. All rights reserved.
 * @license      http://www.gnu.org/licenses/gpl.html GNU/GPL, see LICENSE.txt
 */

defined('_JEXEC') or die();


class plgSystemPlazartInstallerScript
{
    /**
     * Called after any type of action
     *
     * @param     string              $route      Which action is happening (install|uninstall|discover_install)
     * @param     jadapterinstance    $adapter    The object responsible for running this script
     *
     * @return    boolean                         True on success
     */
    public function postflight($route, JAdapterInstance $adapter)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->update('#__extensions')->set("`enabled`='1'")->where("`type`='plugin'")->where("`folder`='system'")->where("`element`='plazart'");
        $db->setQuery($query);
        $db->query();
        return true;
    }
}
