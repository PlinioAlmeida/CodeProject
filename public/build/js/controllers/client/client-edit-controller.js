/**
 * Created by Administrador on 05/07/17.
 */
angular.module('app.controllers')
    .controller('ClientEditController',
        ['$scope', '$location', '$routeParams', 'Client',
            function ($scope, $location, $routeParams, Client) {

                $scope.client = Client.get({id: $routeParams.id });

                $scope.save = function () {
                    if($scope.form.$valid){
                        Client.update({id: $scope.client.id}, $scope.client, function () {
                            $location.path('/clients');
                        },function(error){
                            if(error.data.hasOwnProperty('error') && error.data.error){
                                $scope.error = {
                                    error: true,
                                    message: error.data.message
                                };
                            }
                        });
                    }
                };
            }]);
