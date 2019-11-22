<?php
namespace CwAddons\Modules\Woocommerce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

use CwAddons\Modules\QueryControl\Controls\Group_Control_Posts;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WC_Slider extends Widget_Base {
	private $_query = null;

	public function get_name() {
		return 'ink-wc-slider';
	}

	public function get_title() {
		return __( 'WC - Slider', 'colorway-addons' );
	}

	public function get_icon() {
		return 'ink-widget-icon fab fa-slideshare';
	}

	public function get_categories() {
		return [ 'colorway-addons' ];
	}

	public function get_keywords() {
		return [ 'slider', 'woocommerce' ];
	}

	public function get_script_depends() {
		return [ 'imagesloaded', 'ink-uikit-icons' ];
	}

	// public function _register_skins() {
	// $this->add_skin( new Skins\Skin_Slade( $this ) );
	// }

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['posts_post_type'] = 'services';
		}

		return $element;
	}

	public function on_export( $element ) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
		return $element;
	}

	public function get_query() {
		return $this->_query;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => __( 'Layout', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'   => __( 'Text Align', 'colorway-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'left',
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'colorway-addons' ),
						'icon'  => 'fas fa-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'colorway-addons' ),
						'icon'  => 'fas fa-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'colorway-addons' ),
						'icon'  => 'fas fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'colorway-addons' ),
						'icon'  => 'fas fa-align-justify',
					],
				],
			]
		);

		$this->add_control(
			'vertical_align',
			[
				'label'   => __( 'Vertical Align', 'colorway-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'middle',
				'options' => [
					'top'    => [
						'title' => __( 'Top', 'colorway-addons' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'colorway-addons' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'colorway-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'label'   => __( 'Image Size', 'colorway-addons' ),
				'exclude' => [ 'custom' ],
				'default' => 'full',
			]
		);

		$this->add_control(
			'content_reverse',
			[
				'label' => __( 'Content Reverse', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settings',
			[
				'label' => __( 'Slider Settings', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Slider Animations', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'slide',
				'options'   => [
					'slide' => esc_html__( 'Slide', 'colorway-addons' ),
					'fade'  => esc_html__( 'Fade', 'colorway-addons' ),
					'scale' => esc_html__( 'Scale', 'colorway-addons' ),
					'push'  => esc_html__( 'Push', 'colorway-addons' ),
					'pull'  => esc_html__( 'Pull', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'     => __( 'Autoplay Interval(ms)', 'colorway-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'slider_size_ratio',
			[
				'label'       => esc_html__( 'Size Ratio', 'colorway-addons' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Slider ratio to widht and height, such as 16:9',
			]
		);

		$this->add_control(
			'slider_min_height',
			[
				'label' => esc_html__( 'Minimum Height', 'colorway-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
			]
		);

		$this->add_control(
			'slider_fullscreen',
			[
				'label' => __( 'Slideshow Fullscreen', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_additional',
			[
				'label' => __( 'Additional', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'show_price',
			[
				'label'   => __( 'Price', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label'   => __( 'Show Title', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'   => __( 'Rating', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_text',
			[
				'label' => __( 'Show Text', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_cart',
			[
				'label'   => __( 'Add to Cart', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_readmore',
			[
				'label'   => esc_html__( 'Read More', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'   => __( 'Show Badge', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_thumbnav',
			[
				'label'   => __( 'Show Thumbnav', 'colorway-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_readmore',
			[
				'label'     => __( 'Read More', 'colorway-addons' ),
				'condition' => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->add_control(
			'readmore_text',
			[
				'label'       => esc_html__( 'Read More Text', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'colorway-addons' ),
				'placeholder' => esc_html__( 'Read More', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'wc_slider_readmore_icon',
			[
				'label'            => esc_html__( 'Icon', 'colorway-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'readmore_icon',
			]
		);

		$this->add_control(
			'readmore_icon_align',
			[
				'label'     => esc_html__( 'Icon Position', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Before', 'colorway-addons' ),
					'right' => esc_html__( 'After', 'colorway-addons' ),
				],
				'condition' => [
					'wc_slider_readmore_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'readmore_icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 8,
				],
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'wc_slider_readmore_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ink-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => __( 'Navigation', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'arrows',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'colorway-addons' ),
					'arrows' => __( 'Arrows', 'colorway-addons' ),
					'dots'   => __( 'Dots', 'colorway-addons' ),
					'none'   => __( 'None', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'both_position',
			[
				'label'     => __( 'Arrows and Dots Position', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => colorway_addons_navigation_position(),
				'condition' => [
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'     => __( 'Arrows Position', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-right',
				'options'   => colorway_addons_navigation_position(),
				'condition' => [
					'navigation' => [ 'arrows' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => __( 'Dots Position', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => colorway_addons_pagination_position(),
				'condition' => [
					'navigation' => 'dots',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_button',
			[
				'label'     => __( 'Button', 'colorway-addons' ),
				'condition' => [
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Read More', 'colorway-addons' ),
				'placeholder' => __( 'Read More', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'            => __( 'Icon', 'colorway-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'     => __( 'Icon Position', 'colorway-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => __( 'Before', 'colorway-addons' ),
					'right' => __( 'After', 'colorway-addons' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 8,
				],
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-button-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-button-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[
				'label' => __( 'Query', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'       => _x( 'Source', 'Posts Query Control', 'colorway-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''        => __( 'Show All', 'colorway-addons' ),
					'by_name' => __( 'Manual Selection', 'colorway-addons' ),
				],
				'label_block' => true,
			]
		);

		$product_categories = get_terms( 'product_cat' );

		$options = [];
		foreach ( $product_categories as $category ) {
			$options[ $category->slug ] = $category->name;
		}

		$this->add_control(
			'product_categories',
			[
				'label'       => __( 'Categories', 'colorway-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $options,
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'source' => 'by_name',
				],
			]
		);

		$this->add_control(
			'exclude_products',
			[
				'label'       => esc_html__( 'Exclude Product(s)', 'colorway-addons' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'product_id',
				'label_block' => true,
				'description' => __( 'Write product id here, if you want to exclude multiple products so use comma as separator. Such as 1 , 2', '' ),
			]
		);

		$this->add_control(
			'posts',
			[
				'label'   => __( 'Product Limit', 'colorway-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'show_product_type',
			[
				'label'   => esc_html__( 'Show Product', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all'      => esc_html__( 'All Products', 'colorway-addons' ),
					'onsale'   => esc_html__( 'On Sale', 'colorway-addons' ),
					'featured' => esc_html__( 'Featured', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'hide_free',
			[
				'label' => esc_html__( 'Hide Free', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hide_out_stock',
			[
				'label' => esc_html__( 'Hide Out of Stock', 'colorway-addons' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'  => esc_html__( 'Date', 'colorway-addons' ),
					'price' => esc_html__( 'Price', 'colorway-addons' ),
					'sales' => esc_html__( 'Sales', 'colorway-addons' ),
					'rand'  => esc_html__( 'Random', 'colorway-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'colorway-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'colorway-addons' ),
					'ASC'  => esc_html__( 'Ascending', 'colorway-addons' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => __( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slider-item-content' => 'background: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Content Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'     => __( 'Item Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-item-inner' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[
				'label'     => __( 'Price', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_heading',
			[
				'label' => __( 'Old Price', 'colorway-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-slider-price del, .ink-wc-slider .ink-slider-skin-price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[
				'label'      => __( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-slider-price del, .ink-wc-slider .ink-slider-skin-price del' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'old_price_typography',
				'label'    => __( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-wc-slider-price del, .ink-wc-slider .ink-slider-skin-price del',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[
				'label'     => __( 'Sale Price', 'colorway-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-slider-price, .ink-wc-slider .ink-slider-skin-price, {{WRAPPER}} .ink-wc-slider .ink-wc-slider-price ins, .ink-wc-slider .ink-slider-skin-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[
				'label'      => __( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-slider-price, .ink-wc-slider .ink-slider-skin-price, {{WRAPPER}} .ink-wc-slider .ink-wc-slider-price ins, .ink-wc-slider .ink-slider-skin-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sale_price_typography',
				'label'    => __( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-wc-slider-price, .ink-wc-slider .ink-slider-skin-price, {{WRAPPER}} .ink-wc-slider .ink-wc-slider-price ins, .ink-wc-slider .ink-slider-skin-price ins',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => __( 'Title', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => [ 'yes' ],
				],
			]
		);

		// $this->add_responsive_control(
		// 'title_width',
		// [
		// 'label'   => __( 'Width (px)', 'colorway-addons' ),
		// 'type'    => Controls_Manager::SLIDER,
		// 'range' => [
		// 'px' => [
		// 'min' => 50,
		// 'max' => 550,
		// ],
		// ],
		// 'selectors' => [
		// '{{WRAPPER}} .ink-wc-slider-slade-skin .ink-wc-slider-title' => 'max-width: {{SIZE}}{{UNIT}};',
		// ],
		// 'condition' => [
		// '_skin!' => '',
		// ],
		// ]
		// );

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => __( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_radius',
			[
				'label'      => __( 'Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => __( 'Spacing', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_rating',
			[
				'label'     => __( 'Rating', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_rating' => 'yes',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7e7e7',
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .star-rating:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'active_rating_color',
			[
				'label'     => __( 'Active Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFCC00',
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .star-rating span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
			[
				'label'      => __( 'Spacing', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-rating' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label' => __( 'Text', 'colorway-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// $this->add_responsive_control(
		// 'text_width',
		// [
		// 'label'   => __( 'Width (px)', 'colorway-addons' ),
		// 'type'    => Controls_Manager::SLIDER,
		// 'range' => [
		// 'px' => [
		// 'min' => 50,
		// 'max' => 650,
		// ],
		// ],
		// 'selectors' => [
		// '{{WRAPPER}} .ink-wc-slider-slade-skin .ink-wc-slider-text' => 'max-width: {{SIZE}}{{UNIT}};',
		// ],
		// 'condition' => [
		// '_skin!' => '',
		// ],
		// ]
		// );

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_background',
			[
				'label'     => __( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => __( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => __( 'Text Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-text, .ink-wc-slider .ink-slideshow-items .ink-wc-slider-text p',
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label'      => __( 'Spacing', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-slideshow-items .ink-wc-slider-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => __( 'Add to Cart Button', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_cart' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => __( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => __( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label'      => __( 'Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'add_to_cart_spacing',
			[
				'label'      => __( 'Spacing', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'button_hover_background',
			[
				'label'     => __( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'button_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-add-to-cart a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'     => esc_html__( 'Read More', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_readmore' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[
				'label' => esc_html__( 'Normal', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider-readmore' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ink-wc-slider-readmore svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider-readmore' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'readmore_border',
				'label'       => esc_html__( 'Border', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-slider-readmore',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_radius',
			[
				'label'      => esc_html__( 'Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'readmore_shadow',
				'selector' => '{{WRAPPER}} .ink-wc-slider-readmore',
			]
		);

		$this->add_responsive_control(
			'readmore_padding',
			[
				'label'      => esc_html__( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_space_between',
			[
				'label'     => esc_html__( 'Space Between', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-slider-readmore' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'readmore_typography',
				'label'    => esc_html__( 'Typography', 'colorway-addons' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider-readmore',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[
				'label' => esc_html__( 'Hover', 'colorway-addons' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider-readmore:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ink-wc-slider-readmore:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider-readmore:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'readmore_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider-readmore:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'colorway-addons' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => __( 'Badge', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => __( 'Text Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background',
			[
				'label'     => __( 'Background', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'badge_border',
				'label'       => __( 'Border Color', 'colorway-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-slider .ink-badge',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_radius',
			[
				'label'      => __( 'Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => __( 'Padding', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_margin',
			[
				'label'      => __( 'Margin', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-wc-slider-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .ink-wc-slider .ink-badge',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'colorway-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label'     => __( 'Arrows', 'colorway-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label'     => __( 'Size', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 44,
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => __( 'Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[
				'label'     => __( 'Hover Background Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev:hover svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next:hover svg' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[
				'label'     => __( 'Hover Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev:hover svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'     => __( 'Padding', 'colorway-addons' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-next svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'arrows_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .ink-wc-slider .ink-navigation-prev svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next svg',
				'condition'   => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_radius',
			[
				'label'      => __( 'Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev svg, {{WRAPPER}} .ink-wc-slider .ink-navigation-next svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'navigation!' => [ 'none', 'dots' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[
				'label'      => __( 'Space', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_dots',
			[
				'label'     => __( 'Dots', 'colorway-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label'     => __( 'Size', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-dotnav li a' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'dots_width',
			[
				'label'     => __( 'Active Size', 'colorway-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-dotnav li.ink-active a' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_responsive_control(
			'active_dot_radius',
			[
				'label'      => __( 'Radius', 'colorway-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-dotnav li.ink-active a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => __( 'Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-dotnav li a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[
				'label'     => __( 'Active Color', 'colorway-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ink-wc-slider .ink-dotnav li.ink-active a' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'navigation!' => [ 'arrows', 'none' ],
				],
			]
		);

		$this->add_control(
			'heading_position',
			[
				'label'     => __( 'Position', 'colorway-addons' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'navigation!' => 'none',
				],
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[
				'label'      => __( 'Arrows Horizontal Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'separator'  => 'before',
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => [ 'arrows' ],
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[
				'label'      => __( 'Arrows Vertical Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => [ 'arrows' ],
						],
						[
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[
				'label'      => __( 'Arrows Horizontal Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation',
							'operator' => 'in',
							'value'    => [ 'arrows' ],
						],
						[
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[
				'label'      => __( 'Horizontal Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[
				'label'      => __( 'Vertical Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 30,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[
				'label'      => __( 'Horizontal Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[
				'label'      => __( 'Vertical Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 40,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[
				'label'      => __( 'Arrows Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 20,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .ink-wc-slider .ink-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[
				'label'      => __( 'Dots Offset', 'colorway-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => -40,
				],
				'range'      => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ink-wc-slider .ink-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'navigation',
							'value' => 'both',
						],
						[
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	public function render_query() {
		$settings = $this->get_settings();

		$exclude_products = ( $settings['exclude_products'] ) ? explode( ',', $settings['exclude_products'] ) : [];

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $settings['posts'],
			'no_found_rows'       => true,
			'meta_query'          => [],
			'tax_query'           => [ 'relation' => 'AND' ],
			'order'               => $settings['order'],
			'post__not_in'        => $exclude_products,
		);

		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		if ( 'by_name' === $settings['source'] and ! empty( $settings['product_categories'] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy'     => 'product_cat',
				'field'        => 'slug',
				'terms'        => $settings['product_categories'],
				'post__not_in' => $exclude_products,
			);
		}

		if ( 'yes' == $settings['hide_free'] ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		if ( 'yes' == $settings['hide_out_stock'] ) {
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
		}

		switch ( $settings['show_product_type'] ) {
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'onsale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
		}

		switch ( $settings['orderby'] ) {
			case 'price':
				$query_args['meta_key'] = '_price'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand':
				$query_args['orderby'] = 'rand';
				break;
			case 'sales':
				$query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			default:
				$query_args['orderby'] = 'date';
		}

		$wp_query = new \WP_Query( $query_args );

		return $wp_query;
	}

	public function render_navigation() {
		$settings = $this->get_settings();

		?>
		<div class="ink-position-z-index ink-visible@m ink-position-<?php echo esc_attr( $settings['arrows_position'] ); ?>">
			<div class="ink-arrows-container ink-slidenav-container">
				<a href="" class="ink-navigation-prev ink-slidenav-previous ink-icon ink-slidenav" ink-icon="icon: chevron-left; ratio: 1.9" ink-slideshow-item="previous"></a>
				<a href="" class="ink-navigation-next ink-slidenav-next ink-icon ink-slidenav" ink-icon="icon: chevron-right; ratio: 1.9" ink-slideshow-item="next"></a>
			</div>
		</div>
		<?php
	}

	public function render_dotnavs() {
		$settings = $this->get_settings();

		?>
		<div class="ink-position-z-index ink-visible@m ink-position-<?php echo esc_attr( $settings['dots_position'] ); ?>">
			<div class="ink-dotnav-wrapper ink-dots-container">
				<ul class="ink-dotnav ink-flex-center">

					<?php
					$ink_counter = 0;

					$wp_query = $this->render_query();

					while ( $wp_query->have_posts() ) :
						$wp_query->the_post();
						$active = ( 0 == $ink_counter ) ? ' ink-active' : '';
						echo '<li class="ink-slideshow-dotnav' . $active . '" ink-slideshow-item=" ' . $ink_counter . ' "><a href="#"></a></li>';
						$ink_counter++;
					endwhile;
					wp_reset_postdata();
					?>

				</ul>
			</div>
		</div>
		<?php
	}

	public function render_both_navigation() {
		$settings = $this->get_settings();
		?>

		<div class="ink-position-z-index ink-position-<?php echo esc_attr( $settings['both_position'] ); ?>">
			<div class="ink-arrows-dots-container ink-slidenav-container ">

				<div class="ink-flex ink-flex-middle">
					<div>
						<a href="" class="ink-navigation-prev ink-slidenav-previous ink-icon ink-slidenav" ink-icon="icon: chevron-left; ratio: 1.9" ink-slideshow-item="previous"></a>

					</div>

					<?php if ( 'center' !== $settings['both_position'] ) : ?>
						<div class="ink-dotnav-wrapper ink-dots-container">
							<ul class="ink-dotnav">
								<?php
								$ink_counter = 0;

								$wp_query = $this->render_query();

								while ( $wp_query->have_posts() ) :
									$wp_query->the_post();
									echo '<li class="ink-slideshow-dotnav" ink-slideshow-item="' . $ink_counter . '"><a href="#"></a></li>';
									$ink_counter++;
								endwhile;
								wp_reset_postdata();
								?>
							</ul>
						</div>
					<?php endif; ?>

					<div>
						<a href="" class="ink-navigation-next ink-slidenav-next ink-icon ink-slidenav" ink-icon="icon: chevron-right; ratio: 1.9" ink-slideshow-item="next"></a>

					</div>

				</div>
			</div>
		</div>

		<?php
	}

	public function render_item_image() {
		$settings  = $this->get_settings();
		$image_src = wp_get_attachment_image_url( get_post_thumbnail_id(), $settings['image_size'] );

		if ( $image_src ) :
			echo '<img src="' . esc_url( $image_src ) . '" alt="' . get_the_title() . '">';
		endif;

		return 0;
	}

	public function render_header( $skin = 'default' ) {
		$settings        = $this->get_settings_for_display();
		$slides_settings = [];
		$ratio           = ( $settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height'] ) ? $settings['slider_size_ratio']['width'] . ':' . $settings['slider_size_ratio']['height'] : '1920:768';

		$slider_settings['ink-slideshow'] = wp_json_encode(
			array_filter(
				[
					'animation'         => $settings['slider_animations'],
					'ratio'             => $ratio,
					'min-height'        => $settings['slider_min_height']['size'],
					'autoplay'          => ( $settings['autoplay'] ) ? true : false,
					'autoplay-interval' => $settings['autoplay_interval'],
					'pause-on-hover'    => ( 'yes' === $settings['pause_on_hover'] ) ? true : false,
				]
			)
		);

		$slider_settings['class'][] = 'ink-wc-slider';

		if ( 'both' == $settings['navigation'] ) {
			$slider_settings['class'][] = 'ink-arrows-dots-align-' . $settings['both_position'];
		} elseif ( 'arrows' == $settings['navigation'] ) {
			$slider_settings['class'][] = 'ink-arrows-align-' . $settings['arrows_position'];
		} elseif ( 'dots' == $settings['navigation'] ) {
			$slider_settings['class'][] = 'ink-dots-align-' . $settings['dots_position'];
		}

		$slider_fullscreen = ( $settings['slider_fullscreen'] ) ? ' ink-height-viewport="offset-top: true"' : '';

		?>
		<div <?php echo \colorway_addons_helper::attrs( $slider_settings ); ?>>
		<div class="ink-position-relative ink-visible-toggle">
		<ul class="ink-slideshow-items ink-child-width-1-1"<?php echo esc_attr( $slider_fullscreen ); ?>>
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>
		</ul>
		<?php if ( 'both' == $settings['navigation'] ) : ?>
			<?php $this->render_both_navigation(); ?>

			<?php if ( 'center' === $settings['both_position'] ) : ?>
				<?php $this->render_dotnavs(); ?>
			<?php endif; ?>

		<?php elseif ( 'arrows' == $settings['navigation'] ) : ?>
			<?php $this->render_navigation(); ?>
		<?php elseif ( 'dots' == $settings['navigation'] ) : ?>
			<?php $this->render_dotnavs(); ?>
		<?php endif; ?>
		</div>
		</div>
		<?php
	}

	public function render_readmore() {
		$settings = $this->get_settings_for_display();

		$animation = ( $this->get_settings( 'readmore_hover_animation' ) ) ? ' elementor-animation-' . $this->get_settings( 'readmore_hover_animation' ) : '';

		if ( ! isset( $settings['readmore_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['readmore_icon'] = 'fas fa-arrow-right';
		}

		$migrated = isset( $settings['__fa4_migrated']['wc_slider_readmore_icon'] );
		$is_new   = empty( $settings['readmore_icon'] ) && Icons_Manager::is_migration_allowed();

		?>

		<a href="<?php echo esc_url( get_permalink() ); ?>" class="ink-wc-slider-readmore <?php echo esc_attr( $animation ); ?>">
			<?php echo esc_html( $this->get_settings( 'readmore_text' ) ); ?>

			<?php if ( $settings['wc_slider_readmore_icon']['value'] ) : ?>
				<span class="ink-button-icon-align-<?php echo esc_attr( $this->get_settings( 'readmore_icon_align' ) ); ?>">

						<?php
						if ( $is_new || $migrated ) :
							Icons_Manager::render_icon(
								$settings['wc_slider_readmore_icon'],
								[
									'aria-hidden' => 'true',
									'class'       => 'fa-fw',
								]
							);
						else :
							?>
							<i class="<?php echo esc_attr( $settings['readmore_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>

					</span>
			<?php endif; ?>

		</a>
		<?php
	}

	public function render_item_content() {
		$settings = $this->get_settings_for_display();

		?>
		<div class="ink-slideshow-content-wrapper ink-padding ink-text-<?php echo esc_attr( $settings['text_align'] ); ?>">

			<?php if ( $settings['show_price'] ) : ?>
				<div class="ink-wc-slider-price">
					<span class="wae-product-price"><?php woocommerce_template_single_price(); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( $settings['show_title'] ) : ?>
				<h2 class="ink-wc-slider-title"><?php the_title(); ?></h2>
			<?php endif; ?>

			<?php if ( $settings['show_rating'] ) : ?>
				<div class="ink-wc-rating ink-flex ink-flex-<?php echo esc_attr( $settings['text_align'] ); ?>">
					<?php woocommerce_template_loop_rating(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $settings['show_text'] ) : ?>
				<div class="ink-wc-slider-text"><?php the_excerpt(); ?></div>
			<?php endif; ?>

			<?php if ( $settings['show_cart'] ) : ?>
			<div class="ink-wc-add-to-cart-readmore ink-flex ink-flex-<?php echo esc_attr( $settings['text_align'] ); ?> ink-flex-middle">
				<?php if ( $settings['show_cart'] ) : ?>
					<div class="ink-wc-add-to-cart">
						<?php woocommerce_template_loop_add_to_cart(); ?>
					</div>
				<?php endif; ?>

				<?php if ( $settings['show_readmore'] ) : ?>
					<?php $this->render_readmore(); ?>
				<?php endif; ?>

				<?php endif; ?>
			</div>

		</div>
		<?php
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$content_reverse = $settings['content_reverse'] ? ' ink-flex-first' : '';

		$this->render_header();

		$wp_query = $this->render_query();

		while ( $wp_query->have_posts() ) :
			$wp_query->the_post();
			global $product;
			?>

			<li class="ink-slideshow-item">
				<div class="ink-slideshow-item-inner ink-grid ink-grid-collapse ink-height-1-1" ink-grid>
					<div class="ink-width-1-2@m ink-flex ink-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?> ink-mobile-order">
						<div class="ink-position-relative ink-wc-slider-image">

							<?php $this->render_item_image(); ?>

							<?php if ( $settings['show_badge'] and $product->is_on_sale() ) : ?>
								<div class="ink-badge ink-position-top-left ink-position-small">
									<?php woocommerce_show_product_loop_sale_flash(); ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
					<div class="ink-width-1-2@m ink-flex ink-flex-<?php echo esc_attr( $settings['vertical_align'] ); ?> ink-slider-item-content<?php echo esc_attr( $content_reverse ); ?>">
						<?php $this->render_item_content(); ?>
					</div>

				</div>
			</li>

			<?php
		endwhile;
		wp_reset_postdata();

		$this->render_footer();
	}
}

