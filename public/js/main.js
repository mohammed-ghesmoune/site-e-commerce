(function ($) {
    $(document).ready(function () {

        //tooltips
        $('[data-tooltips="tooltip"]').tooltip();

        // toggle login/register forms
        function toggleForms() {
            $("#se-connecter , #inscrivez-vous").click(function (event) {
                event.preventDefault();
                $("#se-connecter , #inscrivez-vous").toggleClass('active');
                $("#login-form, #register-form").toggleClass('d-none');
                window.history.pushState({},null,$(this).data('href'))
            });
        }
        toggleForms();

        // show forgot password modal
        if ($('#forgotPasswordModal').data('show-forgot-password-modal') == true) {
            $('#forgotPasswordModal').modal();
        }



        // sideNave
        $('#openSideNavButton').click(function () {
            $(".sideNav").css('width', '100%');
            $("#main").addClass('margin_left');
            $(this).toggleClass('change');
        });


        $(".sideNav").click(function (event) {
            if (event.target == this) {
                $(".sideNav").css('width', '0');
                $("#main").removeClass('margin_left');
                $('#openSideNavButton').toggleClass('change');
            }
        })

        $('#closeSideNavButton').click(function () {
            $(".sideNav").css('width', '0');
            $("#main").removeClass('margin_left');
            $('#openSideNavButton').toggleClass('change');
        })

        //dropdown sideNav
        const dropdownElements = document.querySelectorAll('.dropdownWithAfter');
        dropdownElements.forEach(element => {
            element.addEventListener('click', function () {
                dropdownElements.forEach(el => {
                    el.querySelector('i').style.transform = 'rotate(0deg)'
                    el.style.fontWeight = 'initial'
                })
                if (this.classList.contains('collapsed')) {
                    this.querySelector('i').style.transform = 'rotate(90deg)'
                    this.style.fontWeight = '600'
                } else {
                    this.querySelector('i').style.transform = 'rotate(0deg)'
                    this.style.fontWeight = 'initial'

                }
            })
        })

        // submenu
        document.querySelectorAll('header .nav-link').forEach(element => {
            if (window.location.href === element.href) {
                element.classList.add('active')
            }
        })
        document.querySelectorAll('header .dropdown-toggle').forEach(element => {
            if (window.location.href.startsWith(element.href)) {
                element.classList.add('active')
            }
        })

        //scroll to top

        const headerNavHeight = document.querySelector('.header').offsetHeight;
        const scrollToTopButton = document.querySelector('.back-to-top') ;
        window.addEventListener('scroll', ()=>{    
            if (document.body.scrollTop > headerNavHeight || document.documentElement.scrollTop > headerNavHeight) {
				scrollToTopButton.style.visibility = "visible";
				scrollToTopButton.style.opacity = "1";
			} else {
				scrollToTopButton.style.visibility = "hidden";
				scrollToTopButton.style.opacity = "0";
			}
        })
        scrollToTopButton.addEventListener('click', function(){
            document.body.scrollTop = 0; // For Safari
		   document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        })
		

    });
})(jQuery);
