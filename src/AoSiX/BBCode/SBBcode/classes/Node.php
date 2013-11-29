<?php

namespace SBBCodeParser;

abstract class Node
{
	/**
	 * Nodes parent
	 * @var Node_Container
	 */
	protected $parent;

	/**
	 * Nodes root parent
	 * @var Node_Container
	 */
	protected $root;


	/**
	 * Sets the nodes parent
	 * @param Node $parent
	 */
	public function set_parent(Node_Container $parent=null)
	{
		$this->parent = $parent;

		if($parent instanceof Node_Container_Document)
			$this->root = $parent;
		else
			$this->root = $parent->root();
	}

	/**
	 * Gets the nodes parent. Returns null if there
	 * is no parent
	 * @return Node
	 */
	public function parent()
	{
		return $this->parent;
	}

	/**
	 * @return string
	 */
	public function get_html()
	{
		return null;
	}

	/**
	 * Gets the nodes root node
	 * @return Node
	 */
	public function root()
	{
		return $this->root;
	}

	/**
	 * Finds a parent node of the passed type.
	 * Returns null if none found.
	 * @param string $tag
	 * @return Node_Container_Tag
	 */
	public function find_parent_by_tag($tag)
	{
		$node = $this->parent();

		while($this->parent() != null
			&& !$node instanceof Node_Container_Document)
		{
			if($node->tag() === $tag)
				return $node;

			$node = $node->parent();
		}

		return null;
	}
}