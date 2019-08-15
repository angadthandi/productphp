(function(){
    'use strict';
    
    angular.module('ProductApp').
        service('ProductService', ProductService);
    
    ProductService.$inject = ['$http', 'UniqueArrayFilter'];
    function ProductService($http, UniqueArrayFilter) {
        var service = this;

        service.callbacks = [];

        // register listeners
        service.onGetProducts = function(callback) {
            service.callbacks.push(callback);
        };

        service.GetProducts = function() {
            return $http.get('api',
                {params: {'action':'products'}}).
                then(function(response) {
                    var i = 0;

                    //notify if there are any listeners
                    for(i=0; i<service.callbacks.length; i++) {
                        service.callbacks[i](response.data);
                    }

                    return response.data;
                }).
                catch(function(error){
                    console.log(error);
                    return false;
                });
        };
    }
})();