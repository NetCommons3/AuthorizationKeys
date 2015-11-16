<?php
/**
 * AuthorizationKey Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('Component', 'Controller');

/**
 * AuthorizationKey Component
 *
 * キー認証画面へのリダイレクト、認証処理を行います。<br>
 * 利用方式、対象アクション、認証要素key名称を指定してください。
 *
 * [利用方式](#operationtype)<br>
 * [対象アクション](#operationtype)
 *
 * @author AllCreator <info@allcreator.net>
 * @package NetCommons\AuthorizationKey\Controller\Component
 */
class AuthorizationKeyComponent extends Component {

/**
 * Other components utilized by AuthComponent
 *
 * @var array
 */
	public $components = array('Session', 'Flash', 'RequestHandler', 'NetCommons.NetCommons');

/**
 * captcha operation type
 *
 * @var string
 */
	const OPERATION_REDIRECT = 'redirect';
	const OPERATION_EMBEDDING = 'embedding';
	const OPERATION_POPUP = 'popup';
	const OPERATION_NONE = 'none';

/**
 * 利用方式
 *
 * * OPERATION_REDIRECT<br>
 * 切り替わり方式<br>
 * 認証が必要な画面を表示する前に、キー認証画面が自動的に表示される方式です。<br>
 * キー認証に成功した後、認証が必要な画面を表示します。<br>
 * この場合、キー認証画面、認証Postを当プラグインが処理するため、、
 * 利用プラグインは、AuthorizationKeyを設定するのみです。<br>
 * 対象アクション名も指定してください。
 *
 * #### サンプルコード
 * ```
 * public $components = array(
 * 	'AuthorizationKeys.AuthorizationKey' => array(
 * 		'operationType' => AuthorizationKeyComponent::OPERATION_REDIRECT,
 * 		'targetAction' => 'answer'
 * 	)
 * )
 * ```
 *
 * * OPERATION_EMBEDDING<br>
 * 埋め込み方式(デフォルト)<br>
 * 認証が必要な画面に、キー認証パーツを埋め込む方式です。<br>
 * 切り替わり方式だと画像認証画面だけが表示されることになるが、埋め込み方式は認証が必要な画面の任意の場所に埋め込めます。<br>
 * この場合は、AuthorizationKeyComponentを設定、viewファイルへのedit_form.ctpの埋め込み、
 * 正しい回答がされたかのチェックを行う必要があります。<br>
 *
 * #### サンプルコード
 * ##### Controller
 * ```
 * public $components = array(
 * 	'AuthorizationKeys.AuthorizationKey' => array(
 * 		'operationType' => AuthorizationKeyComponent::OPERATION_EMBEDDING
 * 	)
 * )
 * ```
 * ##### View
 * ```
 * <?php
 * 	echo $this->element('AuthorizationKeys.edit_form');
 * ?>
 * ```
 *
 * * OPERATION_POPUP<br>
 * ポップアップ方式<br>
 * 認証が必要なリンクをクリックされた際に、ポップアップでキー認証画面を表示する方式です。<br>
 * キー認証に成功した後、リンク先を表示します。<br>
 * この場合、キー認証画面、認証Postを当プラグインが処理するため、、
 * 利用プラグインは、AuthorizationKeyComponentを設定するのみです。<br>
 * 対象アクション名も指定してください。
 *
 * #### サンプルコード
 * ```
 * public $components = array(
 * 	'AuthorizationKeys.AuthorizationKey' => array(
 * 		'operationType' => AuthorizationKeyComponent::OPERATION_POPUP,
 * 		'targetAction' => 'answer'
 * 	)
 * )
 * ```
 *
 * @var string
 */
	public $operationType = AuthorizationKeyComponent::OPERATION_EMBEDDING;

/**
 * call controller w/ associations
 *
 * @var object
 */
	public $controller = null;

/**
 * authorization key redirect target controller action
 *
 * @var string
 */
	public $targetAction = null;

/**
 * authorization key target model name
 *
 * @var string
 */
	public $model = null;

/**
 * authorization key target content id
 *
 * @var int
 */
	public $contentId = null;

/**
 * authorization key target additional id
 *
 * @var string
 */
	public $additionalId = null;

/**
 * 切り替えタイプのときの切り替え先画面のURLデフォルト値
 * デフォルトの認証キー画面では困る場合はこの構造データを変更してください
 *
 * @var array
 */
	public $AuthorizeKeyAction = array(
		'plugin' => 'authorization_keys',
		'controller' => 'authorization_keys',
		'action' => 'view',
	);

/**
 * 認証後戻るURL
 * 切り替え型の時しか使わない
 * 切り替え型で、認証キー成功時戻る先のURL
 *
 * @var array
 */
	public $returnUrl = array();

/**
 * 切り替え方式、埋め込み方式の場合
 * キー入力画面を表示する前のタイミングでセッションに取り扱い認証キー情報を書き込む
 * その書き込むときのセッションキー情報
 *
 * @var string
 */
	protected $_hashKey = '';

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Controller with components to initialize
 * @return void
 * @link http://book.cakephp.org/2.0/en/controllers/components.html#Component::initialize
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->AuthorizationKey = ClassRegistry::init('AuthorizationKeys.AuthorizationKey', true);
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
		// 何もしないでと指示されている場合
		if ($this->operationType == AuthorizationKeyComponent::OPERATION_NONE) {
			// すぐ戻る
			return;
		}

		// 切り替え、埋め込みの場合は認証キー動作が発生するので
		// 指定されているModel、IDに該当する認証キー情報を取得しておく
		//
		if ($controller->request->isGet()) {
			// もしかしたら空データかもしれないが、ここではチェックしない
			// 後程入力された認証キーとの一致を調べるときに空データの場合は絶対一致しなくなって
			// 決して解除されないガードとなる
			//
			// 後から利用となるのでセッションに記録
			//$this->_hashKey = Security::hash($controller->name . mt_rand() . microtime(), 'md5');
			$this->_hashKey = Security::hash($this->model . $this->contentId . $this->additionalId, 'md5');
			$controller->Session->write(
				'AuthorizationKey.currentAuthorizationKey.' . $this->_hashKey,
				$this->AuthorizationKey->getAuthorizationKeyByContentId($this->model, $this->contentId, $this->additionalId));

			// Controllerにキーを探し出すためのハッシュキーを覚えておいてもらう
			// 実際の認証キーinputを生成するときに、この値がhiddenで埋め込まれる
			$controller->request->data['AuthorizationKey']['authorization_hash'] = $this->_hashKey;
		}

		// 埋め込み型の時
		if ($this->operationType == AuthorizationKeyComponent::OPERATION_EMBEDDING) {
			// 埋め込み型のときは判断・処理は利用側のプラグインに移譲するのでここで戻る
			return;
		}
		// 切り替え型のとき
		if ($this->operationType == AuthorizationKeyComponent::OPERATION_REDIRECT) {
			$this->_redirectStartup($controller);
			return;
		}
		// POPUP型の時
		if ($this->operationType == AuthorizationKeyComponent::OPERATION_POPUP) {
			$this->_popupStartup($controller);
			return;
		}
	}

/**
 * _redirectStartup
 * 認証に成功したあとの戻りURLをセッションに保存して
 * 切り替え型の画面を呼び出す
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 */
	protected function _redirectStartup(Controller $controller) {
		// 戻り先URL準備
		$this->returnUrl = array(
				'plugin' => Inflector::underscore(Current::read('Plugin.key')),
				'controller' => Inflector::underscore($this->controller->name),
				'action' => Inflector::underscore($this->controller->action),
			) + $this->controller->request->query;

		// リダイレクトURL準備
		$this->AuthorizeKeyAction[] = $this->_hashKey;
		$this->AuthorizeKeyAction['frame_id'] = Current::read('Frame.id');
		// リファラが自分自身でないことが必須（無限ループになる
		if ($this->operationType == AuthorizationKeyComponent::OPERATION_REDIRECT
			&& $controller->referer('', true) != NetCommonsUrl::actionUrl($this->AuthorizeKeyAction)
			&& $controller->action == $this->targetAction) {
			// 切り替え後、認証成功時のURLを取り出す
			$returnUrl = $controller->here;
			$controller->Session->write('AuthorizationKey.returnUrl.' . $this->_hashKey, $returnUrl . '?' . http_build_query($this->controller->request->query));
			$controller->redirect(NetCommonsUrl::actionUrl($this->AuthorizeKeyAction));
		}
	}

/**
 * _popupStartup
 * POPUP型の場合はGetアクセスをはじく
 * POSTが来たときは、送信された認証キーとControllerが指定しているmodel, contentId, additionalIdでDBからデータを取り出し
 * マッチするか確認する
 * 一致しない場合は、前の画面を再度呼び出す
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	protected function _popupStartup(Controller $controller) {
		// 現在実行されようとしているActionがガード対象のものであればチェックを走らせる
		if ($controller->action == $this->targetAction) {
			if ($controller->request->isPost() || $controller->request->isPut()) {
				// POPUPのときはここでDBからデータを取り出す
				$authKey = $this->AuthorizationKey->getAuthorizationKeyByContentId($this->model, $this->contentId, $this->additionalId);
				//
				// 入力された認証キーが正しいことを確認する
				$data = $this->controller->request->data;
				if (! isset($data['AuthorizationKey']['authorization_key']) ||
					$authKey['AuthorizationKey']['authorization_key'] !== $data['AuthorizationKey']['authorization_key']) {
					$this->_setErrorMessage();
					$controller->redirect($controller->referer());	// 元に戻す
				}
			} else {
				// POPUP型のガード処理でPOST以外で来ているということはURL強制HACK!
				throw new ForbiddenException(__d('authorization_keys', 'you can not access without entering authorization key.'));	// 許さない
			}
		}
		// それ以外の場合は何もせず通す
		return true;
	}

/**
 * getReturnUrl get return screen url
 *
 * @return string
 */
	public function getReturnUrl() {
		$hashKey = $this->controller->request->data['AuthorizationKey']['authorization_hash'];
		return $this->controller->Session->read('AuthorizationKey.returnUrl.' . $hashKey);
	}

/**
 * check input response
 *
 * @return bool
 */
	public function check() {
		$reqData = $this->controller->request->data;

		$ret = $this->validateKey($reqData);
		if ($ret === false) {
			$this->_setErrorMessage();
		}

		return $ret;
	}

/**
 * check input response
 *
 * @param array $data Hash data for check
 * @return bool
 */
	public function validateKey($data) {
		// ハッシュキーがない　エラー
		if (! isset($data['AuthorizationKey']['authorization_hash'])) {
			return false;
		}
		// ハッシュキー取り出し
		$hashKey = $data['AuthorizationKey']['authorization_hash'];
		// dataの中から認証キーデータを探し
		// そのデータがセッション内容と一致するか確認し
		// OK/NGを返す
		$authorizationKey = $this->controller->Session->read('AuthorizationKey.currentAuthorizationKey.' . $hashKey);

		// セッションに情報がない　エラー
		if (! $authorizationKey) {
			return false;
		}
		// POSTデータに認証キーがない　エラー
		if (! isset($data['AuthorizationKey']['authorization_key'])) {
			return false;
		}

		if ($authorizationKey['AuthorizationKey']['authorization_key'] === $data['AuthorizationKey']['authorization_key']) {
			// FIXME OKになったときは認証キーのセッション情報をクリアすべきかな
			return true;
		} else {
			$this->controller->set('authorizationKeyErrorMessage', __d('authorization_keys', 'answer was NOT valid! Please try again.'));
			return false;
		}
	}

/**
 * set error message
 *
 * @return void
 */
	protected function _setErrorMessage() {
		$this->NetCommons->setFlashNotification(__d('authorization_keys', 'answer was NOT valid! Please try again.'));
		$this->controller->set('authorizationKeyErrorMessage', __d('authorization_keys', 'answer was NOT valid! Please try again.'));
	}
}
