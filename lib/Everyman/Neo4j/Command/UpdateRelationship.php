<?php
namespace Everyman\Neo4j\Command;
use Everyman\Neo4j\Command,
	Everyman\Neo4j\Exception,
	Everyman\Neo4j\Relationship;

/**
 * Update a relationship's properties
 */
class UpdateRelationship implements Command
{
	protected $rel = null;

	/**
	 * Set the relationship to drive the command
	 *
	 * @param Relationship $rel
	 */
	public function __construct(Relationship $rel)
	{
		$this->rel = $rel;
	}

	/**
	 * Return the data to pass
	 *
	 * @return mixed
	 */
	public function getData()
	{
		return $this->rel->getProperties();
	}

	/**
	 * Return the transport method to call
	 *
	 * @return string
	 */
	public function getMethod()
	{
		return 'put';
	}

	/**
	 * Return the path to use
	 *
	 * @return string
	 */
	public function getPath()
	{
		if (!$this->rel->getId()) {
			throw new Exception('No relationship id specified');
		}
		return '/relationship/'.$this->rel->getId().'/properties';
	}

	/**
	 * Use the results
	 *
	 * @param integer $code
	 * @param array   $headers
	 * @param array   $data
	 * @return integer on failure
	 */
	public function handleResult($code, $headers, $data)
	{
		if ((int)($code / 100) == 2) {
			return null;
		}
		return $code;
	}
}
