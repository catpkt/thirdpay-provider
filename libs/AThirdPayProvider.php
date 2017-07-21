<?php

namespace CatPKT\ThirdPayProvider;

use FenzHTTP\HTTP;
use Symfony\Component\HttpFoundation\{  Request,  Response  };

////////////////////////////////////////////////////////////////

abstract class AThirdPayProvider
{

	/**
	 * Var app
	 *
	 * @access protected
	 *
	 * @var    AApp
	 */
	protected $app;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  AApp $app
	 */
	public function __construct( AApp$app )
	{
		$this->app= $app;
	}

	/**
	 * Handle the request and returns the response.
	 *
	 * @access public
	 *
	 * @param  Request $request
	 * @param  string $baseUrl
	 *
	 * @return Response
	 */
	public function handle( Request$request, string$baseUrl='/' ):Response
	{
		return new Response(
			$this->app()->getEncryptor()->encrypt(
				$this->{'action'.$this->route( $request, $baseUrl )}( $request )
			)
		);
	}

	/**
	 * Route the request to a controller method.
	 *
	 * @access private
	 *
	 * @param  Request $request
	 * @param  string $baseUrl
	 *
	 * @return string
	 */
	private function route( Request$request, $baseUrl ):string
	{
		$path= trim( substr( $request->getPathInfo(), strlen( $baseUrl ) ), '/' )?:'/';

		return [
			'POST:/'=> 'CreatePay',
			'POST:/asyncCallback'=> 'AsyncCallback',
			// 'GET:/'=> 'Orders',
			// 'POST:/refund'=> 'Refund',
			// 'GET:/refund'=> 'RefundLogs',
		][$request->getMethod().':'.$path];
	}

	/**
	 * Method actionCreatePay
	 *
	 * @access private
	 *
	 * @param  Request $request
	 *
	 * @return Response
	 */
	private function actionCreatePay( Request$request ):Response
	{
		return $this->createPay(...[
			$requests->get( 'thirdId' ),
			$requests->get( 'code' ),
			$requests->get( 'amount' ),
			$requests->get( 'comment' ),
			$requests->get( 'extends', [] ),
		]);
	}

	/**
	 * Method createPay
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @param  string $user
	 * @param  string $code
	 * @param  int $amount
	 * @param  string $comment
	 * @param  array $extends
	 *
	 * @return Response
	 */
	abstract protected function createPay( string$userId, string$code, int$amount, string$comment, array$extends=[] ):Response;

	/**
	 * Method actionAsyncCallback
	 *
	 * @access private
	 *
	 * @param  Request $request
	 *
	 * @return Response
	 */
	private function actionAsyncCallback( Request$request ):Response
	{
		$payload= $this->parseCallback( $request );

		$result= $this->sendToApp( $payload );

		return $this->respondCallback( $result );
	}

	/**
	 * Method parseCallback
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return CallbackPayload
	 */
	abstract protected function parseCallback( Request$request ):CallbackPayload;

	/**
	 * Method respondCallback
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @param  CallbackResult $result
	 *
	 * @return Response
	 */
	abstract protected function respondCallback( CallbackResult$result ):Response;

	/**
	 * Method sendToApp
	 *
	 * @access private
	 *
	 * @param  CallbackPayload $payload
	 *
	 * @return CallbackResult
	 */
	private function sendToApp( CallbackPayload$payload ):CallbackResult
	{
		return new CallbackResult(
			HTTP::url( trim( $this->app->getApiUri(), '/' ).'/callback' )->post(
				$this->app->encrypt(
					$payload->getDetails()
				)
			)
		);
	}

}
