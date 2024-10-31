<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( $archive_readmore_text != '' ) :
		echo '<!-- Entry Button --><div class="entry-button">';
			echo '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="mfx-button">'.esc_html($archive_readmore_text).'<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
	   <style type="text/css">
			   .st01a{clip-path:url(#SVGID_21A);fill:none;stroke:currentColor;stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
	   </style>
	   <g>
		   <defs>
			   <rect id="SVGID_11A" x="0" y="19.9" width="99.9" height="62.1"/>
		   </defs>
		   <clipPath id="SVGID_21A">
			   <use xlink:href="#SVGID_11A"  style="overflow:visible;"/>
		   </clipPath>
		   <polyline class="st01a" points="3.2,50.9 96.7,50.9 68.9,23 	"/>
		   <line class="st01a" x1="96.7" y1="50.9" x2="68.9" y2="78.8"/>
	   </g>
	   </svg></span></a>';
		echo '</div><!-- Entry Button -->';
	endif; ?>