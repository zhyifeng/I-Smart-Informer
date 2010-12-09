<div class="groupRelations form">
<?php echo $this->Form->create('GroupRelation');?>
	<fieldset>
 		<legend><?php __('Edit Group Relation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('groupOwner_id');
		echo $this->Form->input('groupOwned_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('GroupRelation.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('GroupRelation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Group Relations', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Owner', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>