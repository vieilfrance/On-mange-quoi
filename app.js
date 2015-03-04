var app = angular.module('onMangeQuoi', ['ngRoute']);

app.config(['$routeProvider',
        function($routeProvider) {
            $routeProvider
                .when('/add', {
                    templateUrl: 'templates/add.html',
                    controller: 'AddMealController'
                })
                .when('/', {
                    templateUrl: 'templates/index.html',
                    controller: 'IndexController'
                })
				.otherwise({redirectTo : "/"})
				;
        }]);

app.controller("AddMealController", function($scope, $rootScope, $location, progress, Refs, Meal) {
    $('head').append('<script src="js/forms.js"></script>');
    $scope.types = [];
    $scope.seasons = [];

    Refs.getRefs().then(function(refs){
        $scope.types=refs.refs[0].ref;
        $scope.seasons=refs.refs[2].ref;
    });

    $scope.addMeal = function() {
        progress.start();
        $scope.NewMeal.datetime=Date.now();
        Meal.add($scope.NewMeal).then(function() {
            progress.stop().then(function() {
                $location.path("/add");
                $scope.NewMeal="";
                $rootScope.$broadcast("FlashStatus","Idée de repas ajouté !"  );
                });
        }, function(reason) {
                progress.stop().then(function() {
                    error="";
                    console.log(error);
                    $rootScope.$broadcast("FlashStatus","erreur : "+error  );
                });
        });
    };

});

app.controller("IndexController", function($scope) {
});

app.controller("MealFinder", function($scope,$rootScope, Meal) {

    $scope.loadRecipe = function () {
        Meal.get().then(function(meal){
            $(".recipe").fadeOut("fast", function() {
                $(".recipe").html("<div class='recipe-filed-title' id='name'>"+meal.results[0].name+"</div><div class='recipe-filed' id='type'>C'est une recette de <b>"+meal.results[0].type+"</b></div>");
                });
            $(".recipe").fadeIn("fast");
        }, function(reason) {
                    error="";
                    $rootScope.$broadcast("FlashStatus","erreur : "+error  );
        });
    };

$scope.loadRecipe();

});

//var apiHost = ''; // Define HERE API host. If not define, it'll be the local server.
if (typeof apiHost == "undefined") {
    var apiHost =".";
    }