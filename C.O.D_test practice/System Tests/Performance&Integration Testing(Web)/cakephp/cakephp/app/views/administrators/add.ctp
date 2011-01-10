<div class="administrators form">
<?php echo $this->Form->create('Administrator');?>
	<fieldset>
 		<legend><?php __('Add Administrator'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('password');
		echo $this->Form->input('group_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Administrators', true), array('action' => 'index'));?></li>
	</ul>
</div>