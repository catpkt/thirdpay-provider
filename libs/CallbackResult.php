<?php

namespace CatPKT\ThirdPayProvider;

use FenzHTTP\Response;

////////////////////////////////////////////////////////////////

class CallbackResult
{

	/**
	 * Var status
	 *
	 * @access protected
	 *
	 * @var    true
	 */
	protected $status;

	/**
	 * Var payload
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $payload;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  bool $status
	 * @param  array $payload
	 */
	public function __construct( bool$status, array$payload )
	{
		$this->status= $status;
		$this->payload= $payload;
	}

	/**
	 * Method isSuccessful
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function isSuccessful():bool
	{
		return $this->status<300 && $this->status>=200;
	}

	/**
	 * Method getMessoge
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function getMessoge():string
	{
		return $this->message;
	}

}
