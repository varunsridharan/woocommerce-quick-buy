<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class WooCommerce_Quick_Buy {
	protected static $_instance   = null;
	protected static $frontend    = null;
	protected static $auto_add    = null; # Required Plugin Class Instance
	protected static $admin       = null; # Required Plugin Class Instance
	public           $version     = '1.8'; # Required Plugin Class Instance
	public           $plugin_vars = array();     # Required Plugin Class Instance

	/**
	 * Class Constructor
	 */
	public function __construct() {
		$this->define_constant();
		$this->load_required_files();
		wc_quick_buy_db_settings();
		$this->init_class();
		add_action( 'plugins_loaded', array( $this, 'after_plugins_loaded' ), 99 );
		add_filter( 'load_textdomain_mofile', array( $this, 'load_plugin_mo_files' ), 10, 2 );
	}

	/**
	 * Define Required Constant
	 */
	private function define_constant() {
		$this->define( 'WCQB_NAME', 'WooCommerce Quick Buy' ); # Plugin Name
		$this->define( 'WCQB_SLUG', 'woocommerce-quick-buy' ); # Plugin Slug
		$this->define( 'WCQB_TXT', 'woocommerce-quick-buy' ); #plugin lang Domain
		$this->define( 'WCQB_DB', 'wc_quick_buy_' );
		$this->define( 'WCQB_V', $this->version ); # Plugin Version
		$this->define( 'WCQB_PATH', plugin_dir_path( __FILE__ ) ); # Plugin DIR
		$this->define( 'WCQB_LANGUAGE_PATH', WCQB_PATH . 'languages' ); # Plugin Language Folder
		$this->define( 'WCQB_INC', WCQB_PATH . 'includes/' ); # Plugin INC Folder
		$this->define( 'WCQB_ADMIN', WCQB_INC . 'admin/' ); # Plugin Admin Folder

		$this->define( 'WCQB_URL', plugins_url( '', __FILE__ ) . '/' );  # Plugin URL
		$this->define( 'WCQB_CSS', WCQB_URL . 'includes/css/' ); # Plugin CSS URL
		$this->define( 'WCQB_IMG', WCQB_URL . 'includes/img/' ); # Plugin IMG URL
		$this->define( 'WCQB_JS', WCQB_URL . 'includes/js/' ); # Plugin JS URL
		$this->define( 'WCQB_FILE', plugin_basename( __FILE__ ) ); # Current File
	}

	/**
	 * Define constant if not already set
	 *
	 * @param  string      $name
	 * @param  string|bool $value
	 */
	protected function define( $key, $value ) {
		if ( ! defined( $key ) ) {
			define( $key, $value );
		}
	}

	/**
	 * Loads Required Plugins For Plugin
	 */
	private function load_required_files() {
		$this->load_files( WCQB_INC . 'class-*.php' );
		if ( $this->is_request( 'admin' ) ) {
			$this->load_files( WCQB_ADMIN . 'class-*.php' );
		}
	}

	# Returns Plugin's Functions Instance

	/**
	 * Loads Files Based On Give Path & regex
	 */
	protected function load_files( $path, $type = 'require' ) {
		foreach ( glob( $path ) as $files ) {
			if ( $type == 'require' ) {
				require_once( $files );
			} elseif ( $type == 'include' ) {
				include_once( $files );
			}
		}
	}

	# Returns Plugin's Functions Instance

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	# Returns Plugin's Admin Instance

	/**
	 * Inits loaded Class
	 */
	private function init_class() {
		self::$frontend = new WooCommerce_Quick_Buy_FrontEnd;
		self::$auto_add = new WooCommerce_Quick_Buy_Auto_Add;

		if ( $this->is_request( 'admin' ) ) {
			self::$admin = new WooCommerce_Quick_Buy_Admin;
		}
	}

	/**
	 * Creates or returns an instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function func() {
		return self::$frontend;
	}

	public function auto_add() {
		return self::$auto_add;
	}

	public function admin() {
		return self::$admin;
	}

	/**
	 * Set Plugin Text Domain
	 */
	public function after_plugins_loaded() {
		wc_quick_buy_db_settings();
		load_plugin_textdomain( WCQB_TXT, false, WCQB_LANGUAGE_PATH );
	}

	/**
	 * load translated mo file based on wp settings
	 */
	public function load_plugin_mo_files( $mofile, $domain ) {
		if ( WCQB_TXT === $domain )
			return WCQB_LANGUAGE_PATH . '/' . get_locale() . '.mo';

		return $mofile;
	}
}