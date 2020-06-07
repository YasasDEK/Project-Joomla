<?php
defined('_JEXEC') or die;
?><?php
if (!defined('_DESIGNER_FUNCTIONS'))
  require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../functions.php');

function modChrome_drstyle($module, &$params, &$attribs)
{
    $module->content = funcContentRoutesCorrector($module->content);
    $module->content = processingShortcodes($module->content);
    if ('' === $attribs['drstyle'] || $params->get('vmcache', 0) == '1') {
        echo $module->content;
        return;
    }

    $parts = explode('%', $attribs['drstyle']);
    $style = $parts[0];

    if (!isset($attribs['funcStyling']))
        $attribs['funcStyling'] = count($parts) > 1 ? $parts[1] : '';

    $styles = array(
      'block' => 'modChrome_block',
      'nostyle' => 'modChrome_nostyle'
    );

    $classes = explode(' ', rtrim($params->get('moduleclass_sfx')));
    $keys = array_keys($styles);
    $dr = array();
    foreach ($classes as $key => $class) {
      if (in_array($class, $keys)) {
        $dr[] = $class;
        $classes[$key] = ' ';
      }
    }
    $classes = str_replace('  ', ' ', rtrim(implode(' ', $classes)));
    $style = count($dr) ? array_pop($dr) : $style;
    $params->set('moduleclass_sfx', $classes);
    call_user_func($styles[$style], $module, $params, $attribs);
}

function modChrome_block($module, $params, $attribs)
{
    $result = '';
    if (!empty ($module->content)) {
        $content = $module->content;
        if (isset($module->contentChanged)) {
            $content = $module->oldContent;
        }
        $args = array('title' => $module->showtitle != 0 ? $module->title : '',
            'content' => $content,
            'classes' => $params->get('moduleclass_sfx'),
            'id' => $module->id);
        if ('' !== $attribs['funcStyling']) {
            $args['extraClass'] = isset($attribs['extraClass']) ? $attribs['extraClass'] : '';
            $result = renderTemplateFromIncludes($attribs['funcStyling'], $args);
            if (!isset($module->contentChanged)) {
                $module->contentChanged = true;
                $module->oldContent = $module->content;
            }
        }
        else {
            $result = $module->content;
        }
    }
    echo $result;
}

function modChrome_nostyle($module, $params, $attribs)
{
if (!empty ($module->content)) : ?>
<div class="<?php echo $params->get('moduleclass_sfx'); ?>">
<?php if ($module->showtitle != 0) : ?>
    <h3><?php echo $module->title; ?></h3>
<?php endif; ?>
<?php echo $module->content; ?>
</div>
<?php endif;
}
?>
