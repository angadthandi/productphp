(function(){
    'use strict';

    angular.module('ProductApp').
        service('CartService', CartService);

    CartService.$inject = ['$http'];
    function CartService($http) {
        var service = this;

        service.callbacks = [];
    }
})();