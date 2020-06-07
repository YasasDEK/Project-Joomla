<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonClients extends SppagebuilderAddons {

	public function render() {

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$alignment = (isset($this->addon->settings->alignment) && $this->addon->settings->alignment) ? $this->addon->settings->alignment : '';
		$columns = (isset($this->addon->settings->count) && $this->addon->settings->count) ? $this->addon->settings->count : 2;
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		$output   = '';
		$output  = '<div class="sppb-addon sppb-addon-clients ' . $alignment . ' ' . $class . '">';

		if($title) {
			$output .= '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>';
		}

		$output .= '<div class="sppb-addon-content">';
		$output .= '<div class="sppb-row">';

		foreach ($this->addon->settings->sp_clients_item as $key => $value) {
			if($value->image) {
				$output .= '<div class="' . $columns . '">';
				if(isset($value->url) && $value->url) $output .= '<a target="_blank" rel="nofollow" href="'. $value->url .'">';
				$output .= '<img class="sppb-img-responsive" src="' . $value->image . '" alt="' . $value->title . '">';
				if(isset($value->url) && $value->url) $output .= '</a>';
				$output .= '<div class"sppb-title">'.$value->title.'</div>';
				$output .= '</div>';
			}
		}

		$output  .= '</div>';
		$output  .= '</div>';
		$output  .= '</div>';

		return $output;
	}

	public static function getTemplate(){
		$output = '
		<div class="sppb-addon sppb-addon-clients {{ data.class }} {{ data.alignment }}">
			<# if( !_.isEmpty( data.title ) ){ #><{{ data.heading_selector }} class="sppb-addon-title">{{ data.title }}</{{ data.heading_selector }}><# } #>
			<div class="sppb-addon-content">
				<div class="sppb-row">
					<# _.each(data.sp_clients_item, function(clients_item, key){ #>
						<# if(clients_item.image){ #>
							<div class="{{ data.count }}">
								<# if(clients_item.url){ #><a target="_blank" rel="nofollow" href=\'{{clients_item.url}}\'><# } #>
									<# if(clients_item.image && clients_item.image.indexOf("https://") == -1 && clients_item.image.indexOf("http://") == -1){ #>
										<img class="sppb-img-responsive" src=\'{{ pagebuilder_base + clients_item.image }}\' alt="{{ clients_item.title }}">
									<# } else if(clients_item.image){ #>
										<img class="sppb-img-responsive" src=\'{{ clients_item.image }}\' alt="{{ clients_item.title }}">
									<# } #>
								<# if(clients_item.url){ #></a><# } #>
							</div>
						<# } #>
					<# }); #>
				</div>
			</div>
		</div>
		';

		return $output;
	}
}
