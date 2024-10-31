<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$content = trim( get_the_content( '', false, $post_ID ) );
    // Take the first quote from the content
    preg_match('/<blockquote>(.*?)<\/blockquote>/s', $content, $match);
    $quote_string = isset( $match[0] ) ? $match[0] : '';

    // Make sure there's a quote on the content
    if ( !$quote_string == "" ) : ?>
    	<div class="entry-quote-inner">
    		<div class="entry-quote-text">
    			<span class="mfxicon-quote-left"></span>
    			<?php echo multifox_html_output($quote_string); ?>
    		</div><!-- Quote Text -->
    	</div><!-- Quote Inner --><?php
    endif;
?>