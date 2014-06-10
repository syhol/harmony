<?php

/**
 * Class wrapper for terms
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_Term extends Glyph
{

	/**
	 * Array of WP_Post object keys that need to be saved using wp_update_post
	 * 
	 * @var array
	 */
	protected static $term_keys = array(
		'term_id',
		'name',
		'slug',
		'term_group',
		'term_taxonomy_id',
		'taxonomy',
		'description',
		'parent',
		'count',
		'filter'
	);

	/**
	 * Array of original data
	 *  
	 * @var array
	 */
	protected $original = array();

	/**
	 * Setup the container with required properties
	 *
	 * @param array           $data
	 */
	public function __construct($data = array())
	{
		$this->data = $this->original = $data;
	}

	/**
	 * Save term meta and data
	 * 
	 * @return self
	 */	
	public function save()
	{
		return $this;
	}
}
