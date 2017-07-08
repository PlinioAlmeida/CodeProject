/**
 * Created by Administrador on 07/07/17.
 */
angular.module('app.filters').filter('dateBr', ['$filter', function($filter){
    return function (input) {
        return $filter('date')(input, 'dd/MM/yyyy');
    }
}]);
