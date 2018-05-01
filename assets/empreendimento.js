$(document).scroll(function (e) {
    let $obra = $(".div-andamento-obra");
    if ($obra.attr("data-effect") === "0" && $(window).scrollTop() > ($obra.offset().top - $(window).height())) {
        $obra.attr("data-effect", 1);
        $('.loaderCircle').each(function () {
            $(this).ClassyLoader({
                percentage: $(this).attr("rel"),
                speed: ((100 - parseInt($(this).attr("rel"))) * 0.33) + 16.5,
                fontFamily: 'Georgia',
                fontColor: 'rgba(0,0,0,0.4)',
                lineColor: 'rgba(234,196,57,1)',
                lineWidth: 3,
                start: 'top',
                diameter: 65,
                fontSize: '27px',
                width: 140,
                height: 140,
                remainingLineColor: 'rgba(0,0,0,0.1)'
            });
        });
    }

    if($(window).scrollTop() > 650 && !$(".empreendimento-video").find(".c-slide-opaco").length) {
        $(".empreendimento-video").html(background).css("height", "400px");
    }
});

var fotoActive = 1;
var background = $(".empreendimento-video").html();

function slideFotosTo(active) {
    if ($(".slide-block-fotos img:eq(" + active + ")").length) {
        if (active === 0) {
            $(".slide-block-fotos").css("transform", "translate(0)");
        } else {
            let widthFotos = $(".slide-block-fotos").parent().width();
            let widthActive = $(".slide-block-fotos img:eq(" + active + ")").width();
            var translateSlide = (widthFotos - widthActive) / 2;
            translateSlide *= -1;

            for (var i = 0; i < active; i++)
                translateSlide += $(".slide-block-fotos img:eq(" + i + ")").width();

            $(".slide-block-fotos").css("transform", "translate(-" + translateSlide + "px)");
        }
    }
}

$(function () {
    $("#nextFotoObra").off("click").on("click", function () {
        $(".empreendimento-obra-foto");
    });

    $('a[href^="#"]').on('click', function (event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });

    $(".planta-select").off("click").on("click", function () {
        $(".planta-select").removeClass("color-text-yellow");
        $(".planta-img").addClass("hide");
        $(this).addClass("color-text-yellow");
        $("#planta-img-" + $(this).attr("rel")).removeClass("hide");
    });


    $("#nextFotoObra").off("click").on("click", function () {
        if (fotoActive < $(".slide-block-fotos img").length - 1) {
            fotoActive += 1;
            slideFotosTo(fotoActive);
        }
    });

    $("#prevFotoObra").off("click").on("click", function () {
        if (fotoActive > 0) {
            fotoActive -= 1;
            slideFotosTo(fotoActive);
        }
    });

    $(".empreendimento-video").off("click", ".btn-empreendimento-video").on("click", ".btn-empreendimento-video", function () {
        const $this = $(this);
        $(".empreendimento-video").css("height", "600px").css("padding", 0);
        const id = $this.attr("data-id");
        const server = $this.attr("data-server");

        if (server === "youtube")
            $(".empreendimento-video").html('<iframe id="playerID" style="width: 100%" height="600" src="https://www.youtube.com/embed/' + id + '?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
    });

    slideFotosTo(fotoActive);
});