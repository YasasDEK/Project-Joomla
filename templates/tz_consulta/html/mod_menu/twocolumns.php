<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.

$is_navbar = strpos(' ' . $class_sfx . ' ', ' navbar-nav ') !== false;
?>
<ul class="nav <?php echo ($is_navbar ? '' : ' nav-pills nav-stacked '),  $class_sfx;?>"<?php
$tag = '';
if ($params->get('tag_id') != null)
{
    $tag = $params->get('tag_id').'';
    echo ' id="'.$tag.'"';
}
?>>
    <?php
    if (is_array($list)) :
        foreach ($list as $i => &$item) :
            $class = 'item-'.$item->id;
            if ($item->id == $active_id) {
                $class .= ' current';
            }

            if (in_array($item->id, $path)) {
                $class .= ' active';
            }
            elseif ($item->type == 'alias') {
                $aliasToId = $item->params->get('aliasoptions');
                if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
                    $class .= ' active';
                }
                elseif (in_array($aliasToId, $path)) {
                    $class .= ' alias-parent-active';
                }
            }

            if ($item->type == 'separator') {
                $class .= ' divider';
            }

            if ($item->deeper) {
                if ($item->level > 1){
                    $class .= ' dropdown-submenu';
                } else {
                    $class .= ' deeper dropdown';
                }
            }

            if ($item->parent) {
                $class .= ' parent';
            }

            if (!empty($class)) {
                $class = ' class="'.trim($class) .'"';
            }

            echo '<li'.$class.'>';

            // Render the menu item.
            switch ($item->type) :
                case 'separator':
                case 'url':
                case 'component':
                case 'heading':
                    require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
                    break;

                default:
                    require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
                    break;
            endswitch;

            // The next item is deeper.
            if ($item->deeper) {
                echo '<ul class="dropdown-menu">';
            }
            // The next item is shallower.
            elseif ($item->shallower) {
                echo '</li>';
                echo str_repeat('</ul></li>', $item->level_diff);
            }
            // The next item is on the same level.
            else {
                echo '</li>';
            }
        endforeach;
    endif;
    ?></ul>
