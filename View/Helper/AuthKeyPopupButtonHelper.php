<?php
/**
 * PopupButtonHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Authorization key poup button Helper
 *
 * @package NetCommons\AuthorizationKeys\View\Helper
 */
class AuthKeyPopupButtonHelper extends AppHelper {

/**
 * 概要
 *
 * ダウンロードパスワードを求めるなど
 * なんらかのアクション実行前にどうしてもキーとなるワードの入力を求めたいときに
 * 表示するキーワード入力専用POPUPを出せるボタンを提供します
 *
 * 利用方法
 * 通常のHelper利用と同様です AuthorizationKeys.AuthKeyPopupButtonをHelperとして組み込んでください。
 * Viewでは、popupButtonメソッドを呼び出します。
 * popupButtonでは最低限、以下の要素をオプション配列の形式で引数として与える必要があります。
 * url: キーワード入力後に遷移する先のURL
 *
 * 必要に応じて以下の指定をすることができます
 * icon: ボタンに表示するアイコン(default:glyphicon-download)
 * btn-label: ボタンに表示するラベル(default:なし)
 * class: ボタンのclass(default:btn btn-success)
 * popup-title: POPUPダイアログに表示するタイトル(default:__d('authorization_keys', 'Authorization key confirm dialog')
 * popup-label: POPUPダイアログに表示する入力エリアラベル(default:__d('authorization_keys', 'Authorization key')
 * popup-placeholder: POPUPダイアログに表示するplaceholder(default:__d('authorization_keys', 'Please input authorization key')
 *
 * #### サンプルコード
 * ```
 * 	public $helpers = array(
 *     'AuthorizationKeys.AuthKeyPopupButton',
 *  );
 * <?php echo $this->AuthKeyPopupButton->popupButton(array(
 *          'url' => NetCommonsUrl::actionUrl(.......),
 * 			'popup-label' => __d('questionnaires', 'Title'),
 *          'popup-title' => __d('questionnaires', 'Download password'),
 *   ));?>
 * ```
 */
/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommonsForm',
		'NetCommonsHtml',
		'Form',
		'Html'
	);

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->script('/authorization_keys/js/authorization_keys.js');
		parent::beforeRender($viewFile);
	}

/**
 * Get button for popup dialog
 *
 * @param array $options option for input
 * @return string button tag
 */
	public function popupButton($options) {
		$defaults = array(
			'class' => 'btn btn-success',
			'icon' => 'glyphicon-download',
			'label' => '',
			'popup-title' => __d('authorization_keys', 'Authorization key confirm dialog'),
			'popup-label' => __d('authorization_keys', 'Authorization key'),
			'popup-placeholder' => __d('authorization_keys', 'Please input authorization key')
		);
		$options = Hash::merge($defaults, $options);
		if (! empty($options['icon'])) {
			$icon = '<span class="glyphicon ' . $options['icon'] . '" ></span>';
		} else {
			$icon = '';
		}
		$html = '<a  authorization-keys-popup-link frame-id="' . Current::read('Frame.id') . '" ' .
			'class="' . $options['class'] . '" ' .
			'url="' . $options['url'] . '" ' .
			'popup-title="' . $options['popup-title'] . '" ' .
			'popup-label="' . $options['popup-label'] . '" ' .
			'popup-placeholder="' . $options['popup-placeholder'] . '">' .
			$icon .
			$options['label'] .
			'</a>';
		return $html;
	}
}
