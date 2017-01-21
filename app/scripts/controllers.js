'use strict';

angular.module('AWapp')

    .controller('HeaderCNTRLR', function($scope, $location) {
        $scope.isActive = function (viewLocation) {
            return viewLocation === $location.path();
        };
    })

    .controller('PaintingsCNTRLR', function($scope,paintingService){
        $scope.tab=1;
        $scope.filtText = 'portrait';
        $scope.showPaintings = false;
        $scope.message ="Loading ...";

        $scope.paintings = paintingService.getPaintings().query(
            function(response) {
                        $scope.paintings = response;
                        $scope.showPaintings = true;
                    },
                    function(response) {
                        $scope.message = "Error: "+response.status + " " + response.statusText;
                    }
        );

        $scope.select = function(setTab) {
            $scope.tab = setTab;
            if (setTab === 1) { $scope.filtText = "portrait"; }
            else if (setTab === 2) {  $scope.filtText = "life"; }
            else if (setTab === 3) {  $scope.filtText = "still"; }
            else if (setTab === 4) {  $scope.filtText = "drawings"; }
            else if (setTab === 5) {  $scope.filtText = "etchings"; }
            else if (setTab === 6) {  $scope.filtText = "orchestra"; }
            else if (setTab === 7) {  $scope.filtText = "portraitegypt"; }
            else { $scope.filtText = "portrait"; }
        };

        $scope.isSelected = function (checkTab) { return ($scope.tab === checkTab); };


    })




    .controller('ExhibitionsCNTRLR', function($scope,exhibitionService){
        $scope.showExhibitions = false;
        $scope.showExhibsGroups = false;
        $scope.showExhibsSolos = false;
        $scope.message = "Loading ...";


        $scope.allExhibitions = exhibitionService.getExhibitions().query(
        function(response) {
                    $scope.allExhibitions = response;
                    $scope.showExhibitions = true;
                },
                function(response) {
                    $scope.message = "Error: "+response.status + " " + response.statusText;
                }
        );



        $scope.exhibsGroups = exhibitionService.getExhibsGroups().query(
        function(response) {
                    $scope.exhibitions = response;
                    $scope.showExhibsGroups = true;
                },
                function(response) {
                    $scope.message = "Error: "+response.status + " " + response.statusText;
                }
        );

        $scope.exhibsSolos = exhibitionService.getExhibsSolos().query(
            function(response) {
                    $scope.exhibitions = response;
                    $scope.showExhibsSolos = true;
                },
                function(response) {
                    $scope.message = "Error: "+response.status + " " + response.statusText;
                }
        );

        $scope.future = function(val){
            var d = new date().toISOString.slice(0,10);
            if(d<val) {$scope.future = true; alert(d);}
            else {$scope.future = false;}
        }

})
