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

        service.GuestAuthenticate = function() {
            return $http.post('api',
                {params: {
                    'action':'authenticate',
                    'data': {
                        'userType': 'guest',
                    },
                }}).
                then(function(response) {
                    var i = 0;

                    //notify if there are any listeners
                    for(i=0; i<service.callbacks.length; i++) {
                        service.callbacks[i](response.data);
                    }

                    return response.data;
                }).
                catch(function(error){
                    console.log(error);
                    return false;
                });
        };
    }
})();