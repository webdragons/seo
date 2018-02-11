<?php

/**
 * @var \bulldozer\seo\backend\widgets\forms\SeoUpdateForm $seoUpdateForm
 * @var \yii\widgets\ActiveForm $form
 * @var string $entity
 * @var int $entity_id
 * @var \yii\db\ActiveRecord $model
 */

use dosamigos\ckeditor\CKEditor;

?>
<?php if ($seoUpdateForm->hasErrors()): ?>
    <div class="alert alert-danger">
        <?= $form->errorSummary($seoUpdateForm) ?>
    </div>
<?php endif ?>

<?= $form->field($seoUpdateForm, 'title')->textInput(['maxlength' => true, 'id' => 'title']) ?>

<?= $form->field($seoUpdateForm, 'h1')->textInput(['maxlength' => true, 'id' => 'h1']) ?>

<?= $form->field($seoUpdateForm, 'keywords')->textarea(['id' => 'keywords']) ?>

<?= $form->field($seoUpdateForm, 'description')->textarea(['id' => 'description']) ?>

<?= $form->field($seoUpdateForm, 'seo_text')->widget(CKEditor::className(), [
    'options' => ['rows' => 12],
]) ?>

