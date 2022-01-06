<?php   
    /* 
    Plugin Name: Membership Ordering System
    Plugin URI: http://www.wordpress.org 
    Description: 既存HP（ワードプレス使用）内で会員制発注システムの制作
    Author: Moon Rider 
    Version: 1.0 
    Author URI: http://www.xyz.com 
    */  

global $wpdb;

class membershipOrderingSystemPlug
{  
    
    private $my_plugin_screen_name;  
    private static $instance;  
    private $wpdb;
       /*......*/  
    
    static function GetInstance()  
    {  
        
        if (!isset(self::$instance))  
        {  
            self::$instance = new self();
              
        }  
        return self::$instance;  
    }  
    public function CreateDb()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'ms_shop';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            shop_name varchar(100) NOT NULL,
            img text NOT NULL,        
            shop_post varchar(100) NULL,        
            shop_pref varchar(100) NULL,        
            shop_city varchar(100) NULL,
            shop_address varchar(200) NOT NULL,
            name varchar(100) NOT NULL,
            tel varchar(100) NOT NULL,
            mail varchar(100) NOT NULL,
            invoice_info text NOT NULL,            
            PRIMARY KEY  (id)
        );";
    
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'ms_client';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name varchar(100) NOT NULL,
            img text NOT NULL,  
            shop_id varchar(200) NOT NULL,
            shop varchar(200) NOT NULL,        
            client_post varchar(100) NULL,        
            client_pref varchar(100) NULL,        
            client_city varchar(100) NULL,
            address varchar(100) DEFAULT '' NULL,
            tel varchar(100) NOT NULL,
            mail varchar(100) NOT NULL,
            shipping_info text NOT NULL,            
            PRIMARY KEY  (id)
        );";
    
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'ms_products';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            name varchar(100) NOT NULL,
            shop varchar(100) NULL,
            shop_id varchar(100) NULL,
            img text NULL,   
            regular double NULL,
            sale double NULL,
            currency varchar(100) NOT NULL,     
            comment text NULL, 
            PRIMARY KEY  (id)
        );";
    
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'ms_invoice';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            history_id varchar(100) NULL,
            invoice_date date DEFAULT '0000-00-00 00:00:00' NOT NULL,
            invoice_num varchar(100) NULL,
            client varchar(100) NULL,
            client_id varchar(20) DEFAULT '' NOT NULL,
            address varchar(100) NULL,
            product_list varchar(100) NULL,
            sel_product_id varchar(100) NULL,
            price varchar(100) NOT NULL,     
            cnt varchar(100) NULL,     
            money varchar(100) NULL,
            delivery_date varchar(100) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
        );";
    
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'ms_invoice_history';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time varchar(100) DEFAULT '' NOT NULL,
            history_id varchar(100) DEFAULT '' NOT NULL,
            invoice_date date DEFAULT '' NOT NULL,
            invoice_num varchar(100) NULL,
            client varchar(100) NULL,     
            client_id varchar(100) DEFAULT '' NOT NULL, 
            products text NOT NULL,      
            products_id varchar(100) DEFAULT '' NOT NULL, 
            state varchar(100) NULL,            
            PRIMARY KEY  (id)
        );";
    
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    public function PluginMenu()  
    {  
        
        // $menu_slug = 'ms-ordering-sys';
        
        // $this->my_plugin_screen_name = add_menu_page('会員制発注SYS', 
        //                                             'ご発注フォーム', 
        //                                             'manage_options', 
        //                                             $menu_slug, 
        //                                             array($this, 'RenderPage'), 
        //                                             'dashicons-welcome-widgets-menus');
        $menu_slug = 'ms-ordering-invoice-add';
        
        $this->my_plugin_screen_name = add_menu_page('会員制発注SYS', 
                                                    '会員制発注SYS', 
                                                    'manage_options', 
                                                    $menu_slug, 
                                                    array($this, 'RenderPage'), 
                                                    'dashicons-welcome-widgets-menus');
        add_submenu_page( $menu_slug, 'ご発注フォーム', 'ご発注フォーム', 'manage_options', $menu_slug, array($this, 'RenderPage') );
        
        $menu_slug_shop = 'ms-ordering-shop';
        add_submenu_page( $menu_slug, '代理店リスト', '代理店リスト', 'manage_options', $menu_slug_shop, array($this, 'RenderSubPage') );
        
        $menu_slug_shop = 'ms-ordering-shop-add';
        add_submenu_page( $menu_slug, '代理店新規登録', '代理店新規登録', 'manage_options', $menu_slug_shop, array($this, 'RenderSubPage') );
        
        $menu_slug_client = 'ms-ordering-client';
        add_submenu_page( $menu_slug, '客先リスト', '客先リスト', 'manage_options', $menu_slug_client, array($this, 'RenderSubPage'));

        $menu_slug_client = 'ms-ordering-client-add';
        add_submenu_page( $menu_slug, '客先新規登録', '客先新規登録', 'manage_options', $menu_slug_client, array($this, 'RenderSubPage'));

        $menu_slug_client = 'ms-ordering-products';
        add_submenu_page( $menu_slug, '商品リスト', '商品リスト', 'manage_options', $menu_slug_client, array($this, 'RenderSubPage'));

        $menu_slug_client = 'ms-ordering-products-add';
        add_submenu_page( $menu_slug, '商品新規登録', '商品新規登録', 'manage_options', $menu_slug_client, array($this, 'RenderSubPage'));

        $menu_slug_client = 'ms-ordering-sys';
        add_submenu_page( $menu_slug, '発注履歴', '発注履歴', 'manage_options', $menu_slug_client, array($this, 'RenderSubPage'));
        


        // $menu_slug_things = 'ms-ordering-products';
        // add_submenu_page( $menu_slug, '商品管理画面', '商品管理画面', 'manage_options', $menu_slug_things, array($this, 'RenderSubPage'));


    }  
        
    public function RenderPage()
    {  
        include $_REQUEST['page'].".php";
        ?>  
            <!-- <h1>既存HP（ワードプレス使用）内で会員制発注システムの制作</h1> -->
        <?php  
    }  

    public function RenderSubPage()
    {  
        include $_REQUEST['page'].".php";
    }
    function so_enqueue_scripts(){
        wp_register_script( 
          'ajaxHandle', 
          plugins_url('PATH TO YOUR SCRIPT FILE/jquery.ajax.js', __FILE__), 
          array(), 
          false, 
          true 
        );
        wp_enqueue_script( 'ajaxHandle' );
        wp_localize_script( 
          'ajaxHandle', 
          'ajax_object', 
          array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) 
        );
    }
    public function custom_callback_function() {
        if (is_page('sample-page')) {
		
            if(!empty($_REQUEST['invoice'])){

                include "ms-invoice-email.php";

            }
            
        }
        
        
    }
    public function InitPlugin()  
    {          
        add_action('admin_menu', array($this, 'CreateDb'));
        add_action('admin_menu', array($this, 'PluginMenu'));  
        add_action('the_content', array($this, 'custom_callback_function'));
        
    }  
    
}  
   
$membershipOrderingSystemPlug = membershipOrderingSystemPlug::GetInstance();  
$membershipOrderingSystemPlug->InitPlugin();  
?> 