/**
 * Created by Administrador on 30/06/17.
 */
angular.module('app.controllers')
    .controller('HomeController',['$scope','$cookies',function($scope,$cookies){
        console.log($cookies.getObject('user').email);
        console.log($cookies.getObject('user').name);
        console.log($cookies.getObject('user').id);
}]);