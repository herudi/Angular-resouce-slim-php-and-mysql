(function () {
    var app = angular.module('service', []);
    app.factory('personSrv',function ($resource){
         return $resource('../Backend/person/:id', {id: '@id'}, {
            'update': {method: 'PUT'}
        });
    });
})();