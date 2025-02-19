<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://teconce.com/about/
 * @since      1.0.0
 *
 * @package    Edd_Sale_Counter_Advanced
 * @subpackage Edd_Sale_Counter_Advanced/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Edd_Sale_Counter_Advanced
 * @subpackage Edd_Sale_Counter_Advanced/admin
 * @author     Nazmus Shadhat <hello@teconce.com>
 */
class Edd_Sale_Counter_Advanced_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		// Add simple sale price field
		add_action( 'edd_after_price_field', array( $this, 'simple_sale_price_field' ) );

		// Add fields to EDD save
		add_action( 'edd_save_download', array( $this, 'save_custom_sale_fields' ) );


		/*************************
		 * Variable price hooks
		 ************************/

		// Add sale price to args
		add_filter( 'edd_price_row_args', array( $this, 'edd_price_row_args' ), 10, 2 );

		// Display sale price field
		add_action( 'edd_download_price_option_row', array( $this, 'variable_sale_price_field' ), 1, 3 );


		register_meta(
			'post',
			'edd_sale_price',
			array(
				'object_subtype'    => 'download',
				'sanitize_callback' => array( $this, 'sanitize_price' ),
				'type'              => 'float',
				'description'       => __( 'The sale price of the product.', 'easy-digital-downloads' ),
				'show_in_rest'      => true,
			)
		);
		
			register_meta(
			'post',
			'edd_sale_price_time',
			array(
				'object_subtype'    => 'download',
				'type'              => 'float',
				'description'       => __( 'The sale price time.', 'easy-digital-downloads' ),
				'show_in_rest'      => true,
			)
		);

		if ( ! has_filter( 'sanitize_post_meta_edd_sale_price' ) ) {
			add_filter( 'sanitize_post_meta_edd_sale_price', array( $this, 'sanitize_price' ), 10, 4 );
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Edd_Sale_Counter_Advanced_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Edd_Sale_Counter_Advanced_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 	wp_enqueue_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/edd-sale-counter-advanced-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Edd_Sale_Counter_Advanced_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Edd_Sale_Counter_Advanced_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 wp_enqueue_script( 'jquery-timepicker', plugin_dir_url( __FILE__ ) . 'js/jquery-timepicker.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/edd-sale-counter-advanced-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	
	/**
	 * Sale price field.
	 *
	 * Display the simple sale price field below the normal price field.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the current download being edited.
	 */
	public function simple_sale_price_field( $post_id ) {

		$price 				= edd_get_download_price( $post_id );
		$sale_price			= get_post_meta( $post_id, 'edd_sale_price', true );
		$time_sales			= get_post_meta( $post_id, 'edd_sale_price_time', true );
		$variable_pricing 	= edd_has_variable_prices( $post_id );
		$prices				= edd_get_variable_prices( $post_id );
		$single_option_mode	= edd_single_price_option_mode( $post_id );

		$price_display		= $variable_pricing ? ' style="display:none;"' : '';
		$variable_display	= $variable_pricing ? '' : ' style="display:none;"';

		?><div id="edd_regular_sale_price_field" class="edd_pricing_fields" <?php echo $price_display; ?>>
		<label class="eddadvsllabel">Sale Price</label>
		<?php

			$price_args = array(
				'name'	=> 'edd_sale_price',
				'value' => $sale_price !== '' ? esc_attr( edd_format_amount( $sale_price ) ) : '',
				'class'	=> 'edd-price-field edd-sale-price-field'
			);

			$currency_position = edd_get_option( 'currency_position' );
			if ( empty( $currency_position ) || $currency_position == 'before' ) :
				echo edd_currency_filter( '' ) . ' ' . EDD()->html->text( $price_args ) . ' ';
			else :
				echo EDD()->html->text( $price_args ) . ' ' . edd_currency_filter( '' ) . ' ';
			endif;

		

		?></div>
		
		
		<div id="edd_regular_sale_price_time_field" class="edd_pricing_fields">
			<label class="eddadvsllabel">Sale Price End Time</label>
			<span class="dashicons dashicons-clock"></span>
		<?php

			$time_args = array(
				'name'	=> 'edd_sale_price_time',
				'value' => $time_sales !== '' ? esc_attr( $time_sales ) : '',
				'id'	=> 'edd-sale-price-time-field',
				'class'	=> 'edd-price-field edd-sale-price-time-field'
			);

				echo EDD()->html->text( $time_args );
		

		?></div>
		
		
		
		<?php

	}


	/**
	 * Save sale price.
	 *
	 * Save the sale price by adding it to the EDD post
	 * meta saving list.
	 *
	 * @since 1.0.0
	 *
	 * @param	array $fields 	Existing array of fields to save.
	 * @return	array			Modified array of fields to save.
	 */
	public function save_custom_sale_fields( $post_id ) {
		if ( isset( $_POST['edd_sale_price'] ) ) {
			$new = apply_filters( 'edd_metabox_save_edd_sale_price', $_POST['edd_sale_price'] );
			$newtime = apply_filters( 'edd_metabox_save_edd_sale_time', $_POST['edd_sale_price_time'] );
			update_post_meta( $post_id, 'edd_sale_price', $new );
				update_post_meta( $post_id, 'edd_sale_price_time', $newtime );
		}
	}


	/**
	 * Sale price args.
	 *
	 * Add the sale price to the arguments to use later in $this->variable_sale_price_field().
	 *
	 * @since 1.0.0
	 *
	 * @param	array $args 	List of existing arguments being passed.
	 * @param	array $values 	List of set values for this specific price variation.
	 * @return	array			List of modified arguments being passed.
	 */
	public function edd_price_row_args( $args, $values ) {

		$args['sale_price'] = isset( $values['sale_price'] ) && $values['sale_price'] != '' ? edd_sanitize_amount( $values['sale_price'] ) : '';

		return $args;

	}


	/**
	 * Sale price header.
	 *
	 * Add the 'sale price' header to the variable prices table.
	 *
	 * @since 1.0.0
	 */
	public function add_variable_sale_price_header() {

		?><th style="width: 100px"><?php _e( 'Sale price', 'edd-sale-price' ); ?></th><?php

	}


	/**
	 * Variable sale price.
	 *
	 * Display the variable sale price field.
	 *
	 * @since 1.0.0
	 *
	 * @param	int 	$post_id 	ID of the download post.
	 * @param	int 	$key		Index key of the current price variation.
	 * @param	array	$args		Array of value arguments.
	 */
	public function variable_sale_price_field( $post_id, $key, $args ) {

		$args = wp_parse_args( $args, array(
			'sale_price' => null,
		) );

		$price_args = array(
			'name'	=> 'edd_variable_prices[' . $key . '][sale_price]',
			'value' => $args['sale_price'] != '' ? esc_attr( edd_format_amount( $args['sale_price'] ) ) : '',
			'class'	=> 'edd-price-field edd-sale-price-field'
		);

		?><div class="edd-custom-price-option-section">
			<div class="edd-custom-price-option-section-content"><?php
				$currency_position = edd_get_option( 'currency_position' );
				if ( empty( $currency_position ) || $currency_position == 'before' ) :
					?><label class="eddadvsllabel">Sale Price</label><span><?php echo edd_currency_filter( '' ) . ' ' . EDD()->html->text( $price_args ) . ' '; ?></span><?php
				else :
					?><label class="eddadvsllabel">Sale Price</label><span><?php echo EDD()->html->text( $price_args ) . ' ' . edd_currency_filter( '' ) . ' '; ?></span><?php
				endif;
			?></div>
		</div>
		
		
		<?php

	}


	/**
	 * Duplicate of EDD_Register_Meta::sanitize_price()
	 *
	 * Modifications: ( Price != '' ) check to allow empty values.
	 *
	 * @since 1.0.5
	 *
	 * @param  float $price The price to sanitize.
	 * @return float        A sanitized price.
	 */
	public function sanitize_price( $price ) {

		$allow_negative_prices = apply_filters( 'edd_allow_negative_prices', false );

		if ( $price != '' && ! $allow_negative_prices && $price < 0 ) {
			$price = 0;
		}

		return $price != '' ? edd_sanitize_amount( $price ) : '';
	}


    public function eddadv_settings_link( $links ) {
	  $settings_link = '<a href="options-general.php?page=eddadv_options">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}


}
