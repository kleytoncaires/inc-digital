$(function () {
    var stickyMenu = document.querySelector('#sticky-menu-top')

    if (stickyMenu) {
        var observer = new IntersectionObserver(
            function (entries) {
                // no intersection with screen
                if (entries[0].intersectionRatio === 0) {
                    document
                        .querySelector('#header-bar')
                        .classList.add('sticky')
                }
                // fully intersects with screen
                else if (entries[0].intersectionRatio === 1) {
                    document
                        .querySelector('#header-bar')
                        .classList.remove('sticky')
                }
            },
            {
                threshold: [0, 1],
            }
        )

        observer.observe(stickyMenu)
    }

    observer.observe(document.querySelector('#sticky-menu-top'))

    // Masks
    var maskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11
                ? '(00) 00000-0000'
                : '(00) 0000-00009'
        },
        options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options)
            },
        }
    $('.form-tel').mask(maskBehavior, options)
    $('.form-cep').mask('00000-000')
    $('.form-cpf').mask('000.000.000-00')
    $('.form-cnpj').mask('00.000.000/0000-00')

    // Floating Labels in CF7
    var formControls = document.querySelectorAll(
        '.wpcf7 .form-control, .wpcf7 .form-select'
    )

    for (var i = 0; i < formControls.length; i++) {
        var input = formControls[i]
        var label = input.parentNode.parentNode.querySelector('label')

        input.addEventListener('focus', function () {
            this.parentNode.parentNode.classList.add('active')
        })

        input.addEventListener('blur', function () {
            var cval = this.value
            if (cval.length < 1) {
                this.parentNode.parentNode.classList.remove('active')
            }
        })

        if (label) {
            label.addEventListener('click', function () {
                var input = this.parentNode.querySelector(
                    '.form-control, .form-select'
                )
                input.focus()
            })
        }
    }

    // Get container offset
    offsetWidth()
    $(window).on('resize', function () {
        offsetWidth()
    })

    function offsetWidth() {
        var containerOffset = $('.container').offset().left
        $('.container-offset').css('width', containerOffset)
    }

    // Smooth Scrolling to Anchor Links
    $('.smooth-scroll').bind('click', function (event) {
        var $anchor = $(this)

        $('html, body')
            .stop()
            .animate(
                {
                    scrollTop: $($anchor.attr('href')).offset().top - 300,
                },
                1000
            )

        event.preventDefault()
    })

    // Fancybox
    Fancybox.bind()

    // Aos
    AOS.init()
})
