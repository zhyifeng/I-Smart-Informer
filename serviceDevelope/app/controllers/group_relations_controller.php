<?php
class GroupRelationsController extends AppController {

	var $name = 'GroupRelations';

	function index() {
		$this->GroupRelation->recursive = 1;
		$this->set('groupRelations', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid group relation', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('groupRelation', $this->GroupRelation->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->GroupRelation->create();
			if ($this->GroupRelation->save($this->data)) {
				$this->Session->setFlash(__('The group relation has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group relation could not be saved. Please, try again.', true));
			}
		}
		$groupOwners = $this->GroupRelation->GroupOwner->find('list');
		$groupOwneds = $this->GroupRelation->GroupOwned->find('list');
		$this->set(compact('groupOwners', 'groupOwneds'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid group relation', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->GroupRelation->save($this->data)) {
				$this->Session->setFlash(__('The group relation has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group relation could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GroupRelation->read(null, $id);
		}
		$groupOwners = $this->GroupRelation->GroupOwner->find('list');
		$groupOwneds = $this->GroupRelation->GroupOwned->find('list');
		$this->set(compact('groupOwners', 'groupOwneds'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for group relation', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GroupRelation->delete($id)) {
			$this->Session->setFlash(__('Group relation deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Group relation was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>