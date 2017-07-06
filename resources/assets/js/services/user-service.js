/**
 * Created by Administrador on 06/07/17.
 */
angular.module('app.services')
    .service('User', ['$resource', 'appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/user', {},{
            authenticated: {
                url: appConfig.baseUrl + '/user/authenticated',
                method: 'GET'
            }
        });
    }]);
