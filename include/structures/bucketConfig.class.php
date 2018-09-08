<?php
/**
 * Created by PhpStorm.
 * User: Reza
 * Date: 7/10/2018
 * Time: 2:03 PM
 */

abstract class bucketConfig
{
    protected $bucket = array(
        'id' => 0,
        'name' => "",
        'createdDate' => "00/00/00",
        'activeDate' => "00/00/00",
        'expireDate' => "00/00/00",
        'timestamp' => "00/00/00",
        'slug' => "",
        'term_id' => 0,
        'taxonomy' => "product_cat",
        'totalRecordsInserted' => 0,
        'items' => array(
                    array()
                        )
    );
    abstract public function setBucket($bucket);
    abstract public function getBucket();

}
