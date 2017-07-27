<?php

namespace CatPKT\ThirdPayProvider;

use CatPKT\Encryptor\TWithEncryptor;

////////////////////////////////////////////////////////////////

abstract class AApp
{
	use TWithEncryptor;

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
