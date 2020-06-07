<?php
$menutype = 'horizontal';
$tag_id = ($params->get('tag_id') != NULL) ? ' id="' . $params->get('tag_id') . '"' : '';
$itemLI = '<li class="">';
$optLevels = 'expand on hover';
$optResponsiveLevels = 'expand on hover';

$showAll = true;
if ('one level' === $optLevels && 'one level' === $optResponsiveLevels) {
	$showAll = false;
}

$start = $params->get('startLevel');

$megamenuClass = '';
$megamenuSubCatItemClass = 'bd-sub-item bd-mega-item  bd-menuitem-76';

$popupWidth = 'sheet';
$popupCustomWidth = '600';

ob_start();
?>
<div class="bd-menu-25  bd-no-margins bd-mega-grid bd-grid-16">
    <div class="container-fluid">
        <div class="separated-grid row">
<?php
$megaMenuLayoutStart = ob_get_clean();
$megaMenuTags = false;
ob_start();
?>
        </div>
    </div>
</div>
<?php
$megaMenuLayoutEnd = ob_get_clean();

ob_start();
?>
<div class="bd-menuitem-74 bd-sub-item bd-mega-item  bd-menuitem-75 separated-item-18">
    <div class="bd-griditem-18 bd-grid-item">
<?php
$megaMenuSubLayoutStart = ob_get_clean();

ob_start();
?>
    </div>
</div>
<?php
$megaMenuSubLayoutEnd = ob_get_clean();

$params = JFactory::getApplication()->getTemplate(true)->params;
$menusOptions = json_decode(base64_decode($params->get('menusOptions', '')), true);

$columns = array(
    'lg' => '',
    'md' => '',
    'sm' => '',
    'xs' => '',
);
$responsive = 'xs';

foreach($list as $key => $item)
{
    if (property_exists($item, 'megaclass'))
        continue;
    $list[$key]->megaclass = '';
    if ($megamenuClass && 3 == $item->level) {
        $i = 1;
        while($list[$key - $i]->level != 1)
            $i++;
        if ($menusOptions !== null && array_key_exists($list[$key - $i]->id, $menusOptions) && $menusOptions[$list[$key - $i]->id]['megamenuopt'] == '0')
            continue;
        $itemThemeOptions = $menusOptions && array_key_exists($list[$key - $i]->id, $menusOptions) ? $menusOptions[$list[$key - $i]->id] : '';
        //second level items
        $countSecondItems = 0;
        $i = 1;
        while($list[$key - $i]->level != 1) {
            if ($list[$key - $i]->level == 2)
                $countSecondItems++;
            $i++;
        }
        $i = 1;
        while(isset($list[$key + $i]) && $list[$key + $i]->level != 1) {
            if ($list[$key + $i]->level == 2)
                $countSecondItems++;
            $i++;
        }

        // third level items
        $i = 0;
        while(isset($list[$key + $i]) && $list[$key + $i]->level != 1) {
            if ($list[$key + $i]->level == 3)
                $list[$key + $i]->megaclass = $megamenuSubCatItemClass;
            if ($list[$key + $i]->level == 2) {
                $list[$key + $i]->megaclass = getColumnsClass($columns, $responsive, $itemThemeOptions, $countSecondItems);
            }
            $i++;
        }

        $i = 1;
        while($list[$key - $i]->level != 1) {
            if ($list[$key - $i]->level != 2) {
                $i++;
                continue;
            }
            $list[$key - $i]->megaclass .= getColumnsClass($columns, $responsive, $itemThemeOptions, $countSecondItems);
            $i++;
        }

        // first level item
        $list[$key - $i]->megaclass = $megamenuClass;
        if (isset($menusOptions[$list[$key - $i]->id]) && !empty($menusOptions[$list[$key - $i]->id]['mode'])) {
            $mode = $menusOptions[$list[$key - $i]->id]['mode'];
            $widthValue = $mode == 'custom' ? $menusOptions[$list[$key - $i]->id]['value'] : '';
        } else {
            $mode = $popupWidth;
            $widthValue = $mode == 'custom' ? $popupCustomWidth : '';
        }
        $list[$key - $i]->megawidth = $mode;
        $list[$key - $i]->megawidthvalue = $widthValue;

        continue;
    }
}

// true - skip the current node, false - render the current node.
$skip = false;
?>
<div class=" bd-horizontalmenu-11 clearfix">
    <div class="bd-container-inner">
        
            <div class=" bd-container-179 bd-tagstyles">
    
    <?php
echo <<<'CUSTOM_CODE'

CUSTOM_CODE;
?>
 </div>
        <?php
$mIconClassName = '';
ob_start();
?>
<li class=" bd-menuitem-73 bd-toplevel-item {submenu_icon_only}">
<?php 
$menuStartItem = ob_get_clean();
ob_start();
?>

<ul class=" bd-menu-24 nav navbar-left nav-pills<?php echo $class_sfx;?>" <?php echo $tag_id; ?>>
<?php
$bHMenu = ob_get_clean();
$eHMenu = "</ul>";
?>
        <?php echo $bHMenu; ?>
        <?php foreach ($list as $i => & $item) : ?>
            <?php
    if ($item->level == $start) {
        $itemLI = str_replace('{submenu_icon_only}', $item->deeper == true ? 'bd-submenu-icon-only' : '', $menuStartItem);
    }
    if ($skip) {
        if ($item->shallower) {
            if (($item->level - $item->level_diff) <= $limit) {
                if ($megaMenuTags) {
                    echo '</li>' . str_repeat('</ul></div></li>', $limit - $item->level + ($item->level_diff - 1));
                    echo $megaMenuLayoutEnd;
                    echo '</div></li>';
                    $megaMenuTags = false;
                } else {
                    echo '</li>' . str_repeat('</ul></div></li>', $item->level_diff);
                }
                $skip = false;
            }
        }
        continue;
    }

    $class = 'item-' . $item->id;
    $class .= ' ' . $item->megaclass;
    $class .= $item->id == $active_id ? ' current' : '';
    $class .= ('alias' == $item->type
        && in_array($item->params->get('aliasoptions'), $path)
        || in_array($item->id, $path)) ? '' : '';
    $class .= $item->deeper ? ' deeper' : '';
    $class .= $item->parent ? ' parent' : '';

    $additionalAttrs = '';
    if (property_exists($item, 'megawidth'))
        $additionalAttrs = ' data-mega-width="' . $item->megawidth . '"';
    if (property_exists($item, 'megawidthvalue') && $item->megawidthvalue)
        $additionalAttrs .= ' data-mega-width-value="' . $item->megawidthvalue . '"';
    ?>    
    <?php
$subIconClassName = '';
ob_start();
?>
<li class=" bd-menuitem-74 bd-sub-item">
<?php $subMenuStartItem = ob_get_clean(); ?>
    <?php
    $iconClassName = 1 == $item->level ? $mIconClassName : $subIconClassName;
    echo preg_replace('/class\s*=\s*[\'"]{1}([^\'^"]*)[\'"]{1}/', 'class="$1 ' . $class . '"' . $additionalAttrs, ($megaMenuTags && $item->level == 2 ? $megaMenuSubLayoutStart : $itemLI), 1);
    // Render the menu item.
    switch ($item->type) {
        case 'separator':
        case 'url':
        case 'component':
            require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
            break;
        default:
            require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
            break;
    }
    if ($item->deeper) {
        if (!$showAll) {
            $limit = $item->level;
            $skip = true;
            continue;
        }
        $itemLI = $subMenuStartItem;
        ?>
        <div class="bd-menu-25-popup<?php echo $item->megaclass && $item->level == 2 ? ' bd-megamenu-popup' : ''; ?>">
            <?php if ($item->megaclass && $item->level == 1) : ?>
                <?php $megaMenuTags = true; ?>
                <?php echo $megaMenuLayoutStart; ?>
            <?php else : ?>
                <ul class=" bd-menu-25  bd-no-margins">
            <?php endif; ?>
        <?php
    }
    elseif ($item->shallower){
        if ($megaMenuTags) {
            if ($item->level_diff + 1 == $item->level) {
                if ($item->level > 2) {
                    echo '</li>' . str_repeat('</ul></div></li>', $item->level_diff - 2);
                    echo '</ul></div>';
                }
                echo $megaMenuSubLayoutEnd;
                echo $megaMenuLayoutEnd;
                echo '</div></li>';
                $megaMenuTags = false;
            } else {
                if ($item->level == $item->level_diff + 2) {
                    if ($item->level == 3) {
                        echo '</li>';
                    } else {
                        echo '</li>' . str_repeat('</ul></div></li>', $item->level_diff - 1);
                    }
                    echo '</ul></div>' . $megaMenuSubLayoutEnd;
                } else {
                    echo '</li>' . str_repeat('</ul></div></li>', $item->level_diff);
                }
            }
        } else {
            echo '</li>' . str_repeat('</ul></div></li>', $item->level_diff);
        }
    } else {
        if ($megaMenuTags && $item->level == 2)
            echo $megaMenuSubLayoutEnd;
        else
            echo '</li>';
    }
 ?>
        <?php endforeach; ?>
        <?php echo $eHMenu; ?>
        
            <div class=" bd-container-180 bd-tagstyles">
    
    <?php
echo <<<'CUSTOM_CODE'

CUSTOM_CODE;
?>
 </div>
    </div>
</div>