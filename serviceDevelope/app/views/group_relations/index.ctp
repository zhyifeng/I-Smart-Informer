<div class="groupRelations index">
	<h2><?php __('Group Relations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('groupOwner_id');?></th>
			<th><?php echo $this->Paginator->sort('groupOwned_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($groupRelations as $groupRelation):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $groupRelation['GroupRelation']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($groupRelation['GroupOwner']['name'], array('controller' => 'groups', 'action' => 'view', $groupRelation['GroupOwner']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($groupRelation['GroupOwned']['name'], array('controller' => 'groups', 'action' => 'view', $groupRelation['GroupOwned']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $groupRelation['GroupRelation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $groupRelation['GroupRelation']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $groupRelation['GroupRelation']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $groupRelation['GroupRelation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Group Relation', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Owner', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>