'use strict';

angular.module('AWapp', ['ui.router','ngResource'])
.config(function($stateProvider, $urlRouterProvider) {
        $stateProvider
        
            // route for the home page
            .state('app', {
                url:'/',
                views: {
                    'header': {
                        templateUrl : 'views/header.html',
                    },
                    'content': {
                        templateUrl : 'views/home.html',
                        controller  : 'IndexCNTRLR'
                    },
                    'footer': {
                        templateUrl : 'views/footer.html',
                    }
                }

            })
        
            // route for the biography page
            .state('app.biography', {
                url:'biography',
                views: {
                    'content@': {
                        templateUrl : 'views/biography.html'               
                    }
                }
            })
        
            // route for the gallery page
            .state('app.paintings', {
                url:'paintings',
                views: {
                    'content@': {
                        templateUrl : 'views/paintings.html',
                        controller  : 'PaintingsCNTRLR'                  
                    }
                }
            })
        
            // route for the exhibition page
            .state('app.exhibitions', {
                url:'exhibitions',
                views: {
                    'content@': {
                        templateUrl : 'views/exhibitions.html',
                        controller  : 'ExhibitionsCNTRLR'                  
                    }
                }
            })
        
            // route for the teaching page
            .state('app.teachings', {
                url:'teachings',
                views: {
                    'content@': {
                        templateUrl : 'views/teachings.html',
                        controller  : 'TeachingsCNTRLR'                  
                    }
                }
            })
        
            // route for the publication page
            .state('app.publications', {
                url:'publications',
                views: {
                    'content@': {
                        templateUrl : 'views/publications.html',
                        controller  : 'PublicationsCNTRLR'                  
                    }
                }
            })
        
            // route for the publication page
            .state('app.blogs', {
                url:'blogs',
                views: {
                    'content@': {
                        templateUrl : 'views/blogs.html',
                        controller  : 'BlogsCNTRLR'                  
                    }
                }
            })
    
        $urlRouterProvider.otherwise('/');
    })

.filter('searchFor',function(){
    return function(arr,searchString){
        if(!searchString){return arr;}
        var result =[];
        searchString = searchString.toLowerCase();
        angular.forEach(arr,function(item){
            if(item.Title.toLowerCase().indexOf(searchString) !== -1  ||            item.Gallery.toLowerCase().indexOf(searchString) !== -1  || item.To.toLowerCase().indexOf(searchString) !== -1) {
                result.push(item);
            }
        });
        return result;
    }
})
;

$(document).ready(function() {
    
    $('[data-toggle="tooltip"]').tooltip();
    
    $(window).scroll(function () {
      //if you hard code, then use console
      //.log to determine when you want the 
      //nav bar to stick.  
      console.log($(window).scrollTop())
    if ($(window).scrollTop() > 88) {
      $('#nav_bar').addClass('navbar-fixed-top');
      $('#nav_bar').css("position","fixed");    
      console.log('fixed top now');
    }
    if ($(window).scrollTop() < 87) {
      $('#nav_bar').removeClass('navbar-fixed-top');
      console.log('fixed top removed');
    }
        
  });
});