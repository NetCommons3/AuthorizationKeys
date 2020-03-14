<?php
/**
 * AuthorizationKey Behavior
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * AuthorizationKeyBehavior Behavior
 *
 * 認証キー情報を登録、取得します。<br>
 * モデル名、コンテンツID、認証キーをAuthorizationKeyモデルに登録します。<br>
 * 削除時も該当する認証キーデータを削除します。<br>
 *
 * #### サンプルコード
 * ```
 * public $actsAs = array(
 *	'AuthorizationKeys.AuthorizationKey'
 * );
 * ```
 *
 * @author AllCreator <info@allcreator.net>
 * @package  NetCommons\AuthorizationKey\Model\Befavior
 */
class AuthorizationKeyBehavior extends ModelBehavior {

/**
 * @var array 設定
 */
	public $settings;

/**
 * @var null 削除予定の元モデルのデータ
 */
	protected $_deleteTargetData = null;

/**
 * 認証キーモデルを返す
 *
 * @return AuthorizationKey
 */
	protected function _getModel() {
		$model = ClassRegistry::init('AuthorizationKeys.AuthorizationKey');
		return $model;
	}

/**
 * setup
 *
 * @param Model $Model モデル
 * @param array $settings 設定値
 * @return void
 */
	public function setup(Model $Model, $settings = array()) {
		$this->settings[$Model->alias] = $settings;
	}

/**
 * 認証キー保存処理
 *
 * @param Model $Model モデル
 * @param bool $created 新規作成
 * @param array $options options
 * @throws InternalErrorException
 * @return void
 */
	public function afterSave(Model $Model, $created, $options = array()) {
		//$contentId = $Model->data[$Model->alias]['id'];
		//$contentId = $Model->getLastInsertID();
		$contentId = $Model->id;
		if (isset($Model->data['AuthorizationKey']) &&
			! empty($Model->data['AuthorizationKey']['authorization_key'])) {
			$AuthorizationKey = $this->_getModel();
			if (! $AuthorizationKey->saveAuthorizationKey(
				$Model->alias,
				$contentId,
				$Model->data['AuthorizationKey']['authorization_key'])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		} else {
			// フィールドを特定しての部分更新じゃないのに認証キーフィールドが設定ないなら、削除
			if (! isset($options['fieldList']) || empty($options['fieldList'])) {
				$AuthorizationKey = $this->_getModel();
				$AuthorizationKey->cleanup($Model, $contentId);
			}
		}
	}

/**
 * 認証キー情報をFind結果にまぜる
 *
 * @param Model $Model モデル
 * @param mixed $results Find結果
 * @param bool $primary primary
 * @return array $results
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function afterFind(Model $Model, $results, $primary = false) {
		foreach ($results as $key => $target) {
			if (isset($target[$Model->alias]['id'])) {
				$AuthorizationKey = $this->_getModel();
				$authKey = $AuthorizationKey->getAuthorizationKeyByContentId(
					$Model->alias, $target[$Model->alias]['id']);
				if ($authKey) {
					$target['AuthorizationKey'] = $authKey['AuthorizationKey'];
				}
				$results[$key] = $target;
			}
		}
		return $results;
	}

/**
 * afterDeleteで使いたいので削除前に削除対象のデータを保持しておく
 *
 * @param Model $Model 認証キーを使ってるモデル
 * @param bool $cascade cascade
 * @return bool
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function beforeDelete(Model $Model, $cascade = true) {
		if ($cascade) {
			$this->_deleteTargetData = $Model->findById($Model->id);
		}
		return true;
	}

/**
 * 削除されたデータに関連する認証キーデータのクリーンアップ
 *
 * @param Model $Model 認証キーを使ってるモデル
 * @return void
 */
	public function afterDelete(Model $Model) {
		if (isset($this->_deleteTargetData[$Model->alias]['id'])) {
			$contentId = $this->_deleteTargetData[$Model->alias]['id'];
		} else {
			$contentId = null;
		}
		$AuthorizationKey = $this->_getModel();
		$AuthorizationKey->cleanup($Model, $contentId);
	}

}