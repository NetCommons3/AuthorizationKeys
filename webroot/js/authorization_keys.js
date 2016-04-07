/**
 * Created by AllCreator on 2015/11/06.
 */
var AuthorizationKeys = angular.module('AuthorizationKeys', []);

AuthorizationKeys.directive('authorizationKeysPopupLink',
    ['$uibModal', function($uibModal) {
      return {
        scope: {
          url: '@',
          frameId: '@'
        },
        restrict: 'A',
        link: function(scope, element, attr, controller) {
          var Popup = function(event) {
            scope.modalInstance = $uibModal.open({
              animation: true,
              templateUrl:
               '/authorization_keys/authorization_keys/popup/?frame_id=' +
               scope.frameId +
               '&url=' +
               scope.url +
               Math.random().toString(36).slice(2),
              controller: 'authorizationKeyPopupCtrl',
              resolve: {
                url: function() {
                  return scope.url;
                }
              }
            });
          };
          element.bind('click', Popup);
        }
      };
    }]);

NetCommonsApp.requires.push('AuthorizationKeys');

NetCommonsApp.controller('authorizationKeyPopupCtrl',
    function($scope, $uibModalInstance, url) {
      $scope.url = url;
      $scope.submit = function() {
        $uibModalInstance.dismiss('submit');
      };
      $scope.cancel = function() {
        $uibModalInstance.dismiss('cancel');
      };
    });
