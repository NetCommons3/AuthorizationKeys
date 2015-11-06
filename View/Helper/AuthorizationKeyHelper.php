<?php
/**
 * AuthorizationKey Helper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('NetCommonsFormHelper', 'Plugin/NetCommons/View/Helper');

/**
 * AuthorizationKey Helper
 *
 */
class AuthorizationKeyHelper extends FormHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
    public $helpers = array(
        'NetCommonsForm',
    );
/**
 * AuthorizationKey input field.
 *
 * @return string
 */
    public function authorizationKeyInput() {
        $authKey = '';

        $authKey .= $this->NetCommonsForm->input('AuthorizationKey.authorization_key', array(
            'label' => __d('authorization_keys', 'Authorization key'),
            'placeholder' => __d('authorization_keys', 'Please input authorization key')));

        if (isset($this->_View->viewVars['authorizationKeyErrorMessage'])) {
            $authKey .= '<div class="has-error"><div class="help-block">';
            $authKey .= $this->_View->viewVars['authorizationKeyErrorMessage'];
            $authKey .= '</div></div>';
        }

        $authKey .= $this->NetCommonsForm->hidden('AuthorizationKey.authorization_hash');
        return $authKey;
    }
}
