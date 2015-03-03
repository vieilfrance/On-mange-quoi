app.service('Refs', function($http, $q, $timeout){
    var host = apiHost;
    this.refs=false;

    this.getRefs = function() {
        var deferred = $q.defer();
        var endpoint = '/api/refs.json';

        endpoint=host+endpoint; // test 
        $http.get(endpoint)
            .success(function(data, status){
                this.refs=data.results;
                deferred.resolve(this.refs);
            })
            .error(function(data, status){
                deferred.reject(status);
            })
        return deferred.promise;
    };

})