(function(){
    'use strict';

    angular.module('ProductApp').
        config(ConfigRoutes);
    
    ConfigRoutes.$inject = ['$routeProvider'];
    function ConfigRoutes($routeProvider) {
        $routeProvider
            .when("/", {
                title: 'Home',
                template: '<product-component></product-component>',
                activetab: 'home'
            })
            .when("/order", {
                title: 'Order',
                template: '<order-component></order-component>',
                activetab: 'order'
            });
    }

})();