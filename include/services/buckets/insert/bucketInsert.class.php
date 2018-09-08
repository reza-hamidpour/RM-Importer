<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 7/10/2018
 * Time: 1:42 PM
 */
require_once(dirname(__FILE__) . "/../../../structures/bucketConfig.class.php");

class buckets extends bucketConfig
{
    private $buckets;
    private $totalRecords;


    public function setBuckets($buckets, $totalRecords)
    {
        $this->buckets = $buckets;
        $this->totalRecords = $totalRecords;
    }

    public function getBuckets()
    {
        return $this->buckets;
    }

    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    public function setBucket($bucket)
    {
        foreach ($bucket as $key => $value) {
            if (array_key_exists($key, $this->bucket) && $key !== "items") {
                $this->bucket[$key] = $value;
            } else if ($key == "items") {
                foreach ($bucket[items] as $product) {
                    array_push($this->bucket["items"], $product["itemId"], array(
                        "itemId" => $product['itemId']
                    ));
                }
            }
        }
        $this->bucket["slug"] = str_replace(" ", "-", $this->bucket["name"]) . "-slug";
    }

    public function getBucket()
    {
        return $this->bucket;
    }

    public function insertBuckets($buckets)
    {
        global $wpdb;
        foreach ($buckets as $bucket) {
            setBucket($bucket);
            $termId = term_exists($this->bucket['slug']);
            if ($termId === 0 || $termId === null) {
                $this->bucket['term_id'] = wp_insert_term($this->bucket['name'], 'category', array('slug' => $this->bucket['slug']));
                $resultWpUpdate = $wpdb->update(
                    'wp_term_taxonomy',
                    array('taxonomy' => $this->bucket['taxonomy']),
                    array('term_id' => $this->bucket['term_id']),
                    array('%s'),
                    array('%d')
                );
                if ($resultWpUpdate === false || $resultWpUpdate === null) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }
}
