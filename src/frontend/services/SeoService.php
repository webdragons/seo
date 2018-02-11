<?php

namespace bulldozer\seo\frontend\services;

use bulldozer\App;
use bulldozer\seo\common\ar\Seo;
use Yii;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\i18n\PhpMessageSource;

/**
 * Class SeoService
 * @package frontend\services
 */
class SeoService extends BaseObject
{
    /**
     * @var Pagination
     */
    public $pagination;

    /**
     * @var ActiveRecord
     */
    private $_model;

    /**
     * @var Seo
     */
    private $_seo;

    /**
     * SeoService constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        if (empty(App::$app->i18n->translations['seo'])) {
            App::$app->i18n->translations['seo'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/../../messages',
            ];
        }

        $this->initSeo();

        $this->process();
    }

    /**
     * @param ActiveRecord $value
     */
    public function setModel(ActiveRecord $value): void
    {
        $this->_model = $value;
    }

    /**
     * @param array $defaultValues
     * @throws \yii\base\InvalidConfigException
     */
    public function setDefaultValues(array $defaultValues): void
    {
        $this->initSeo();

        $this->_seo->setAttributes($defaultValues);
    }

    /**
     * @return null|string
     */
    public function getH1(): ?string
    {
        $h1 = $this->_seo->h1;

        if ($this->pagination && $h1) {
            $page = $this->pagination->page + 1;

            if ($page > 1) {
                $h1 = Yii::t('seo', '{h1} - page {page}', [
                    'h1' => $h1,
                    'page' => $page,
                ]);
            }
        }

        return $h1;
    }

    /**
     * @return null|string
     */
    public function getSeoText(): ?string
    {
        return $this->_seo->seo_text;
    }

    /**
     * Process seo
     */
    protected function process(): void
    {
        $seo = $this->findSeoInfo();

        if ($seo) {
            $this->updateSeo($seo);
        }

        if (!empty($this->_seo->title)) {
            $title = $this->_seo->title;

            if ($this->pagination) {
                $page = $this->pagination->page + 1;
                $pagesCount = $this->pagination->pageCount;

                if ($page > 1) {
                    $title = Yii::t('seo', '{title} - page {page} from {pagesCount}', [
                        'title' => $title,
                        'page' => $page,
                        'pagesCount' => $pagesCount
                    ]);
                }
            }

            App::$app->view->title = $title;
        }

        if (!empty($this->_seo->description)) {
            $description = $this->_seo->description;

            if ($this->pagination) {
                $page = $this->pagination->page + 1;
                $pagesCount = $this->pagination->pageCount;

                if ($page > 1) {
                    $description = $description . Yii::t('seo', ' | Page {page} from {pagesCount}', [
                            'page' => $page,
                            'pagesCount' => $pagesCount,
                        ]);
                }
            }

            App::$app->view->registerMetaTag([
                'name' => 'description',
                'content' => $description,
            ]);
        }

        if (!empty($this->_seo->keywords)) {
            App::$app->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $this->_seo->keywords,
            ]);
        }
    }

    /**
     * @param Seo $seo
     */
    protected function updateSeo(Seo $seo): void
    {
        $attributes = $seo->getAttributes();

        foreach ($attributes as $attribute => $value) {
            if (!empty($value)) {
                $this->_seo->setAttribute($attribute, $value);
            }
        }
    }

    /**
     * @return Seo|null
     */
    protected function findSeoInfo(): ?Seo
    {
        if ($this->_model) {
            $seo = Seo::findOne([
                'entity' => $this->_model::tableName(),
                'entity_id' => $this->_model->getPrimaryKey(),
            ]);

            if ($seo) {
                return $seo;
            }
        }

        return null;
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function initSeo(): void
    {
        if ($this->_seo === null) {
            $this->_seo = App::createObject([
                'class' => Seo::class,
            ]);
        }
    }
}