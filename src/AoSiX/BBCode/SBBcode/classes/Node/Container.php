<?php

namespace SBBCodeParser;

abstract class Node_Container extends Node
{
	/**
	 * Array of child nodes
	 * @var array
	 */
	protected $children = array();


	/**
	 * Adds a Node as a child
	 * of this node.
	 * @param $child The child node to add
	 * @return void
	 */
	public function add_child(Node $child)
	{
		$this->children[] = $child;
		$child->set_parent($this);
	}

	/**
	 * Replaces a child node
	 * @param Node $what
	 * @param mixed $with Node or an array of Node
	 * @return bool
	 */
	public function replace_child(Node $what, $with)
	{
		$replace_key = array_search($what, $this->children);

		if($replace_key === false)
			return false;

		if(is_array($with))
			foreach($with as $child)
				$child->set_parent($this);

		array_splice($this->children, $replace_key, 1, $with);

		return true;
	}

	/**
	 * Removes a child fromthe node
	 * @param Node $child
	 * @return bool
	 */
	public function remove_child(Node $child)
	{
		$key = array_search($what, $this->children);

		if($key === false)
			return false;

		$this->children[$key]->set_parent();
		unset($this->children[$key]);
		return true;
	}

	/**
	 * Gets the nodes children
	 * @return array
	 */
	public function children()
	{
		return $this->children;
	}

	/**
	 * Gets the last child of type Node_Container_Tag.
	 * @return Node_Container_Tag
	 */
	public function last_tag_node()
	{
		$children_len = count($this->children);

		for($i=$children_len-1; $i >= 0; $i--)
			if($this->children[$i] instanceof Node_Container_Tag)
				return $this->children[$i];

		return null;
	}

	/**
	 * Gets a HTML representation of this node
	 * @return string
	 */
	public function get_html($nl2br=true)
	{
		$html = '';

		foreach($this->children as $child)
			$html .= $child->get_html($nl2br);

		if($this instanceof Node_Container_Document)
			return $html;

		$bbcode = $this->root()->get_bbcode($this->tag);

		if(is_callable($bbcode->handler()) && ($func = $bbcode->handler()) !== false)
			return $func($html, $this->attribs, $this);
		//return call_user_func($bbcode->handler(), $html, $this->attribs, $this);

		return str_replace('%content%', $html, $bbcode->handler());
	}

	/**
	 * Gets the raw text content of this node
	 * and it's children.
	 *
	 * The returned text is UNSAFE and should not
	 * be used without filtering!
	 * @return string
	 */
	public function get_text()
	{
		$text = '';

		foreach($this->children as $child)
			$text .= $child->get_text();

		return $text;
	}
}