<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Territoires Controller
 *
 * @property Territoire $Territoire
 */
class TerritoiresController extends AppController {

    public $components = array('Paginator');

    public $uses = array('Territoire');
    
    public function beforeFilter()
    {
        $this->Auth->allow('liste');
    }

    public function isAuthorized($user) {
        if(in_array($this->action, array('index', 'add', 'edit', 'delete'))){
            if($this->Auth->user('type') != 'admin')
                return false;
        }
        return true;
    }

    /**
     * List users
     *
     * @return void
     */
    public function index() {
        $this->Territoire->recursive = 0;
        $this->set('terittoires', $this->Paginator->paginate());
    }

    /**
     * Add a user
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Territoire->create();
            if ($this->Territoire->save($this->request->data)) {
                $this->Session->setFlash(__('The territoire has been saved'),'flash/success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The territoire could not be saved. Please, try again.'),'flash/error');
            }
        }
    }

    /**
     * Edit a user
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Territoire->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post')) {
            if ($this->Territoire->save($this->request->data)) {
                $this->Session->setFlash(__('The territoire has been saved'),'flash/success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The territoire could not be saved. Please, try again.'),'flash/error');
            }
        } else {
            $options = array('recuresive' => 0,'conditions' => array('User.' . $this->Territoire->primaryKey => $id));
            $this->request->data = $this->Territoire->find('first', $options);
        }
    }

    /**
     * Delete a user
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Territoire->id = $id;
        if (!$this->Territoire->exists()) {
            throw new NotFoundException(__('Invalid territoire'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Territoire->delete()) {
            $this->Session->setFlash(__('Territoire deleted'),'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Territoire was not deleted'),'flash/error');
        $this->redirect(array('action' => 'index'));
    }
    
    /**
     * Webserice part
     */
    
    /**
     *   status = 0 // Failed
     *   status = 1 // Success
     *   status = 2 // Wrong call
     *   status = 3 // Inactive account
     *   status = 4 // Unknown user
     */
    public function liste() {
        $return = array();
        $return['status'] = 2;

        // Retrieving user
        $territoire = $this->Territoire->find('all');

        if($territoire)
        {
            $return['status'] = 1;
            $return['Territoire'] = $territoire;
        }
        else
        {
            $return['status'] = 4; 
        }
        
        return new CakeResponse(array('body'=>json_encode($return)));
    }
    
}
