<?php
/**
 * Created by PhpStorm.
 * User: Reza
 * Date: 7/10/2018
 * Time: 2:01 PM
 */

abstract class productConfig
{
    protected $productPost = array(
        'post_author'=>1,
        'post_date'=>"00/00/00",
        'post_date_gmt'=>"00/00/00",
        'post_content'=>"00/00/00",
        'post_title'=>"",
        'post_excerpt'=>'',
        'post_status'=>'publish',
        'comment_status'=>'open',
        'ping_status'=>'closed',
        'post_password'=>'',
        'post_name'=>"",
        'to_ping'=>'',
        'pinged'=>'',
        'post_modified'=>"00/00/00",
        'post_modified_gmt'=>"00/00/00",
        'post-content-filtered'=>'',
        'post_parent'=>0,
        'menu_order'=>0,
        'post_type'=>'product',
        'post_mime_type'=>'',
        'comment_count'=>0,
        'meta_input'=> array()
                );
    protected $productAttrWc = array(
        '_length' => 0,
        '_width' => 0,
        '_sku' => "",
        '_regular_price' => 0.0,
        '_sale_price' => 0.0,
        '_price' => 0.0
        );
    protected $totalRecords;

    abstract public function setProducts($product,$timestamp);
}
