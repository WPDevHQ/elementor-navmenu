<?php
namespace ElementorNavmenu;

use ElementorNavmenu\Widgets\Elementor_Navmenu;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_default_scripts' ), 998 );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_default_scripts' ], 997 );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}
	
	/**
	 * Enqueue Custom CSS - theme agnostic.
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_default_scripts() {
		wp_register_style( 'elementor-default', plugins_url( 'assets/css/default.css', __FILE__ ) );
		wp_enqueue_style( 'elementor-default' );
		
		wp_register_script( 'elementor-default-js', plugins_url( 'assets/js/default.js', __FILE__ ), array( 'jquery' ), '4.7', true );
		wp_enqueue_script( 'elementor-default-js' );
		
		wp_localize_script( 'elementor-default-js', 'elementorScreenReaderText', array(
			'expand'   => __( 'expand child menu', 'elementor-default' ),
			'collapse' => __( 'collapse child menu', 'elementor-default' ),
		) );
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require __DIR__ . '/widgets/elementor-navmenu.php';
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Navmenu() );
	}
}

new Plugin();