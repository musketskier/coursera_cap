'use strict';

angular.module('AWapp')
    .constant("baseURL","http://localhost/adelewagstaff/v1/")   //  adele/api/v1/

    .service('exhibitionService', ['$resource','baseURL', function($resource, baseURL){
        // this.getExhibitions = function() {
        //     return $resource(baseURL+'Exhibitions/:id_Exhibition');  //
        // }

        this.getExhibsSolos = function() {
            return $resource(baseURL+'exhibitions?Type=Solo');  //&$orderby=To
        }
        this.getExhibsGroups = function() {
            return $resource(baseURL+'exhibitions?Type=Group');
        }

    }])

    .service('paintingService', ['$resource','baseURL', function($resource,baseURL){
        this.getPaintings = function() {
            return $resource(baseURL+'/galleries?Web=y');
        }

    }])
;
