(function(){
    'use strict';

    angular.module('ProductApp').
        config(ConfigRoutes);
    
    ConfigRoutes.$inject = ['$routeProvider'];
    function ConfigRoutes($routeProvider) {
        $routeProvider.
            when("/", {
                title: 'Home',
                template: '<home-component></home-component>',
                activetab: 'home'
            }).
            when("/product", {
                title: 'Product',
                template: '<product-component></product-component>',
                activetab: 'product',
                resolve: {
                    user: checkUser,
                }
            }).
            when("/cart", {
                title: 'cart',
                template: '<cart-component></cart-component>',
                activetab: 'cart',
                resolve: {
                    user: checkUser,
                }
            }).
            when("/order", {
                title: 'Order',
                template: '<order-component></order-component>',
                activetab: 'order',
                resolve: {
                    user: checkUser,
                }
            });
    }

    var checkUser = function($q) {
        var deferred = $q.defer(),
            userCookie = "";

        // userCookie = "1";
        if (userCookie !== "") {
            deferred.resolve();
        }

        return deferred.promise;
    }

})();