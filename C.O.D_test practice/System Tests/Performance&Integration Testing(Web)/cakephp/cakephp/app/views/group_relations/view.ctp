<div class="groupRelations view">
<h2><?php  __('Group Relation');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group Owner'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($groupRelation['GroupOwner']['name'], array('controller' => 'groups', 'action' => 'view', $groupRelation['GroupOwner']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group Owned'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($groupRelation['GroupOwned']['name'], array('controller' => 'groups', 'action' => 'view', $groupRelation['GroupOwned']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group Relation', true), array('action' => 'edit', $groupRelation['GroupRelation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Group Relation', true), array('action' => 'delete', $groupRelation['GroupRelation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $groupRelation['GroupRelation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Group Relations', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Relation', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
