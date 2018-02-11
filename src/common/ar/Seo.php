<?php

namespace bulldozer\seo\common\ar;

use bulldozer\db\ActiveRecord;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property integer $id
 * @property string $entity
 * @property integer $entity_id
 * @property string $title
 * @property string $h1
 * @property string $keywords
 * @property string $description
 * @property string $seo_text
 */
class Seo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%seo}}';
    }
}
