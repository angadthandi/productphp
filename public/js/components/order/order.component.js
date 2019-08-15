(function(){
    'use strict';

    OrderController.$inject = ['OrderService'];

    function OrderController(OrderService) {
        var ctrl = this;

        ctrl.$onInit = function() {

        };

        ctrl.$onChanges = function() {

        };
    }

    angular.module('ProductApp').
        component('orderComponent', {
            templateUrl: '/js/components/order/order.template.html',
            controller: OrderController,
            controllerAs: '$ctrl',
            bindings: {
                
            }
        });
})();