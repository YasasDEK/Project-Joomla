<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'content',
		'addon_name'=>'sp_information',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_INFOR'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_INFOR_DESC'),
		'category'=>'Content',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),

				'title'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
					'std'=>  'Feature Box'
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
					'std'=>'h6',
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
					'std'=>array('md'=>16),
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

				'title_lineheight'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_LINE_HEIGHT'),
					'std'=>array('md'=>22),
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
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
					'std'=>'#2e2e2e',
					'depends'=>array(array('title', '!=', '')),
				),

				'title_margin_top'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
					'placeholder'=>'10',
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

				'title_margin_bottom'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
					'placeholder'=>'10',
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

                'separator_icon_options'=>array(
                    'type'=>'separator',
                    'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_ICON_OPTIONS')
                ),

				'icon_name'=>array(
					'type'=>'icon',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_ICON_NAME'),
					'std'=> 'fa-trophy'
				),

				'icon_size'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_ICON_SIZE'),
					'placeholder'=>16,
					'std'=>array('md'=>16),
					'responsive' => true,
					'max'=> 400,
				),

				'icon_color'=>array(
					'type'=>'color',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
					'std'=>'#2e2e2e'
				),

				'icon_margin_top'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_TOP'),
					'responsive' => true,
					'max'=> 400,
				),

				'icon_margin_bottom'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_MARGIN_BOTTOM'),
					'responsive' => true,
					'max'=> 400,
				),

				'icon_padding'=>array(
					'type'=>'padding',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_PADDING'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_PADDING_DESC'),
					'responsive' => true
				),

				'separator_addon_options'=>array(
					'type'=>'separator',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_ADDON_OPTIONS')
				),

				'text'=>array(
					'type'=>'editor',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT'),
					'std'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer adipiscing erat eget risus sollicitudin pellentesque et non erat. Maecenas nibh dolor, malesuada et bibendum a, sagittis accumsan ipsum.'
				),

                'text_color'=>array(
                    'type'=>'color',
                    'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_COLOR'),
                    'std'=>'#f4824c'
                ),

				'text_font_family'=>array(
					'type'=>'fonts',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CONTENT_FONT_FAMILY'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CONTENT_FONT_FAMILY_DESC'),
					'depends'=>array(array('text', '!=', '')),
					'selector'=> array(
						'type'=>'font',
						'font'=>'{{ VALUE }}',
						'css'=>'.sppb-addon-content .sppb-addon-text { font-family: {{ VALUE }}; }'
					)
				),

				'text_fontsize'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT_FONT_SIZE'),
					'std'=>'',
					'max'=>400,
					'responsive'=>true
				),

                'text_fontstyle'=>array(
                    'type'=>'fontstyle',
                    'title'=> JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE')
                ),

				'text_lineheight'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_CONTENT_LINE_HEIGHT'),
					'std'=>'',
					'max'=>400,
					'responsive'=>true
				),

				'alignment'=>array(
					'type'=>'select',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CONTENT_ALIGNMENT'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_CONTENT_ALIGNMENT'),
					'values'=>array(
						'sppb-text-left'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
						'sppb-text-center'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
						'sppb-text-right'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
					),
					'std'=>'sppb-text-left',
				),

				'class'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=>''
				),

			),
		),
	)
);
