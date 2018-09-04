<?php

namespace App\Responses;
use App\Http\Responses\Arrayed;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;


/**
 * Class Factory
 * @package App\Responses
 */
class Factory {

	public static function jsonFromModel( AppModel $model, $status = 200, $headers = [] ){
		return   new Response( $model, $status, $headers );
	}

	/**
	 * JSON from Eloquent collection
	 *
	 * @param Collection $collection
	 * @param int $status
	 * @param array $headers
	 *
	 * @return Response
	 */
	public static function jsonFromCollection(Collection $collection, $status = 200, $headers = [] )
	{
		$data = ( new Arrayed($collection) )->getResponseData();
		return static::json( $data, $status, $headers );
	}

	/**
	 * Respond with JSON
	 *
	 * @param array $data
	 * @param int $status
	 * @param array $headers
	 *
	 * @return Response
	 */
	public static function json( array  $data, int $status = 200, array $headers = [] )
	{
		return ( new Response( json_encode( $data ), $status, $headers ) )->header( 'content-type', 'application/json' );
	}

	public static function exceptionToResponse( Exception $exception, int $status = 400, bool $json = true, array  $headers = [] )
	{
		return self::error( $exception->getMessage(), $status, $json, $headers );
	}

	/**
	 * Respond with error message
	 *
	 * @param string $message
	 * @param int $status
	 * @param bool $json
	 * @param array $headers
	 *
	 * @return Response
	 */
	public static function error( string $message, int $status = 400, bool $json = true, array  $headers = [] ){
		if( $json ) {
			return static::json( [
				'error'   => true,
				'message' => $message
			], $status, $headers );
		}else{
			return response( $message, $status, $headers );
		}
	}

	/**
	 * Respond with response indicating accoutn limitation
	 *
	 * @param $message
	 * @param bool $json
	 * @param array $headers
	 *
	 * @return Response
	 */
	public static function accountLimited( $message, bool $json = true, array $headers = [] )
	{
		return self::error( $message, 402, $json, $headers );
	}


	public static function success( string $message, int $status = 200, bool $json = true, array  $headers = [] ){
		if( $json ) {
			return static::json( [
				'error'   => false,
				'message' => $message
			], $status, $headers );
		}else{
			return response( $message, $status, $headers );
		}
	}


}