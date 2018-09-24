<?php
/**
 * Created by PhpStorm.
 * User: nahuel
 * Date: 04/09/2018
 * Time: 11:01
 */
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class filesTest extends TestCase
{

    /**
     * Test that the put to default storage returns true
     *
     * @return void
     */
    public function testUploadFile()
    {
        $filename = 'file.txt';
        $filePath = 'coucou';

        $path = Storage::put($filename, $filePath);

        $this->assertEquals($path, true);
    }


}