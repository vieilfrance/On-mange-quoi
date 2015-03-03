app.service('progress', function($q, $timeout){
    var intObj = {
      template: 3, 
      parent: '#progress' // this option will insert bar HTML into this parent Element 
    };
    var indeterminateProgress = new Mprogress(intObj);

    this.start = function(){
        var deferred = $q.defer();
        indeterminateProgress.start();
        deferred.resolve();
        return deferred.promise;
        }

    this.stop = function(){
        var deferred = $q.defer();
        indeterminateProgress.end();
        deferred.resolve();
        return deferred.promise;
    }
});
