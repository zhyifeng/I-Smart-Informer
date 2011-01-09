<?php
class GroupTypesController extends AppController {

	var $name = 'GroupTypes';

	function index() {
		$this->GroupType->recursive = 0;
		$this->set('groupTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid group type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('groupType', $this->GroupType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->GroupType->create();
			if ($this->GroupType->save($this->data)) {
				$this->Session->setFlash(__('The group type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group type could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id || empty($this->data)) {
			$this->Session->setFlash(__('Invalid group type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->GroupType->save($this->data)) {
				$this->Session->setFlash(__('The group type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GroupType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for group type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GroupType->delete($id)) {
			$this->Session->setFlash(__('Group type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Group type was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>