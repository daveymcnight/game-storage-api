/**
 * Created by McDavis on 8/11/15.
 */
var gameApp = angular.module('gameApp',[]);


gameApp.controller('mainController', ['$scope','$http', function($scope, $http) {


$scope.addSystem = function(){
    $http.post('/post/system/',  JSON.stringify({ 'name' : "HEY" }));
}
}]);