(function(){
    'use strict';

    NavbarController.$inject = ['$route'];

    function NavbarController($route) {
        var ctrl = this;
        ctrl.route = $route;

        ctrl.$onInit = function() {

        };

        ctrl.$onChanges = function() {

        };
    }

    angular.module('ProductApp').
        component('navbarComponent', {
            templateUrl: '/js/components/navbar/navbar.template.html',
            controller: NavbarController,
            controllerAs: '$ctrl',
            bindings: {
                
            }
        });

})();