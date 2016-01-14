(function () {
    var person = {};
    var app = angular.module('controller', []);
    app.controller('personCtrl', function ($scope, $state, personSrv) {
        function getAll() {
            $scope.datas = personSrv.query();
        };
        getAll();
        $scope.add = function () {
            person = {};
            $state.go('form');
        };
        $scope.edit = function (data) {
            person = data;
            $state.go('form');
        };
        $scope.remove = function (id){
            var r = confirm("Are you sure delete this person ? ");
            if (r === true) {
                personSrv.delete({id: id}, function () {
                    getAll();
                    alert('Delete Data Success');
                });
            } else {
                getAll();
            }
        };
    });
    app.controller('formCtrl', function ($scope, $state, personSrv) {
        $scope.post = person;
        $scope.back = function () {
            $state.go('person');
        };
        $scope.save = function () {
            if ($scope.post.id === undefined) {
                personSrv.save($scope.post, function () {
                    $scope.post = '';
                    alert('Save Data Success');
                });
            } else {
                personSrv.update($scope.post, function () {
                    alert('Update Data Success');
                });
            }
        };
    });
})();