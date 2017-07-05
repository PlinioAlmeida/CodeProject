/**
 * Created by Administrador on 01/07/17.
 */
angular.module('app.services')
.service('Client',['$resource','appConfig',function($resource,appConfig){
    return $resource(appConfig.baseUrl+'/client/:id',{id:'@id'})
}]);