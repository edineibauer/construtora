$(document).scroll(function (e) {
    let $obra = $(".div-andamento-obra");
    if($obra.attr("data-effect") === "0" && $(window).scrollTop() > ($obra.offset().top - $(window).height())) {
        $obra.attr("data-effect", 1);
        console.log('ok');
        $('.loaderCircle').each(function() {
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
});

$(function () {
   $("#nextFotoObra").off("click").on("click", function () {
       $(".empreendimento-obra-foto");
   });

    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
});