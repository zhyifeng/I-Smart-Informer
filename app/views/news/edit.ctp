<div class="news form">
<?php echo $this->Form->create('News');?>
	<fieldset>
 		<legend><?php __('Edit News'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('text');
		echo $this->Form->input('date');
		echo $this->Form->input('administrator_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('News.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('News.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List News', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Administrators', true), array('controller' => 'administrators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Administrator', true), array('controller' => 'administrators', 'action' => 'add')); ?> </li>
	</ul>
</div>