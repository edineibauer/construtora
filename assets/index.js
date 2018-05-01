var slideContent = "";
var slideActive = 0;
var interval = null;
var slideDirection = 1;

$(document).scroll(function () {
    if ($(window).scrollTop() > 650 && !$("#c-slide-" + slideActive).find(".c-slide-opaco").length) {
        $("#c-slide-" + slideActive).html(slideContent);
        startSlide();
    }
});

function slide(active, auto = false) {
    if (!$("#c-slide-" + (slideActive + active)).length && auto) {
        slideDirection = slideDirection === 1 ? -1 : 1;
        active = active === 1 ? -1 : 1;
    }

    if ($("#c-slide-" + (slideActive + active)).length) {
        if(!auto)
            startSlide();

        let $oldActive = $("#c-slide-" + slideActive);
        slideActive += active;
        let transition = active * $oldActive.width() * -1;
        $oldActive.css("transform", "translate(" + transition + "px)").css("z-index", 2);
        $("#c-slide-" + slideActive).css("transform", "translate(0)").css("z-index", 3);
    }
}

function startSlide() {
    clearInterval(interval);
    interval = setInterval(function () {
        slide(slideDirection, true);
    }, 4000);
}

function noticiaSlide(active) {
    let s = active === 1 ? 3 : 0;
    $(".home-noticia").addClass("hide");
    for(var i = s; i < s + 3; i++) {
        $(".home-noticia:eq(" + i + ")").removeClass("hide");
    }
}

$(function () {
    $(".empreendimento-status").off("click").on("click", function () {
        $(".empreendimento-status").removeClass("active");
        $(this).addClass("active");
        $(".empreendimento-home-list").addClass("hide");
        $(".empreendimento-" + $(this).attr("rel")).removeClass("hide");
    });

    $(".c-slide").off("click", ".btn-video-slide-home").on("click", ".btn-video-slide-home", function () {
        clearInterval(interval);
        const $slide = $("#c-slide-" + $(this).attr("rel"));
        const $this = $(this);
        const id = $this.attr("data-id");
        const server = $this.attr("data-server");
        slideContent = $slide.html();
        if (server === "youtube")
            $slide.html('<iframe id="playerID" style="width: 100%" height="600" src="https://www.youtube.com/embed/' + id + '?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
    });

    $("#prevNoticia").off("click").on("click", function () {
        noticiaSlide(-1);
    });

    $("#nextNoticia").off("click").on("click", function () {
        noticiaSlide(1);
    });

    $(".c-slide").off("click", ".nextSlideHome").on("click", ".nextSlideHome", function () {
        slide(1);
    }).off("click", ".prevSlideHome").on("click", ".prevSlideHome", function () {
        slide(-1);
    });

    startSlide();
});