/**
 * Created by AllCreator on 2015/11/06.
 */
var AuthorizationKeys = angular.module('AuthorizationKeys', []);

AuthorizationKeys.directive('authorizationKeysPopupLink', ['$modal', function($modal) {
    return {
        scope: {
            url: '@',
            frameId: '@'
        },
        restrict: 'A',
        link: function(scope, element, attr, controller) {
            var Popup = function(event) {
                scope.modalInstance = $modal.open({
                    animation: true,
                    templateUrl: '/authorization_keys/authorization_keys/popup/?frame_id=' + scope.frameId + '&url=' + scope.url + Math.random().toString(36).slice(2),
                    controller: 'authorizationKeyPopupCtrl',
                    resolve: {
                        url: function () {
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

NetCommonsApp.controller('authorizationKeyPopupCtrl', function ($scope, $modalInstance, url) {
    $scope.url = url;
    $scope.submit = function() {
        $modalInstance.dismiss('submit');
    };
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
});