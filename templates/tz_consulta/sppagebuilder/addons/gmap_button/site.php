<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonGmap_button extends SppagebuilderAddons {

	public function render() {

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		//Options
		$map = (isset($this->addon->settings->map) && $this->addon->settings->map) ? $this->addon->settings->map : '';
		$infowindow  = (isset($this->addon->settings->infowindow) && $this->addon->settings->infowindow) ? $this->addon->settings->infowindow : '';
		$gmap_api = (isset($this->addon->settings->gmap_api) && $this->addon->settings->gmap_api) ? $this->addon->settings->gmap_api : '';
		$type = (isset($this->addon->settings->type) && $this->addon->settings->type) ? $this->addon->settings->type : '';
		$zoom = (isset($this->addon->settings->zoom) && $this->addon->settings->zoom) ? $this->addon->settings->zoom : '';
		$mousescroll = (isset($this->addon->settings->mousescroll) && $this->addon->settings->mousescroll) ? $this->addon->settings->mousescroll : '';
		$icon = (isset($this->addon->settings->icon) && $this->addon->settings->icon) ? $this->addon->settings->icon : '';

		if($map) {
			$map = explode(',', $map);
			$output  = '<div id="sppb-addon-map-'. $this->addon->id .'" class="sppb-addon sppb-addon-gmap ' . $class . '" style="display: none;">';
			$output .= ($title) ? '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>' : '';
			$output .= '<div class="sppb-addon-content">';
			$output .= '<div id="sppb-addon-gmap-'. $this->addon->id .'" class="sppb-addon-gmap-canvas" data-lat="' . trim($map[0]) . '" data-lng="' . trim($map[1]) . '" data-maptype="' . $type . '" data-mapzoom="' . $zoom . '" data-mousescroll="' . $mousescroll . '" data-infowindow="' . base64_encode($infowindow) . '"></div>';
			$output .= '</div>';
			$output .= '</div>';
            $output .= '<div id="sppb-addon-gbutton-'. $this->addon->id .'" class="sppb-addon sppb-addon-gbutton ' . $class . '">';
            $output .= '<a href="#"><i class="fa '.$icon.'"></i></a>';
            $output .= '</div>';
            $output .= '<script type="text/javascript">jQuery(document).ready(function(){gmap_button('.$this->addon->id.')});</script>';
			return $output;

		}

		return;
	}

	public function scripts() {

		jimport('joomla.application.component.helper');
		$params = JComponentHelper::getParams('com_sppagebuilder');
		$gmap_api = $params->get('gmap_api', '');

		return array(
			'//maps.googleapis.com/maps/api/js?key='. $gmap_api,
			JURI::base(true) . '/components/com_sppagebuilder/assets/js/gmap.js',
			JURI::base(true) . '/templates/tz_consulta/js/gmap_button.js'
		);
	}

	public function css() {
		$addon_id = '#sppb-addon-map-' . $this->addon->id;
		$height = (isset($this->addon->settings->height) && $this->addon->settings->height) ? $this->addon->settings->height : 0;
		$height_sm = (isset($this->addon->settings->height_sm) && $this->addon->settings->height_sm) ? $this->addon->settings->height_sm : 0;
		$height_xs = (isset($this->addon->settings->height_xs) && $this->addon->settings->height_xs) ? $this->addon->settings->height_xs : 0;

		$css = '';
		if($height) {
			$css .= $addon_id . ' .sppb-addon-gmap-canvas {';
			$css .= 'height:' . (int) $height . 'px;';
			$css .= '}';
		}

		if ($height_sm) {
				$css .= '@media (min-width: 768px) and (max-width: 991px) {';
					$css .= $addon_id . ' .sppb-addon-gmap-canvas {';
					$css .= 'height:' . (int) $height_sm . 'px;';
					$css .= '}';
				$css .= '}';
		}

		if ($height_xs) {
				$css .= '@media (max-width: 767px) {';
					$css .= $addon_id . ' .sppb-addon-gmap-canvas {';
					$css .= 'height:' . (int) $height_xs . 'px;';
					$css .= '}';
				$css .= '}';
		}

		return $css;
	}

	public static function getTemplate() {
		$output = '
		<#
			var map = data.map.split(",");
		#>
		<style type="text/css">
		#sppb-addon-{{ data.id }} .sppb-addon-gmap-canvas {
			<# if(_.isObject(data.height)){ #>
				height: {{ data.height.md }}px;
			<# } else { #>
				height: {{ data.height }}px;
			<# } #>
		}
		@media (min-width: 768px) and (max-width: 991px) {
			#sppb-addon-{{ data.id }} .sppb-addon-gmap-canvas {
				<# if(_.isObject(data.height)){ #>
					height: {{ data.height.sm }}px;
				<# } #>
			}
		}
		@media (max-width: 767px) {
			#sppb-addon-{{ data.id }} .sppb-addon-gmap-canvas {
				<# if(_.isObject(data.height)){ #>
					height: {{ data.height.xs }}px;
				<# } #>
			}
		}
		</style>
		<div id="sppb-addon-map-{{ data.id }}" class="sppb-addon sppb-addon-gmap {{ data.class }}">
			<# if( !_.isEmpty( data.title ) ){ #><{{ data.heading_selector }} class="sppb-addon-title">{{ data.title }}</{{ data.heading_selector }}><# } #>
			<div class="sppb-addon-content">
				<div id="sppb-addon-gmap-{{ data.id }}" class="sppb-addon-gmap-canvas" data-lat="{{ map[0] }}" data-lng="{{ map[1] }}" data-maptype="{{ data.type }}" data-mapzoom="{{ data.zoom }}" data-mousescroll="{{ data.mousescroll }}" data-infowindow="{{ btoa(data.infowindow) }}"></div>
			</div>
		</div>
		';

		return $output;
	}
}
