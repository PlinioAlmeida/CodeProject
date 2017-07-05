/**
 * Created by Administrador on 05/07/17.
 */
angular.module('app.controllers')
    .controller('ProjectNoteNewController',
        ['$scope', '$location', '$routeParams', 'ProjectNote',
            function ($scope, $location, $routeParams, ProjectNote) {

                $scope.projectNote = new ProjectNote();
                $scope.projectNote.project_id  = $routeParams.id;

                $scope.save = function () {
                    if($scope.form.$valid){
                        $scope.projectNote.$save({id: $routeParams.id}).then(function () {
                            $location.path('/project/'+$routeParams.id+'/notes');
                        }), function (error) {
                            if(error.data.hasOwnProperty('error') && error.data.error){
                                $scope.error = {
                                    error: true,
                                    message: error.data.message
                                };
                            }
                        };
                    }
                };

            }
        ]);

