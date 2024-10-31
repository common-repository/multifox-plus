<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusCustomizerSiteBlog' ) ) {
    class MultifoxPlusCustomizerSiteBlog {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15 );
            add_filter( 'multifox_plus_customizer_default', array( $this, 'default' ) );
        }

        function default( $option ) {

            $option['blog-post-layout']          = 'entry-grid';
            $option['blog-post-grid-list-style'] = 'mfx-boxed';
            $option['blog-post-cover-style']     = 'mfx-boxed';
            $option['blog-post-columns']         = 'one-column';
            $option['blog-list-thumb']           = 'entry-left-thumb';
            $option['blog-alignment']            = 'alignnone';
            $option['enable-equal-height']       = '0';
            $option['enable-no-space']           = '0';
            $option['enable-gallery-slider']     = '1';
            $option['blog-elements-position']    = array( 'feature_image', 'title', 'content', 'meta_group', 'read_more' );
            $option['blog-meta-position']        = array( 'author', 'category', 'tag', 'date', 'comment' );
            $option['enable-post-format']        = '0';
            $option['enable-excerpt-text']       = '1';
            $option['blog-excerpt-length']       = '25';
            $option['enable-video-audio']        = '0';
            $option['blog-readmore-text']        = esc_html__('Read More', 'multifox-plus');
            $option['blog-image-hover-style']    = 'mfx-default';
            $option['blog-image-overlay-style']  = 'mfx-default';
            $option['blog-pagination']           = 'pagination-default';

            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Panel
             */
            $wp_customize->add_panel(
                new Multifox_Customize_Panel(
                    $wp_customize,
                    'site-blog-main-panel',
                    array(
                        'title'    => esc_html__('Blog Settings', 'multifox-plus'),
                        'priority' => multifox_customizer_panel_priority( 'blog' )
                    )
                )
            );

            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-blog-archive-section',
                    array(
                        'title'    => esc_html__('Blog Archives', 'multifox-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 10,
                    )
                )
            );


            /**
             * Option : Archive Post Layout
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control_Radio_Image(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-post-layout]', array(
                    'type' => 'mfx-radio-image',
                    'label' => esc_html__( 'Post Layout', 'multifox-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'multifox_blog_archive_layout_options', array(
                        'entry-grid' => array(
                            'label' => esc_html__( 'Grid', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-grid.png'
                        ),
                        'entry-list' => array(
                            'label' => esc_html__( 'List', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-list.png'
                        ),
                        'entry-cover' => array(
                            'label' => esc_html__( 'Cover', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-cover.png'
                        ),
                    ))
                )
            ));

            /**
             * Option : Post Grid, List Style
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-post-grid-list-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'multifox-plus' ),
                    'choices' => apply_filters('blog_post_grid_list_style_update', array(
                        'mfx-boxed' => esc_html__('Boxed', 'multifox-plus'),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' )
                )
            ));

            /**
             * Option : Post Cover Style
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-post-cover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Post Style', 'multifox-plus' ),
                    'choices' => apply_filters('blog_post_cover_style_update', array(
                        'mfx-boxed' => esc_html__('Boxed', 'multifox-plus')
                    )),
                    'dependency'   => array( 'blog-post-layout', '==', 'entry-cover' )
                )
            ));

            /**
             * Option : Post Columns
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control_Radio_Image(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-post-columns]', array(
                    'type' => 'mfx-radio-image',
                    'label' => esc_html__( 'Columns', 'multifox-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'multifox_blog_archive_columns_options', array(
                        'one-column' => array(
                            'label' => esc_html__( 'One Column', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/one-column.png'
                        ),
                        'one-half-column' => array(
                            'label' => esc_html__( 'One Half Column', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/one-half-column.png'
                        ),
                        'one-third-column' => array(
                            'label' => esc_html__( 'One Third Column', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/one-third-column.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : List Thumb
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control_Radio_Image(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-list-thumb]', array(
                    'type' => 'mfx-radio-image',
                    'label' => esc_html__( 'List Type', 'multifox-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'multifox_blog_archive_list_thumb_options', array(
                        'entry-left-thumb' => array(
                            'label' => esc_html__( 'Left Thumb', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-left-thumb.png'
                        ),
                        'entry-right-thumb' => array(
                            'label' => esc_html__( 'Right Thumb', 'multifox-plus' ),
                            'path' => MULTIFOX_PLUS_DIR_URL . 'modules/blog/customizer/images/entry-right-thumb.png'
                        ),
                    )),
                    'dependency' => array( 'blog-post-layout', '==', 'entry-list' ),
                )
            ));

            /**
             * Option : Post Alignment
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-alignment]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Elements Alignment', 'multifox-plus' ),
                    'choices' => array(
                      'alignnone'   => esc_html__('None', 'multifox-plus'),
                      'alignleft'   => esc_html__('Align Left', 'multifox-plus'),
                      'aligncenter' => esc_html__('Align Center', 'multifox-plus'),
                      'alignright'  => esc_html__('Align Right', 'multifox-plus'),
                    ),
                    'dependency'   => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                )
            ));

            /**
             * Option : Equal Height
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[enable-equal-height]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Switch(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[enable-equal-height]', array(
                        'type'    => 'mfx-switch',
                        'label'   => esc_html__( 'Enable Equal Height', 'multifox-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                            'off' => esc_attr__( 'No', 'multifox-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );

            /**
             * Option : No Space
             */
            /*$wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[enable-no-space]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Switch(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[enable-no-space]', array(
                        'type'    => 'mfx-switch',
                        'label'   => esc_html__( 'Enable No Space', 'multifox-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                            'off' => esc_attr__( 'No', 'multifox-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-cover' ),
                    )
                )
            );*/

            /**
             * Option : Gallery Slider
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Switch(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[enable-gallery-slider]', array(
                        'type'    => 'mfx-switch',
                        'label'   => esc_html__( 'Display Gallery Slider', 'multifox-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                            'off' => esc_attr__( 'No', 'multifox-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Divider : Blog Gallery Slider Bottom
             */
            $wp_customize->add_control(
                new Multifox_Customize_Control_Separator(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-gallery-slider-bottom-separator]', array(
                        'type'     => 'mfx-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Blog Elements
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control_Sortable(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-elements-position]', array(
                    'type' => 'mfx-sortable',
                    'label' => esc_html__( 'Elements Positioning', 'multifox-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'multifox_archive_post_elements_options', array(
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
                    )),
                )
            ));

            /**
             * Option : Blog Meta Elements
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control_Sortable(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-meta-position]', array(
                    'type' => 'mfx-sortable',
                    'label' => esc_html__( 'Meta Group Positioning', 'multifox-plus'),
                    'section' => 'site-blog-archive-section',
                    'choices' => apply_filters( 'multifox_blog_archive_meta_elements_options', array(
                        'author'        => esc_html__('Author', 'multifox-plus'),
                        'date'          => esc_html__('Date', 'multifox-plus'),
                        'comment'       => esc_html__('Comments', 'multifox-plus'),
                        'category'      => esc_html__('Categories', 'multifox-plus'),
                        'tag'           => esc_html__('Tags', 'multifox-plus'),
                        'social'        => esc_html__('Social Share', 'multifox-plus'),
                        'likes_views'   => esc_html__('Likes & Views', 'multifox-plus'),
                    )),
                    'description' => esc_html__('Note: Use max 3 items for better results.', 'multifox-plus'),
                )
            ));

            /**
             * Divider : Blog Meta Elements Bottom
             */
            $wp_customize->add_control(
                new Multifox_Customize_Control_Separator(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-meta-elements-bottom-separator]', array(
                        'type'     => 'mfx-separator',
                        'section'  => 'site-blog-archive-section',
                        'settings' => array(),
                    )
                )
            );

            /**
             * Option : Post Format
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[enable-post-format]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Switch(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[enable-post-format]', array(
                        'type'    => 'mfx-switch',
                        'label'   => esc_html__( 'Enable Post Format', 'multifox-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                            'off' => esc_attr__( 'No', 'multifox-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Enable Excerpt
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Switch(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[enable-excerpt-text]', array(
                        'type'    => 'mfx-switch',
                        'label'   => esc_html__( 'Enable Excerpt Text', 'multifox-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                            'off' => esc_attr__( 'No', 'multifox-plus' )
                        )
                    )
                )
            );

            /**
             * Option : Excerpt Text
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-excerpt-length]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Excerpt Length', 'multifox-plus' ),
                        'description' => esc_html__('Put Excerpt Length', 'multifox-plus'),
                        'input_attrs' => array(
                            'value' => 25,
                        ),
                        'dependency'  => array( 'enable-excerpt-text', '==', 'true' ),
                    )
                )
            );

            /**
             * Option : Enable Video Audio
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[enable-video-audio]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Switch(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[enable-video-audio]', array(
                        'type'    => 'mfx-switch',
                        'label'   => esc_html__( 'Display Video & Audio for Posts', 'multifox-plus'),
                        'description' => esc_html__('YES! to display video & audio, instead of feature image for posts', 'multifox-plus'),
                        'section' => 'site-blog-archive-section',
                        'choices' => array(
                            'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                            'off' => esc_attr__( 'No', 'multifox-plus' )
                        ),
                        'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                    )
                )
            );

            /**
             * Option : Readmore Text
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-readmore-text]', array(
                        'type'        => 'text',
                        'section'     => 'site-blog-archive-section',
                        'label'       => esc_html__( 'Read More Text', 'multifox-plus' ),
                        'description' => esc_html__('Put the read more text here', 'multifox-plus'),
                        'input_attrs' => array(
                            'value' => esc_html__('Read More', 'multifox-plus'),
                        )
                    )
                )
            );

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-image-hover-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Hover Style', 'multifox-plus' ),
                    'choices' => array(
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
                    'description' => esc_html__('Choose image hover style to display archives pages.', 'multifox-plus'),
                )
            ));

            /**
             * Option : Image Hover Style
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-image-overlay-style]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Image Overlay Style', 'multifox-plus' ),
                    'choices' => array(
                      'mfx-default'           => esc_html__('None', 'multifox-plus'),
                      'mfx-fixed'             => esc_html__('Fixed', 'multifox-plus'),
                      'mfx-tb'                => esc_html__('Top to Bottom', 'multifox-plus'),
                      'mfx-bt'                => esc_html__('Bottom to Top', 'multifox-plus'),
                      'mfx-rl'                => esc_html__('Right to Left', 'multifox-plus'),
                      'mfx-lr'                => esc_html__('Left to Right', 'multifox-plus'),
                      'mfx-middle'            => esc_html__('Middle', 'multifox-plus'),
                      'mfx-middle-radial'     => esc_html__('Middle Radial', 'multifox-plus'),
                      'mfx-tb-gradient'       => esc_html__('Gradient - Top to Bottom', 'multifox-plus'),
                      'mfx-bt-gradient'       => esc_html__('Gradient - Bottom to Top', 'multifox-plus'),
                      'mfx-rl-gradient'       => esc_html__('Gradient - Right to Left', 'multifox-plus'),
                      'mfx-lr-gradient'       => esc_html__('Gradient - Left to Right', 'multifox-plus'),
                      'mfx-radial-gradient'   => esc_html__('Gradient - Radial', 'multifox-plus'),
                      'mfx-flash'             => esc_html__('Flash', 'multifox-plus'),
                      'mfx-circle'            => esc_html__('Circle', 'multifox-plus'),
                      'mfx-hm-elastic'        => esc_html__('Horizontal Elastic', 'multifox-plus'),
                      'mfx-vm-elastic'        => esc_html__('Vertical Elastic', 'multifox-plus'),
                    ),
                    'description' => esc_html__('Choose image overlay style to display archives pages.', 'multifox-plus'),
                    'dependency' => array( 'blog-post-layout', 'any', 'entry-grid,entry-list' ),
                )
            ));

            /**
             * Option : Pagination
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control( new Multifox_Customize_Control(
                $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[blog-pagination]', array(
                    'type'    => 'select',
                    'section' => 'site-blog-archive-section',
                    'label'   => esc_html__( 'Pagination Style', 'multifox-plus' ),
                    'choices' => array(
                      'pagination-default'        => esc_html__('Older & Newer', 'multifox-plus'),
                      'pagination-numbered'       => esc_html__('Numbered', 'multifox-plus'),
                      'pagination-loadmore'       => esc_html__('Load More', 'multifox-plus'),
                      'pagination-infinite-scroll'=> esc_html__('Infinite Scroll', 'multifox-plus'),
                    ),
                    'description' => esc_html__('Choose pagination style to display archives pages.', 'multifox-plus')
                )
            ));

        }
    }
}

MultifoxPlusCustomizerSiteBlog::instance();