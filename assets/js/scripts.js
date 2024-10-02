$(function () {
    // Sticky header
    var observer = new IntersectionObserver(
        function (entries) {
            // no intersection with screen
            if (0 === entries[0].intersectionRatio) {
                document.querySelector('#header-bar').classList.add('sticky')
            }

            // fully intersects with screen
            else if (1 === entries[0].intersectionRatio) {
                document.querySelector('#header-bar').classList.remove('sticky')
            }
        },
        {
            threshold: [0, 1],
        }
    )

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

    // CEP autofill
    $('#form-cep').on('focusout', function () {
        $.ajax({
            url: 'https://viacep.com.br/ws/' + $(this).val() + '/json/',
            dataType: 'json',
            success: function (resposta) {
                $('#form-endereco').val(resposta.logradouro)
                $('#form-complemento').val(resposta.complemento)
                $('#form-bairro').val(resposta.bairro)
                $('#form-cidade').val(resposta.localidade)
                $('#form-uf').val(resposta.uf)
                $('#form-numero').focus()
            },
        })
    })

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
