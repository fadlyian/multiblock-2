<?php // phpcs:ignore Class file names should be based on the class name with "class-" prepended.
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The parent class of all api class for this theme.
 *
 * @link       https://www.acmeit.org/
 * @since      1.0.0
 *
 * @package    Patterns_Automotive
 * @subpackage Patterns_Automotive/includes/api
 */

/**
 * The common variables and methods of api of the theme.
 *
 * Define namespace, vresion and other common properties and methods.
 *
 * @package    Patterns_Automotive
 * @subpackage Patterns_Automotive/includes/api
 * @author     codersantosh <codersantosh@gmail.com>
 */
if ( ! class_exists( 'Patterns_Automotive_Api' ) ) {

	/**
	 * Patterns_Automotive_Api
	 *
	 * @package Patterns_Automotive
	 * @since 1.0.1
	 */
	class Patterns_Automotive_Api extends WP_REST_Controller {

		/**
		 * Rest route namespace.
		 *
		 * @var Patterns_Automotive_Api
		 */
		public $namespace = 'patterns-automotive/';

		/**
		 * Rest route version.
		 *
		 * @var Patterns_Automotive_Api
		 */
		public $version = 'v1';

		/**
		 * Whether the controller supports batching.
		 *
		 * @since 1.0.0
		 * @var array
		 */
		protected $allow_batch = array( 'v1' => true );

		/**
		 * Table name.
		 *
		 * @var string
		 */
		public $type;

		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 */
		public function __construct() {}

		/**
		 * Initialize the class
		 */
		public function run() {
			/*Custom Rest Routes*/
			add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		}

		/**
		 * Gets an instance of this object.
		 * Prevents duplicate instances which avoid artefacts and improves performance.
		 *
		 * @static
		 * @access public
		 * @return object
		 * @since 1.0.1
		 */
		public static function get_instance() {
			// Store the instance locally to avoid private static replication.
			static $instance = null;

			// Only run these methods if they haven't been ran previously.
			if ( null === $instance ) {

				$instance = new self();
			}

			// Always return the instance.
			return $instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @access public
		 * @return void
		 * @since 1.0.0
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'patterns-automotive' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @access public
		 * @return void
		 * @since 1.0.0
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'patterns-automotive' ), '1.0.0' );
		}
	}
}
