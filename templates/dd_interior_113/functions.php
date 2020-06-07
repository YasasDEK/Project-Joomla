<?php

defined('_JEXEC') or die;

if (!defined('_DESIGNER_FUNCTIONS')) {

    define('_DESIGNER_FUNCTIONS', 1);

    $GLOBALS['theme_settings'] = array(
        'is_preview' => false,
        'active_paginator' => 'common'
    );

    require_once dirname(__FILE__) . '/library/Designer/LogFormatter.php';

    function getSystemInfo() {
        $info = array();
        $info[] = 'OS: ' . php_uname();
        $info[] = 'PHP: ' . phpversion();
        return implode("\n", $info);
    }

    $errors = array();
    function errorHandlerPreviewTheme($errno, $errstr, $errfile, $errline, $errcontext)
    {
        global $errors;

        if (count($errors) >= 20) return;

        $bt = debug_backtrace();
        $formatter = new LogFormatter();
        $callstack = '';
        foreach($bt as $key => $caller) {
            if (0 === $key) continue;
            $callstack .= "   # ";
            if (isset($caller['class']))
                $callstack .= $caller['class'] . '::';
            $callstack .= $caller['function'] . '(' . $formatter->args($caller['args']) . ')';
            $callstack .= "\n";
        }
        $errors[] = array(
            'type' => $errno,
            'message' => $errstr,
            'file' => $errfile,
            'line' => $errline,
            'systemInfo' => getSystemInfo(),
            'stack' => $callstack
        );
    }

    // Will be called when php script ends
    function shutdownHandler()
    {
        global $errors;

        $errorText = '';
        $error = error_get_last();
        if (is_array($error)) {
            switch ($error['type']) {
                case E_ERROR:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_PARSE:
                    $errorText = $error['type'] . " | message: " . $error['message'] . " | file: " . $error['file'] . " | line: " . $error['line'];
            }
        }
        if ('' !== $errorText) {
            printf('[PHP_ERROR]%s[PHP_ERROR]' . PHP_EOL, json_encode($error));
            print_r(array(
                'error' => $errorText,
                'errors' => $errors
            ));
            die;
        }
    }

    if ($GLOBALS['theme_settings']['is_preview']) {
        // display errors on screen
        ini_set('display_errors', 1);
        // sets which PHP errors are reported
        error_reporting(E_ERROR);
        // sets a user-defined error handler function
        set_error_handler('errorHandlerPreviewTheme');
        // register a function for execution on shutdown
        register_shutdown_function("shutdownHandler");
    }
    require_once dirname(__FILE__) . '/library/Designer.php';
    
    function renderTemplateFromIncludes($name, $args = array(), $folder = 'includes', $callFunc = true)
    {
        $application = JApplication::getInstance('site');
        $template = $application->getTemplate();
        $templatePath = JPATH_SITE . '/templates/' . $template;
        if (basename(dirname(__FILE__)) == 'editor')
            $templatePath .= '/editor';
        $filePath = $templatePath . '/' . $folder . '/' . $name . '.php';
        include_once($filePath);
        if ($callFunc)
            return call_user_func_array($name, $args);
    }
    
    function funcUrlToHref($url)
    {
        $result = '';
        $p = parse_url($url);
        if (isset($p['scheme']) && isset($p['host'])) {
            $result = $p['scheme'] . '://';
            if (isset($p['user'])) {
                $result .= $p['user'];
                if (isset($p['pass']))
                    $result .= ':' . $p['pass'];
                $result .= '@';
            }
            $result .= $p['host'];
            if (isset($p['port']))
                $result .= ':' . $p['port'];
            if (!isset($p['path']))
                $result .= '/';
        }
        if (isset($p['path']))
            $result .= $p['path'];
        if (isset($p['query'])) {
            $result .= '?' . str_replace('&', '&amp;', $p['query']);
        }
        if (isset($p['fragment']))
            $result .= '#' . $p['fragment'];
        return $result;
    }

    /**
     * Searches $content for tags and returns information about each found tag.
     *
     * Created to support button replacing process, e.g. wrapping submit/reset
     * inputs and buttons with artisteer style.
     *
     * When all the $name tags are found, they are processed by the $filter specified.
     * Filter is applied to the attributes. When an attribute contains several values
     * (e.g. class attribute), only tags that contain all the values from filter
     * will be selected. E.g. filtering by the button class will select elements
     * with class="button" and class="button validate".
     *
     * Parsing does not support nested tags. Looking for span tags in
     * <span>1<span>2</span>3</span> will return <span>1<span>2</span> and
     * <span>2</span>.
     *
     * Examples:
     *  Select all tags with class='readon':
     *   funcFindTags($html, array('*' => array('class' => 'readon')))
     *  Select inputs with type='submit' and class='button':
     *   funcFindTags($html, array('input' => array('type' => 'submit', 'class' => 'button')))
     *  Select inputs with type='submit' and class='button validate':
     *   funcFindTags($html, array('input' => array('type' => 'submit', 'class' => array('button', 'validate'))))
     *  Select inputs with class != 'bd-button'
     *   funcFindTags($html, array('input' => array('class' => '!bd-button')))
     *  Select inputs with non-empty class
     *   funcFindTags($html, array('input' => array('class' => '!')))
     *  Select inputs with class != 'bd-button' and non-empty class:
     *   funcFindTags($html, array('input' => array('class' => array('!bd-button', '!'))))
     *  Select inputs with class = button but != 'bd-button'
     *   funcFindTags($html, array('input' => array('class' => array('button', '!bd-button'))))
     *
     * @return array of text fragments and tag information: position, length,
     *         name, attributes, raw_open_tag, body.
     */
    function funcFindTags($content, $filters)
    {
        $result = array('');
        $index = 0;
        $position = 0;
        $name = implode('|', array_keys($filters));
        $name = str_replace('*', '\w+', $name);
        // search for open tag
        if (preg_match_all(
            '~<(' . $name . ')\b(?:\s+[^\s]+\s*=\s*(?:"[^"]+"|\'[^\']+\'|[^\s>]+))*\s*/?' . '>~i', $content,
            $tagMatches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER))
        {
            foreach ($tagMatches as $tagMatch) {
                $rawMatch = $tagMatch[0][0];
                $name = $tagMatch[1][0];
                $normalName = strtolower($name);
                $tag = array('name' => $name, 'position' => $tagMatch[0][1]);
                $openTagTail = (strlen($rawMatch) > 1 && '/' == $rawMatch[strlen($rawMatch) - 2])
                    ? '/>' : '>';
                // different instructions for paired and unpaired tags
                switch ($normalName)
                {
                    case 'input':
                    case 'img':
                    case 'br':
                        $tag['paired'] = false;
                        $tag['length'] = strlen($tagMatch[0][0]);
                        $tag['body'] = null;
                        $tag['close'] = 2 == strlen($openTagTail);
                        break;
                    default:
                        $closeTag = '</' . $name . '>';
                        $closeTagLength = strlen($closeTag);
                        $tag['paired'] = true;
                        $end = strpos($content, $closeTag, $tag['position']);
                        if (false === $end)
                            continue 2;
                        $openTagLength = strlen($tagMatch[0][0]);
                        $tag['body'] = substr($content, $tag['position'] + $openTagLength,
                            $end - $openTagLength - $tag['position']);
                        $tag['length'] = $end + $closeTagLength - $tag['position'];
                        break;
                }
                // parse attributes
                $rawAttributes = trim(substr($tagMatch[0][0], strlen($name) + 1,
                    strlen($tagMatch[0][0]) - strlen($name) - 1 - strlen($openTagTail)));
                $attributes = array();
                if (preg_match_all('~([^=\s]+)\s*=\s*(?:(")([^"]+)"|(\')([^\']+)\'|([^\s]+))~',
                    $rawAttributes, $attributeMatches, PREG_SET_ORDER))
                {
                    foreach ($attributeMatches as $attrMatch) {
                        $attrName = $attrMatch[1];
                        $attrDelimeter = (isset($attrMatch[2]) && '' !== $attrMatch[2])
                            ? $attrMatch[2]
                            : ((isset($attrMatch[4]) && '' !== $attrMatch[4])
                                ? $attrMatch[4] : '');
                        $attrValue = (isset($attrMatch[3]) && '' !== $attrMatch[3])
                            ? $attrMatch[3]
                            : ((isset($attrMatch[5]) && '' !== $attrMatch[5])
                                ? $attrMatch[5] : $attrMatch[6]);
                        if ('class' == $attrName)
                            $attrValue = explode(' ', preg_replace('~\s+~', ' ', $attrValue));
                        $attributes[$attrName] = array('delimeter' => $attrDelimeter,
                            'value' => $attrValue);
                    }
                }
                // apply filter to attributes
                $passed = true;
                $filter = isset($filters[$normalName])
                    ? $filters[$normalName]
                    : (isset($filters['*']) ? $filters['*'] : array());
                foreach ($filter as $key => $value) {
                    $criteria = is_array($value) ? $value : array($value);
                    for ($c = 0; $c < count($criteria) && $passed; $c++) {
                        $crit = $criteria[$c];
                        if ('' == $crit) {
                            // attribute should be empty
                            if ('class' == $key) {
                                if (isset($attributes[$key]) && count($attributes[$key]['value']) != 0) {
                                    $passed = false;
                                    break;
                                }
                            } else {
                                if (isset($attributes[$key]) && strlen($attributes[$key]['value']) != 0) {
                                    $passed = false;
                                    break;
                                }
                            }
                        } else if ('!' == $crit) {
                            // attribute should be not set or empty
                            if ('class' == $key) {
                                if (!isset($attributes[$key]) || count($attributes[$key]['value']) == 0) {
                                    $passed = false;
                                    break;
                                }
                            } else {
                                if (!isset($attributes[$key]) || strlen($attributes[$key]['value']) == 0) {
                                    $passed = false;
                                    break;
                                }
                            }
                        } else if ('!' == $crit[0]) {
                            // * attribute should not contain value
                            // * if attribute is empty, it does not contain value
                            if ('class' == $key) {
                                if (isset($attributes[$key]) && count($attributes[$key]['value']) != 0
                                    && in_array(substr($crit, 1), $attributes[$key]['value']))
                                {
                                    $passed = false;
                                    break;
                                }
                            } else {
                                if (isset($attributes[$key]) && strlen($attributes[$key]['value']) != 0
                                    && $crit == $attributes[$key]['value'])
                                {
                                    $passed = false;
                                    break;
                                }
                            }
                        } else {
                            // * attribute should contain value
                            // * if attribute is empty, it does not contain value
                            if ('class' == $key) {
                                if (!isset($attributes[$key]) || count($attributes[$key]['value']) == 0) {
                                    $passed = false;
                                    break;
                                }
                                if (!in_array($crit, $attributes[$key]['value'])) {
                                    $passed = false;
                                    break;
                                }
                            } else {
                                if (!isset($attributes[$key]) || strlen($attributes[$key]['value']) == 0) {
                                    $passed = false;
                                    break;
                                }
                                if ($crit != $attributes[$key]['value']) {
                                    $passed = false;
                                    break;
                                }
                            }
                        }
                    }
                    if (!$passed)
                        break;
                }
                if (!$passed)
                    continue;
                // finalize tag info constrution
                $tag['attributes'] = $attributes;
                $result[$index] = substr($content, $position, $tag['position'] - $position);
                $position = $tag['position'] + $tag['length'];
                $index++;
                $result[$index] = $tag;
                $index++;
            }
        }
        $result[$index] = $position < strlen($content) ? substr($content, $position) : '';
        return $result;
    }

    /**
     * Converts tag info created by funcFindTags back to text tag.
     *
     * @return string
     */
    function funcTagInfoToString($info)
    {
        $result = '<' . $info['name'];
        if (isset($info['attributes']) && 0 != count($info['attributes'])) {
            $attributes = '';
            foreach ($info['attributes'] as $key => $value)
                $attributes .= ' ' . $key . '=' . $value['delimeter']
                    . (is_array($value['value']) ? implode(' ', $value['value']) : $value['value'])
                    . $value['delimeter'];
            $result .= $attributes;
        }
        if ($info['paired']) {
            $result .= '>';
            $result .= $info['body'];
            $result .= '</' . $info['name'] . '>';
        } else
            $result .= ($info['close'] ? ' /' : '') . '>';
        return $result;
    }

    /**
     * Decorates the specified tag with artisteer button style.
     *
     * @param string $name tag name that should be decorated
     * @param array $filter select $name tags with attributes matching $filter
     * @return $content with replaced $name tags
     */
    function funcReplaceButtons($content, $filter = array('input' => array('class' => 'button')))
    {
        $result = '';
        foreach (funcFindTags($content, $filter) as $tag) {
            if (is_string($tag))
                $result .= $tag;
            else {
                $tag['attributes']['class']['value'][] = 'bd-button';
                $result .= funcTagInfoToString($tag);
            }
        }
        return $result;
    }

    function funcLinkButton($data = array())
    {
        return '<a class="' . (isset($data['classes']) && isset($data['classes']['a']) ? $data['classes']['a'] . ' ' : '')
            . 'bd-button" href="' . $data['link'] . '">' . $data['content'] . '</a>';
    }

    function funcHtmlFixFormAction($content)
    {
        if (preg_match('~ action="([^"]+)" ~', $content, $matches, PREG_OFFSET_CAPTURE)) {
            $content = substr($content, 0, $matches[0][1])
                . ' action="' . funcUrlToHref($matches[1][0]) . '" '
                . substr($content, $matches[0][1] + strlen($matches[0][0]));
        }
        return $content;
    }

    function funcTagBuilder($tag, $attributes = array(), $content = '') {
        $result = '<' . $tag;
        foreach ($attributes as $name => $value) {
            if (is_string($value)) {
                if (!empty($value))
                    $result .= ' ' . $name . '="' . $value . '"';
            } else if (is_array($value)) {
                $values = array_filter($value);
                if (count($values))
                    $result .= ' ' . $name . '="' . implode(' ', $value) . '"';
            }
        }
        $result .= '>' . $content . '</' . $tag . '>';
        return $result;
    }

    $funcFragments = array();

    function funcFragmentBegin($head = '')
    {
        global $funcFragments;
        $funcFragments[] = array('head' => $head, 'content' => '', 'tail' => '');
    }

    function funcFragmentContent($content = '')
    {
        global $funcFragments;
        $funcFragments[count($funcFragments) - 1]['content'] = $content;
    }

    function funcFragmentEnd($tail = '', $separator = '', $return = false)
    {
        global $funcFragments;
        $fragment = array_pop($funcFragments);
        $fragment['tail'] = $tail;
        $content = trim($fragment['content']);
        if (count($funcFragments) == 0) {
            if ($return)
                return (trim($content) == '') ? '' : ($fragment['head'] . $content . $fragment['tail']);
            echo (trim($content) == '') ? '' : ($fragment['head'] . $content . $fragment['tail']);
        } else {
            $result = (trim($content) == '') ? '' : ($fragment['head'] . $content . $fragment['tail']);
            $fragment =& $funcFragments[count($funcFragments) - 1];
            $fragment['content'] .= (trim($fragment['content']) == '' ? '' : $separator) . $result;
        }
    }

    function funcFragment($head = '', $content = '', $tail = '', $separator = '', $return = false)
    {
        global $funcFragments;
        if ($head != '' && $content == '' && $tail == '' && $separator == '') {
            $content = $head;
            $head = '';
        } elseif ($head != '' && $content != '' && $tail == '' && $separator == '') {
            $separator = $content;
            $content = $head;
            $head = '';
        }
        funcFragmentBegin($head);
        funcFragmentContent($content);
        funcFragmentEnd($tail, $separator, $return);
    }

    function funcPostprocessBlockContent($content)
    {
        return funcPostprocessContent($content);
    }

    function funcPostprocessPostContent($content)
    {
        return funcPostprocessContent($content);
    }

    function funcPostprocessContent($content)
    {
        $config = JFactory::getConfig();
        $sef = $config->get('sef');
        if ($sef)
            $content = str_replace('url(\'images/', 'url(\'' . JURI::base(true) . '/images/', $content);
        $content = funcReplaceButtons($content, array('input' => array('class' => array('button', '!bd-button')),
            'button' => array('class' => array('button', '!bd-button'))));
        return $content;
    }

    $balanceStorage = array();
    $balanceIndex = 0;

    function balanceReplacer($match) {
        global $balanceStorage;
        global $balanceIndex;
        $balanceIndex++;
        $key = '[[BDSCRIPT' . $balanceIndex . ']]';
        $balanceStorage[$key] = $match[0];
        return $key;
    }

    function balanceReplacer2($match) {
        global $balanceStorage;
        return $balanceStorage[$match[0]];
    }

    function funcBalanceTags($text) {

        $text = preg_replace_callback('/<script[^>]*>([\s\S]*?)<\/script>/', 'balanceReplacer' , $text);

        $singleTags = array('area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source');
        $nestedTags = array('blockquote', 'div', 'object', 'q', 'span');

        $stack = array();
        $size = 0;
        $queue = '';
        $output = '';

        while (preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $match)) {
            $output .= $queue;

            $i = strpos($text, $match[0]);
            $l = strlen($match[0]);

            $queue = '';

            if (isset($match[1][0]) && '/' == $match[1][0]) {
                // processing of the end tag
                $tag = strtolower(substr($match[1],1));

                if($size <= 0) {
                    $tag = '';
                } else if ($stack[$size - 1] == $tag) {
                    $tag = '</' . $tag . '>';
                    array_pop($stack);
                    $size--;
                } else {
                    for ($j = $size-1; $j >= 0; $j--) {
                        if ($stack[$j] == $tag) {
                            for ($k = $size-1; $k >= $j; $k--) {
                                $queue .= '</' . array_pop($stack) . '>';
                                $size--;
                            }
                            break;
                        }
                    }
                    $tag = '';
                }
            } else {
                // processing of the begin tag
                $tag = strtolower($match[1]);

                if (substr($match[2], -1) == '/') {
                    if (!in_array($tag, $singleTags))
                        $match[2] = trim(substr($match[2], 0, -1)) . "></$tag";
                } elseif (in_array($tag, $singleTags)) {
                    $match[2] .= '/';
                } else {
                    if ($size > 0 && !in_array($tag, $nestedTags) && $stack[$size - 1] == $tag) {
                        $queue = '</' . array_pop($stack) . '>';
                        $size--;
                    }
                    $size = array_push($stack, $tag);
                }

                // attributes
                $attributes = $match[2];
                if(!empty($attributes) && $attributes[0] != '>')
                    $attributes = ($tag ? ' ' : '') . $attributes;

                $tag = '<' . $tag . $attributes . '>';

                if (!empty($queue)) {
                    $queue .= $tag;
                    $tag = '';
                }
            }
            $output .= substr($text, 0, $i) . $tag;
            $text = substr($text, $i + $l);
        }

        $output .= ($queue . $text);

        while($t = array_pop($stack))
            $output .= '</' . $t . '>';

        $output = preg_replace_callback('/\[\[BDSCRIPT[0-9]+\]\]/', 'balanceReplacer2', $output);
        return $output;
    }

    /**
     * Build tabs
     *
     * Example:
     *   echo funcBuildTabs(array(
     *       array('id' => 'tab1', 'caption' => 'Tab 1', 'content' => ...),
     *       array('id' => 'tab2', 'caption' => 'Tab 2', 'content' => ...)
     *   ));
     */
    function funcBuildTabs($tabs) {
        $tabControl = '<div class="tabbable">';
        $tabControlTabs = '<ul class="nav nav-tabs">';
        $tabControlContents = '<div class="tab-content">';

        for($i = 0; $i < count($tabs); $i++) {
            $activeClass = (0 === $i ? 'active' : '');
            $liElement = '<li class="' . $activeClass . '"';
            $liElement .= '>';
            $aElement = '<a href="#' . $tabs[$i]['id'] . '" data-toggle="tab">';
            $aElement .= $tabs[$i]['caption'] . '</a>';
            $liElement .= $aElement . '</li>';

            $contentElement = '<div ';
            $contentElement .= 'class="tab-pane ' . $activeClass . '" ';
            $contentElement .= 'id="' . $tabs[$i]['id'] . '">';
            $contentElement .= '<div class="std">';
            $contentElement .= $tabs[$i]['content'] . '</div></div>';

            $tabControlTabs .= $liElement;
            $tabControlContents .= $contentElement;
        }

        $tabControlTabs .= '</ul>';
        $tabControlContents .= '</div>';

        $tabControl .= $tabControlTabs;
        $tabControl .= $tabControlContents;
        $tabControl .= '</div>';

        return $tabControl;
    }

    function funcBuildSliders($sliders) {
        $sliderControl = '<div class=" bd-accordion">';
            for($i = 0; $i < count($sliders); $i++) {
                $sliderControl .= '<div class=" bd-menuitem-14" id="tab' . $i . '">';
                $sliderControl .= '<a data-toggle="collapse" data-target="#tab' . $i . ' + div"' . (0 == $i ? ' class="active"' : '') .'>';
                $sliderControl .= $sliders[$i]['header'];
                $sliderControl .= '</a>';
                $sliderControl .= '</div>';
                $sliderControl .= '<div class="collapse' . (0 == $i ? ' in' : '') . '">';
                $sliderControl .= '<div class=" bd-container-43 bd-tagstyles clearfix">';
                $sliderControl .= $sliders[$i]['content'];
                $sliderControl .= '</div>';
                $sliderControl .= '</div>';
             }
        $sliderControl .= '</div>';
        return $sliderControl;
    }

    function funcBuildPages($pages) {
        $pagesControl = '<div class="list-group">';
        foreach($pages as $page) {
            $pagesControl .= '<a href="' . $page['href'] . '" class="list-group-item">' . $page['text'] . '</a>';
        }
        $pagesControl .= '</div>';
        return $pagesControl;
    }
    
    function funcBuildRoute($address, $attributeName = '') {

        $exts_media = array('gif', 'jpg', 'jpeg', 'png', 'wbmp', 'bmp');

        $startQuote = '"';
        $endQuote = '"';
        if (is_array($address)) {
            $attributeName = $address[1];
            $route = $address[3];
            $startQuote = $address[2];
            $endQuote = $address[4];
            if ($startQuote !== $endQuote)
                return $address[0];
        } else {
            $route = $address;
        }

        if ('.href' === $attributeName) {
            if ('/' !== substr($route, 0, 1)) {
                return $attributeName . "=" . $startQuote . $route . $endQuote;
            }
        }

        $template = JFactory::getApplication('site')->getTemplate();
        $exists_is_preview = false !== strpos($route, 'is_preview=on');

        $route_parts = pathinfo($route);
        $is_media = isset($route_parts['extension']) && in_array($route_parts['extension'], $exts_media);
        $isNotUrl = 0 !== preg_match('/^(javascript|mailto|tel):/', $route_parts['basename']);
        $firstSymbol = substr($route, 0, 1);
        $index = substr($route, 0, 9);
        $isExternal = preg_match('#^(https?:\/\/)|(\/\/)#', $route) ? true : false;
        if ('#' !== $firstSymbol && !$is_media && !$exists_is_preview && !$isNotUrl && !$isExternal) {
            if ('on' === JRequest::getCmd('is_preview')){
                if (('/' === $firstSymbol || 'index.php' === $index) && '' !== $template) {
                    $config = JFactory::getConfig();
                    $sef = $config->get('sef');
                    if ($sef) {
                        $combiner = '?';
                        if (false !== strpos($route_parts['filename'], '='))
                            $combiner = '&';
                        $route .= $combiner . 'template=' . $template . '&is_preview=on';
                    } else {
                        $parts = explode('index.php', $route);
                        if (count($parts) > 1) {
                            $query = array_pop($parts);
                            $route = $parts[0] . 'index.php' . ($query ? $query . '&' : '?') . 'template=' . $template . '&is_preview=on';
                        }
                    }
                } else {
                    $parts = parse_url($route);
                    $route .= (isset($parts['query']) && '' !== $parts['query'] ? '&' : '?') . 'template=' . $template . '&is_preview=on';
                }
            }
        }

        if ('.href' === $attributeName) {
            return $attributeName . "=" . $startQuote . $route . $endQuote;
        } else {
            return $attributeName ? $attributeName . '=' . $startQuote . $route . $endQuote : $route;
        }
    }

    function funcContentRoutesCorrector($content) {
        $content = preg_replace_callback('/([\s\.]href|[\s]action)=[\s]*([\"\'])?([^"\']*)([\"\'])/', "funcBuildRoute", $content);
        $content = replaceGlobalPlaceholders($content);
        return $content;
    }

    function replaceGlobalPlaceholders($content) {
        $url   = urlencode(JURI::getInstance()->toString());
        $title = urlencode(JFactory::getDocument()->title);
        return str_replace(array('[DYNAMIC-URL]', '[DYNAMIC-TITLE]') , array($url, $title), $content);
    }

    function addClassToTag($tagHtml, $value) {
        return preg_replace("/(class=)\"(.*?)\"/", "\\1\"\\2 ". $value ."\"", $tagHtml);
    }

    function addThemeVersion($url) {
        return $url . "?version=1.0.2149";
    }

    function buildDataPositionAttr($name)
    {
        return $GLOBALS['theme_settings']['is_preview'] ? 'data-position=' . $name : '';
    }

    function getCustomComponentContent($content, $type) {
        if (preg_match('/<!--COMPONENT ' . $type . ' -->([\s\S]*?)<!--COMPONENT ' . $type . ' \/-->/', $content, $matches)) {
            $additionalContent = preg_replace('/<!--COMPONENT [\w]+ -->([\s\S]*?)<!--COMPONENT [\w]+ \/-->/', '[DELIMETER]', $content, -1, $count);
            $parts = explode('[DELIMETER]', $additionalContent);
            $content = trim($parts[0]) . $matches[1] . trim($parts[$count]);
            $content = str_replace(' /**/style="display:none"/**/', '', $content);
        }
        return $content;
    }

    function getCurrentTemplateNameByFileName($fileName)
    {
        $themePath = JPATH_SITE . '/templates/' . JFactory::getApplication()->getTemplate();
        $templatesInfo = array();
        $editor = $GLOBALS['theme_settings']['is_preview'] ? '/editor' : '';
        $listPath = $themePath . $editor . '/templates/list.php';
        // including this file to create a variable - $resultTemplatesList, $templatesInfo
        include($listPath);
        foreach($templatesInfo as $name => $item) {
            if ($item['fileName'] == $fileName) {
                return $name;
            }
        }
        return '';
    }

    function sampleArticlesForPreview($template)
    {
        $items = array();
        if ($GLOBALS['theme_settings']['is_preview']) {

            $sampleData = getThemeParams('sampleData');
            if ($sampleData == '')
                return $items;

            $sampleData = json_decode($sampleData);
            $sampleData = $sampleData->blog;
            $currentTemplateName = getCurrentTemplateNameByFileName($template);
            if (!array_key_exists($currentTemplateName, $sampleData))
                return $items;

            $idsStr = $sampleData->{$currentTemplateName};
            if ('' == $idsStr)
               return $items;
            $articleIds = explode(',', $idsStr);
            require_once  JPATH_SITE . '/components/com_content/models/article.php';

            Designer::load('Designer_Data_Mappers');
            $content = Designer_Data_Mappers::get('content');

            $articleModel = new ContentModelArticle();
            foreach($articleIds as $id) {
                if (count($content->find(array('id' => $id, 'state' => 1))) == 0)
                   continue;
               $id = (int)$id;
               $res = $articleModel->getItem($id);
               if ($res !== false) {
                   $items[] = $res;
               }
            }

            foreach ($items as $item)
            {
                $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

                $item->parent_slug = ($item->parent_alias) ? ($item->parent_id . ':' . $item->parent_alias) : $item->parent_id;

                // No link for ROOT category
                if ($item->parent_alias == 'root')
                {
                    $item->parent_slug = null;
                }

                $item->catslug = $item->category_alias ? ($item->catid.':'.$item->category_alias) : $item->catid;
                $item->event   = new stdClass;

                $dispatcher = JEventDispatcher::getInstance();

                // Old plugins: Ensure that text property is available
                if (!isset($item->text))
                {
                    $item->text = $item->introtext;
                }

                JPluginHelper::importPlugin('content');
                $dispatcher->trigger('onContentPrepare', array ('com_content.category', &$item, &$item->params, 0));

                // Old plugins: Use processed text as introtext
                $item->introtext = $item->text;

                $results = $dispatcher->trigger('onContentAfterTitle', array('com_content.category', &$item, &$item->params, 0));
                $item->event->afterDisplayTitle = trim(implode("\n", $results));

                $results = $dispatcher->trigger('onContentBeforeDisplay', array('com_content.category', &$item, &$item->params, 0));
                $item->event->beforeDisplayContent = trim(implode("\n", $results));

                $results = $dispatcher->trigger('onContentAfterDisplay', array('com_content.category', &$item, &$item->params, 0));
                $item->event->afterDisplayContent = trim(implode("\n", $results));
            }
        }
        return $items;
    }

    function getCurrentTemplateByType($templateType)
    {
        // save cookie for rendering one component
        setcookie('componentType', $templateType, 0, '/');

        $com_option = JRequest::getCmd('option', '');
        $com_view = JRequest::getCmd('view', '');
        $currentItemTypes = array('option' => $com_option, 'view' => $com_view);

        $app = JFactory::getApplication();
        $menu = $app->getMenu();
        $activeItem = $menu->getActive();
        $activeItemTypes = $currentItemTypes;
        if ($activeItem && isset($activeItem->query['option']) && isset($activeItem->query['view'])) {
            $activeItemTypes = array('option' => $activeItem->query['option'],
                'view' => $activeItem->query['view']);
        }
        $lang = JFactory::getLanguage();
        if ($templateType != 'error404' && 0 == count(array_diff_assoc($currentItemTypes, $activeItemTypes))
            && ($activeItem == $menu->getDefault() || $activeItem == $menu->getDefault($lang->getTag()))) {
            $templateType = 'home';
        }

        $themePath = JPATH_SITE . '/templates/' . JFactory::getApplication()->getTemplate();

        $defaultTemplate = '';
        $templatesInfo = array();
        $editor = $GLOBALS['theme_settings']['is_preview'] ? '/editor' : '';
        $templateNameFromUrl = JRequest::getVar('file_template_name', '');
        $templateTypeFromUrl = $templateType;
        $listPath = $themePath . $editor . '/templates/list.php';
        // including this file to create a variable - $resultTemplatesList, $templatesInfo
        include($listPath);
        $defaultTemplateFound = false;
        foreach($templatesInfo as $item) {
            if ($templateType == $item['kind'] && 'false' == $item['isCustom'] && !$defaultTemplateFound) {
                $defaultTemplate = $item['fileName'];
                $defaultTemplateFound = true;
            }
            if ($templateNameFromUrl && $item['fileName'] == $templateNameFromUrl) {
                $templateTypeFromUrl = $item['kind'];
            }
        }

        $themeParams = JFactory::getApplication()->getTemplate(true)->params;
        if ($activeItem && (int) $activeItem->template_style_id > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('params')
                ->from('#__template_styles')
                ->where('id = ' . $activeItem->template_style_id)
                ->where('client_id = 0');
            $db->setQuery($query);
            $ret = $db->loadResult();
            if ($ret) {
                $newParams = new JRegistry();
                $newParams->loadString($ret);
                $themeParams = $newParams;
            }
        }
        if ('' !== $templateNameFromUrl && $templateTypeFromUrl == $templateType) {
            $currentTemplate = $templateNameFromUrl;
        } else if ('' !== $themeParams->get($templateType, '')) {
            $parts = explode(':', $themeParams->get($templateType, ''));
            $currentTemplate = count($parts) > 1 ? $parts[1] : $parts[0];
        } else {
            $currentTemplate = $defaultTemplate;
        }
        return file_exists($themePath . $editor . '/templates/' . $currentTemplate . '.php') ?
            $currentTemplate : $defaultTemplate;
    }
    $GLOBALS['theme_settings']['currentTemplate'] = getCurrentTemplateByType('default');

    function processingShortcodes($content) {
        if ($GLOBALS['theme_settings']['is_preview']) {
            Designer::addPath('PreviewShortcodes', dirname(__FILE__) . '/plugins/content/lib');
            Designer::load("PreviewShortcodes_Shortcodes");
            if (class_exists('DesignerShortcodes'))
                $content = DesignerShortcodes::process($content);
        }
        return $content;
    }

    function getThemeParams($name) {
        $template = JFactory::getApplication()->getTemplate();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id, params')
            ->from('#__template_styles')
            ->where('template = ' . $db->quote($template))
            ->where('client_id = 0');
        $db->setQuery($query);
        $templates = $db->loadObjectList('id');

        if (count($templates) < 1)
            return '';

        $site = JFactory::getApplication('site');
        $menu = $site->getMenu('site');
        $item = $menu->getActive();

        $id         = is_object($item) ? $item->template_style_id : 0;
        $template   = isset($templates[$id]) ? $templates[$id] : array_shift($templates);

        $registry = new JRegistry();
        $registry->loadString($template->params);
        return $registry->get($name, '');
    }

    function getColumnsClass($columns, $responsive, $themeOptions, $count) {
        $conf = array('lg' => 'desktops', 'md' => 'laptops', 'sm' => 'tablets', 'xs' => 'phones');

        $nextMode = '';
        $columnsClass = '';
        $columnsMax = 12;
        foreach(array('lg', 'md', 'sm', 'xs') as $mode) {
            if ($responsive == $mode)
                break;
            $nextMode = $mode;
            if ($themeOptions && !empty($themeOptions[$conf[$mode]])) {
                $columnsClass .= " col-$mode-" . ($columnsMax / $themeOptions[$conf[$mode]]);
            } else if (!empty($columns[$mode])) {
                $columnsClass .= " col-$mode-" . ($columnsMax / $columns[$mode]);
            }
        }
        if (!$columnsClass && $nextMode) {
            for($i = $count; $i <= $columnsMax; $i++) {
                if ($i && $columnsMax % $i === 0) {
                    $columnsClass .= " col-$nextMode-" . ($columnsMax / $i);
                    break;
                }
            }
        }
        return $columnsClass;
    }

    require_once dirname(__FILE__) . '/functions-additional.php';
}