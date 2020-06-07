<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonSocial_share extends SppagebuilderAddons {

	public function render() {

		$getUri 					= JFactory::getURI();
		$doc 						= JFactory::getDocument();

		// Options
		$class 	 					= (isset($this->addon->settings->class) && $this->addon->settings->class) ? ' ' . $this->addon->settings->class : '';
		$class 						.= (isset($this->addon->settings->social_style) && $this->addon->settings->social_style) ? ' sppb-social-share-style-' 	. str_replace('_', '-', $this->addon->settings->social_style) : '';
		$heading_selector 	= (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';
		$title 						= (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$show_social_names 	= (isset($this->addon->settings->show_social_names) && $this->addon->settings->show_social_names) ? $this->addon->settings->show_social_names : '';
		$show_counter 				= (isset($this->addon->settings->show_counter) && $this->addon->settings->show_counter) ? $this->addon->settings->show_counter : '';
		$show_totalshare 			= (isset($this->addon->settings->show_totalshare) && $this->addon->settings->show_totalshare) ? $this->addon->settings->show_totalshare : '';
		$show_socials 				= (isset($this->addon->settings->show_socials) && $this->addon->settings->show_socials) ? $this->addon->settings->show_socials : '';
		$api 	= (isset($this->addon->settings->api) && $this->addon->settings->api) ? $this->addon->settings->api : '';

		$current_url 				= $getUri->toString();
		$page_title 				= $doc->getTitle();

		$statistics = '';
		if ($show_counter || $show_totalshare) {
			if (!$api) {
				$output = '<p class="alert alert-warning">' . JText::_('COM_SPPB_ADDON_SOCIALSHARE_API_NOT_FOUND') . '</p>';
				return $output;
			}
			
			// Get Statistics of share
			$statistics = $this->getStatistics();
		}

		if ($show_totalshare) {
			$share_col = 'sppb-col-sm-3';
			$icons_col = 'sppb-col-sm-9';
		} else {
			$share_col = 'sppb-col-sm-12';
			$icons_col = 'sppb-col-sm-12';
		}

		$output  = '';
		$output .= '<div class="sppb-addon sppb-addon-social-share' . $class . '">';
		$output .= '<div class="sppb-social-share">';
		$output .= ($title) ? '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>' : '';

		$output .= '<div class="sppb-social-share-wrap sppb-row">';

		if (isset($statistics->total) && $show_totalshare) {
			$output .= '<div class="sppb-social-total-shares '. $share_col .'">';
			$output .= '<em>' . $statistics->total . '</em>';
			$output .= '<div class="sppb-social-total-share-caption">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_TOTAL_SHARES') . '</div>';
			$output .= '</div>';
		}

		$output .= '<div class="sppb-social-items-wrap ' . $icons_col . '">';
		$output .= '<ul>';
		if (in_array('facebook', $show_socials)) {
			$output .= '<li class="sppb-social-share-facebook">';
			$output .= '<a onClick="window.open(\'http://www.facebook.com/sharer.php?u='. $current_url . '\',\'Facebook\',\'width=600,height=300,left=\'+(screen.availWidth/2-300)+\',top=\'+(screen.availHeight/2-150)+\'\'); return false;" href="http://www.facebook.com/sharer.php?u=' . $current_url . '">';
			$output .= '<i class="fa fa-facebook"></i>';
			if ($show_social_names) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_FACEBOOK') . '</span>';
			}
			if (isset($statistics->shares->facebook) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->facebook . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('twitter', $show_socials)) {
			//twitter
			$output .= '<li class="sppb-social-share-twitter">';
			$output .= '<a onClick="window.open(\'http://twitter.com/share?url=' . $current_url . '&amp;text=' . str_replace(" ", "%20", $page_title ) . '\',\'Twitter share\',\'width=600,height=300,left=\'+(screen.availWidth/2-300)+\',top=\'+(screen.availHeight/2-150)+\'\'); return false;" href="http://twitter.com/share?url=' . $current_url. '&amp;text=' . str_replace(" ", "%20", $page_title) . '">';
			$output .= '<i class="fa fa-twitter"></i>';
			if ($show_social_names) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_TWITTER') . '</span>';
			}
			if (isset($statistics->shares->twitter) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->twitter . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('gplus', $show_socials)) {
			//google plus
			$output .= '<li class="sppb-social-share-glpus">';
			$output .= '<a onClick="window.open(\'https://plus.google.com/share?url=' . $current_url . '\',\'Google plus\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="https://plus.google.com/share?url=' . $current_url .'" >';
			$output .= '<i class="fa fa-google-plus"></i>';
			if ($show_social_names) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_GOOGLE_PLUS') . '</span>';
			}
			if (isset($statistics->shares->google) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->google . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('linkedin', $show_socials)) {
			//linkedin
			$output .= '<li class="sppb-social-share-linkedin">';
			$output .= '<a onClick="window.open(\'http://www.linkedin.com/shareArticle?mini=true&url=' . $current_url .'\',\'Linkedin\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=' . $current_url . '" >';
			$output .= '<i class="fa fa-linkedin-square"></i>';
			if ($show_social_names) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_LINKEDIN') . '</span>';
			}
			if (isset($statistics->shares->linkedin) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->linkedin . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('pinterest', $show_socials)) {
			$output .= '<li class="sppb-social-share-pinterest">';
			$output .= '<a onClick="window.open(\'http://pinterest.com/pin/create/button/?url='.$current_url.'&amp;description='.$page_title .'\',\'Pinterest\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://pinterest.com/pin/create/button/?url='.$current_url.'&amp;description='.$page_title. '" >';
			$output .= '<i class="fa fa-pinterest"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_PINTEREST') . '</span>';
			}
			if (isset($statistics->shares->pinterest) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->pinterest . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('thumblr', $show_socials)) {
			$output .= '<li class="sppb-social-share-thumblr">';
			$output .= '<a onClick="window.open(\'http://tumblr.com/share?s=&amp;v=3&amp;t='.$page_title.'&amp;u='.$current_url .'\',\'Thumblr\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://tumblr.com/share?s=&amp;v=3&amp;t='.$page_title.'&amp;u='.$current_url. '" >';
			$output .= '<i class="fa fa-tumblr"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_THUMBLR') . '</span>';
			}
			if (isset($statistics->shares->tumblr) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->tumblr . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('getpocket', $show_socials)) {
			$output .= '<li class="sppb-social-share-getpocket">';
			$output .= '<a onClick="window.open(\'https://getpocket.com/save?url='.$current_url .'\',\'Getpocket\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="https://getpocket.com/save?url='.$current_url. '" >';
			$output .= '<i class="fa fa-get-pocket"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_GETPOCKET') . '</span>';
			}
			if (isset($statistics->shares->pocket) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->pocket . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('reddit', $show_socials)) {
			$output .= '<li class="sppb-social-share-reddit">';
			$output .= '<a onClick="window.open(\'http://www.reddit.com/submit?url='.$current_url .'\',\'Reddit\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://www.reddit.com/submit?url='.$current_url. '" >';
			$output .= '<i class="fa fa-reddit"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_REDDIT') . '</span>';
			}
			if (isset($statistics->shares->reddit) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->reddit . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('vk', $show_socials)) {
			$output .= '<li class="sppb-social-share-vk">';
			$output .= '<a onClick="window.open(\'http://vk.com/share.php?url=' . $current_url .'\',\'Vk\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://vk.com/share.php?url='.$current_url. '" >';
			$output .= '<i class="fa fa-vk"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_VK') . '</span>';
			}
			if (isset($statistics->shares->vk) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->vk . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('xing', $show_socials)) {
			$output .= '<li class="sppb-social-share-xing">';
			$output .= '<a onClick="window.open(\'https://www.xing.com/spi/shares/new?cb=0&url=' . $current_url .'\',\'Xing\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="https://www.xing.com/spi/shares/new?cb=0&url='.$current_url. '" >';
			$output .= '<i class="fa fa-xing"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_XING') . '</span>';
			}
			if (isset($statistics->shares->xing) && $statistics->shares && $show_counter) {
				$output .= '<span class="sppb-social-share-count">' . $statistics->shares->xing . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		} if (in_array('whatsapp', $show_socials)) {
			$output .= '<li class="sppb-social-share-whatsapp">';
			$output .= '<a href="whatsapp://send?text='.$current_url. '" >';
			$output .= '<i class="fa fa-whatsapp"></i>';
			if ($show_social_names == 1) {
				$output .= '<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_WHATSAPP') . '</span>';
			}
			$output .= '</a>';
			$output .= '</li>';
		}
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function css() {
		$addon_id = '#sppb-addon-' . $this->addon->id;

		$social_use_border	= (isset($this->addon->settings->social_use_border) && $this->addon->settings->social_use_border) ? $this->addon->settings->social_use_border : '';
		$social_style 	= (isset($this->addon->settings->social_style) && $this->addon->settings->social_style) ? $this->addon->settings->social_style : '';

		$style  = (isset($this->addon->settings->background_color) && $this->addon->settings->background_color && $social_style =='custom') ? 'background-color:' . $this->addon->settings->background_color  . ';' : '';
		$style .= (isset($this->addon->settings->social_border_width) && $this->addon->settings->social_border_width && $social_use_border) ? "border-style: solid; border-width: " . $this->addon->settings->social_border_width  . "px;" : '';
		$style .= (isset($this->addon->settings->social_border_color) && $this->addon->settings->social_border_color && $social_use_border) ? "border-color: " . $this->addon->settings->social_border_color  . ";" : '';
		$style .= (isset($this->addon->settings->social_border_radius) && $this->addon->settings->social_border_radius) ? "border-radius: " . $this->addon->settings->social_border_radius  . ";" : '';
		$hover_style = (isset($this->addon->settings->background_hover_color) && $this->addon->settings->background_hover_color && $social_style =='custom') ? 'background-color:' . $this->addon->settings->background_hover_color  . ';' : '';
		$hover_style .= (isset($this->addon->settings->social_border_hover_color) && $this->addon->settings->social_border_hover_color && $social_use_border) ? 'border-color:' . $this->addon->settings->social_border_hover_color  . ';' : '';

		$css = '';
		if( $style ) {
			$css .= $addon_id . ' .sppb-social-share-wrap ul li a {' . $style . '}';
		}

		if($hover_style) {
			$css .= $addon_id . ' .sppb-social-share-wrap ul li a:hover {' . $hover_style . '}';
		}

		if(isset($this->addon->settings->icon_align) && $this->addon->settings->icon_align) {
			$css .= $addon_id . ' .sppb-social-share-wrap {text-align:' . $this->addon->settings->icon_align . ';}';
		}

		return $css;

	}

	private function getStatistics() {
		$getUri 			= JFactory::getURI();
		$current_url 	= $getUri->toString();
		
		$host 	= (isset($this->addon->settings->host) && $this->addon->settings->host) ? $this->addon->settings->host : 'free.donreach.com';
		$api 	= (isset($this->addon->settings->api) && $this->addon->settings->api) ? $this->addon->settings->api : '';

		jimport( 'joomla.filesystem.folder' );
		$cache_path = JPATH_CACHE . '/com_sppagebuilder/addons/addon-' . $this->addon->id;
		$cache_file = $cache_path . '/social_share.json';

		if(!file_exists($cache_path)) {
			JFolder::create($cache_path, 0755);
		}

		if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 30 ))) {
			$statistics = file_get_contents($cache_file);
		} else {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://'. $host .'/shares?providers=facebook,twitter,google,linkedin,pinterest,tumblr,pocket,reddit,vk&url=' . $current_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			$headers = array();
			$headers[] = 'Authorization:' . $api;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$statistics = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close ($ch);
			file_put_contents($cache_file, $statistics, LOCK_EX);
		}

		$json = json_decode($statistics);

		if(isset($json->shares)) {
			return $json;
		}

		return array();
	}

	public static function getTemplate(){

			$current_url 				= JFactory::getURI()->toString();
			$page_title 				= JFactory::getDocument()->getTitle();
			

		$output ='
			<#
					let current_url = "' . $current_url .'"
					let page_title = "' . $page_title .'"
					let show_totalshare = data.show_totalshare || ""
					let share_col = "sppb-col-sm-12"
					let icons_col = "sppb-col-sm-12"
					let totalShareText = "'. JText::_("COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_TOTAL_SHARES") . '"

					let sShareClass = data.class || ""
							sShareClass += (!_.isEmpty(data.social_style))? " sppb-social-share-style-"+data.social_style.replace("_","-"):""

					if (show_totalshare == 1) {
						share_col = "sppb-col-sm-3"
						icons_col = "sppb-col-sm-9"
					}
			#>

			<style type="text/css">
				#sppb-addon-{{ data.id }} .sppb-social-share-wrap ul li a {
					<# if( data.background_color && data.social_style == "custom" ) {#>
					background-color: {{ data.background_color }};
					<# } #>
					<# if( data.icon_color && data.social_style == "custom" ) {#>
						color: {{ data.icon_color }};
					<# } #>
					<# if( data.social_border_width && data.social_use_border ){ #>
						border-style: solid;
						border-width: {{ data.social_border_width }}px;
					<# } #>
					<# if( data.social_border_color && data.social_use_border ){ #>
						border-color: {{ data.social_border_color }};
					<# } #>
					<# if( data.social_border_radius ){ #>
						border-radius: {{ data.social_border_radius }};
					<# } #>
				}

				#sppb-addon-{{ data.id }}  .sppb-social-share-wrap ul li a:hover {
					<# if( data.background_hover_color && data.social_style == "custom" ) { #>
						background-color: {{ data.background_hover_color }};
					<# } #>
					<# if( data.icon_hover_color && data.social_style == "custom" ) { #>
						color: {{ data.icon_hover_color }};
					<# } #>
					<# if( data.social_border_hover_color && data.social_use_border ){ #>
						border-color: {{ data.social_border_hover_color }};
					<# } #>
				}

				<# if (data.icon_align) { #>
					#sppb-addon-{{ data.id }} .sppb-social-share-wrap{
						text-align: {{ data.icon_align }};
					}
				<# } #>

			</style>

			<# if(!data.api){ #>
				<p class="alert alert-warning">'. JText::_('COM_SPPB_ADDON_SOCIALSHARE_API_NOT_FOUND') .'</p>
			<# } #>

			<div class="sppb-addon sppb-addon-social-share {{ sShareClass }}">
				<div class="sppb-social-share">
					<# if( !_.isEmpty( data.title ) ){ #><{{ data.heading_selector }} class="sppb-addon-title">{{{ data.title }}}</{{ data.heading_selector }}><# } #>
					<div class="sppb-social-share-wrap sppb-row">

					<# if(show_totalshare){ #>
						<div class="sppb-social-total-shares {{ share_col }}">
							<em>000</em>
							<div class="sppb-social-total-share-caption">{{ totalShareText }}</div>
						</div>
					<# } #>

					<div class="sppb-social-items-wrap {{ icons_col }}">
						<ul>
						<# if(_.indexOf(data.show_socials, "facebook") != "-1") { #>
							<li class="sppb-social-share-facebook">
							  <a onClick="window.open(\'http://www.facebook.com/sharer.php?u={{ current_url }}\',\'Facebook\',\'width=600,height=300,left=\'+(screen.availWidth/2-300)+\',top=\'+(screen.availHeight/2-150)+\'\'); return false;" href="http://www.facebook.com/sharer.php?u={{current_url}}">
								  <i class="fa fa-facebook"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_FACEBOOK') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "twitter") != "-1") { #>
							<li class="sppb-social-share-twitter">
							  <a onClick="window.open(\'http://twitter.com/share?url={{ current_url }}&amp;text={{ page_title }}\',\'Twitter share\',\'width=600,height=300,left=\'+(screen.availWidth/2-300)+\',top=\'+(screen.availHeight/2-150)+\'\'); return false;" href="http://twitter.com/share?url={{ current_url }}&amp;text={{ page_title }}">
								  <i class="fa fa-twitter"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_TWITTER') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "gplus") != "-1") { #>
							<li class="sppb-social-share-glpus">
							  <a onClick="window.open(\'https://plus.google.com/share?url={{ current_url }}\',\'Google plus\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="https://plus.google.com/share?url={{ current_url }}" >
								  <i class="fa fa-google-plus"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_GOOGLE_PLUS') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "linkedin") != "-1") { #>
							<li class="sppb-social-share-linkedin">
							  <a onClick="window.open(\'http://www.linkedin.com/shareArticle?mini=true&url={{ current_url }}\',\'Linkedin\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url={{ current_url }}">
								  <i class="fa fa-linkedin-square"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_LINKEDIN') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "pinterest") != "-1") { #>
							<li class="sppb-social-share-pinterest">
							  <a onClick="window.open(\'http://pinterest.com/pin/create/button/?url={{ current_url }}&amp;description={{ page_title }}\',\'Pinterest\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://pinterest.com/pin/create/button/?url={{ current_url }}&amp;description={{ page_title }}" >
								  <i class="fa fa-pinterest"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_PINTEREST') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "thumblr") != "-1") { #>
							<li class="sppb-social-share-thumblr">
							  <a onClick="window.open(\'http://tumblr.com/share?s=&amp;v=3&amp;t={{ page_title }}&amp;u={{ current_url }}\',\'Thumblr\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://tumblr.com/share?s=&amp;v=3&amp;t={{ page_title }}&amp;u={{ current_url }}" >
								  <i class="fa fa-tumblr"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_THUMBLR') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "getpocket") != "-1") { #>
							<li class="sppb-social-share-getpocket">
							  <a onClick="window.open(\'https://getpocket.com/save?url={{ current_url }}\',\'Getpocket\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="https://getpocket.com/save?url={{ current_url }}" >
								  <i class="fa fa-get-pocket"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_GETPOCKET') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "reddit") != "-1") { #>
							<li class="sppb-social-share-reddit">
							  <a onClick="window.open(\'http://www.reddit.com/submit?url={{ current_url }}\',\'Reddit\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://www.reddit.com/submit?url={{ current_url }}">
								  <i class="fa fa-reddit"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_REDDIT') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "vk") != "-1") { #>
							<li class="sppb-social-share-vk">
							  <a onClick="window.open(\'http://vk.com/share.php?url={{ current_url }}\',\'Vk\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="http://vk.com/share.php?url={{ current_url }}" >
								  <i class="fa fa-vk"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_VK') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "xing") != "-1") { #>
							<li class="sppb-social-share-xing">
							  <a onClick="window.open(\'https://www.xing.com/spi/shares/new?cb=0&url={{ current_url }}\',\'Xing\',\'width=585,height=666,left=\'+(screen.availWidth/2-292)+\',top=\'+(screen.availHeight/2-333)+\'\'); return false;" href="https://www.xing.com/spi/shares/new?cb=0&url={{ current_url }}">
								  <i class="fa fa-xing"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_XING') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>

						<# if(_.indexOf(data.show_socials, "whatsapp") != "-1") { #>
							<li class="sppb-social-share-whatsapp">
							  <a href="whatsapp://send?text={{ current_url }}">
								  <i class="fa fa-whatsapp"></i>
									<# if ( data.show_social_names != 0 ) { #>
										<span class="sppb-social-share-title">' . JText::_('COM_SPPAGEBUILDER_ADDON_SOCIALSHARE_WHATSAPP') . '</span>
									<# } #>
									<# if ( data.show_counter ) { #>
										<span class="sppb-social-share-count">00</span>
									<# } #>
							  </a>
						  </li>
						<# } #>
						</ul>
					</div>

					</div>
				</div>
			</div>
			';

			return $output;
	}

}
