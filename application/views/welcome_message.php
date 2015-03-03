<!DOCTYPE html>
<html ng-app="onMangeQuoi">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>On mange quoi ce soir ?</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="/bower_components/angular/angular.js"></script>
		<script src="/bower_components/angular-route/angular-route.js"></script>

		<script src="app.js"></script>
		<script src="js/controller/status.js"></script>
		<script src="js/service/progress.js"></script>
		<script src="js/service/refs.js"></script>
		<script src="js/service/meal.js"></script>

		<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bower_components/bootstrap-material-design/dist/css/material.min.css">
        <link rel="stylesheet" href="/bower_components/mprogress/build/css/mprogress.css">
		<link rel="stylesheet" href="/css/app.css">

    </head>
    <body>
    	<div id="progress"></div>
    	<div ng-view id="view"></div>
	    <div class="snackbar-container" data-ng-controller="statusController">
	    <div class="snackbar" id="snack">
	        <span class="snackbar-content">{{qStatus}}</span>
	        <span ng-click="close()" class="snackbar-action btn btn-material-lime btn-flat">{{qActionName}}</span>
	    </div>  
	    </div>

		<script src="/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    	<script src="/bower_components/mprogress/build/js/mprogress.min.js"></script>
    	<link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
   	</body>
</html>
