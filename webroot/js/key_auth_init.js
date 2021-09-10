/**
 * Created by AllCreator on 2015/11/06.
 */


/**
 * LikeSettings Controller Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('AuthorizationKey',
    ['$scope', '$http', 'NC3_URL', function($scope, $http, NC3_URL) {

      /**
       * initialize
       *
       * @return {void}
       */
      $scope.initialize = function(url) {
        $http.get(NC3_URL + url);
      };
    }]);
