<div id = "newsForm" class="news form">
<?php echo $this->Form->create('News');?>
	<fieldset>
 		<legend><?php __('Add News'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('text',array('type'=>'textarea'));
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List News', true), array('action' => 'index'));?></li>
	</ul>
</div>