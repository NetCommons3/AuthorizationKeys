<?php
/**
 * AuthorizationKey Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * AuthorizationKeyController
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKeys\Controller
 */
class AuthorizationKeysController extends AuthorizationKeysAppController {

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'AuthorizationKeys.AuthorizationKey' => array(
			'operationType' => 'none',
		),
		'Security',
	);

/**
 * use helpers
 *
 */
	public $helpers = [
		'NetCommons.Token',
	];

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('view', 'popup');

		if ($this->action == 'view') {
			$this->PageLayout = $this->Components->load('Pages.PageLayout');
		}
		if ($this->RequestHandler->accepts('json')) {
			$this->viewClass = '';
			$this->layout = true;
		}
	}
/**
 * view method
 * Display the AuthorizationKey auto redirect screen
 *
 * @return void
 */
	public function view() {
		if ($this->request->is('post')) {
			if ($this->AuthorizationKey->check()) {
				$this->redirect($this->AuthorizationKey->getReturnUrl());
			}
		}
		if (isset($this->params['pass'][1])) {
			$hashKey = $this->params['pass'][1];
		} else {
			$this->setAction('throwBadRequest');
			return;
		}
		$this->request->data['Frame'] = Current::read('Frame');
		$this->request->data['Block'] = Current::read('Block');
		$this->request->data['AuthorizationKey']['authorization_hash'] = $hashKey;
	}
/**
 * popup method
 * Display the AuthorizationKey popup screen
 *
 * @return void
 */
	public function popup() {
		if (! isset($this->request->query['url'])) {
			$this->setAction('throwBadRequest');
			return;
		}
		$url = $this->request->query['url'];
		$this->set('url', $url);
	}
}
