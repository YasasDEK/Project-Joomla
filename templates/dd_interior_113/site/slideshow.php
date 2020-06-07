<style>
.bd-slide-4 {background-image: url(<?php echo JURI::base()?>/<?php echo $document->params->get('s1-1'); ?>);}
.bd-slide-6 {background-image: url(<?php echo JURI::base()?>/<?php echo $document->params->get('s2-1'); ?>);}

</style>
<section class=" bd-section-19 bd-page-width bd-tagstyles " id="slider" data-section-title="slider">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-parallaxbackground-1 bd-parallax-bg-effect" data-control-selector=".bd-slider-3">



<div id="carousel-3" class="bd-slider-3 bd-background-width   bd-slider bd-no-margins  carousel slide bd-carousel-fade" >
    

    

    

    <div class="bd-slides carousel-inner">
        <?php if ($slide1 == 1) { ?><div class=" bd-slide-4 bd-textureoverlay bd-textureoverlay-3 bd-slide item"
    
    
    >
    <div class="bd-container-inner">
        <div class="bd-container-inner-wrapper">
            <div class=" bd-layoutbox-21 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <div class=" bd-layoutbox-41 animated bd-animation-41 bd-no-margins clearfix" data-animation-name="fadeInLeft" data-animation-event="slidein" data-animation-duration="1000ms" data-animation-delay="700ms" data-animation-infinited="false">
    <div class="bd-container-inner">
        <div class=" bd-customhtml-3 bd-tagstyles">
    <div class="bd-container-inner bd-content-element">

<script>

'use strict';

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// ——————————————————————————————————————————————————
// TextScramble
// ——————————————————————————————————————————————————

function textScramble() {
  var TextScramble = function () {
    function TextScramble(el) {
      _classCallCheck(this, TextScramble);

      this.el = el;
      this.chars = 'lkjsbdkjbdslkdjsblkbsdl';
      this.update = this.update.bind(this);
    }

    TextScramble.prototype.setText = function setText(newText) {
      var _this = this;

      var oldText = this.el.innerText;
      var length = Math.max(oldText.length, newText.length);
      var promise = new Promise(function (resolve) {
        return _this.resolve = resolve;
      });
      this.queue = [];
      for (var i = 0; i < length; i++) {
        var from = oldText[i] || '';
        var to = newText[i] || '';
        var start = Math.floor(Math.random() * 40);
        var end = start + Math.floor(Math.random() * 80);
        this.queue.push({ from: from, to: to, start: start, end: end });
      }
      cancelAnimationFrame(this.frameRequest);
      this.frame = 0;
      this.update();
      return promise;
    };

    TextScramble.prototype.update = function update() {
      var output = '';
      var complete = 0;
      for (var i = 0, n = this.queue.length; i < n; i++) {
        var _queue$i = this.queue[i];
        var from = _queue$i.from;
        var to = _queue$i.to;
        var start = _queue$i.start;
        var end = _queue$i.end;
        var char = _queue$i.char;

        if (this.frame >= end) {
          complete++;
          output += to;
        } else if (this.frame >= start) {
          if (!char || Math.random() < 0.28) {
            char = this.randomChar();
            this.queue[i].char = char;
          }
          output += '<span class="dud">' + char + '</span>';
        } else {
          output += from;
        }
      }
      this.el.innerHTML = output;
      if (complete === this.queue.length) {
        this.resolve();
      } else {
        this.frameRequest = requestAnimationFrame(this.update);
        this.frame++;
      }
    };

    TextScramble.prototype.randomChar = function randomChar() {
      return this.chars[Math.floor(Math.random() * this.chars.length)];
    };

    return TextScramble;
  }();

  // ——————————————————————————————————————————————————
  // Example
  // ——————————————————————————————————————————————————

  var phrases = ['<?php echo $document->params->get('s1-2'); ?>'];

  var el = document.querySelector('.text');
  var fx = new TextScramble(el);

  var counter = 0;
  var next = function next() {
    fx.setText(phrases[counter]).then(function () {
      setTimeout(next, 2500);
    });
    counter = (counter + 1) % phrases.length;
  };

  next();
}
setTimeout(textScramble, 0);


</script>

<style>



.containertext {
  height: 100%;
  width: 100%;
  justify-content: left;
  align-items: left;
  display: flex;
    margin-top:60px;
    margin-left 40px;
}
.text {
  font-weight: 100;
  font-size: 50px;
  color: #fafafa;
  line-height:50px;
}
.dud {
  color: #757575;
}


</style>



<div class="containertext">
  <div class="text"><span class="dud">d</span><span class="dud">d</span><span class="dud">l</span>h<span class="dud">k</span>t<span class="dud">b</span>c<span class="dud">l</span><span class="dud">k</span><span class="dud">l</span><span class="dud">b</span> <span class="dud">s</span><span class="dud">b</span><span class="dud">k</span><span class="dud">j</span><span class="dud">k</span><span class="dud">k</span><span class="dud">k</span><span class="dud">b</span><span class="dud">b</span>r</div>
</div>
  </div>
</div>
    </div>
</div>
	
		<div class=" bd-spacer-5 clearfix"></div>
	
		<div class="bd-separator-3 animated bd-animation-43  bd-separator-left bd-separator-content-center clearfix"  data-animation-name="fadeIn" data-animation-event="slidein" data-animation-duration="1000ms" data-animation-delay="600ms" data-animation-infinited="false">
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<p class=" bd-textblock-21 animated bd-animation-42 bd-content-element" data-animation-name="fadeInLeft" data-animation-event="slidein" data-animation-duration="1000ms" data-animation-delay="300ms" data-animation-infinited="false">
<?php echo $document->params->get('s1-2a'); ?>
</p>
    </div>
</div>
	
		<div class=" bd-layoutbox-50 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <div class=" bd-layoutbox-52 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <?php
$app = JFactory::getApplication();
$themeParams = $app->getTemplate(true)->params;
$sitename = $app->getCfg('sitename');
$logoSrc = '';
ob_start();
?>
src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); ?>/images/designer/logo.png"
<?php

$logoSrc = ob_get_clean();
$logoLink = '';

if ($themeParams->get('logoFile'))
    $logoSrc = 'src="' . JURI::root() . $themeParams->get('logoFile') . '"';

if ($themeParams->get('logoLink'))
    $logoLink = $themeParams->get('logoLink');

if (!$logoLink)
    $logoLink = JUri::base(true);

?>
<a class=" bd-logo-5" href="<?php echo $logoLink; ?>">
<img class=" bd-imagestyles-147 animated bd-animation-5 animated bd-animation-15" data-animation-name="fadeInDownBig,fadeOutUpBig" data-animation-event="slidein,slideout" data-animation-duration="1200ms,1200ms" data-animation-delay="600ms,600ms" data-animation-infinited="false,false" <?php echo $logoSrc; ?> alt="<?php echo $sitename; ?>">
</a>
	
		<div class=" bd-spacer-13 clearfix"></div>
	
		<div class="bd-separator-6 hidden-xs animated bd-animation-7 animated bd-animation-17  bd-separator-center bd-separator-content-center clearfix"  data-animation-name="fadeIn,fadeOut" data-animation-event="slidein,slideout" data-animation-duration="1100ms,1000ms" data-animation-delay="200ms,200ms" data-animation-infinited="false,false">
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<div class=" bd-layoutbox-2 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <p class=" bd-textblock-2 hidden-xs animated bd-animation-11 animated bd-animation-21 bd-content-element" data-animation-name="fadeIn,fadeOut" data-animation-event="slidein,slideout" data-animation-duration="1000ms,1000ms" data-animation-delay="1300ms,500ms" data-animation-infinited="false,false">
<?php echo $document->params->get('s1-3'); ?>
</p>
    </div>
</div>
	
		<div class="bd-separator-4 hidden-xs animated bd-animation-18 animated bd-animation-19  bd-separator-center bd-separator-content-center clearfix"  data-animation-name="fadeIn,fadeOut" data-animation-event="slidein,slideout" data-animation-duration="1000ms,1000ms" data-animation-delay="200ms,300ms" data-animation-infinited="false,false">
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<a 
 href="<?php echo $document->params->get('s1-5'); ?>" class="bd-linkbutton-9 hidden-xs animated bd-animation-13 animated bd-animation-22  bd-button-160  bd-own-margins bd-content-element"  data-animation-name="fadeInUp,fadeOutDown" data-animation-event="slidein,slideout" data-animation-duration="1000ms,1000ms" data-animation-delay="1500ms,1500ms" data-animation-infinited="false,false"   >
    <?php echo $document->params->get('s1-4'); ?>
</a>
    </div>
</div>
    </div>
</div>
        </div>
    </div>
</div><?php } ?>
	
		<?php if ($slide2 == 1) { ?><div class=" bd-slide-6 bd-slide item"
    
    
    >
    <div class="bd-container-inner">
        <div class="bd-container-inner-wrapper">
            <div class=" bd-layoutbox-23 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <div class=" bd-layoutbox-24 animated bd-animation-56 bd-no-margins clearfix" data-animation-name="fadeInLeft" data-animation-event="slidein" data-animation-duration="1000ms" data-animation-delay="700ms" data-animation-infinited="false">
    <div class="bd-container-inner">
        <div class=" bd-flexalign-2 bd-no-margins bd-flexalign"><div class=" bd-customhtml-4 bd-tagstyles ">
    <div class="bd-container-inner bd-content-element">

<div class="containertext">
  <div class="texts2"><?php echo $document->params->get('s2-2'); ?></div>
</div>

    </div>
</div></div>
    </div>
</div>
	
		<div class=" bd-spacer-14 clearfix"></div>
    </div>
</div>
	
		<div class=" bd-layoutbox-19 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <div class=" bd-layoutbox-20 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <?php
$app = JFactory::getApplication();
$themeParams = $app->getTemplate(true)->params;
$sitename = $app->getCfg('sitename');
$logoSrc = '';
ob_start();
?>
src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate(); ?>/images/designer/logo.png"
<?php

$logoSrc = ob_get_clean();
$logoLink = '';

if ($themeParams->get('logoFile'))
    $logoSrc = 'src="' . JURI::root() . $themeParams->get('logoFile') . '"';

if ($themeParams->get('logoLink'))
    $logoLink = $themeParams->get('logoLink');

if (!$logoLink)
    $logoLink = JUri::base(true);

?>
<a class=" bd-logo-7" href="<?php echo $logoLink; ?>">
<img class=" bd-imagestyles-149 animated bd-animation-52 animated bd-animation-53" data-animation-name="fadeInDownBig,fadeOutUpBig" data-animation-event="slidein,slideout" data-animation-duration="1200ms,1200ms" data-animation-delay="600ms,600ms" data-animation-infinited="false,false" <?php echo $logoSrc; ?> alt="<?php echo $sitename; ?>">
</a>
	
		<div class=" bd-spacer-12 clearfix"></div>
	
		<div class="bd-separator-13 hidden-xs animated bd-animation-50 animated bd-animation-51  bd-separator-center bd-separator-content-center clearfix"  data-animation-name="fadeIn,fadeOut" data-animation-event="slidein,slideout" data-animation-duration="1100ms,1000ms" data-animation-delay="200ms,200ms" data-animation-infinited="false,false">
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<div class=" bd-layoutbox-22 bd-no-margins clearfix">
    <div class="bd-container-inner">
        <p class=" bd-textblock-13 hidden-xs animated bd-animation-48 animated bd-animation-49 bd-content-element" data-animation-name="fadeIn,fadeOut" data-animation-event="slidein,slideout" data-animation-duration="1000ms,1000ms" data-animation-delay="1300ms,500ms" data-animation-infinited="false,false">
<?php echo $document->params->get('s2-3'); ?>
</p>
    </div>
</div>
	
		<div class="bd-separator-12 hidden-xs animated bd-animation-46 animated bd-animation-47  bd-separator-center bd-separator-content-center clearfix"  data-animation-name="fadeIn,fadeOut" data-animation-event="slidein,slideout" data-animation-duration="1000ms,1000ms" data-animation-delay="200ms,300ms" data-animation-infinited="false,false">
    <div class="bd-container-inner">
        <div class="bd-separator-inner">
            
        </div>
    </div>
</div>
	
		<a 
 href="<?php echo $document->params->get('s2-5'); ?>" class="bd-linkbutton-20 hidden-xs animated bd-animation-44 animated bd-animation-45  bd-button-166  bd-own-margins bd-content-element"  data-animation-name="fadeInUp,fadeOutDown" data-animation-event="slidein,slideout" data-animation-duration="1000ms,1000ms" data-animation-delay="1500ms,1500ms" data-animation-infinited="false,false"   >
   <?php echo $document->params->get('s2-4'); ?>
</a>
    </div>
</div>
    </div>
</div>
        </div>
    </div>
</div>
		<?php } ?>
	
	
    </div>

    

    

    
        <div class="bd-left-button">
    <a class=" bd-carousel-23" href="#">
        <span class="bd-icon"></span>
    </a>
</div>

<div class="bd-right-button">
    <a class=" bd-carousel-23" href="#">
        <span class="bd-icon"></span>
    </a>
</div>

    <script type="text/javascript">
        /* <![CDATA[ */
        if ('undefined' !== typeof initSlider) {
            initSlider(
                '.bd-slider-3',
                {
                    leftButtonSelector: 'bd-left-button',
                    rightButtonSelector: 'bd-right-button',
                    navigatorSelector: '.bd-carousel-23',
                    indicatorsSelector: '.bd-indicators',
                    carouselInterval: <?php echo $document->params->get('speed'); ?>,
                    carouselPause: "hover",
                    carouselWrap: true,
                    carouselRideOnStart: true
                }
            );
        }
        /* ]]> */
    </script>
</div></div>
    </div>
</section>