<div class="groupRelations form">
<?php echo $this->Form->create('GroupRelation');?>
	<fieldset>
 		<legend><?php __('Add Group Relation'); ?></legend>
	<?php
		echo $this->Form->input('groupOwner_id');
		echo $this->Form->input('groupOwned_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Group Relations', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Owner', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>