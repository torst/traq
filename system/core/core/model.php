<?php
/**
 * Avalon
 * Copyright (C) 2011 Jack Polgar
 * 
 * @license http://opensource.org/licenses/BSD-3-Clause BSD License
 */

class Model
{
	public static $db;
	protected static $_name;
	protected static $_primary;
	private $keys = array();
	
	public function __construct($data = array())
	{
		if (count($data) > 0) {
			foreach ($data as $key => $val) {
				$this->keys[] = $key;
				$this->$key = $val;
			}
		}
	}
	
	public static function find($args = array())
	{
		if (!is_array($args)) {
			$args = array(
				'where' => array(
					array(static::$_primary . ' = \'?\'', $args)
				)
			);
		}
		
		$row = static::$db->select()->from(static::$_name);
		
		if (isset($args['where'])) {
			foreach ($args['where'] as $where) {
				$row->where($where[0], $where[1]);
			}
		}
		
		if (isset($args['order'])) {
			$row->orderby($args['order'][0], $args['order'][1]);
		}
		
		$row->limit(1);
		
		return new self($row->exec()->fetchAssoc());
	}
	
	public static function fetchAll($args = array())
	{
		$rows = static::$db->select()->from(static::$_name);
		
		if (isset($args['where'])) {
			foreach ($args['where'] as $where) {
				$rows->where($where[0], $where[1]);
			}
		}
		
		if (isset($args['order'])) {
			$rows->orderby($args['order'][0], $args['order'][1]);
		}
		
		return $rows->exec()->fetchAll();
	}
}