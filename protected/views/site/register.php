<?php
$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
        'Login',
);
?>
 
<h1>Register</h1>
 
<p>Please fill out the following form with your register credentials:</p>
 
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>true,
)); ?>
 
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <div class="row">
                <?php //echo $form->labelEx($model,'name'); ?>
                <?php //echo $form->textField($model,'name'); ?>
                <?php //echo $form->error($model,'name'); ?>
        </div>
        <div class="row">
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model,'email'); ?>
                <?php echo $form->error($model,'email'); ?>
        </div>
 
        <div class="row">
                <?php echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model,'username'); ?>
                <?php echo $form->error($model,'username'); ?>
        </div>
 
        <div class="row">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password'); ?>
                <?php echo $form->error($model,'password'); ?>
        </div>
 
        <div class="row buttons">
                <?php echo CHtml::submitButton('Register'); ?>
        </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->