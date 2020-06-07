<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

$params = JComponentHelper::getParams('com_sppagebuilder');
$gmap_api = $params->get('gmap_api', '');

$gmap_config = array(
	'admin_label'=>array(
		'type'=>'text',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
		'category'=>'General',
		'std'=> ''
	),

	// Title
	'title'=>array(
		'type'=>'text',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
		'std'=>  ''
	),

	'heading_selector'=>array(
		'type'=>'select',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
		'values'=>array(
			'h1'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
			'h2'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
			'h3'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
			'h4'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
			'h5'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
			'h6'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
		),
		'std'=>'h3',
		'depends'=>array(array('title', '!=', '')),
	),

	'title_font_family'=>array(
		'type'=>'fonts',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY_DESC'),
		'depends'=>array(array('title', '!=', '')),
		'selector'=> array(
			'type'=>'font',
			'font'=>'{{ VALUE }}',
			'css'=>'.sppb-addon-title { font-family: {{ VALUE }}; }'
		)
	),

	'title_fontsize'=>array(
		'type'=>'slider',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
		'std'=>'',
		'max'=>400,
		'responsive'=>true,
		'depends'=>array(array('title', '!=', '')),
	),

	'title_lineheight'=>array(
		'type'=>'slider',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_LINE_HEIGHT'),
		'std'=>'',
		'max'=>400,
		'responsive'=>true,
		'depends'=>array(array('title', '!=', '')),
	),

	'title_font_style'=>array(
		'type'=>'fontstyle',
		'title'=> JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE'),
		'depends'=>array(array('title', '!=', '')),
	),

	'title_letterspace'=>array(
		'type'=>'select',
		'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LETTER_SPACING'),
		'values'=>array(
			'0'=> 'Default',
			'1px'=> '1px',
			'2px'=> '2px',
			'3px'=> '3px',
			'4px'=> '4px',
			'5px'=> '5px',
			'6px'=>	'6px',
			'7px'=>	'7px',
			'8px'=>	'8px',
			'9px'=>	'9px',
			'10px'=> '10px'
		),
		'std'=>'0',
		'depends'=>array(array('title', '!=', '')),
	),

	'title_text_color'=>array(
		'type'=>'color',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
		'depends'=>array(array('title', '!=', '')),
	),

	'title_margin_top'=>array(
		'type'=>'slider',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
		'placeholder'=>'10',
		'max'=>400,
		'responsive'=>true,
		'depends'=>array(array('title', '!=', '')),
	),

	'title_margin_bottom'=>array(
		'type'=>'slider',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
		'placeholder'=>'10',
		'max'=>400,
		'responsive'=>true,
		'depends'=>array(array('title', '!=', '')),
	),

	// Map

	'separator_addon_options'=>array(
		'type'=>'separator',
		'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_ADDON_OPTIONS')
	)

);

if (empty($gmap_api)) {
	$gmap_config['message'] = array(
		'type'=>'message',
		'alert' => 'warning',
		'message' => JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_APIKEY_MISSING'),
	);
}

$gmap_config['map'] = array(
	'type'=>'gmap',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_LOCATION'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_LOCATION_DESC'),
	'std' => '23.755349,90.375961'
);

$gmap_config['infowindow'] = array(
	'type'=>'textarea',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_INFOWINDOW'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_INFOWINDOW_DESC'),
);

$gmap_config['height'] = array(
	'type'=>'slider',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_HEIGHT'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_HEIGHT_DESC'),
	'placeholder'=>'300',
	'std'=>array('md'=>300),
	'max'=>2000,
	'responsive'=>true,
	'depends'=>array(array('map', '!=', '')),
);

$gmap_config['type'] = array(
	'type'=>'select',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_TYPE'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_TYPE_DESC'),
	'values'=>array(
		'ROADMAP'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_TYPE_ROADMAP'),
		'SATELLITE'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_TYPE_SATELLITE'),
		'HYBRID'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_TYPE_HYBRID'),
		'TERRAIN'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_TYPE_TERRAIN'),
	),
	'std'=>'ROADMAP',
	'depends'=>array(array('map', '!=', '')),
);
$gmap_config['zoom'] = array(
	'type'=>'slider',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_ZOOM'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_ZOOM_DESC'),
	'placeholder'=>'18',
	'std'=>'18',
	'max'=>25,
	'depends'=>array(array('map', '!=', '')),
);
$gmap_config['mousescroll'] = array(
	'type'=>'select',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_DISABLE_MOUSE_SCROLL'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_DISABLE_MOUSE_SCROLL_DESC'),
	'values'=>array(
		'false'=>JText::_('JYES'),
		'true'=>JText::_('JNO'),
	),
	'std'=>'true',
	'depends'=>array(array('map', '!=', '')),
);

$gmap_config['icon'] = array(
    'type'=>'icon',
    'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
    'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
    'std'=>'fa-map',
);

$gmap_config['class'] = array(
	'type'=>'text',
	'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
	'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
	'std'=>''
);

SpAddonsConfig::addonConfig(
	array(
		'type'=>'content',
		'addon_name'=>'sp_gmap_button',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_BUTTON'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GMAP_DESC'),
		'attr'=>array(
			'general' => $gmap_config
		),
	)
);
