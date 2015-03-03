app.controller('statusController', ['$scope', '$timeout',  
    function ($scope, $timeout) {
        $scope.qStatus = "";
        $scope.$on('BeginStatus', function (event, args) {
            $scope.qStatus = args;
            $("#view").addClass("waiting");
            $("#snack").addClass("snackbar-opened");

        });

        $scope.$on("EndStatus", function (event) {
            $timeout(function(){
                $("#snack").removeClass("snackbar-opened");
                $("#view").removeClass("waiting");
                $scope.qStatus = "";
                }, 3000)
        });

        $scope.$on('FlashStatus', function (event, args) {
			$scope.qStatus = args;
            $("#snack").addClass("snackbar-opened");
			$timeout(function(){
                    $("#snack").removeClass("snackbar-opened");
                    $("#view").removeClass("waiting");
                    $scope.qStatus = "";
                }, 3000)
        });

        $scope.$on('ACKStatus', function (event, args) {
            $scope.qStatus = args.status;
            $scope.qActionName = args.actionName;
            $scope.qAction = args.action;
            $("#view").addClass("waiting");
            $("#snack").addClass("snackbar-opened");
        });

        $scope.close = function()
           {
            $timeout(function(){
                $("#snack").removeClass("snackbar-opened");
                $("#view").removeClass("waiting");
                $scope.qStatus = "";
                $scope.qActionName = "";
                $scope.qAction = "";
                }, 0)
           }
    }
]);