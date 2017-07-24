<?php

namespace CatPKT\ThirdPayProvider;

////////////////////////////////////////////////////////////////

class CallbackPayload
{

	/**
	 * Var details
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $details;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  string $code
	 * @param  string $tradeId
	 * @param  int $time
	 * @param  int $payerId
	 * @param  array $extensions
	 */
	public function __construct( string$code, string$tradeId, int$time, int$payerId=null, array$extensions=[] )
	{
		$this->details['code']= $code;
		$this->details['tradeId']= $tradeId;
		$this->details['time']= $time;
		$this->details['payerId']= $payerId;
		$this->details['extensions']= $extensions;
	}

	/**
	 * Method getDetails
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function getDetails():array
	{
		return $this->details;
	}

}
