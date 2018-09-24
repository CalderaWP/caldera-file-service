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

    /**
     * Delete File
     *
     * @param Request $request $file_id
     *
     * @return \Illuminate\Http\Response
     */
    public function delete( Request $request, $file_id )
    {

        try {

            $s3_path = DB::table('files')->where('file_id', $file_id )->value('s3_path');

            if ( $s3_path ) {

                $db_deleted = DB::table('files')->where('file_id', $file_id )->delete();

                $storage_deleted = Storage::delete( $s3_path );

                return response()->json([
                    'db_deleted'        => $db_deleted,
                    'storage_deleted'   =>  $storage_deleted
                ]);

            } else {
                return response()->json([
                    'no_file'        => 'Nothing Found'
                ]);
            }


        } catch ( Unauthorized $e ) {
            return ResponseFactory::exceptionToResponse( $e );
        }


    }

    /**
     * Retrieve File
     *
     * @param Request $request $file_id
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieve( Request $request, $file_id )
    {

        try {

            $s3_path = DB::table('files')->where('file_id', $file_id )->value('s3_path');

            if ( $s3_path ) {

                $filename = DB::table('files')->where('file_id', $file_id )->value('filename');
                $url = DB::table('files')->where('file_id', $file_id )->value('cdn_url');
                $cf_entry_id = DB::table('files')->where('file_id', $file_id )->value('cf_entry_id');


                return response()->json([
                    'filename'      => $filename,
                    'url'           =>  $url,
                    'cf_entry_id'   =>  $cf_entry_id
                ]);

            } else {
                return response()->json([
                    'no_file'        => 'Nothing Found'
                ]);
            }


        } catch ( Unauthorized $e ) {
            return ResponseFactory::exceptionToResponse( $e );
        }


    }


}
