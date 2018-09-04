<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Unauthorized;
use App\Account;
use App\Responses\Factory as ResponseFactory;
use App\File as FileModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class s3FilesController extends Controller
{

    /**
     * Upload File
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function upload( Request $request )
    {

        try {

            //$account = $this->checkAuth( $request );
            foreach ( $request->allFiles() as $file ){

                $path = $file->store( 'images' );
                return response()->json([
                    'path' => $path
                ]);
                
            }


        } catch ( Unauthorized $e ) {
            return ResponseFactory::exceptionToResponse( $e );
        }


    }

    public function store(Request $request)
    {

        $path = Storage::put( 'client-folder', 'file' );
        return response()->json([
            'path' => $path
        ]);


    }

}
