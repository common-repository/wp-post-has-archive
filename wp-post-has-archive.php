<?php
/*
Plugin Name: WP Post Has Archive
Description: WP Post Has Archive allows you to create an archive page with the URL of your choice.
Author: Nakashima Masahiro
Version: 1.0.1
Text Domain: post-has-archive
*/

namespace WP_Post_Has_Archive;

if (!class_exists('WP_Post_Has_Archive')) {
    class WP_Post_Has_Archive
    {
        public $plugin_dir_path;
        public $functions;

        public function __construct()
        {
            $this->plugin_dir_path = plugin_dir_path(__FILE__);
            // Load
            add_action('plugins_loaded', array($this, 'load_init_files'), 9);
            add_action('plugins_loaded', array($this, 'init'), 11);
            // Set Rule
            add_filter('register_post_type_args', array($this, 'register_post_archive'), 10, 2);
            // プラグインが有効・無効化されたとき
            register_activation_hook( __FILE__, array( $this, 'activationHook' ) );
            register_deactivation_hook( __FILE__, array( $this, 'deactivationHook' ) );
        }

        /**
         * ファイルのinclude.
         */
        public function load_init_files()
        {
            // Setting
            include_once $this->plugin_dir_path.'/config.php';
            include_once $this->plugin_dir_path.'/classes/util.php';
            include_once $this->plugin_dir_path.'/classes/functions.php';
            // controllers
            include $this->plugin_dir_path.'/controllers/controller.php';
            include $this->plugin_dir_path.'/controllers/admin.php';
            include $this->plugin_dir_path.'/controllers/admin/setting.php';
        }

        /**
         * Initialize.
         */
        public function init()
        {
            load_plugin_textdomain( Config::TEXT_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages/' );
            // Controllers
            $admin = new Admin_Controller();
        }

        /**
         * POST アーカイブのFilter
         */
        public function register_post_archive($args, $post_type){
            if ('post' == $post_type) {
                $option = get_option(Config::OPTION);
                $args['has_archive'] = $option['has_archive'];
                Functions::set_post_archive($args, $post_type);
            }
            return $args;
        }

        /**
         * プラグインが有効化されたときに実行
         */
        function activationHook() {
            $this->load_init_files();

            if ( !get_option(Config::OPTION) ) {
                update_option( Config::OPTION, Config::DEFAULT_OPTION );
            }
            $option = get_option(Config::OPTION);
            $args = array();
            $args['has_archive'] = $option['has_archive'];
            Functions::set_post_archive($args, 'post');
            flush_rewrite_rules();
        }

        /**
         * 無効化ときに実行
         */
        function deactivationHook() {
            delete_option(Config::OPTION);
        }

    }
    new WP_Post_Has_Archive();
}
