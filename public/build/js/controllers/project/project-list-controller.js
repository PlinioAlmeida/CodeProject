/**
 * Created by Administrador on 07/07/17.
 */
angular.module('app.controllers')
    .controller('ProjectListController',['$scope','Project',function($scope,Project){
        $scope.projects = Project.query();
    }]);