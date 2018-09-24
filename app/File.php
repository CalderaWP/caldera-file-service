<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /** @inheritdoc */
    protected $table = [
        'file_id',
        'cf_account_id',
        'cdn_url',
        'filename',
        's3_path',
        'cf_entry_id'
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