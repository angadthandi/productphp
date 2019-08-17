(function(){
    'use strict';

    HomeController.$inject = ['HomeService'];

    function HomeController(HomeService) {
        var ctrl = this;

        ctrl.loginAsGuest = function() {
            HomeService.GuestAuthenticate().
                then(function(responseData){
                    console.log('TODO Set Authenticate Cookie!');
                    console.log(responseData);
                });
        };

        // init function
        ctrl.init = function() {

        };

        ctrl.$onInit = function() {
            ctrl.init();
        };

        ctrl.$onChanges = function() {

        };
    }

    angular.module('ProductApp').
        component('homeComponent', {
            templateUrl: '/js/components/home/home.template.html',
            controller: HomeController,
            controllerAs: '$ctrl',
            bindings: {
                
            }
        });

})();