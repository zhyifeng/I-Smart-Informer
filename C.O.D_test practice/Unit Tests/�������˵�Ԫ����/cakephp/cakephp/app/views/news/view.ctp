<div class="news view">
<h2><?php  __('News');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $news['News']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $news['News']['text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $news['News']['date']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit News', true), array('action' => 'edit', $news['News']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete News', true), array('action' => 'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List News', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New News', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
