<?php
function addImporter()
{
    add_menu_page('RM Pro Importer', 'RmPro', 'manage_options', 'rm-pro-imp-slug', 'ImporterManager');
    add_menu_page('Data Link Importer', 'DataLink', 'manage_options', 'data-link-imp-slug', 'dataLinkImporter');
    add_submenu_page('rm-pro-imp-slug', 'Rm Pro Picture url structer', 'pic structer', 'manage_options', 'rm-pic-struc-slug', 'RMpicStructer');

}


//include_once(ABSPATH."woocommerce/includes/api/legacy/v3/class-wc-api-products.php");
add_action('admin_menu', 'addImporter');
function ImporterManager()
{
    require_once(dirname(__FILE__) . "/../assets/panelui/importerpanel.php");
}

function RMpicStructer()
{
    require_once(dirname(__FILE__) . "/../assets/panelui/picturestructer.php");
}

function dataLinkImporter()
{
    require_once(dirname(__FILE__) . "/../assets/panelui/datalinkpanel.php");
}

/*
 * start service with service name
*/
//***************************************Rm Pro
if (isset($_POST['sync_with_server'])) {
//    $json = file_get_contents(dirname(__FILE__).'/test.json'); // Get json from sample file
//    $products_data = json_decode($json, true); // Decode it into an array
    // insert_product_ri(array(null));
    echo "Hello word";
}
//**************************************
//************************** Data Link
var_dump(wc_get_attribute_taxonomies());
if (isset($_POST['sync_with_data_link'])) {
    /* sample data */
    $baseUrl = "http://apps.rminno.com";
    $port = "80";
    $service = "customApi/vendorproduct/getbucketproduct";
    $params = "isVendorWebsite=1&bucketId=5b7144e3a1300c88575207c6&skip=1&where={\"\":\"\"}";
    /***************/
//    $productDataLink = new DataLinkRequests($baseUrl, $port, $service, $params, "POST", "", "");
//    echo $productDataLink->getHeaderRequest();
//    $productDataLink->requestApi(30);


//    insertProductVariation();
//    addaprdct();
// The variation data
//    $_pf = new WC_Product_Factory();
//    $product_ = $_pf->get_product(50);
//    var_dump($product_);
//    $variation_data =  array(
//        'attributes' => array(
//            'size'  => 'large',
//            'color' => 'green',
//        ),
//        'sku'           => '',
//        'regular_price' => '22.00',
//        'sale_price'    => '',
//        'stock_qty'     => 10,
//    );
//    $postProduct = get_post($parent_id);
// The function to be run
//    create_product_variation( 57, $variation_data );
//    create_product_variation();
//    wc_create_attribute(array(
//        'attribute_label'   => 'sample_test',
//        'attribute_name'    => 'sample_test',
//        'attribute_type'    => 'select',
//        'attribute_orderby' => 'menu_order',
//        'attribute_public'  => 0));
    // Create attribute
//    $attribute_name = "sample_test";
//    $attribute = array(
//        'attribute_label'   => $attribute_name,
//        'attribute_name'    => $attribute_name,
//        'attribute_type'    => 'select',
//        'attribute_orderby' => 'menu_order',
//        'attribute_public'  => 0,
//    );
//    $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
//    $return['attribute_id'] = $wpdb->insert_id;
    // Register the taxonomy
//    $name  = wc_attribute_taxonomy_name( $attribute_name );
//    $label = $attribute_name;
    $parent_id = 50; // Or get the variable product id dynamically
//    connectTermToTaxonomy('blue|green|reed', 'testtt35', 57);
//    unset($optionWC[8]);
//    $optionWC[7] = array('stdClass' => (object) array(
//        'attribute_id' => 10,
//        'attribute_name' => 'soozy',
//        'attribute_label' => 'soozy',
//        'attribute_type' => 'select',
//        'attribute_orderby' => 'menu_order',
//        'attribute_public' => 1));
//    var_dump(($optionWC));
//    setAttributeToProduct(57,'book' , 'Green');
//    wc_delete_attribute(13);
}

function connectTermToTaxonomy($termName, $attributeName, $objectID)
{
    global $wpdb;
    $insertTaxonomyNew = $wpdb->insert('wp_woocommerce_attribute_taxonomies',
        array('attribute_name' => $attributeName,
            'attribute_label' => $attributeName,
            'attribute_type' => 'select',
            'attribute_orderby' => 'menu_order',
            'attribute_public' => 1));
    $optionWC = get_option('_transient_wc_attribute_taxonomies', false);
    array_push($optionWC, '{"attribute_id" : $wpdb->insert_id, "attribute_name" : $attributeName, "attribute_label" : $attributeName, "attribute_type" : $attributeName, "attribute_orderby" : \'menu_order\', "attribute_public" : 1}' ) ;
    update_option('_transient_wc_attribute_taxonomies' , $optionWC);
    if ($insertTaxonomyNew) {
        $taxonomyName = 'pa_' . $attributeName;
        //    wp_insert_term($termName , $taxonomyName);
        $insertToTermtb = $wpdb->insert('wp_terms',
            array(
                'name' => $termName,
                'slug' => $termName,
                'term_group' => 0
            ),
            array(
                '%s', '%s', '%d'
            )
        );
        $wpdb->insert_id;
        if ($insertToTermtb) {
            $insertToTermTaxonomy = $wpdb->insert('wp_term_taxonomy',
                array('term_id' => $wpdb->insert_id,
                    'taxonomy' => $taxonomyName,
                    'description' => "",
                    'parent' => 0,
                    'count' => 0),
                array('%d', '%s', '%s', '%d', '%d')
            );
            if ($insertToTermTaxonomy) {
                $insertToRelTerms = $wpdb->insert('wp_term_relationships',
                    array('object_id' => $objectID,
                        'term_taxonomy_id' => $wpdb->insert_id,
                        'term_order' => 0
                    ),
                    array('%d', '%d', '%d'));
                setAttributeToProduct($objectID, $taxonomyName, 'blue|green|reed');
                return $insertToRelTerms;
            }
        }
    }
}

//
//function add_taxonomy()
//{
//
//    var_dump(register_new_taxonomy('soozy', 'product_type', array(
//        "label" => "soozy",
//        "singular_label" => "soozy",
//        "rewrite" => true,
//        "show_ui" => "true",
//        'hierarchical' => true,
//        'rewrite' => array('slug' => 'soozy')
//    )));
//}
//
//add_action('init', 'add_taxonomy', 'product_type', $args);
//***********************************

function register_new_taxonomy($taxonomyName, $objectType = 'product_type', $args = array())
{
    echo 'hello word';
    return register_taxonomy(
        $taxonomyName,
        $objectType,
        $args
    );
}

function insertProductVariation()
{
    $data = [
        'name' => 'Ship Your Idea',
        'type' => 'variable',
        'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
        'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
        'product_type' => 'variable',
        'categories' => [
            [
                'id' => 9
            ],
            [
                'id' => 14
            ]
        ],
        'images' => [
            [
                'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_front.jpg',
                'position' => 0
            ],
            [
                'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_back.jpg',
                'position' => 1
            ],
            [
                'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_front.jpg',
                'position' => 2
            ],
            [
                'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_back.jpg',
                'position' => 3
            ]
        ],
        'available_attributes' => [
            'color', 'size'
        ],
        'variations' => [
            [
                'attributes' => [
                    'size' => 'm',
                    'color' => 'Black'
                ],
                'price' => '14$'
            ],
            [
                'attributes' => [
                    'size' => 's',
                    'color' => 'Green'
                ],
                'price' => '13$'
            ]
        ]
    ];

//    print_r(wc()->post('products', $data));

    insert_product($data);
//        $obData->create_product($data);
}
