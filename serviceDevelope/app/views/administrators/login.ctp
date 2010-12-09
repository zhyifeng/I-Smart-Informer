<div id = "AdministratorLoginForm">
<h2><?php __('Login');?></h2>
<?php echo $form->create('Administrator', array('action' => 'login')); ?>

<?php
    echo $form->input('Administrator.name');
    echo $form->input('Administrator.password');
?>

<?php echo $form->end('Login');?>
</div>