<?php
/**
 * ------------------------------------------------------------------------
 * TZ tz System Plugin
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.templaza.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JFormFieldTZDepend extends JFormField
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected $type = 'TZDepend';
	
	/**
	 * Check and load assets file if needed
	 */
	function loadAsset(){
		if (!defined ('_TZ_DEPEND_ASSET_')) {
			define ('_TZ_DEPEND_ASSET_', 1);
			$uri = str_replace(DIRECTORY_SEPARATOR, '/', str_replace( JPATH_SITE, JURI::base(), dirname(__FILE__) ));
			$uri = str_replace('/administrator/', '', $uri);

			if(!defined('TZ_TEMPLATE')){
				$jdoc = JFactory::getDocument();
				$jdoc->addStyleSheet($uri.'/css/tzdepend.css');
				$jdoc->addScript($uri.'/js/tzdepend.js');	
			}
		}
	}

	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected function getInput(){
		$this->loadAsset();
		
		$func 	= (string)$this->element['function'] ? (string)$this->element['function'] : '';
		$value 	= $this->value ? $this->value : (string) $this->element['default'];

		if (substr($func, 0, 1) == '@'){
			$func = substr($func, 1);
			if (method_exists($this, $func)) {
				return $this->$func();
			}
		} else {
			$subtype = ( isset( $this->element['subtype'] ) ) ? trim($this->element['subtype']) : '';
			if (method_exists ($this, $subtype)) {
				return $this->$subtype ();
			}
		}
		return; 
	}
	
	/**
     *
     * Get profile config
     * @return Ambigous <string, multitype:>|string
     */
    protected function profile()
    {
        $this->loadAsset();

        $module = $this->element['module'];

        if(!$module){
        	 return JText::_('UNKNOWN_MODULE_PATH');
        }

        /* Get all profiles name folder from folder profiles */
        $profiles = array();
        $jsonData = array();
        // get in module
        $path = JPATH_SITE . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'profiles';
        if (!JFolder::exists($path)){
            return JText::_('PROFILE_FOLDER_NOT_EXIST');
		}
        $files = JFolder::files($path, '.ini');
        if ($files) {
            foreach ($files as $fname) {
                $fname = substr($fname, 0, -4);

                $f = new stdClass();
                $f->id = $fname;
                $f->title = $fname;

                $profiles[$fname] = $f;
				
				$params = new JRegistry(JFile::read($path . DIRECTORY_SEPARATOR . $fname . '.ini'));
                $jsonData[$fname] = $params->toArray();
            }
        }

        $xmlparams = JPATH_SITE . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'config.xml';
        if (file_exists($xmlparams)) {
            /* For General Form */
            $tzform = JForm::getInstance('jform', $xmlparams, array('control' => 'tzform'));

			$profileHTML = JHTML::_('select.genericlist', $profiles, '' . $this->name, 'onchange="TZFileConfig.changeProfile(this.value)"', 'id', 'title', $this->value);

			ob_start();
				require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tpls' . DIRECTORY_SEPARATOR . 'profile.php';
				$content = ob_get_clean();
			ob_end_flush();
			
			return $content;
		}
    }
	
    /**
     *
     * Get Label of element param
     * @return string label
     */
	function getLabel()
	{
		$func 	= (string)$this->element['function']?(string)$this->element['function']:'';
		if (substr($func, 0, 1) == '@' || !isset( $this->label ) || !$this->label){
			return;
		} else {
			return parent::getLabel ();
		}
	}
	
	/**
	 * render title: name="@title"
     * @param	string	$name The name of element param
     * @param	string	$value	The value of element
     * @param	object	$node The node of element
     * @param	string	$control_name
     * @return	string  title
     */
    function title()
    {
        $_title = (string) $this->element['label'];
        $_description = $this->description;
        $_url = (isset($this->element['url'])) ? (string) $this->element['url'] : '';
        $class = (isset($this->element['class'])) ? (string) $this->element['class'] : '';
        $level = (isset($this->element['level'])) ? (string) $this->element['level'] : '';
        $group = (isset($this->element['group'])) ? (string) $this->element['group'] : '';
        $group = $group ? "id='params$group-group'" : "";
        if ($_title) {
            $_title = html_entity_decode(JText::_($_title));
        }

        if ($_description) {
            $_description = html_entity_decode(JText::_($_description));
        }
        if ($_url) {
            $_url = " <a target='_blank' href='{$_url}' >[" . html_entity_decode(JText::_("Demo")) . "]</a> ";
        }
		
		$regionID = time()+rand();
		
		$class_name = trim(str_replace(" ", "", strtolower($_title) ));
		
		if($level==1){
			$html = '
				<h4 rel="'.$level.'" class="block-head block-head-'.$class_name.' open '.$class.' " '.$group.' id="'.$regionID.'">
					<span class="block-setting" >'.$_title.$_url.'</span> 
					<span class="icon-help editlinktip hasTip" title="'.htmlentities($_description).'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<a class="toggle-btn open" title="'.JText::_('Expand all').'" onclick="TZDepend.showseg(\''.$regionID.'\', \'level'.$level.'\'); return false;">'.JText::_('Expand all').'</a>
					<a class="toggle-btn close" title="'.JText::_('Collapse all').'" onclick="TZDepend.showseg(\''.$regionID.'\', \'level'.$level.'\'); return false;">'.JText::_('Collapse all').'</a>
		    	</h4>';
		} else {
			$html = '
				<h4 rel="'.$level.'" class="block-head block-head-'.$class_name.' open '.$class.' " '.$group.' id="'.$regionID.'">
					<span class="block-setting" >'.$_title.$_url.'</span> 
					<span class="icon-help editlinktip hasTip" title="'.htmlentities($_description).'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<a class="toggle-btn" title="'.JText::_('Click here to expand or collapse').'" onclick="TZDepend.segment(\''.$regionID.'\', \'level'.$level.'\'); return false;">open</a>
		    	</h4>';
		} 
		//<div class="block-des '.$class.'"  id="desc-'.$regionID.'">'.$_description.'</div>';
		
		return $html;
	}
	
	/**
	 * Subtype - Checkbox: subtype="checkbox"
	 */
	function checkbox(){		
		$k = 0;
		$html = "";
		
		$cols = intval($this->element['cols']);
		if($cols == 0){
			$cols = 1;
		}
		$width = floor(100/$cols);
		$style = ' style="width:'.$width.'%;"';
		if($this->element->children()){
			foreach ($this->element->children() as $option)
			{
				$group = isset($option['group'])?intval($option['group']):0;
				$odesc	= isset($option['description'])?JText::_($option['description']):'';
				$otext	= JText::_(trim((string) $option));
	
				$tooltip	= addslashes(htmlspecialchars($odesc, ENT_QUOTES, 'UTF-8'));
				$titletip		= addslashes(htmlspecialchars($otext, ENT_QUOTES, 'UTF-8'));
	
				if($titletip) {
					$titletip = $titletip.'::';
				}
				
				if($group) {
					$html .= "\n\t<div class=\"group_title\"><span class=\"hasTip\" title=\"{$titletip}{$tooltip}\">$otext</span></div>";
				} else {
				
					
					$oval	= $option['value'];
					$children	= $option['children'];
					$alt = ($children) ? ' alt="'.$children.'"' : '';
					$extra	 = '';
		
					if (is_array( $this->value ))
					{
						foreach ($value as $val)
						{
							$val2 = is_object( $val ) ? $val->$key : $val;
							if ($oval == $val2)
							{
								$extra .= ' checked="checked"';
								break;
							}
						}
					} else {
						$extra .= ( (string)$oval == (string)$this->value  ? ' checked="checked"' : '' );
					}
					
					$html .= "\n\t<div class=\"group_item\" $style>";	
					$html .= "\n\t<input type=\"checkbox\" name=\"{$this->name}[]\" id=\"{$this->id}{$k}\" value=\"$oval\"$extra $alt />";
					$html .= "\n\t<label id=\"{$this->id}{$k}-label\" class=\"hasTip\" title=\"{$titletip}{$tooltip}\" for=\"{$this->id}{$k}\">$otext</label>";
					$html .= "\n\t</div>";
					
					$k++;
				}
			}
		}

		return $html;
	}
	
	/**
	 * render js to control setting form.
     * @param	string	$name The name of element param
     * @param	string	$value	The value of element
     * @param	object	$node The node of element
     * @param	string	$control_name
     * @return	string  group param
	 */
	function group(){
		$this->loadAsset();

		preg_match_all('/jform\\[([^\]]*)\\]/', $this->name, $matches);
		$group_name = 'jform';
		
		if(!isset($matches[1]) || empty($matches[1])){
			preg_match_all('/tzform\\[([^\]]*)\\]/', $this->name, $matches);
			$group_name = 'tzform';
		}
		
		if(isset($matches[1]) && !empty($matches[1])):
		
		?>
		<script type="text/tzvascript">
			jQuery(document).ready(function(){
			<?php 
			foreach ($this->element->children() as $option):
				$elms = preg_replace('/\s+/', '', (string)$option[0]);
			?>
				TZDepend.add('<?php echo $option['for']; ?>', {
					val: '<?php echo $option['value']; ?>',
					elms: '<?php echo $elms?>',
					group: '<?php echo $group_name . '[' . @$matches[1][0] . ']'; ?>'
				});
			<?php
				endforeach;
			?>
			});
		</script>
		<?php
		endif;
	}

	function legend(){
		return '<legend class="tz-form-legend">' . JText::_($this->element['label']) . '<small class="tz-form-legend-desc">' . JText::_($this->element['description']) . '</small> </legend>';
	}
	
	/**
     *
     * Get Template Actived
     * @return string template active name
     */
    function getActiveTemplate(){

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('template');
		$query->from('#__template_styles');
		$query->where('client_id = 0');
		$query->where('home = 1');

		$db->setQuery($query);
		$tpl = $db->loadResult();

		return $tpl;
	}
} 