document.addEventListener('DOMContentLoaded', function() {
        var navItems = document.querySelectorAll('.nav-item');
    
        navItems.forEach(function(navItem) {
            navItem.addEventListener('click', function() {
                navItems.forEach(function(item) {
                    item.classList.remove('active');
                });

                navItem.classList.add('active');
            });
        });
    });

    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        if (window.scrollY > 0) {
            header.classList.add('header-bg');
        } else {
            header.classList.remove('header-bg');
        }
    });
    