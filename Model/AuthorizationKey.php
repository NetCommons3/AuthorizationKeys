<?php
/**
 *  AuthorizationKey Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AuthorizationKeysAppModel', 'AuthorizationKeys.Model');

/**
 * Summary for AuthorizationKey Model
 */
class AuthorizationKey extends AuthorizationKeysAppModel {

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function beforeValidate($options = array()) {
		$this->validate = ValidateMerge::merge($this->validate, array(
			'model' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'content_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'authorization_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'allowEmpty' => true,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		));
	}
/**
 * コンテンツIDと関連づく認証キーを返す
 *
 * @param string $modelName モデル名
 * @param int $contentId コンテンツID
 * @param string $additionalId 付加ID
 * @return array タグ
 */
	public function getAuthorizationKeyByContentId($modelName, $contentId, $additionalId = null) {
		$conditions = array(
			'AuthorizationKey.model' => $modelName,
			'AuthorizationKey.content_id' => $contentId,
			'AuthorizationKey.additional_id' => $additionalId,
		);
		$options = array(
			'conditions' => $conditions,
		);
		$key = $this->find('first', $options);
		if (empty($key)) {
			return false;
		}
		return $key;
	}

/**
 * 認証キーの保存
 *
 * @param string $modelName 使用モデルのモデル名
 * @param int $contentId 関連づくコンテンツのID
 * @param string $key 認証キー
 * @param string $additionalId 付加情報ID
 * @return bool
 * @throws InternalErrorException
 */
	public function saveAuthorizationKey($modelName, $contentId, $key, $additionalId = null) {
		try {
			$this->begin();
			$original = $this->getAuthorizationKeyByContentId($modelName, $contentId, $additionalId);
			$data = $this->create();
			if ($original) {
				$data['AuthorizationKey']['id'] = $original['AuthorizationKey']['id'];
			}
			$data['AuthorizationKey']['content_id'] = $contentId;
			$data['AuthorizationKey']['model'] = $modelName;
			$data['AuthorizationKey']['authorization_key'] = $key;
			$data['AuthorizationKey']['additional_id'] = $additionalId;

			//バリデーション
			$this->set($data);
			if (!$this->validates()) {
				return false;
			}

			if (! $this->save($data, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$this->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback();
			//エラー出力
			CakeLog::error($ex);
			throw $ex;
		}
		return true;
	}
/**
 * 認証キーの削除
 *
 * @param Model $Model 認証キー使用モデル
 * @param int $contentId コンテンツID
 * @return void
 * @throws InternalErrorException
 */
	public function cleanup(Model $Model, $contentId) {
		$modelName = $Model->alias;
		//トランザクションBegin
		$this->begin();
		try {
			if (! $this->deleteAll(array('model' => $modelName, 'content_id' => $contentId), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			//トランザクションCommit
			$this->commit();
		} catch (Exception $ex) {
			//トランザクションRollback
			$this->rollback($ex);
		}

		return true;
	}

}
