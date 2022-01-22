<?php 

/* 
Plugin Name: Membership Ordering System
Plugin URI: http://www.wordpress.org 
Description: 既存HP（ワードプレス使用）内で会員制発注システムの制作
Author: Moon Rider 
Version: 1.0 
Author URI: http://www.xyz.com 
*/  
	// global $wpdb;


	// $table_name = $wpdb->prefix . 'ms_shop';

 //    $sql = "CREATE TABLE $table_name (
 //        id mediumint(9) NOT NULL AUTO_INCREMENT,
 //        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        shop_name varchar(100) NOT NULL,
 //        img text NOT NULL,        
 //        shop_post varchar(100) NULL,        
 //        shop_pref varchar(100) NULL,        
 //        shop_city varchar(100) NULL,
 //        shop_address varchar(200) NOT NULL,
 //        name varchar(100) NOT NULL,
 //        tel varchar(100) NOT NULL,
 //        mail varchar(100) NOT NULL,
 //        invoice_info text NOT NULL,            
 //        PRIMARY KEY  (id)
 //    );";

 //    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 //    dbDelta( $sql );

 //    $table_name = $wpdb->prefix . 'ms_client';

 //    $sql = "CREATE TABLE $table_name (
 //        id mediumint(9) NOT NULL AUTO_INCREMENT,
 //        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        client_code varchar(100) NOT NULL UNIQUE,
 //        name varchar(100) NOT NULL,
 //        img text NOT NULL,  
 //        shop_id varchar(200) NOT NULL,
 //        shop varchar(200) NOT NULL,        
 //        client_post varchar(100) NULL,        
 //        client_pref varchar(100) NULL,        
 //        client_city varchar(100) NULL,
 //        address varchar(100) DEFAULT '' NULL,
 //        tel varchar(100) NOT NULL,
 //        mail varchar(100) NOT NULL,
 //        shipping_info text NOT NULL,            
 //        PRIMARY KEY  (id)
 //    );";

 //    // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 //    dbDelta( $sql );

 //    $table_name = $wpdb->prefix . 'ms_products';

 //    $sql = "CREATE TABLE $table_name (
 //        id mediumint(9) NOT NULL AUTO_INCREMENT,
 //        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        name varchar(100) NOT NULL,
 //        shop varchar(100) NULL,
 //        shop_id varchar(100) NULL,
 //        img text NULL,   
 //        regular double DEFAULT 0 NULL,
 //        sale double DEFAULT 0 NULL,
 //        currency varchar(100) NOT NULL,     
 //        comment text NULL, 
 //        PRIMARY KEY  (id)
 //    );";

 //    // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 //    dbDelta( $sql );

 //    $table_name = $wpdb->prefix . 'ms_invoice';

 //    $sql = "CREATE TABLE $table_name (
 //        id mediumint(9) NOT NULL AUTO_INCREMENT,
 //        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        history_id varchar(100) NULL,
 //        invoice_date date DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        invoice_num bigint(10) NOT NULL,
 //        client varchar(100) NULL,
 //        client_id varchar(20) DEFAULT '' NOT NULL,
 //        client_code varchar(10) DEFAULT '' NOT NULL, 
 //        address varchar(100) NULL,
 //        product_list varchar(100) NULL,
 //        sel_product_id varchar(100) NULL,
 //        price varchar(100) NOT NULL,     
 //        cnt varchar(100) NULL,     
 //        money varchar(100) NULL,
 //        delivery_date varchar(100) DEFAULT '' NOT NULL,
 //        PRIMARY KEY  (id)
 //    );";

 //    // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 //    dbDelta( $sql );

 //    $table_name = $wpdb->prefix . 'ms_invoice_history';

 //    $sql = "CREATE TABLE $table_name (
 //        id mediumint(9) NOT NULL AUTO_INCREMENT,
 //        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        history_id varchar(100) DEFAULT '' NOT NULL,
 //        invoice_date date DEFAULT CURRENT_TIMESTAMP NOT NULL,
 //        invoice_num bigint(10) NOT NULL UNIQUE,
 //        client varchar(100) NULL,     
 //        client_id varchar(100) DEFAULT '' NOT NULL, 
 //        client_code varchar(10) DEFAULT '' NOT NULL, 
 //        products text NOT NULL,      
 //        products_id varchar(100) DEFAULT '' NOT NULL, 
 //        state varchar(100) NULL,            
 //        PRIMARY KEY  (id)
 //    );";

 //    // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
 //    dbDelta( $sql );
    function create_tables(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'ms_shop';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
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
            time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            client_code varchar(100) NOT NULL UNIQUE,
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
            time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            name varchar(100) NOT NULL,
            shop varchar(100) NULL,
            shop_id varchar(100) NULL,
            img text NULL,   
            regular double DEFAULT 0 NULL,
            sale double DEFAULT 0 NULL,
            currency varchar(100) NOT NULL,     
            comment text NULL, 
            PRIMARY KEY  (id)
        );";

        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $table_name = $wpdb->prefix . 'ms_invoice';

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            history_id varchar(100) NULL,
            invoice_date date NULL,
            invoice_num bigint(10) NOT NULL,
            client varchar(100) NULL,
            client_id varchar(20) DEFAULT '' NOT NULL,
            client_code varchar(10) DEFAULT '' NOT NULL, 
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
            time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            history_id varchar(100) DEFAULT '' NOT NULL,
            invoice_date date NULL,
            invoice_num bigint(10) NOT NULL UNIQUE,
            client varchar(100) NULL,     
            client_id varchar(100) DEFAULT '' NOT NULL, 
            client_code varchar(10) DEFAULT '' NOT NULL, 
            products text NOT NULL,      
            products_id varchar(100) DEFAULT '' NOT NULL, 
            state varchar(100) NULL,            
            PRIMARY KEY  (id)
        );";

        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    add_action('init', 'create_tables');

	function load_ms_ordering_invoice_add()  {
		require_once('ms-ordering-invoice-add.php');
	}
	function load_ms_ordering_shop()  {
		require_once('ms-ordering-shop.php');
	}
	function load_ms_ordering_shop_add()  {
		require_once('ms-ordering-shop-add.php');
	}
	function load_ms_ordering_client()  {
		require_once('ms-ordering-client.php');
	}
	function load_ms_ordering_client_add()  {
		require_once('ms-ordering-client-add.php');
	}
	function load_ms_ordering_products()  {
		require_once('ms-ordering-products.php');
	}
	function load_ms_ordering_products_add()  {
		require_once('ms-ordering-products-add.php');
	}
	function load_ms_ordering_sys()  {
		require_once('ms-ordering-sys.php');
	}

	function hello_world_admin_menu()  {
		$menu_slug = 'ms-ordering-invoice-add';
		add_menu_page('会員制発注SYS', '会員制発注SYS', 'manage_options', $menu_slug, 'load_ms_ordering_invoice_add');  

		add_submenu_page( $menu_slug, 'ご発注フォーム', 'ご発注フォーム', 'manage_options', $menu_slug, 'load_ms_ordering_invoice_add');

		$menu_slug_shop = 'ms-ordering-shop';
	    add_submenu_page( $menu_slug, '代理店リスト', '代理店リスト', 'manage_options', $menu_slug_shop, 'load_ms_ordering_shop');

	    $menu_slug_shop = 'ms-ordering-shop-add';
        add_submenu_page( $menu_slug, '代理店新規登録', '代理店新規登録', 'manage_options', $menu_slug_shop, 'load_ms_ordering_shop_add');
        
        $menu_slug_client = 'ms-ordering-client';
        add_submenu_page( $menu_slug, '客先リスト', '客先リスト', 'manage_options', $menu_slug_client, 'load_ms_ordering_client');

        $menu_slug_client = 'ms-ordering-client-add';
        add_submenu_page( $menu_slug, '客先新規登録', '客先新規登録', 'manage_options', $menu_slug_client, 'load_ms_ordering_client_add');

        $menu_slug_client = 'ms-ordering-products';
        add_submenu_page( $menu_slug, '商品リスト', '商品リスト', 'manage_options', $menu_slug_client, 'load_ms_ordering_products');

        $menu_slug_client = 'ms-ordering-products-add';
        add_submenu_page( $menu_slug, '商品新規登録', '商品新規登録', 'manage_options', $menu_slug_client, 'load_ms_ordering_products_add');

        $menu_slug_client = 'ms-ordering-sys';
        add_submenu_page( $menu_slug, '発注履歴', '発注履歴', 'manage_options', $menu_slug_client, 'load_ms_ordering_sys');
	}  
	add_action( 'admin_menu', 'hello_world_admin_menu' );
	function custom_callback_function() {
        if (is_page('corporation_order')) {
		
            // if(!empty($_REQUEST['invoice'])){/kinujo.jp/corporation_order/

                include "ms-invoice-user.php";

            // }
            
        }else if(is_page('delivery')) {
            include "ms-invoice-email.php";
        }
        
        
    }
	add_action('the_content', 'custom_callback_function');
    

    // add_action( 'phpmailer_init', 'mailer_config', 10, 1);
    // function mailer_config(PHPMailer $mailer){
    //     $mailer->IsSMTP();
    //     $mailer->Host = "engagementring.nagoya"; // your SMTP server
    //     $mailer->Port = 587;
    //     $mailer->SMTPDebug = 2; // write 0 if you don't want to see client/server communication in page
    //     $mailer->CharSet  = "utf-8";
    // }
?>