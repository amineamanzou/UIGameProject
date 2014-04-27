<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $components = array('Paginator');

    public $uses = array('User');
    
    public function beforeFilter()
    {
        $this->Auth->allow('add','signin', 'signout', 'signup', 'activate');
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
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * Add a user
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'),'flash/success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'flash/error');
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
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'),'flash/success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'flash/error');
            }
        } else {
            $options = array('recuresive' => 0,'conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
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
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'),'flash/success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'),'flash/error');
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Authentificate a user to the admin
     */
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if($this->Auth->user('type') != 'player'){
                    $this->User->id = $this->Auth->user('id');
                    $this->User->save();
                    if($this->Auth->user('type') == 'admin'){
                        $this->redirect($this->Auth->redirect());
                    }
                    else {
                        ; // Default section for statistics
                    }
                }
                else {
                    $this->Auth->logout();
                    $this->Session->setFlash(__('Vous n\'avez pas la permission d\'accéder à la section administration.'),'flash/error');
                }
            } else {
                $this->Session->setFlash(__('Nom d\'utilisateur ou Mot de passe invalide.'),'flash/error');
            }
        }
    }

    /**
     * Logout a user from the admin
     */
    public function logout() {
        $this->User->id = $this->Auth->user('id');
        $this->User->set('sessionActive', 0);
        $this->User->save();
        $this->redirect($this->Auth->logout());
    }
    
    /**
     * Activate a user with a ajax call from the admin
     */
     public function userActivation($id) {
        $this->autoRender = false;
        $this->autoLayout = false;
        if($this->RequestHandler->isAjax()){
            $return = array();
            $user = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            if($user) {
                $this->User->id = $id;
                if($user['User']['active'] == 1){
                    $this->User->set('active', 0);
                }
                else {
                    $this->User->set('active', 1);
                }
                if($this->User->save()) {
                    $return['Success'] = true;
                    $return['Message'] = "Utilisateur mis à jour.";
                    $status = 200;
                }
                else {
                    $return['Success'] = false;
                    $return['Message'] = "Erreur lors de la sauvegarde.";
                    $status = 500;
                }
            }
            else {
                $return['Success'] = false;
                $return['Message'] = "L'utilisateur n'existe pas.";
                $status = 500;
            }
            
        }
    }
    
    /**
     * Webserice part
     */
    
    /**
     *   status = 0 // failed
     *   status = 1 // success
     *   status = 2 // wrong call
     *   status = 3 // account not activated
     *   status = 4 // user unknown
     */
    public function signin()
    {
        
    }
    
    /**
     *   status = 0 // failed
     *   status = 1 // success
     *   status = 2 // wrong call
     *   status = 3 // account not activated
     *   status = 4 // user unknown
     */
    public function signout()
    {
        
    }
    
    /**
     *   status = 0 // failed;
     *   status = 1 // success;
     *   status = 2 // bad call;
     *   status = 3 // account already created
     */
    public function signup()
    {
        
    }
    
    /**
     * activation method
     *
     * @return void
     */
    public function activate()
    {
        $result = false;
        
        $id = $this->request['pass'][0];
        $hash = $this->request['pass'][1];
        
        $user = $this->User->find('first', array('conditions'=>array('User.id'=>$id)));
        if($user && $user['User']['password'] == $hash)
        {
            $this->User->id = $id;
            $this->User->set('active', 1);
            if($this->User->save())
            {
                $result = true;
            }
        }
        
        $this->layout = 'activate';
        $this->set('result', $result);
    }
   
}
