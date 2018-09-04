<?php
/**
 * Created by PhpStorm.
 * User: New0
 * Date: 04/09/2018
 * Time: 10:58
 */

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class storageTest extends TestCase
{

    /**
     * Test that the default Storage option is S3 predefined bucket
     *
     * @return void
     */
    public function testFilePath()
    {
        $url = Storage::url('file.jpg');
        $this->assertEquals($url, 'https://caldera-files.s3.us-east-2.amazonaws.com/file.jpg');
    }
}