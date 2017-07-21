<?php

namespace CatPKT\ThirdPayProvider;

////////////////////////////////////////////////////////////////

abstract class AApp
{
	use CatPKT\Encryptor\TWithEncryptor;

	/**
	 * Method getApiUri
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	abstract public function getApiUri():string;

}
