<?php
/*
Plugin Name: Form 2 Airtable
Plugin URI: https://samjco.com/plugins/form2airtable
Description: Plugin that builds a simple form to submit to a Airtable database.
Version: 0.1
Author: Sam Cohen
Author URI: https://samjco.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: form2airtable
Domain Path: /languages
*/

/**
 * Copyright (c) YEAR Your Name (email: Email). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Form_2_Airtable class
 *
 * @class Form_2_Airtable The class that holds the entire Form_2_Airtable plugin
 */
class Form_2_Airtable {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.1.0';

    /**
     * Constructor for the Form_2_Airtable class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses is_admin()
     * @uses add_action()
     */
    public function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        $this->includes();
        $this->init_hooks();
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'FORM2AIRTABLE_VERSION', $this->version );
        define( 'FORM2AIRTABLE_FILE', __FILE__ );
        define( 'FORM2AIRTABLE_PATH', dirname( FORM2AIRTABLE_FILE ) );
        define( 'FORM2AIRTABLE_INCLUDES', FORM2AIRTABLE_PATH . '/includes' );
        define( 'FORM2AIRTABLE_URL', plugins_url( '', FORM2AIRTABLE_FILE ) );
        define( 'FORM2AIRTABLE_ASSETS', FORM2AIRTABLE_URL . '/assets' );
    }

    /**
     * Initializes the Form_2_Airtable() class
     *
     * Checks for an existing Form_2_Airtable() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Form_2_Airtable();
        }

        return $instance;
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

        update_option( 'form2airtable_version', FORM2AIRTABLE_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {
        require_once dirname( __FILE__ ) .'/includes/codestar/cs-framework.php';
        require_once dirname( __FILE__ ) .'/formdata.php';
        require_once dirname( __FILE__ ) .'/formprocess.php';

    }



    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {
        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );

        // Loads frontend scripts and styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        define( 'CS_ACTIVE_FRAMEWORK',   true  ); // default true
        define( 'CS_ACTIVE_METABOX',     false ); // default true
        define( 'CS_ACTIVE_TAXONOMY',    false ); // default true
        define( 'CS_ACTIVE_SHORTCODE',   false ); // default true
        define( 'CS_ACTIVE_CUSTOMIZE',   false ); // default true
        define( 'CS_ACTIVE_LIGHT_THEME',  true  ); // default false



      

    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'form2airtable', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Enqueue admin scripts
     *
     * Allows plugin assets to be loaded.
     *
     * @uses wp_enqueue_script()
     * @uses wp_localize_script()
     * @uses wp_enqueue_style
     */
    public function enqueue_scripts() {

        /**
         * All styles goes here
         */
        wp_enqueue_style( 'form2airtable-styles', plugins_url( 'assets/css/style.css', __FILE__ ), false, date( 'Ymd' ) );
        wp_enqueue_style( 'bootstrap4-styles', plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ), false, date( 'Ymd' ) );

        /**
         * All scripts goes here
         */
        wp_enqueue_script( 'form2airtable-scripts', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), false, true );
        wp_enqueue_script( 'bootstrap4-scripts', plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ), array( 'jquery' ), false, true );


        /**
         * Example for setting up text strings from Javascript files for localization
         *
         * Uncomment line below and replace with proper localization variables.
         */
        // $translation_array = array( 'some_string' => __( 'Some string to translate', 'form2airtable' ), 'a_value' => '10' );
        // wp_localize_script( 'base-plugin-scripts', 'form2airtable', $translation_array ) );

    }

} // Form_2_Airtable

$form2airtable = Form_2_Airtable::init();
