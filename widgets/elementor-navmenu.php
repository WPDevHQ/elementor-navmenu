<?php
namespace ElementorNavmenu\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Elementor Navbar
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Elementor_Navmenu extends Widget_Base {
	
	public function get_name() {
		return 'elementor-navmenu';
	}

	public function get_title() {
		return __( 'Elementor Navmenu', 'elementor-navmenu' );
	}

	public function get_icon() {
		return 'eicon-menu';
	}

	public function get_categories() {
		return [ 'general-elements' ];
	}

	protected function _register_controls() {
		//$menus = $this->get_menus();
		
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Navigation', 'elementor-navmenu' ),
			]
		);
		
		$this->add_control(
			'el_nav_menu',
			[
				'label' => __( 'Select Menu', 'elementor-navmenu' ),
				'type' => Controls_Manager::SELECT,				
				'options' => ele_navbar_menu_choices(),
				'default' => '',
			]
		);
		
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor-navmenu' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'elementor-navmenu' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-navmenu' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-navmenu' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_menu_style',
			[
				'label' => __( 'Colors', 'elementor-navmenu' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'menu_link_color',
			[
				'label' => __( 'Link Color', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'menu_link_bg',
			[
				'label' => __( 'Background', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu .menu-item a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'menu_link_active_color',
			[
				'label' => __( 'Active Color', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu .current-menu-item > a, .elementor-nav-menu .current_page_item > a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'link_active_bg_color',
			[
				'label' => __( 'Active Background', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu .current-menu-item > a, .elementor-nav-menu .current_page_item > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'menu_hover',
			[
				'label' => __( 'Hover Colors', 'elementor-navmenu' ),
				'type' => Controls_Manager::SECTION,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'menu_link_hover_color',
			[
				'label' => __( 'Link Color', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu .menu-item:hover a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'link_hover_bg_color',
			[
				'label' => __( 'Background Color', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu .menu-item a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();		

		$this->start_controls_section(
			'section_menu_borders',
			[
				'label' => __( 'Menu Border', 'elementor-navmenu' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'elementor-navmenu' ),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-nav-menu .menu-item a',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-navmenu' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu .menu-item a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Text Padding - Default 1em', 'elementor-navmenu' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-navigation a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'menu_toggle',
			[
				'label' => __( 'Mobile Toggle', 'elementor-navmenu' ),
				'type' => Controls_Manager::SECTION,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'toggle_icon_color',
			[
				'label' => __( 'Icon Color', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle i.fa.fa-navicon' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'toggle_bg_color',
			[
				'label' => __( 'Background Color', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'toggle_icon_hover',
			[
				'label' => __( 'Icon Hover', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover i.fa.fa-navicon' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'toggle_bg_hover',
			[
				'label' => __( 'Background Hover', 'elementor-navmenu' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();		

		$this->start_controls_section(
			'section_toggle_borders',
			[
				'label' => __( 'Toggle Border', 'elementor-navmenu' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'toggle_border',
				'label' => __( 'Border', 'elementor-navmenu' ),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-menu-toggle',
			]
		);

		$this->add_control(
			'toggle_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'toggle_text_padding',
			[
				'label' => __( 'Text Padding - Default 1em', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle i.fa.fa-navicon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'menu_typography',
			[
				'label' => __( 'Typography', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'label' => __( 'Typography', 'elementor-navmenu' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-nav-menu .menu-item',
			]
		);
		
		$this->end_controls_section();
	}

	protected function render() {
		
		$settings = $this->get_settings();
		// Get menu
		$nav_menu = ! empty( $settings['el_nav_menu'] ) ? wp_get_nav_menu_object( $settings['el_nav_menu'] ) : false;

		if ( !$nav_menu )
			return;
		
		$nav_menu_args = array(
			'fallback_cb' 		=> false,
			'container'			=> false,
			'menu_id'     		=> 'elementor-navmenu',
			'menu_class'  		=> 'elementor-nav-menu',
			'menu'        		=> $nav_menu,
			'echo' 				=> true,
			'depth' 			=> 0, 
			'walker' 			=> '',
		); 
	?>
		<div id="elementor-header" class="elementor-header">
		
			<button id="elementor-menu-toggle" class="elementor-menu-toggle"><i class="fa fa-navicon"></i></button>
			<div id="elementor-menu" class="elementor-menu">
			
				<nav id="elementor-navigation" class="elementor-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Elementor Menu', 'elementor-navmenu' ); ?>">				
				<?php 
					wp_nav_menu( apply_filters( 
						'widget_nav_menu_args', 
						$nav_menu_args, 
						$nav_menu, 
						$settings 
					) ); 
				?>		
				</nav>
			</div>
		</div>
	<?php 
	}

	protected function _content_template() {}
}
