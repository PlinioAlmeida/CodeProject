/**
 * Created by Administrador on 05/07/17.
 */
angular.module('app.controllers')
    .controller('ProjectNoteRemoveController',
        ['$scope', '$location', '$routeParams', 'ProjectNote',
            function ($scope, $location, $routeParams, ProjectNote) {

                $scope.projectNote = ProjectNote.get({
                    id: $routeParams.id,
                    idNote: $routeParams.idNote
                });

                $scope.remove = function () {
                    $scope.projectNote.$delete({
                        id: $routeParams.id,
                        idNote: $scope.projectNote.id
                    }).then(function(){
                        $location.path('/project/'+$routeParams.id+'/notes');
                    }, function (error) {
                        if(error.data.hasOwnProperty('error') && error.data.error){
                            $scope.error = {
                                error: true,
                                message: error.data.message
                            };
                        }
                    });
                };

            }]);
