(function(){
    'use strict';

    CartController.$inject = ['CartService'];

    function CartController(CartService) {
        var ctrl = this;

        ctrl.$onInit = function() {

        };

        ctrl.$onChanges = function() {

        };
    }

    angular.module('ProductApp').
        component('cartComponent', {
            templateUrl: '/js/components/cart/cart.template.html',
            controller: CartController,
            controllerAs: '$ctrl',
            bindings: {
                
            }
        });
})();