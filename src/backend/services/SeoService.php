<?php

namespace bulldozer\seo\backend\services;

use bulldozer\App;
use bulldozer\db\ActiveRecord;
use bulldozer\seo\backend\widgets\forms\SeoUpdateForm;
use bulldozer\seo\common\ar\Seo;
use yii\i18n\PhpMessageSource;

/**
 * Class SeoService
 * @package bulldozer\seo\backend\services
 */
class SeoService
{
    /**
     * @var SeoUpdateForm
     */
    private $form;

    /**
     * SeoService constructor.
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        $this->form = App::createObject([
            'class' => SeoUpdateForm::class,
        ]);

        if (empty(App::$app->i18n->translations['seo'])) {
            App::$app->i18n->translations['seo'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/../../messages',
            ];
        }
    }

    /**
     * @param ActiveRecord $entity
     * @return Seo|null
     * @throws SeoSaveException
     * @throws \yii\base\InvalidConfigException
     */
    public function save(ActiveRecord $entity)
    {
        $seo = Seo::findOne(['entity' => $entity::tableName(), 'entity_id' => $entity->getPrimaryKey()]);

        if ($seo === null) {
            $seo = App::createObject([
                'class' => Seo::class,
            ]);
        }

        if ($this->form->load(App::$app->request->post()) && $this->form->validate()) {
            $seo->setAttributes($this->form->getAttributes($this->form->getSavedAttributes()));

            if ($seo->save()) {
                return $seo;
            }
        }

        throw new SeoSaveException(json_encode($seo->getErrors()));
    }

    /**
     * @return SeoUpdateForm
     */
    public function getForm(): SeoUpdateForm
    {
        return $this->form;
    }
}