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
 * popup型 チェック用URL
 * @see https://github.com/researchmap/RmNetCommons3/issues/2347
 *
 * @var array
 */
	const POPUP_VALIDATE_URLS = [
		'/cabinets/cabinet_files/download/',
		'/multidatabases/multidatabase_contents/download/',
		'/videos/videos/download/',
	];

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
		if (isset($this->params['key'])) {
			$hashKey = $this->params['key'];
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
		$url = $this->__cleansingUrl($url);
		$this->set('url', $url);
	}

/**
 * popup型 URLチェック
 * @see https://github.com/researchmap/RmNetCommons3/issues/2347
 *
 * @param string $url 指定URL
 * @return string クレンジング後のURL エラーの場合、TopページのURLを返す
 */
	private function __cleansingUrl($url): string {
		$valid = false;
		foreach (self::POPUP_VALIDATE_URLS as $validateUrl) {
			if (preg_match('/^' . preg_quote($validateUrl, '/') . '/i', $url)) {
				$parseUrls = explode('?', $url);
				if (isset($parseUrls[1])) {
					// queryサニタイズ
					$query = str_replace('&amp;', '&', h($parseUrls[1]));
					$url = $parseUrls[0] . '?' . $query;
					$valid = true;
					break;
				}
			}
		}
		if (!$valid) {
			// TopページのURLを返す
			return Configure::read('App.fullBaseUrl');
		}
		return $url;
	}
}
