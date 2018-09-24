<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Responses\Factory as ResponseFactory;
use App\File as FileModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

            if ($request->hasFile('file')) {

                $filename = $request->filename;
                $account = $request->account;
                $entry_id = $request->entry_id;
                $path = $request->file('file')->store( $account . '/' . $entry_id );
                $url = Storage::url($path);
                $file_id = sha1( $path . $request->file('file') );

                DB::table('files')->insertGetId(
                    [
                        'file_id'           => $file_id,
                        'cf_account_id'     =>  $account,
                        's3_path'           =>  $path,
                        'cdn_url'           =>  $url,
                        'filename'          =>  $filename,
                        'cf_entry_id'       =>  $entry_id,
                        'created_at'        =>  date("Y-m-d H:i:s")
                    ]
                );

                return $file_id;

            }


        } catch ( Unauthorized $e ) {
            return ResponseFactory::exceptionToResponse( $e );
        }


    }


}
