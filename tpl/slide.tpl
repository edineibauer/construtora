<div class="c-slide position-absolute relative" id="c-slide-{$i}" style="background-image: url('{$background}');{($i > 0)? "transform: translate(1500px); z-index: 2" : "z-index: 3"}">
    <div class="c-slide-opaco"></div>
    <div class="col padding-128">
        <div class="col padding-64 block">
            <div class="col left c-slide-arrow c-slide-arrow-left pointer no-select prevSlideHome">
                <i class="material-icons color-text-white font-jumbo">keyboard_arrow_left</i>
            </div>
            <div class="col right c-slide-arrow c-slide-arrow-right pointer no-select nextSlideHome">
                <i class="material-icons color-text-white font-jumbo">keyboard_arrow_right</i>
            </div>
            <div class="rest">
                <a href="{$home}empreendimento/{$name}" class="col align-center margin-bottom">
                    <img src="{$logo_empreendimento}" class="align-center">
                </a>
                {if $video_server !== ""}
                    <div class="col align-center padding-32">
                        <button data-id="{$video_id}" data-server="{$video_server}" rel="{$i}"
                                class="btn-video-slide-home btn-large hover-shadow color-text-grey c-slide-play radius-xxlarge color-white align-center">
                            <img src="{$homedev}assets/img/play.svg" class="left padding-right" width="34px"
                                 style="width: 34px">
                            <span class="left upper font-weight-bold font-medium">Assista ao Vídeo</span>
                        </button>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
