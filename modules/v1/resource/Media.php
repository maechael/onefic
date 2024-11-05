<?php

namespace app\modules\v1\resource;

use app\models\Metadata;

class Media extends Metadata
{
    public $file;
    public $files;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['basename', 'filename', 'filepath', 'type', 'size', 'extension'], 'required'],
            [['size'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['basename', 'filename', 'filepath'], 'string', 'max' => 255],
            [['type', 'extension'], 'string', 'max' => 50],
            [['file', 'files'], 'file', 'skipOnEmpty' => true],
        ];
    }
}
