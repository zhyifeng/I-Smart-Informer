<div class="administrators view">
<h2><?php  __('Administrator');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $administrator['Administrator']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($administrator['Group']['name'], array('controller' => 'groups', 'action' => 'view', $administrator['Group']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Administrator', true), array('action' => 'edit', $administrator['Administrator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Administrator', true), array('action' => 'delete', $administrator['Administrator']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $administrator['Administrator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Administrators', true), array('action' => 'index')); ?> </li>
	
	</ul>
</div>
<div class="related">
	<h3><?php __('Related News');?></h3>
	<?php if (!empty($administrator['News'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Text'); ?></th>
		<th><?php __('Date'); ?></th>
		<th><?php __('Administrator Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($administrator['News'] as $news):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $news['id'];?></td>
			<td><?php echo $news['title'];?></td>
			<td><?php echo $news['text'];?></td>
			<td><?php echo $news['date'];?></td>
			<td><?php echo $news['administrator_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'news', 'action' => 'view', $news['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'news', 'action' => 'edit', $news['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'news', 'action' => 'delete', $news['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
