<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /** @inheritdoc */
    protected $table = [
        'account_id',
        's3_id',
        'cdn_url'
    ];

    /** @inheritdoc */
    public $timestamps = true;

    /** @inheritdoc */
    public function toArray()
    {

        $array = [
            'id' => $this->id,
            'account_id' => $this->getAccountId(),
            's3_id' => $this->getS3Id(),
            'cdn_url' => $this->getCdnUrl()
        ];

        return $array;

    }

}