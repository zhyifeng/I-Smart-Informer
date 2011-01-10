<div class="groupTypes view">
<h2><?php  __('Group Type');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $groupType['GroupType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $groupType['GroupType']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group Type', true), array('action' => 'edit', $groupType['GroupType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Group Type', true), array('action' => 'delete', $groupType['GroupType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $groupType['GroupType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Group Types', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Type', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
