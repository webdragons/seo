<?php

namespace bulldozer\seo\backend\widgets\forms;

use bulldozer\base\Form;
use bulldozer\seo\common\ar\Seo;
use Yii;

/**
 * Class SeoUpdateForm
 * @package bulldozer\seo\backend\widgets\forms
 *
 * @property Seo $seo
 */
class SeoUpdateForm extends Form
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $keywords;

    /**
     * @var string
     */
    public $h1;

    /**
     * @var string
     */
    public $seo_text;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['title', 'string', 'max' => 255],

            ['description', 'string'],

            ['seo_text', 'string'],

            ['keywords', 'string'],

            ['h1', 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function getSavedAttributes(): array
    {
        return [
            'h1',
            'title',
            'keywords',
            'description',
            'seo_text',
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'h1' => Yii::t('seo', 'Page Title (h1)'),
            'title' => Yii::t('seo', 'Page Title (title)'),
            'keywords' => Yii::t('seo', 'Keywords'),
            'description' => Yii::t('seo', 'Description'),
            'seo_text' => Yii::t('seo', 'SEO text'),
        ];
    }
}