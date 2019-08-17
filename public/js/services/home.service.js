(function(){
    'use strict';
    
    angular.module('ProductApp').
        service('HomeService', HomeService);
    
    HomeService.$inject = ['$http'];
    function HomeService($http) {
        var service = this;

        service.callbacks = [];

        // register listeners
        service.onGetCookie = function(callback) {
            service.callbacks.push(callback);
        };
    }
})();