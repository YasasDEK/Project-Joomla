<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonInformation extends SppagebuilderAddons {

	public function render() {
		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		//Options
		$icon_name = (isset($this->addon->settings->icon_name) && $this->addon->settings->icon_name) ? $this->addon->settings->icon_name : '';
		$text = (isset($this->addon->settings->text) && $this->addon->settings->text) ? $this->addon->settings->text : '';
		$alignment = (isset($this->addon->settings->alignment) && $this->addon->settings->alignment) ? $this->addon->settings->alignment : '';

		//Icon or Image
		$media = '';
        if($icon_name) {
            $media  .= '<div class="sppb-icon">';
            $media  .= '<span class="sppb-icon-container">';
            $media  .= '<i class="fa ' . $icon_name . '"></i>';
            $media  .= '</span>';
            $media  .= '</div>';
        }

		//Title
		$feature_title = '';
		if($title) {
			$heading_class = '';

            $heading_class = ' sppb-media-heading';

			$feature_title .= '<'.$heading_selector.' class="sppb-addon-title sppb-feature-box-title'. $heading_class .'">';
			$feature_title .= $title;
			$feature_title .= '</'.$heading_selector.'>';
		}

		//Feature Text
		$feature_text  = '<div class="sppb-addon-text">';
		$feature_text .= $text;
		$feature_text .= '</div>';

		//Output
		$output  = '<div class="sppb-addon sppb-addon-information ' . $alignment . ' ' . $class . '">';
		$output .= '<div class="sppb-addon-content">';

        if($media) {
            $output .= '<div class="sppb-media">';
            $output .= '<div class="spbd-icon-header">';
            $output .= $media;
            $output .= '<div class="sppb-media-title">';
            $output .= ($title) ? $feature_title : '';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '<div class="sppb-media-body">';
            $output .= $feature_text;
            $output .= '</div>';
            $output .= '</div>';
        }

		$output .= '</div>';
		$output .= '</div>';
		return $output;
	}

	public function css() {
		$addon_id = '#sppb-addon-' . $this->addon->id;
		$icon_color	= (isset($this->addon->settings->icon_color) && $this->addon->settings->icon_color) ? $this->addon->settings->icon_color : '';
		$icon_size = (isset($this->addon->settings->icon_size) && $this->addon->settings->icon_size) ? $this->addon->settings->icon_size : '';
		$icon_margin_top = (isset($this->addon->settings->icon_margin_top) && $this->addon->settings->icon_margin_top) ? $this->addon->settings->icon_margin_top : '';
		$icon_margin_top_sm = (isset($this->addon->settings->icon_margin_top_sm) && $this->addon->settings->icon_margin_top_sm) ? $this->addon->settings->icon_margin_top_sm : '';
		$icon_margin_top_xs = (isset($this->addon->settings->icon_margin_top_xs) && $this->addon->settings->icon_margin_top_xs) ? $this->addon->settings->icon_margin_top_xs : '';
		$icon_margin_bottom	= (isset($this->addon->settings->icon_margin_bottom) && $this->addon->settings->icon_margin_bottom) ? $this->addon->settings->icon_margin_bottom : '';
		$icon_margin_bottom_sm	= (isset($this->addon->settings->icon_margin_bottom_sm) && $this->addon->settings->icon_margin_bottom_sm) ? $this->addon->settings->icon_margin_bottom_sm : '';
		$icon_margin_bottom_xs	= (isset($this->addon->settings->icon_margin_bottom_xs) && $this->addon->settings->icon_margin_bottom_xs) ? $this->addon->settings->icon_margin_bottom_xs : '';
		$icon_padding = (isset($this->addon->settings->icon_padding) && $this->addon->settings->icon_padding) ? $this->addon->settings->icon_padding : '';
		$icon_name = (isset($this->addon->settings->icon_name) && $this->addon->settings->icon_name) ? $this->addon->settings->icon_name : '';

		$css = '';

        $css .= $addon_id . ' .spbd-icon-header {';
        $css .= 'line-height: 1;';
        $css .= '}';

        $css .= $addon_id . ' .spbd-icon-header > div {';
        $css .= 'display: inline-block;';
        $css .= '}';

        $css .= $addon_id . ' .spbd-icon-header > div.sppb-icon {';
        $css .= 'margin-right: 5px;line-height: 1;';
        $css .= '}';

		$text_style = 'line-height: 1;';
		$text_style_sm = '';
		$text_style_xs = '';

        $text_style .= (isset($this->addon->settings->text_fontstyle->weight) && $this->addon->settings->text_fontstyle->weight) ? "font-weight: " . $this->addon->settings->text_fontstyle->weight . ";" : "";
        $text_style .= (isset($this->addon->settings->text_fontstyle->underline) && $this->addon->settings->text_fontstyle->underline) ? "text-decoration: underline;" : "";
        $text_style .= (isset($this->addon->settings->text_fontstyle->italic) && $this->addon->settings->text_fontstyle->italic) ? "font-style: italic;" : "";
        $text_style .= (isset($this->addon->settings->text_fontstyle->uppercase) && $this->addon->settings->text_fontstyle->uppercase) ? "text-transform: uppercase;" : "";
        $text_style .= (isset($this->addon->settings->text_color) && $this->addon->settings->text_color) ? "color: " . $this->addon->settings->text_color . ";" : "";

		$text_style .= (isset($this->addon->settings->text_fontsize) && $this->addon->settings->text_fontsize) ? "font-size: " . $this->addon->settings->text_fontsize . "px;" : "";
		$text_style_sm .= (isset($this->addon->settings->text_fontsize_sm) && $this->addon->settings->text_fontsize_sm) ? "font-size: " . $this->addon->settings->text_fontsize_sm . "px;" : "";
		$text_style_xs .= (isset($this->addon->settings->text_fontsize_xs) && $this->addon->settings->text_fontsize_xs) ? "font-size: " . $this->addon->settings->text_fontsize_xs . "px;" : "";

		$text_style .= (isset($this->addon->settings->text_lineheight) && $this->addon->settings->text_lineheight) ? "line-height: " . $this->addon->settings->text_lineheight . "px;" : "";
		$text_style_sm .= (isset($this->addon->settings->text_lineheight_sm) && $this->addon->settings->text_lineheight_sm) ? "line-height: " . $this->addon->settings->text_lineheight_sm . "px;" : "";
		$text_style_xs .= (isset($this->addon->settings->text_lineheight_xs) && $this->addon->settings->text_lineheight_xs) ? "line-height: " . $this->addon->settings->text_lineheight_xs . "px;" : "";

		if($text_style) {
			$css .= $addon_id . ' .sppb-addon-text {';
			$css .= $text_style;
			$css .= '}';
		}

		if($text_style_sm) {
			$css .= '@media (min-width: 768px) and (max-width: 991px) {';
				$css .= $addon_id . ' .sppb-addon-text {';
				$css .= $text_style_sm;
				$css .= '}';
			$css .= '}';
		}

		if($text_style_xs) {
			$css .= '@media (max-width: 767px) {';
				$css .= $addon_id . ' .sppb-addon-text {';
				$css .= $text_style_xs;
				$css .= '}';
			$css .= '}';
		}
        if($icon_name) {
            $style = '';
            $style_sm = '';
            $style_xs = '';

            $style .= ($icon_margin_top) ? 'margin-top:' . (int) $icon_margin_top . 'px;' : '';
            $style_sm .= ($icon_margin_top_sm) ? 'margin-top:' . (int) $icon_margin_top_sm . 'px;' : '';
            $style_xs .= ($icon_margin_top_xs) ? 'margin-top:' . (int) $icon_margin_top_xs . 'px;' : '';

            $style .= ($icon_margin_bottom) ? 'margin-bottom:' . (int) $icon_margin_bottom . 'px;' : '';
            $style_sm .= ($icon_margin_bottom_sm) ? 'margin-bottom:' . (int) $icon_margin_bottom_sm . 'px;' : '';
            $style_xs .= ($icon_margin_bottom_xs) ? 'margin-bottom:' . (int) $icon_margin_bottom_xs . 'px;' : '';

            $icon_padding_md = '';
            $icon_paddings_md = explode(' ', $icon_padding);
            foreach($icon_paddings_md as $icon_padding_md_item){
                if(empty(trim($icon_padding_md_item))){
                    $icon_padding_md .= ' 0';
                } else {
                    $icon_padding_md .= ' '.$icon_padding_md_item;
                }

            }
            $style .= ($icon_padding_md) ? 'padding:' . $icon_padding_md . ';' : '';

            $icon_padding_sm = '';

            if(trim($icon_padding_sm) != ""){
                $icon_paddings_sm = explode(' ', $icon_padding_sm);
                foreach($icon_paddings_sm as $icon_padding_sm_item){
                    if(empty(trim($icon_padding_sm_item))){
                        $icon_padding_sm .= ' 0';
                    } else {
                        $icon_padding_sm .= ' '.$icon_padding_sm_item;
                    }

                }
            }

            $style_sm .= ($icon_padding_sm) ? 'padding:' . $icon_padding_sm . ';' : '';

            $icon_padding_xs = '';

            if(trim($icon_padding_xs) != ""){
                $icon_paddings_xs = explode(' ', $icon_padding_xs);
                foreach($icon_paddings_xs as $icon_padding_xs_item){
                    if(empty(trim($icon_padding_xs_item))){
                        $icon_padding_xs .= ' 0';
                    } else {
                        $icon_padding_xs .= ' '.$icon_padding_xs_item;
                    }

                }
            }

            $style_xs .= ($icon_padding_xs) ? 'padding:' . $icon_padding_xs . ';' : '';

            $style .= ($icon_color) ? 'color:' . $icon_color  . ';'.'border-color:' . $icon_color  . ';' : '';

            $font_size 	= (isset($icon_size) && $icon_size) ? 'font-size:' . (int) $icon_size . 'px;width:' . (int) $icon_size . 'px;height:' . (int) $icon_size . 'px;line-height:' . (int) $icon_size . 'px;' : '';
            $font_size_sm 	= (isset($icon_size_sm) && $icon_size_sm) ? 'font-size:' . (int) $icon_size_sm . 'px;width:' . (int) $icon_size_sm . 'px;height:' . (int) $icon_size_sm . 'px;line-height:' . (int) $icon_size_sm . 'px;' : '';
            $font_size_xs 	= (isset($icon_size_xs) && $icon_size_xs) ? 'font-size:' . (int) $icon_size_xs . 'px;width:' . (int) $icon_size_xs . 'px;height:' . (int) $icon_size_xs . 'px;line-height:' . (int) $icon_size_xs . 'px;' : '';



            if($style) {
                $css .= $addon_id . ' .sppb-icon .sppb-icon-container {';
                $css .= $style;
                $css .= '}';
            }

            if($font_size) {
                $css .= $addon_id . ' .sppb-icon .sppb-icon-container > i {';
                $css .= $font_size;
                $css .= '}';
            }

            if(!empty($style_sm) || !empty($font_size_sm)){
                $css .= '@media (min-width: 768px) and (max-width: 991px) {';
                if($style_sm) {
                    $css .= $addon_id . ' .sppb-icon .sppb-icon-container {';
                    $css .= $style_sm;
                    $css .= '}';
                }

                if($font_size_sm) {
                    $css .= $addon_id . ' .sppb-icon .sppb-icon-container > i {';
                    $css .= $font_size_sm;
                    $css .= '}';
                }
                $css .= '}';
            }

            if(!empty($style_xs) || !empty($font_size_xs)){
                $css .= '@media (max-width: 767px) {';
                if($style_xs) {
                    $css .= $addon_id . ' .sppb-icon .sppb-icon-container {';
                    $css .= $style_xs;
                    $css .= '}';
                }

                if($font_size_xs) {
                    $css .= $addon_id . ' .sppb-icon .sppb-icon-container > i {';
                    $css .= $font_size_xs;
                    $css .= '}';
                }
                $css .= '}';
            }
        }

		return $css;
	}

}
