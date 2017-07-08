/**
 * Created by Administrador on 30/06/17.
 */
var app = angular.module('app',[
    'ngRoute',
    'angular-oauth2',
    'app.controllers',
    'app.filters',
    'app.directives',
    'app.services',
    'ui.bootstrap.typeahead',
    'ui.bootstrap.datepicker',
    'ui.bootstrap.tpls',
    'ui.bootstrap.modal'
    ]);

angular.module('app.controllers',['ngMessages','angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.directives', []);
angular.module('app.services',['ngResource']);

app.provider('appConfig',['$httpParamSerializerProvider',function($httpParamSerializerProvider){
   var config = {
       baseUrl: 'http://localhost:8000',
       project: {
           status: [
               {value: 1, label: 'Não Iniciado'},
               {value: 2, label: 'Iniciado'},
               {value: 3, label: 'Concluído'}
           ]
       },
       utils: {
           transformRequest: function (data){
               if(angular.isObject(data)){
                   return $httpParamSerializerProvider.$get()(data);
               }
               return data;
           },
           transformResponse: function (data, headers) {
               var headersGetter = headers();
               if(headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json'){
                   var dataJson = JSON.parse(data);
                   if(dataJson.hasOwnProperty('data')) {
                       dataJson = dataJson.data;
                   }
                   return dataJson;
               }
               return data;
           }
       }
   };

   return {
       config: config,
       $get: function() {
           return config;
       }
   }

}]);

app.config([
    '$routeProvider',
    '$httpProvider',
    'OAuthProvider',
    'OAuthTokenProvider',
    'appConfigProvider',
    function($routeProvider,$httpProvider,OAuthProvider,OAuthTokenProvider,appConfigProvider){

        $httpProvider.defaults.headers.post['Content-Type'] = "application/x-www-form-urlencoded;charset=utf-8";
        $httpProvider.defaults.headers.put['Content-Type']  = "application/x-www-form-urlencoded;charset=utf-8";
        $httpProvider.defaults.transformRequest  = appConfigProvider.config.utils.transformRequest;
        $httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;

        $routeProvider
        .when('/login',{
            templateUrl:'build/views/login-view.html',
            controller:'LoginController'
        })
        .when('/home',{
            templateUrl:'build/views/home-view.html',
            controller:'HomeController'
        })

        .when('/clients',{
            templateUrl:'build/views/client/client-list-view.html',
            controller:'ClientListController'
        })
        .when('/client/new',{
            templateUrl:'build/views/client/client-new-view.html',
            controller:'ClientNewController'
        })
        .when('/client/:id/edit',{
            templateUrl:'build/views/client/client-edit-view.html',
            controller:'ClientEditController'
        })
        .when('/client/:id/remove',{
            templateUrl:'build/views/client/client-remove-view.html',
            controller:'ClientRemoveController'
        })

        .when('/projects',{
            templateUrl:'build/views/project/project-list-view.html',
            controller:'ProjectListController'
        })
        .when('/project/new',{
            templateUrl:'build/views/project/project-new-view.html',
            controller:'ProjectNewController'
        })
        .when('/project/:id/edit',{
            templateUrl:'build/views/project/project-edit-view.html',
            controller:'ProjectEditController'
        })
        .when('/project/:id/remove',{
            templateUrl:'build/views/project/project-remove-view.html',
            controller:'ProjectRemoveController'
        })

        .when('/project/:id/notes',{
            templateUrl: 'build/views/projectNote/projectNote-list-view.html',
            controller: 'ProjectNoteListController'
        })
        .when('/project/:id/notes/show',{
            templateUrl: 'build/views/projectNote/projectNote-show-view.html',
            controller: 'ProjectNoteShowController'
        })
        .when('/project/:id/note/new',{
            templateUrl: 'build/views/projectNote/projectNote-new-view.html',
            controller: 'ProjectNoteNewController'
        })
        .when('/project/:id/note/:idNote/edit',{
            templateUrl: 'build/views/projectNote/projectNote-edit-view.html',
            controller: 'ProjectNoteEditController'
        })
        .when('/project/:id/note/:idNote/remove',{
            templateUrl: 'build/views/projectNote/projectNote-remove-view.html',
            controller: 'ProjectNoteRemoveController'
        })
        ;

        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: 'appid1',
            clientSecret: 'secret', // optional
            grantPath: 'oauth/access_token'
        });

        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });

}]);

app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {
    $rootScope.$on('oauth:error', function(event, rejection) {
        // Ignore `invalid_grant` error - should be catched on `LoginController`.
        if ('invalid_grant' === rejection.data.error) {
            return;
        }

        // Refresh token when a `invalid_token` error occurs.
        if ('invalid_token' === rejection.data.error) {
            return OAuth.getRefreshToken();
        }

        // Redirect to `/login` with the `error_reason`.
        return $window.location.href = '/login?error_reason=' + rejection.data.error;
    });
}]);


