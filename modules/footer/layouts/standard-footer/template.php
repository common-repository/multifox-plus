<footer id="footer" class="standard-footer">
    <div class="container">
        <div class="footer-widgets">
            <?php 
                for( $i=1; $i<=$count; $i++ ) {
                    $temp_class = ( $i == 1 ) ? $class . ' first': $class;
                    echo '<div class="'.esc_attr( $temp_class ).'">';
                        if( is_active_sidebar('footer_'.$i) ) {
                            dynamic_sidebar('footer_'.$i);
                        }
                    echo '</div>';
                }?>
        </div>
        <div class="footer-copyright aligncenter">
            <span> &copy; <?php echo date('Y') .' '. get_bloginfo('name') .' '.get_bloginfo('description', 'display'); ?></span>
        </div>
    </div>
</footer>