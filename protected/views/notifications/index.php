<?php
/* @var $this NotificationsController */

$this->breadcrumbs=array(
	'Notifications',
);
?>

<div class="form">
<?php echo CHtml::beginForm(); ?>
 
    <?php //echo CHtml::errorSummary($model); ?>
 
    <div class="row">
        <?php echo CHtml::label('User id', 'userid'); ?>
        <?php echo CHtml::textField('userid') ?>

    </div>
 
    <div class="row">
        <?php echo CHtml::label('Texto',  'texto'); ?>
        <?php echo CHtml::textArea('texto') ?>
    </div>
 
    <div class="row submit">
        <?php echo CHtml::submitButton('Send Notification'); ?>
    </div>
 
<?php echo CHtml::endForm(); ?>
</div><!-- form -->

