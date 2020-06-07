<?php
defined('_JEXEC') or die;
?>

<?php

if (!defined('_DESIGNER_FUNCTIONS'))
  require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../functions.php');

function pagination_list_render($list)
{
	$activePaginator = $GLOBALS['theme_settings']['active_paginator'];
    if ('specific' === $activePaginator) {
        return $list;
    } else {
        return renderTemplateFromIncludes('pagination_list_render_' . $activePaginator, array($list),
            'common' == $activePaginator ? 'prototypes' : 'includes');
	} 
}
?>
