/**
 * Created by Administrador on 01/07/17.
 */
angular.module('app.controllers')
    .controller('ClientListController',['$scope','Client',function($scope,Client){
        $scope.clients = Client.query();
    }]);