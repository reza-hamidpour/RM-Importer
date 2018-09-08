<?php
require_once(dirname(__FILE__)."/../../../structures/productConfig.class.php");
class simpleProducts extends productConfig
{
    public function ___constractor($Products,$PostCat)
    {
        $this->Products = $Products;
        $this->PostCat = array( $PostCat );
    }

  private $Products;
  private $PostCat = array();

  public function setProducts($Products,$timestamp)
  {
    foreach($Products as $product)
    {
      $check_post_exists = rmi_post_exists($product['descripion'],$product['descripion'],$timestamp);
      if( $check_post_exists === 0 ){
        $this->productPost['post_date'] = $timestamp;
        $this->productPost['post_date_gmt'] = $timestamp;
        $this->productPost['post_title'] = $product['descripion'];
        $this->productPost['post_excerpt'] = $product['descripion'];
        $this->productPost['post_modified'] = $timestamp;
        $this->productPost['post_modified_gmt'] = $timestamp;
        $this->productPost['meta_input'] = $product['listValues'];
        $post_id = wp_insert_post($this->productPost);
        if($this->postCategoryList($product) === null)
        {
            echo "This Product can't add to database";
        }else{

        }
      }else{

//          $check_post_exists
      }
    }
  }
  private function insertPost($post)
  {

  }
  private function insertProduct($product,$productId)
  {

  }
  private function addAdditionalAttr($product,$productId)
  {

  }
  private function postCategoryList($product)
  {
    $catExists = term_exists($product['listValues']['category']);
    if($catExists === 0 || $catExists === null)
    {
        $catSlug = str_replace(" ","-",$product['listValues']['category'])."-slug";
        $catId = wp_insert_term($product['listValues']['category'], 'category', array('slug' => $catSlug));
        global $wpdb;
        $resultUpdate = $wpdb->update(
            'wp_term_taxonomy',
            array('taxonomy' => 'product_cat',),
            array( 'term_id' => $catId['term_id']),
            array('%s',),
            array( '%d' )
        );
        if($resultUpdate === 0 || $resultUpdate === null)
        {
            return null;
        }else{

        }
        array_push($this->PostCat ,$catId);
    }else{
        array_push($this->PostCat ,$catExists);
    }
    return true;
  }
  private function rmi_post_exists($title,$content,$date) {
        global $wpdb;
        $post_title = wp_unslash( sanitize_post_field( 'post_title', $title, 0, 'db' ) );
        $post_content = wp_unslash( sanitize_post_field( 'post_content', $content, 0, 'db' ) );
        $post_date = wp_unslash( sanitize_post_field( 'post_date', $date, 0, 'db' ) );

        $query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
        $args = array();

        if ( !empty ( $date ) ) {
            $query .= ' AND post_date = %s';
            $args[] = $post_date;
        }

        if ( !empty ( $title ) ) {
            $query .= ' AND post_title = %s';
            $args[] = $post_title;
        }

        if ( !empty ( $content ) ) {
            $query .= ' AND post_content = %s';
            $args[] = $post_content;
        }

        if ( !empty ( $args ) )
            return (int) $wpdb->get_var( $wpdb->prepare($query, $args) );

        return 0;
    }
}
