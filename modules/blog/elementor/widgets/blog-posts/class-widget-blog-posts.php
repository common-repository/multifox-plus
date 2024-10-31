<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Blog_Posts extends MultifoxElementorWidgetBase {

    public function get_name() {
        return 'mfx-blog-posts';
    }

    public function get_title() {
        return esc_html__('Blog Posts', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-posts-grid mfx-icon';
	}

	public function get_style_depends() {
		return array( 'swiper', 'mfx-blogcarousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-swiper', 'mfx-blogcarousel' );
	}

    protected function _register_controls() {

        $this->start_controls_section( 'mfx_section_general', array(
            'label' => esc_html__( 'General', 'multifox-plus'),
        ) );

            $this->add_control( 'query_posts_by', array(
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__('Query posts by', 'multifox-plus'),
                'default' => 'category',
                'options' => array(
                    'category'  => esc_html__('From Category (for Posts only)', 'multifox-plus'),
                    'ids'       => esc_html__('By Specific IDs', 'multifox-plus'),
                )
            ) );

            $this->add_control( '_post_categories', array(
                'label'       => esc_html__( 'Categories', 'multifox-plus' ),
                'type'        => Controls_Manager:: SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->multifox_post_categories(),
                'condition'   => array( 'query_posts_by' => 'category' )
            ) );

            $this->add_control( '_post_ids', array(
                'label'       => esc_html__( 'Select Specific Posts', 'multifox-plus' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $this->multifox_post_ids(),
                'condition' => array( 'query_posts_by' => 'ids' )
            ) );

            $this->add_control( 'count', array(
                'type'        => Controls_Manager::NUMBER,
                'label'       => esc_html__('Post Counts', 'multifox-plus'),
                'default'     => '5',
                'placeholder' => esc_html__( 'Enter post count', 'multifox-plus' ),
            ) );

            $this->add_control( 'blog_post_layout', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Layout', 'multifox-plus'),
                'default' => 'entry-grid',
                'options' => array(
                    'entry-grid'  => esc_html__('Grid', 'multifox-plus'),
                    'entry-list'  => esc_html__('List', 'multifox-plus'),
                    'entry-cover' => esc_html__('Cover', 'multifox-plus'),
                )
            ) );

            $this->add_control( 'blog_post_grid_list_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Style', 'multifox-plus'),
                'default' => 'mfx-boxed',
                'options' => apply_filters( 'blog_post_grid_list_style_update', array(
                    'mfx-boxed' => esc_html__('Boxed', 'multifox-plus'),
                )),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_post_cover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Post Style', 'multifox-plus'),
                'default' => 'mfx-boxed',
                'options' => apply_filters('blog_post_cover_style_update', array(
                    'mfx-boxed' => esc_html__('Boxed', 'multifox-plus')
                )),
                'condition' => array( 'blog_post_layout' => 'entry-cover' )
            ) );

            $this->add_control( 'blog_post_columns', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Columns', 'multifox-plus'),
                'default' => 'one-third-column',
                'options' => array(
                    'one-column'        => esc_html__('I Column', 'multifox-plus'),
                    'one-half-column'   => esc_html__('II Columns', 'multifox-plus'),
                    'one-third-column'  => esc_html__('III Columns', 'multifox-plus'),
                    'one-fourth-column' => esc_html__('IV Columns', 'multifox-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'blog_list_thumb', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('List Type', 'multifox-plus'),
                'default' => 'entry-left-thumb',
                'options' => array(
                    'entry-left-thumb'  => esc_html__('Left Thumb', 'multifox-plus'),
                    'entry-right-thumb' => esc_html__('Right Thumb', 'multifox-plus'),
                ),
                'condition' => array( 'blog_post_layout' => 'entry-list' )
            ) );

            $this->add_control( 'blog_alignment', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Elements Alignment', 'multifox-plus'),
                'default' => 'alignnone',
                'options' => array(
                    'alignnone'   => esc_html__('None', 'multifox-plus'),
                    'alignleft'   => esc_html__('Align Left', 'multifox-plus'),
                    'aligncenter' => esc_html__('Align Center', 'multifox-plus'),
                    'alignright'  => esc_html__('Align Right', 'multifox-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_equal_height', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Equal Height?', 'multifox-plus'),
                'label_on'     => esc_html__( 'Yes', 'multifox-plus' ),
                'label_off'    => esc_html__( 'No', 'multifox-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_no_space', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable No Space?', 'multifox-plus'),
                'label_on'     => esc_html__( 'Yes', 'multifox-plus' ),
                'label_off'    => esc_html__( 'No', 'multifox-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-cover' ) )
            ) );

            $this->add_control( 'enable_gallery_slider', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Display Gallery Slider?', 'multifox-plus'),
                'label_on'     => esc_html__( 'Yes', 'multifox-plus' ),
                'label_off'    => esc_html__( 'No', 'multifox-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'multifox-plus'),
                'default' => 'feature_image',
                'options' => array(
                    'feature_image' => esc_html__('Feature Image', 'multifox-plus'),
                    'title'         => esc_html__('Title', 'multifox-plus'),
                    'content'       => esc_html__('Content', 'multifox-plus'),
                    'read_more'     => esc_html__('Read More', 'multifox-plus'),
                    'meta_group'    => esc_html__('Meta Group', 'multifox-plus'),
                    'author'        => esc_html__('Author', 'multifox-plus'),
                    'date'          => esc_html__('Date', 'multifox-plus'),
                    'comment'       => esc_html__('Comments', 'multifox-plus'),
                    'category'      => esc_html__('Categories', 'multifox-plus'),
                    'tag'           => esc_html__('Tags', 'multifox-plus'),
                    'social'        => esc_html__('Social Share', 'multifox-plus'),
                    'likes_views'   => esc_html__('Likes & Views', 'multifox-plus'),
                ),
            ) );

            $this->add_control( 'blog_elements_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Elements & Positioning', 'multifox-plus'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'title' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $content = new Repeater();
            $content->add_control( 'element_value', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Element', 'multifox-plus'),
                'default' => 'author',
                'options' => array(
                    'author'       => esc_html__('Author', 'multifox-plus'),
                    'date'         => esc_html__('Date', 'multifox-plus'),
                    'comment'      => esc_html__('Comments', 'multifox-plus'),
                    'category'     => esc_html__('Categories', 'multifox-plus'),
                    'tag'          => esc_html__('Tags', 'multifox-plus'),
                    'social'       => esc_html__('Social Share', 'multifox-plus'),
                    'likes_views'  => esc_html__('Likes & Views', 'multifox-plus'),
                ),
            ) );

            $this->add_control( 'blog_meta_position', array(
                'type'        => Controls_Manager::REPEATER,
                'label'       => esc_html__('Meta Group Positioning', 'multifox-plus'),
                'fields'      => array_values( $content->get_controls() ),
                'default'     => array(
                    array( 'element_value' => 'author' ),
                ),
                'title_field' => '{{{ element_value.replace( \'_\', \' \' ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}'
            ) );

            $this->add_control( 'enable_post_format', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Post Format?', 'multifox-plus'),
                'label_on'     => esc_html__( 'Yes', 'multifox-plus' ),
                'label_off'    => esc_html__( 'No', 'multifox-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'enable_video_audio', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Display Video & Audio for Posts?', 'multifox-plus'),
                'label_on'     => esc_html__( 'Yes', 'multifox-plus' ),
                'label_off'    => esc_html__( 'No', 'multifox-plus' ),
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) ),
                'description'  => esc_html__( 'YES! to display video & audio, instead of feature image for posts', 'multifox-plus' ),
            ) );

            $this->add_control( 'enable_excerpt_text', array(
                'type'         => Controls_Manager::SWITCHER,
                'label'        => esc_html__('Enable Excerpt Text?', 'multifox-plus'),
                'label_on'     => esc_html__( 'Yes', 'multifox-plus' ),
                'label_off'    => esc_html__( 'No', 'multifox-plus' ),
                'return_value' => 'yes',
                'default'      => '',
            ) );

            $this->add_control( 'blog_excerpt_length', array(
                'type'      => Controls_Manager::NUMBER,
                'label'     => esc_html__('Excerpt Length', 'multifox-plus'),
                'default'   => '25',
                'condition' => array( 'enable_excerpt_text' => 'yes' )
            ) );

            $this->add_control( 'blog_readmore_text', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Read More Text', 'multifox-plus'),
                'default'     => esc_html__('Read More', 'multifox-plus'),
            ) );

            $this->add_control( 'blog_image_hover_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Image Hover Style', 'multifox-plus'),
                'default' => 'mfx-default',
                'options' => array(
                    'mfx-default'     => esc_html__('Default', 'multifox-plus'),
                    'mfx-blur'        => esc_html__('Blur', 'multifox-plus'),
                    'mfx-bw'          => esc_html__('Black and White', 'multifox-plus'),
                    'mfx-brightness'  => esc_html__('Brightness', 'multifox-plus'),
                    'mfx-fadeinleft'  => esc_html__('Fade InLeft', 'multifox-plus'),
                    'mfx-fadeinright' => esc_html__('Fade InRight', 'multifox-plus'),
                    'mfx-hue-rotate'  => esc_html__('Hue-Rotate', 'multifox-plus'),
                    'mfx-invert'      => esc_html__('Invert', 'multifox-plus'),
                    'mfx-opacity'     => esc_html__('Opacity', 'multifox-plus'),
                    'mfx-rotate'      => esc_html__('Rotate', 'multifox-plus'),
                    'mfx-rotate-alt'  => esc_html__('Rotate Alt', 'multifox-plus'),
                    'mfx-scalein'     => esc_html__('Scale In', 'multifox-plus'),
                    'mfx-scaleout'    => esc_html__('Scale Out', 'multifox-plus'),
                    'mfx-sepia'       => esc_html__('Sepia', 'multifox-plus'),
                    'mfx-tint'        => esc_html__('Tint', 'multifox-plus'),
                ),
                'description' => esc_html__('Note: Fade, Rotate & Scale Styles will not work for Gallery Sliders.', 'multifox-plus'),
            ) );

            $this->add_control( 'blog_image_overlay_style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Image Overlay Style', 'multifox-plus'),
                'default' => 'mfx-default',
                'options' => array(
                    'mfx-default'         => esc_html__('None', 'multifox-plus'),
                    'mfx-fixed'           => esc_html__('Fixed', 'multifox-plus'),
                    'mfx-tb'              => esc_html__('Top to Bottom', 'multifox-plus'),
                    'mfx-bt'              => esc_html__('Bottom to Top', 'multifox-plus'),
                    'mfx-rl'              => esc_html__('Right to Left', 'multifox-plus'),
                    'mfx-lr'              => esc_html__('Left to Right', 'multifox-plus'),
                    'mfx-middle'          => esc_html__('Middle', 'multifox-plus'),
                    'mfx-middle-radial'   => esc_html__('Middle Radial', 'multifox-plus'),
                    'mfx-tb-gradient'     => esc_html__('Gradient - Top to Bottom', 'multifox-plus'),
                    'mfx-bt-gradient'     => esc_html__('Gradient - Bottom to Top', 'multifox-plus'),
                    'mfx-rl-gradient'     => esc_html__('Gradient - Right to Left', 'multifox-plus'),
                    'mfx-lr-gradient'     => esc_html__('Gradient - Left to Right', 'multifox-plus'),
                    'mfx-radial-gradient' => esc_html__('Gradient - Radial', 'multifox-plus'),
                    'mfx-flash'           => esc_html__('Flash', 'multifox-plus'),
                    'mfx-circle'          => esc_html__('Circle', 'multifox-plus'),
                    'mfx-hm-elastic'      => esc_html__('Horizontal Elastic', 'multifox-plus'),
                    'mfx-vm-elastic'      => esc_html__('Vertical Elastic', 'multifox-plus'),
                ),
                'condition' => array( 'blog_post_layout' => array( 'entry-grid', 'entry-list' ) )
            ) );

            $this->add_control( 'blog_pagination', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Pagination Style', 'multifox-plus'),
                'default' => 'older_newer',
                'options' => array(
                    ''                => esc_html__('None', 'multifox-plus'),
                    'older_newer'     => esc_html__('Older & Newer', 'multifox-plus'),
                    'numbered'        => esc_html__('Numbered', 'multifox-plus'),
                    'load_more'       => esc_html__('Load More', 'multifox-plus'),
                    'infinite_scroll' => esc_html__('Infinite Scroll', 'multifox-plus'),
                    'carousel'        => esc_html__('Carousel', 'multifox-plus'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'multifox-plus'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'multifox-plus')
            ) );

        $this->end_controls_section();

		$this->start_controls_section( 'blog_carousel_section', array(
			'label'     => esc_html__( 'Carousel Settings', 'multifox-plus' ),
			'condition' => array( 'blog_pagination' => 'carousel' ),
		) );
			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect', 'multifox-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'multifox-plus' ),
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Default', 'multifox-plus' ),
					'fade' => esc_html__( 'Fade', 'multifox-plus' ),
	            ),
	        ) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View', 'multifox-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Number slides of to show in view port.', 'multifox-plus' ),
				'options'     => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
				'default'     => 2,
	        ) );

			$this->add_control( 'carousel_loopmode', array(
				'label'        => esc_html__( 'Enable Loop Mode', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable continuous loop mode for your carousel.', 'multifox-plus'),
				'label_on'     => esc_html__( 'yes', 'multifox-plus' ),
				'label_off'    => esc_html__( 'no', 'multifox-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'        => esc_html__( 'Enable Mousewheel Control', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('If you wish, you can enable mouse wheel control for your carousel.', 'multifox-plus'),
				'label_on'     => esc_html__( 'yes', 'multifox-plus' ),
				'label_off'    => esc_html__( 'no', 'multifox-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'        => esc_html__( 'Enable Bullet Pagination', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable bullet pagination.', 'multifox-plus'),
				'label_on'     => esc_html__( 'yes', 'multifox-plus' ),
				'label_off'    => esc_html__( 'no', 'multifox-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'        => esc_html__( 'Enable Arrow Pagination', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable arrow pagination.', 'multifox-plus'),
				'label_on'     => esc_html__( 'yes', 'multifox-plus' ),
				'label_off'    => esc_html__( 'no', 'multifox-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type', 'multifox-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.', 'multifox-plus' ),
				'options'     => array(
					''      => esc_html__('Default', 'multifox-plus'),
					'type2' => esc_html__('Type 2', 'multifox-plus'),
				),
				'condition'   => array( 'carousel_arrowpagination' => 'true' ),
				'default'     => '',
	        ) );

			$this->add_control( 'carousel_scrollbar', array(
				'label'        => esc_html__( 'Enable Scrollbar', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__('To enable scrollbar for your carousel.', 'multifox-plus'),
				'label_on'     => esc_html__( 'yes', 'multifox-plus' ),
				'label_off'    => esc_html__( 'no', 'multifox-plus' ),
				'default'      => '',
				'return_value' => 'true',
			) );

		$this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

		$media_carousel_attributes_string = $container_class = $wrapper_class = $item_class = '';

		if( $blog_pagination == 'carousel' ) {

			$media_carousel_attributes = array ();

			array_push( $media_carousel_attributes, 'data-carouseleffect="'.esc_attr($settings['carousel_effect']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselslidesperview="'.esc_attr($settings['carousel_slidesperview']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselloopmode="'.esc_attr($settings['carousel_loopmode']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselmousewheelcontrol="'.esc_attr($settings['carousel_mousewheelcontrol']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselbulletpagination="'.esc_attr($settings['carousel_bulletpagination']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselarrowpagination="'.esc_attr($settings['carousel_arrowpagination']).'"' );
			array_push( $media_carousel_attributes, 'data-carouselscrollbar="'.esc_attr($settings['carousel_scrollbar']).'"' );

			if( !empty( $media_carousel_attributes ) ) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$container_class = 'swiper-container';
			$wrapper_class = 'swiper-wrapper';
			$item_class = 'swiper-slide';

			$out .= '<div class="mfx-post-list-carousel-container">';
		}

		$out .= '<div class="mfx-posts-list-wrapper '.esc_attr($container_class).' '.esc_attr($el_class).'" '.multifox_html_output($media_carousel_attributes_string).'>';

		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
		$warning = esc_html__('No Posts Found','multifox-plus');

        if( !empty( $_post_categories ) && $query_posts_by == 'category' ) {
            $_post_categories = implode( ',', $_post_categories );
			$args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'cat' => $_post_categories, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
			$warning = esc_html__('No Posts Found in Category ','designthemes-theme').$_post_categories;
		} elseif( $query_posts_by == 'ids' && !empty( $_post_ids ) ) {
            $args = array( 'paged' => $paged, 'posts_per_page' => $count, 'orderby' => 'date', 'post__in' => $_post_ids, 'ignore_sticky_posts' => true, 'post_status' => 'publish' );
            $warning = esc_html__('No Posts Found in Criteria ','designthemes-theme').$_post_categories;
        }

		if( !empty( $_post_not_in ) ) {
			$args['post__not_in'] = array( $_post_not_in );
            $settings['blog_excerpt_length'] = $settings['blog_excerpt_length2'];
		}

		$rposts = new WP_Query( $args );
		if ( $rposts->have_posts() ) :

           	do_action( 'call_blog_elementor_sc_filters', $settings );

            $holder_class  = multifox_get_archive_post_holder_class();
            $combine_class = multifox_get_archive_post_combine_class();

            $post_style    = multifox_get_archive_post_style();
            $template_args['Post_Style'] = $post_style;
            $template_args = array_merge( $template_args, multifox_archive_blog_post_params() );
            $template_args = apply_filters( 'multifox_blog_archive_elem_order_params', $template_args );

            // css enqueue
            wp_enqueue_style( 'multifox-plus-blog', MULTIFOX_PLUS_DIR_URL . 'modules/blog/assets/css/blog.css', false, MULTIFOX_PLUS_VERSION, 'all');

            $file_path = MULTIFOX_PRO_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
            if ( file_exists( $file_path ) ) {
                wp_enqueue_style( 'mfx-blog-archive-'.esc_attr($post_style), MULTIFOX_PRO_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, MULTIFOX_PRO_VERSION, 'all');
            } else {
                $file_path = MULTIFOX_PLUS_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
                if ( file_exists( $file_path ) ) {
                    wp_enqueue_style( 'mfx-blog-archive-'.esc_attr($post_style), MULTIFOX_PLUS_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, MULTIFOX_PLUS_VERSION, 'all');
                }
            }

            $out .= "<div class='tpl-blog-holder ".$holder_class."'>";
            $out .= "<div class='grid-sizer ".$combine_class."'></div>";

                while( $rposts->have_posts() ) :
                    $rposts->the_post();
                    $post_ID = get_the_ID();

                    $out .= '<div class="'.esc_attr($combine_class).'">';
                        $out .= '<article id="post-'.esc_attr($post_ID).'" class="' . implode( ' ', get_post_class( '', $post_ID ) ) . '">';

                            $template_args['ID'] = $post_ID;
                            $out .= multifox_get_template_part( 'blog', 'templates/'.esc_attr($post_style).'/post', '', $template_args );
                        $out .= '</article>';
                    $out .= '</div>';
                endwhile;

			wp_reset_postdata($rposts);

            $out .= '</div>';

			if( $blog_pagination == 'numbered' ):

				$out .= '<div class="pagination blog-pagination">'.multifox_pagination($rposts).'</div>';

			elseif( $blog_pagination == 'older_newer' ):

				$out .= '<div class="pagination blog-pagination"><div class="newer-posts">'.get_previous_posts_link( '<i class="mfxicon-angle-left"></i>'.esc_html__(' Newer Posts', 'multifox-plus') ).'</div>';
				$out .= '<div class="older-posts">'.get_next_posts_link( esc_html__('Older Posts ', 'multifox-plus').'<i class="mfxicon-angle-right"></i>', $rposts->max_num_pages ).'</div></div>';

			elseif( $blog_pagination == 'load_more' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

				$out .= "<div class='pagination blog-pagination'><a class='loadmore-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' href='javascript:void(0);' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'>".esc_html__('Load More', 'multifox-plus')."</a></div>";

			elseif( $blog_pagination == 'infinite_scroll' ):

				//$pos = $count % $columns;
				//$pos += 1;
                $pos = 1;
                $_post_categories = !empty( $_post_categories ) ? $_post_categories : '';

                $out .= "<div class='pagination blog-pagination'><div class='infinite-elementor-btn more-items' data-count='".$count."' data-cats='".$_post_categories."' data-maxpage='".esc_attr($rposts->max_num_pages)."' data-pos='".esc_attr($pos)."' data-eheight='".esc_attr($enable_equal_height)."' data-style='".esc_attr($post_style)."' data-layout='".esc_attr($blog_post_layout)."' data-column='".esc_attr($blog_post_columns)."' data-listtype='".esc_attr($blog_list_thumb)."' data-hover='".esc_attr($blog_image_hover_style)."' data-overlay='".esc_attr($blog_image_overlay_style)."' data-align='".esc_attr($blog_alignment)."' data-meta='' data-blogpostloadmore-nonce='".wp_create_nonce('blogpostloadmore_nonce')."' data-settings='".http_build_query($settings)."'></div></div>";

			elseif( $blog_pagination == 'carousel' ):

				$out .= '<div class="mfx-products-pagination-holder">';

					if( $settings['carousel_bulletpagination'] == 'true' ) {
						$out .= '<div class="mfx-products-bullet-pagination"></div>';
					}

					if( $settings['carousel_scrollbar'] == 'true' ) {
						$out .= '<div class="mfx-products-scrollbar"></div>';
					}

					if( $settings['carousel_arrowpagination'] == 'true' ) {
						$out .= '<div class="mfx-products-arrow-pagination '.esc_attr($settings['carousel_arrowpagination_type']).'">';
							$out .= '<a href="#" class="mfx-products-arrow-prev">'.esc_html__('Prev', 'multifox-plus').'</a>';
							$out .= '<a href="#" class="mfx-products-arrow-next">'.esc_html__('Next', 'multifox-plus').'</a>';
						$out .= '</div>';
					}

				$out .= '</div>';

			endif;

		else:
			$out .= "<div class='mfx-warning-box'>{$warning}</div>";
		endif;

		$out .= '</div>';

		if( $blog_pagination == 'carousel' ) {
			$out .= '</div>';
		}

        echo multifox_html_output($out);
    }

}