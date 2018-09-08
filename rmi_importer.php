<?php
/***
    * Plugin Name: RMI IMPORTER
    * Plugin URI: http://portal.rminno.com/
    * description: a plugin to import data from other links
    * Version: 1.2
    * Author: Ray Hamidpour
    * Author URI: hamidpourr@gmail.com
 ***/

defined('ABSPATH') || exit('You dont have permission to access this directory!');
define('GT_URL_PLANING',plugin_dir_URL(__FILE__));


add_action( 'init', 'create_new_taxonomy' );

function create_new_taxonomy() {
    register_taxonomy(
        'pa_size',
        'products',
        array(
            'label' => __( 'Product size' ),
            'rewrite' => array( 'slug' => 'pa_size'),
            'hierarchical' => true,
        )
    );
}



require_once(ABSPATH."wp-includes/pluggable.php");
require dirname(__FILE__)."/../woocommerce/woocommerce.php";


require_once(dirname(__FILE__)."/include/services/buckets/insert/bucketInsert.class.php");
require_once(dirname(__FILE__) . "/include/services/buckets/DataLinkRequests.clsss.php");
//include_once(dirname(__FILE__)."/include/test-variable.php");
include_once dirname(__FILE__)."/include/fsd.php";
include_once(dirname(__FILE__)."/include/main.php");

//require_once(dirname(__FILE__)."/include/services/api_request/request.class.php");


function addTerm(){
    register_taxonomy(
        "siize",
                 "product_cat"
    );
//    unregister_taxonomy('pa_size');
//    $termTaxonomy = wp_insert_term( "large", 'pa_siize'); // Create the term
//    var_dump($termTaxonomy);
}
add_action("init","addTerm");