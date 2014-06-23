<?php
App::uses('AppController', 'Controller');
/**
 * Dates Controller
 *
 * @property Action $Action
 */
class DatesController extends AppController {

    public $uses = array('Date', 'User');

    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function history($username = NULL) {
            $this->Date->recursive = 0;
            if($this->Auth->user('type') === 'admin'){
                $conditions = array();
            }
            // Preparing the condition query according to search and filter of URL
            if($this->request->data){
                $this->redirect(array('action'=>'history',$this->request->data('User.SearchUsername')));
            }
            else if($username != null){
                $username = base64_decode($username);
                array_push($conditions, array('User.username LIKE' => '%'.h($username).'%') );
            }
            $this->paginate = array(
                "order" => "Date.time DESC",
                "conditions" => $conditions
            );
            $this->set(
                'dates', 
                $this->paginate()
            );       
    }

    /**
     * Edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
            if (!$this->Date->exists($id)) {
                    throw new NotFoundException(__('Invalid action'));
            }
            if ($this->request->is('post') || $this->request->is('put')) {
                    if ($this->Date->save($this->request->data)) {
                            $this->Session->setFlash(__('The date has been saved'),'flash/success');
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The date could not be saved. Please, try again.'),'flash/error');
                    }
            } else {
                    $options = array('conditions' => array('Date.' . $this->Date->primaryKey => $id));
                    $this->request->data = $this->Date->find('first', $options);
            }
    }

    /**
     * Delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
            $this->Date->id = $id;
            if (!$this->Date->exists()) {
                    throw new NotFoundException(__('Invalid action'));
            }
            $this->request->onlyAllow('post', 'delete');
            if ($this->Date->delete()) {
                    $this->Session->setFlash(__('Date deleted'),'flash/success');
                    $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Date was not deleted'),'flash/error');
            $this->redirect(array('action' => 'index'));
    }
    
}
