app.service('Meal', function($http, $q, $timeout){
    var host = apiHost;
    this.meal=false;

    this.add = function(meal){
        var deferred = $q.defer();
        var endpoint = '/api/meal/';

        endpoint=host+endpoint; // test 
        $http.post(endpoint,meal)
            .success(function(data, status){
                $timeout(function(){
                    console.log(data.success);
                    deferred.resolve(data.success);
                }, 0);
            })
            .error(function(data, status){
                deferred.reject(data);
            });
        return deferred.promise;

    };

    this.get = function() {
        var deferred = $q.defer();
        var endpoint = '/api/meal/';

        endpoint=host+endpoint; // test 
        $http.get(endpoint)
            .success(function(data, status){
                this.meal=data;
                deferred.resolve(this.meal);
            })
            .error(function(data, status){
                deferred.reject(status);
            });
        return deferred.promise;

    };

    this.list = function() {
        var deferred = $q.defer();
        var endpoint = '/api/meals/';

        endpoint=host+endpoint; // test 
        $http.get(endpoint)
            .success(function(data, status){
                this.meal=data;
                deferred.resolve(this.meal);
            })
            .error(function(data, status){
                deferred.reject(status);
            });
        return deferred.promise;

    };

    this.del = function(meal_id) {
        var deferred = $q.defer();
        var endpoint = '/api/meal/id/';

        endpoint=host+endpoint; // test 
        $http.delete(endpoint+meal_id)
            .success(function(data, status){
                deferred.resolve(data);
            })
            .error(function(data, status){
                deferred.reject(status);
            });
        return deferred.promise;
    }

});