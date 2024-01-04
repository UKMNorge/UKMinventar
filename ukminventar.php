<?php
/* 
Plugin Name: UKM Inventar
Plugin URI: http://www.ukm-norge.no
Description: Enkel plugin for administrasjon av inventar
Author: UKM Norge / J Nordbø
Version: 1.0 
Author URI: http://jardar.net
*/

use UKMNorge\Nettverk\Administrator;
use UKMNorge\Wordpress\Modul;

require_once('UKM/Autoloader.php');



class UKMinventar extends Modul{
    public static $action = 'inventar';
    public static $path_plugin = null;
    public static $current_admin;


    public static function hook() {
        // add_action('user_admin_menu', ['UKMinventar','user_meny']);
        add_action('network_admin_menu', ['UKMinventar','meny']);
        

    }



    // public static function user_meny() {
    //         $userpage[] = add_menu_page(
    //             'UKM Norge Inventarliste', 
    //             'Inventarliste Administrasjon', 
    //             'subscriber', 
    //             'UKMinventar_user',
    //             ['UKMinventar','renderAdmin'], 
    //             'dashicons-archive',
    //             401
    //         );
    //         $userpage[] = add_submenu_page( 
    //             'UKMinventar',
    //             'Tilskuddssøknader',
    //             'Tilskuddssøknader',
    //             'subscriber',
    //             'UKMinventar_soknader',
    //             ['UKMinventar','renderSoknader']
    //         );
    //         foreach( $userpage as $scripthook ) {
    //             add_action(
    //                 'admin_print_styles-' . $scripthook, 
    //                 ['UKMinventar','scripts_and_styles']
    //             );
    //         }

    //     }


    /**
     * Add menu
     */
    public static function meny() {
        $page[] = add_menu_page(
            'UKM Norge Inventarliste', 
            'Inventarliste', 
            'superadmin', 
            'UKMinventar',
            ['UKMinventar','renderAdmin'], 
            'dashicons-archive',
            401
        );
        $page[] = add_submenu_page( 
            'UKMinventar',
            'Kategorier',
            'Kategorier',
            'superadmin',
            'UKMinventar_categories',
            ['UKMinventar','renderCategories']
        );
        $page[] = add_submenu_page( 
            'UKMinventar',
            'Lokasjoner',
            'Lokasjoner',
            'superadmin',
            'UKMinventar_locations',
            ['UKMinventar','renderLocations']
        );
        $page[] = add_submenu_page( 
            '',
            'Rapporter',
            'Rapporter',
            'superadmin',
            'UKMinventar_edit',
            ['UKMinventar','renderEdit']
        );
        $page[] = add_submenu_page( 
            '',
            'Legg til',
            'Legg til',
            'superadmin',
            'UKMinventar_add',
            ['UKMinventar','renderAddItem']
        );
        foreach( $page as $scripthook ) {
            add_action( 
                'admin_print_styles-' . $scripthook, 
                ['UKMinventar', 'scripts_and_styles']
            );
        }
    }

    /**
     * Register hooks
     */
    public static function scripts_and_styles() {
        $path = str_replace('http:','https:', WP_PLUGIN_URL);
        wp_enqueue_style('UKMwp_dashboard_css');
        wp_enqueue_style('https://fonts.googleapis.com/icon?family=Material+Icons');
        wp_enqueue_style('UKMinventarjquery_js', plugin_dir_url( __FILE__ ) .'jquery-3.6.4.min.js' );
        wp_enqueue_style('UKMinventarbootstrap_css', plugin_dir_url( __FILE__ ) .'bootstrap.min.css' );
        wp_enqueue_script('UKMinventarbootstrap_js', plugin_dir_url( __FILE__ ) .'bootstrap.bundle.min.js' );
        wp_enqueue_style('UKMinventardatatables_css', plugin_dir_url( __FILE__ ) .'datatables.min.css' );
        wp_enqueue_script('UKMinventardatatables_js', plugin_dir_url( __FILE__ ) .'datatables.min.js' );
        wp_enqueue_style('UKMinventar_css', plugin_dir_url( __FILE__ ) .'ukminventar.css' );
        wp_enqueue_script('UKMinventar_js', plugin_dir_url( __FILE__ ) .'ukminventar.js' );
    }

    /**
     * Render av soknader-action
     *
     * @return void
     */
    public static function renderEdit() {
        static::setAction('edit');
        return static::renderAdmin();
    }
    public static function renderAddItem() {
        static::setAction('add');
        return static::renderAdmin();
    }
    public static function renderCategories() {
        static::setAction('categories');
        return static::renderAdmin();
    }
    public static function renderLocations() {
        static::setAction('locations');
        return static::renderAdmin();
    }
}

## HOOK MENU AND SCRIPTS
UKMinventar::init(__DIR__);
UKMinventar::hook();