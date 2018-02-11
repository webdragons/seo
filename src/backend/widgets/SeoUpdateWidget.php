<?php

namespace bulldozer\seo\backend\widgets;

use bulldozer\App;
use bulldozer\seo\backend\services\SeoService;
use bulldozer\seo\backend\widgets\forms\SeoUpdateForm;
use InvalidArgumentException;
use Yii;
use yii\base\Widget;

use yii\widgets\ActiveForm;

/**
 * Class SeoUpdateWidget
 * @package bulldozer\seo\backend\widgets
 */
class SeoUpdateWidget extends Widget
{
    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var SeoService
     */
    public $seoService;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        if ($this->form === null) {
            $this->form = new ActiveForm();
        } elseif (!($this->form instanceof ActiveForm)) {
            throw new InvalidArgumentException('Form must be instance of ActiveForm');
        }

        if (!($this->seoService instanceof SeoService)) {
            throw new InvalidArgumentException('seoService must be instance of SeoService');
        }
    }

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        return $this->render('seo_update', [
            'seoUpdateForm' => $this->seoService->getForm(),
            'form' => $this->form,
        ]);
    }
}