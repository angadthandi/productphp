(function(){
    'use strict';
    
    angular.module('ProductApp').
        service('OrderService', OrderService);
    
    OrderService.$inject = ['$http'];
    function OrderService($http) {
        var service = this;

        service.callbacks = [];
    }
})();