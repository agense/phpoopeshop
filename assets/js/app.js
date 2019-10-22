(function(){

contentHandler();

//EVENT LISTENERS
function contentHandler(){

    //CONTROL FRONT PAGE SUBMENU DISPLAY
    var toggler = document.getElementById('toggler');
    var nav = document.querySelector('.nav-links');
    var menuLinks = document.querySelectorAll('.arr');

    //attach event listener on each link
    menuLinks.forEach(function(link){
            link.addEventListener('click', function(e){
            e.preventDefault();    
            let submenu = e.target.parentElement.nextElementSibling;
            controlSubmenu(submenu, e.target);
        });
    });

    //display nav on load based on screen size
    document.addEventListener('DOMContentLoaded', function(){
        controlNav(nav);
    });

    window.addEventListener('resize', function(){
        controlNav(nav);
    });

    //toggle navigation on mobile
    toggler.addEventListener('click', function(){
        showNav(nav);
    });
}

//HELPER FUNCTIONS
//control nav
function controlNav(nav){
    if(window.innerWidth >= 768){
        nav.classList.remove('show-nav','animatedNav');
        nav.classList.add('show-nav');
        nav.querySelectorAll('.submenu').forEach(function(sub){
            sub.classList.remove('show');
            sub.previousElementSibling.querySelector('.arr').innerHTML = `<i class="fas fa-plus"></i>`;
        });
    }
    else{
        nav.classList.remove('show-nav'); 
        if(toggler.classList.contains('change')){
           toggler.classList.remove('change');
        }  
    }
}

//control mobile nav
function showNav(nav){
    if(!nav.classList.contains('show-nav')){
        nav.classList.add('show-nav', 'animatedNav');
        toggler.classList.add('change');
   }else{
       nav.classList.remove('show-nav');
       toggler.classList.remove('change');
   }
}
//function control submenu
function controlSubmenu(submenu, togglerIcon){
    if(!submenu.classList.contains('show')){
        submenu.classList.add('show');
        togglerIcon.innerHTML = `<i class="fas fa-minus"></i>`;  
    }else{
      submenu.classList.remove('show');
      togglerIcon.innerHTML = `<i class="fas fa-plus"></i>`;
    }
}
})();