<?php
/**
 * AuthorizationKeysFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Summary for AuthorizationKeysFixture
 */
class AuthorizationKeysFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'model' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'content_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'additional_id' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'authorization_key' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '作成者'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '作成日時'),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => '更新者'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '更新日時'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_authorization_key_model1_idx' => array('column' => 'model', 'unique' => 0),
			'fk_authorization_key_content1_idx' => array('column' => 'content_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'model' => 'test',
			'content_id' => 1,
			'additional_id' => null,
			'authorization_key' => 'test_key'
		),
		array(
			'id' => 2,
			'model' => 'test',
			'content_id' => 2,
			'additional_id' => 'a',
			'authorization_key' => 'test_key_2'
		),
		array(
			'id' => 3,
			'model' => 'test',
			'content_id' => 2,
			'additional_id' => 'b',
			'authorization_key' => 'test_key_b'
		),
		array(
			'id' => 4,
			'model' => 'AuthorizationKey',
			'content_id' => 1,
			'additional_id' => 'a',
			'authorization_key' => 'test_key_authorization_a'
		),
		array(
			'id' => 5,
			'model' => 'AuthorizationKey',
			'content_id' => 1,
			'additional_id' => 'b',
			'authorization_key' => 'test_key_authorization_b'
		),
		array(
			'id' => 6,
			'model' => 'TestAuthorizationKeyModel',
			'content_id' => 1,
			'additional_id' => null,
			'authorization_key' => 'test_key_authorization_fake_model'
		)
	);
}
