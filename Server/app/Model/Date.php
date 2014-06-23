<?php
App::uses('AppModel', 'Model');

/**
 * Date Model
 *
 * @property Unit $Unit
 */
class Date extends AppModel {

        /**
         * Display field
         *
         * @var string
         */
	public $displayField = 'time';

        /**
        * belongsTo associations
        *
        * @var array
        */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
}