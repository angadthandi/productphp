(function(){
    'use strict';

    ProductController.$inject = ['ProductService', '$timeout'];

    function ProductController(ProductService, $timeout) {
        var ctrl = this;

        ctrl.products = [];

        ctrl.getProducts = function() {
            ProductService.GetProducts().
                then(function(data){
                    ctrl.products = data;
                });
        };

        // init function
        ctrl.init = function() {
            ctrl.getProducts();
        };

        ctrl.$onInit = function() {
            ctrl.init();
        };

        ctrl.$onChanges = function() {

        };
    }

    angular.module('ProductApp').
        component('productComponent', {
            templateUrl: '/js/components/product/product.template.html',
            controller: ProductController,
            controllerAs: '$ctrl',
            bindings: {
                
            }
        });

})();