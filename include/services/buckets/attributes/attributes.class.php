<?php
class attributes {

	private $term = array( "term_id" => 0, "name" => "", "slug" => "", "term_group" => 0 );
	private $termMeta = array( "meta_id", "term_id", "meta_key", "meta_value" );
	private $taxonomy = array("term_taxonomy_id" => 0 , "taxonomy" => "" ,"description" => "" ,"parent" => 0 , "count" => 0);
	private $attributeWc = array(
		"attribute_id"     => 0,
		"attribute_name",
		"attribute_lable",
		"attribute_type",
		"attribute_orderby",
		"attribute_public" => 1
	);
	private $objectID;
	private $wpdb;
	private $object;

	function __construct( $attributeWc ,$term ) {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->setAttributeWC($attributeWc);
		$this->setTerm( $term );
	}

	/**
	 * @return null | true
	 * if result equal null so we can't create attribute on wp_woocommerce_attribute_taxonomies
	 * if result equal true so attribute created successfully
	 */
	public function createAttribute() {
		$CreateAttribute = $this->wpdb->insert( "wp_woocommerce_attribute_taxonomies"
			, array(
				"attribute_name"    => $this->attributeWc['attribute_name'],
				"attribute_label"   => $this->getAttributeWC( "attribute_label" ),
				"attribute_type"    => $this->getAttributeWC( "attribute_type" ),
				"attribute_orderby" => $this->getAttributeWC( "attribute_orderby" ),
				"attribute_public"  => $this->getAttributeWC( "attribute_public" )
			),
			array( "%s", "%s", "%s", "%s", "%d" ) );
		if ( $CreateAttribute === false ) {
			return null;
		}
		$this->setAttributeWC( $this->wpdb->insert_id ); // id of attribute which created above
		$wcAttribues  = unserialize( get_option( "_transient_wc_attribute_taxonomies" ) );
		$newAttribute = (object) [
			"attribute_id"      => $this->getAttributeWC( "attribute_id" ),
			"attribute_name"    => $this->getAttributeWC( "attribute_name" ),
			"attribute_label"   => $this->getAttributeWC( "attribute_label" ),
			"attribute_type"    => $this->getAttributeWC( "attribute_type" ),
			"attribute_orderby" => $this->getAttributeWC( "attribute_orderby" ),
			"attribute_public"  => $this->getAttributeWC( "attribute_public" )
		];
		array_push( $wcAttribues, $newAttribute );
		update_option( "_transient_wc_attribute_taxonomies", serialize( $wcAttribues ) );
//		$this->setTaxonomy();
		return true;
	}

	/**
	 * @return bool|null
	 * if result equal null ,that mean's attribute must create at first or slug is empty
	 * if result equal false , that mean's this term exist or can't insert new term on wp_terms or wp_termmeta
	 */
	public function createTerms() {
		if ( $this->getAttributeWC( "attribute_id" ) == 0 || empty($this->getTerm("slug")) ) {
			return null;
		}
		if ( $this->checkTermExists() === false ) {
			return false;
		}

		$insertTerm = $this->wpdb->insert(
			"wp_terms",
			array( "name"       => $this->getTerm( "name" ),
			       "slug"       => $this->getTerm( "slug" ),
			       "term_group" => $this->getTerm( "term_group" )
			),
			array( '%s', '%s', '%d' )
		);
		if ( $insertTerm === false ) {
			return false;
		}
		$this->setTerm($this->wpdb->insert_id);
		$metaKey = "order_pa_".$this->getTerm("slug");
		$insertTermMeta = $this->wpdb->insert(
			"wp_termmeta",
			array("term_id" => $this->getTerm("term_id"), "meta_key" => $metaKey , "meta_value" => ""),
			array('%d' , '$s', '%d')
		);
		if($insertTermMeta === false)
			return false;

		return addTermToTaxonomy();
	}

	public function addTermToTaxonomy() {
//		if($this->getTerm("term_id") !== 0 && $this->getAtt)
	}

	public function cunnectTermToObject() {

	}

	public function checkTermExists() {
		if ( $this->getTerm( "name" ) !== "" && $this->getTaxonomy() !== "" ) {
			$termCheck = term_exists( $this->getTerm(), $this->getTaxonomy() );
			if ( $termCheck === null ) {
				return false;
			}

			return $termCheck;
		} else if ( $this->getTerm() !== "" ) {
			$termCheck = term_exists( $this->getTerm() );
			if ( $termCheck === null ) {
				return false;
			}

			return $termCheck;
		} else {
			return null;
		}
	}

	/**
	 * @param array|int $term
	 * which if $term equal an int value so that mean's its
	 * id of term
 	 */
	public function setTerm( $term ) {
		if(is_array($term)){
			$this->term = $term;
		}else{
			$this->term["term_id"] = $term;
		}
	}

	/**
	 * @param mixed $taxonomy
	 */
	public function setTaxonomy( $taxonomy ) {
		$this->taxonomy = $taxonomy;
	}

	/**
	 * @param mixed $taxonomyID
	 */
	public function setTaxonomyID( $taxonomyID ) {
		$this->taxonomyID = $taxonomyID;
	}

	/**
	 * @param mixed $term_order
	 */
	public function setTermOrder( $term_order ) {
		$this->term_order = $term_order;
	}

	/**
	 * @param $attribute (array | string 'value of attribute_id')
	 */
	public function setAttributeWC( $attribute ) {
		if ( is_array( $attribute ) ) {
			$this->attributeWc = $attribute;
		} else {
			$this->attributeWc['attribute_id'] = $attribute;
		}
	}

	/**
	 * @return mixed
	 */
	public function getTaxonomy() {
		return $this->taxonomy;
	}

	/**
	 * @return mixed
	 */
	public function getTaxonomyID() {
		return $this->taxonomyID;
	}

	/**
	 * @param string
	 *
	 * @return array (key exists) | null (key not exists)
	 */
	public function getTerm( $index ) {
		if ( key_exists( $index, $this->term ) ) {
			return $this->term[ $index ];
		}

		return null;
	}

	/**
	 * @return mixed
	 */
	public function getObject() {
		return $this->object;
	}

	public function getAttributeWC( $index ) {
		if ( $index == "" ) {
			return null;
		}

		return $this->attributeWc[ $index ];
	}

	/**
	 * @param mixed $object
	 */
	public function setObject( $object ) {
		$this->object = $object;
	}

}