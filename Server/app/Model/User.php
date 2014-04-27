<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';
    
    /**
     * Virtual fields
     * 
     * @var array
     */
    public $virtualFields = array(
        
    );
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
            
    );
    
    /**
     * Before save action 
     * @param type $options
     * @return boolean
     */
    public function beforeSave($options = array()) {
            if (isset($this->data['User']['active']) && $this->data['User']['active'] == 1 && isset($this->data['User']['password'])) {
                    $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
            }
            return true;
    }
    
}
