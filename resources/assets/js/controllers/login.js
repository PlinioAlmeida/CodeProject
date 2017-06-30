/**
 * Created by Administrador on 30/06/17.
 */
angular.module('app.controllers')
    .controller('LoginController',['$scope',function($scope){
    $scope.user = {
        username: '',
        password: ''
    };

    $scope.login = function() {

    };

}]);