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
		'model' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'authorization_key' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
 * @throws Exception
 */
	public function saveAuthorizationKey($modelName, $contentId, $key, $additionalId = null) {
		try {
			$this->begin();
			$data = $this->create();
			$data['AuthorizationKey']['content_id'] = $contentId;
			$data['AuthorizationKey']['model'] = $modelName;
			$data['AuthorizationKey']['authorization_key'] = $key;
			$data['AuthorizationKey']['additional_id'] = $additionalId;
			if (! $this->save($data)) {
				$this->rollback();
				return false;
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
 */
	public function cleanup(Model $Model, $contentId) {
		$modelName = $Model->alias;
		$this->deleteAll(array('model' => $modelName, 'content_id' => $contentId), false);
	}

}
