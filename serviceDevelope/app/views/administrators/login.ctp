<?php
if (isset($error)) {
  echo('Invalid Login.');
}
?>

<p>Please log in.</p>
<?php echo $form->create('Administrator', array('action' => 'login')); ?>

<?php
    echo $form->input('Administrator.name');
    echo $form->input('Administrator.password');
?>

<?php echo $form->end('Login');?>
<pre>
<?php var_dump($administratora);
 ?>
</pre>