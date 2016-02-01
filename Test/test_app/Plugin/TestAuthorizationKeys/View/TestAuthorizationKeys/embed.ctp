embed_view_ctp
<?php
echo $this->NetCommonsForm->create();
echo $this->element('AuthorizationKeys.authorization_key');
echo $this->NetCommonsForm->end();
