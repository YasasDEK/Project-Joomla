<?php
$base = $document->getBase();
if ( !empty( $base ) ) {
    echo '<base href="' . $base . '" />';
    $document->setBase( '' );
    $app = JFactory::getApplication();
    $tplparams = $app->getTemplate( true )->params;

    $slide1 = htmlspecialchars( $tplparams->get( 'slide1' ) );
    $slide2 = htmlspecialchars( $tplparams->get( 'slide2' ) );
    $slide3 = htmlspecialchars( $tplparams->get( 'slide3' ) );
    $slide4 = htmlspecialchars( $tplparams->get( 'slide4' ) );
    $slide5 = htmlspecialchars( $tplparams->get( 'slide5' ) );

    /*close section*/
    $slideshow_close = htmlspecialchars( $tplparams->get( 'slideshow_close' ) );
    $counter_close = htmlspecialchars( $tplparams->get( 'counter_close' ) );
    $info1_close = htmlspecialchars( $tplparams->get( 'info1_close' ) );
    $gallery1_close = htmlspecialchars( $tplparams->get( 'gallery1_close' ) );
    $info2_close = htmlspecialchars( $tplparams->get( 'info2_close' ) );
    $portfolio_close = htmlspecialchars( $tplparams->get( 'portfolio_close' ) );
    $info3_close = htmlspecialchars( $tplparams->get( 'info3_close' ) );
    $footer_close = htmlspecialchars( $tplparams->get( 'footer_close' ) );
    $design_close = htmlspecialchars( $tplparams->get( 'design_close' ) );
    $slideshowpost_close = htmlspecialchars( $tplparams->get( 'slideshowpost_close' ) );
    
}

?>
<link href="<?php echo JURI::base()?>/<?php echo $document->params->get('fav'); ?>" rel="icon" type="image/x-icon"/>