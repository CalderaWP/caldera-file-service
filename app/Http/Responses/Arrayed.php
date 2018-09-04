<?php


namespace App\Http\Responses;
use Illuminate\Support\Collection;

/**
 * Class Arrayed
 *
 * Acts as a recursive toArray() on collections
 *
 * @package App\Responses
 */
class Arrayed {

	/** @var array  */
	public $responseData;

	/** @var Collection  */
	public $collection;

	/**
	 * Arrayed constructor.
	 *
	 * @param Collection $collection
	 */
	public function __construct( Collection $collection )
	{
		$this->collection = $collection;
		$this->responseData = [];
	}

	/**
	 * Get response data (acts as lazy-collector)
	 *
	 * @return array
	 */
	public function getResponseData() : array
	{
		if( empty( $this->responseData ) ){
			$this->setResponseData();
		}

		return $this->responseData;
	}

	/**
	 * Sets the responseData property
	 */
	public function setResponseData()
	{
		$this->collection->each( function ($item, $key) {
			if ( method_exists( $item, 'toArray') ) {
				$this->responseData[] = $item->toArray();
			}else{
				$this->responseData[] = $item;
			}
		});

	}

}