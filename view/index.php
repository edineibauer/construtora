<?php
define('HOMEDEV', HOME . (DEV && DOMINIO === "construtora" ? "" : "vendor/conn/construtora/"));
require_once 'inc/header.php';
?>

<div class="row relative" style="height: 600px;">
    <?php
    $read->exeRead("empreendimentos", "WHERE andamento_da_obra = '3'", "ORDER BY id DESC LIMIT 3");
    if ($read->getResult()) {
        $i = 0;
        foreach ($read->getResult() as $item) {
            $item['video_server'] = "";
            $item['video_id'] = "";
            if (!empty($item['link_do_video'])) {
                if (preg_match('/youtube\.com/i', $item['link_do_video'])) {
                    $item['video_server'] = "youtube";
                    if (preg_match('/\?v=/i', $item['link_do_video']))
                        $item['video_id'] = explode("?v=", $item['link_do_video'])[1];
                    elseif (preg_match('/youtube\.com\/embed\//i', $item['link_do_video']))
                        $item['video_id'] = explode('"', explode("youtube.com/embed/", $item['link_do_video'])[1])[0];

                }
            }

            if (!empty($item['link_do_video']) || !empty($item['logo_empreendimento'])) {
                $item['i'] = $i;
                $item['homedev'] = HOMEDEV;
                $item['logo_empreendimento'] = HOME . str_replace('\\', '/', json_decode($item['logo_empreendimento'], true)[0]['url']);
                $item['background'] = \Helpers\Helper::convertImageJson($item['background']);
                $tpl->show("slide", $item);
                $i++;
            }
        }
    }
    ?>
</div>

<section class="row c-background-home">
    <div class="col padding-32 c-container">
        <div class="col padding-32">
            <h4 class="align-centers c-construindo-sonhos">
                <img src="<?= FAVICON ?>" width="37" class="padding-small left" style="width: 37px">
                <span class="left upper color-text-grey">construindo sonhos</span>
            </h4>
        </div>
        <div class="col padding-48">
            <div class="col s12 m4">
                <div class="col align-center">
                    <img src="<?= HOMEDEV ?>/assets/img/like.svg" class="c-construindo-sonhos-images">
                </div>
                <p class="col padding-24 align-center">
                    Mais do que construir residências nosso compromisso é com o projeto de vida das pessoas.
                </p>
            </div>
            <div class="col s12 m4">
                <div class="col align-center">
                    <img src="<?= HOMEDEV ?>/assets/img/predio.svg" class="c-construindo-sonhos-images">
                </div>
                <p class="col padding-24 align-center">
                    Executar edificações com o melhor custo/benefício, gerando resultados crescentes e sólidos.
                </p>
            </div>
            <div class="col s12 m4">
                <div class="col align-center">
                    <img src="<?= HOMEDEV ?>/assets/img/calendario.svg" class="c-construindo-sonhos-images">
                </div>
                <p class="col padding-24 align-center">
                    Nossos empreendimentos são todos entregues perfeitamente entregue dentro dos prazos estabelecidos.
                </p>
            </div>
        </div>

        <div class="col color-yellow padding-tiny"></div>

        <div class="col font-large font-weight-bold color-text-grey padding-48 align-center upper">
            Mais de uma decada realizando sonhos
        </div>
    </div>
</section>

<section class="row color-grey-light">
    <div class="col c-container padding-24">
        <div class="col padding-24"></div>
        <div class="col border-bottom">
            <h4 class="left c-empreendimentos padding-0 margin-0">
                <img src="<?= FAVICON ?>" width="37" class="padding-small left" style="width: 37px">
                <span class="left upper color-text-grey-dark">Empreendimentos</span>
            </h4>

            <div class="right">
                <ul class="padding-0 font-large margin-0 pointer list-empreendimentos">
                    <li rel="entregue"
                        class="empreendimento-status right color-text-grey-dark hover-opacity-off opacity padding-small active">
                        Entregues
                    </li>
                    <li rel="em-andamento"
                        class="empreendimento-status right color-text-grey-dark hover-opacity-off opacity padding-small">
                        Em construção
                    </li>
                </ul>
            </div>

        </div>
        <div class="col padding-48">
            <?php
            $read->exeRead("empreendimentos", "ORDER BY ID DESC LIMIT 12");
            if ($read->getResult()) {
                $construindo = 0;
                $emAndamento = 0;
                foreach ($read->getResult() as $item) {
                    $item['status'] = $item['andamento_da_obra'] === '3';

                    if($item['status'])
                        $construindo ++;
                    else
                        $emAndamento ++;

                    if(($item['status'] && $construindo < 4) || (!$item['status'] && $emAndamento < 4)) {
                        if (!empty($item['endereco'])) {
                            $endereco = \Entity\Entity::read("endereco", $item['endereco']);
                            $item['local'] = $endereco['logradouro'] . "/" . $endereco['cep']['cidade']['estado']['sigla'];
                        } else {
                            $item['local'] = "";
                        }
                        $item['background'] = \Helpers\Helper::convertImageJson($item['background']);
                        $item['imagem_do_empreendimento'] = \Helpers\Helper::convertImageJson($item['imagem_do_empreendimento']);
                        $tpl->show("empreendimento", $item);
                    }
                }
            }

            ?>
        </div>
    </div>
</section>

<section class="row c-background-contato">
    <div class="col padding-48 c-container">
        <div class="col s12 m8">
            <div class="align-center">
                <h4 class="col upper padding-0">Central de <b>Vendas</b></h4>
            </div>
            <div class="col align-center font-large">Fale com nossos corretores online ou por telefone!</div>
        </div>
        <div class="s12 m4">
            <button class="btn-large upper color-text-white" style="padding:13px 50px; background: #444">Contato
            </button>
        </div>
    </div>
</section>

<section class="row color-grey-light">
    <div class="col padding-12 c-container">
        <div class="col padding-16"></div>
        <div class="col padding-24">
            <h4 class="align-centers c-midia">
                <img src="<?= FAVICON ?>" width="37" class="padding-small left" style="width: 37px">
                <span class="left upper color-text-grey font-light">notícias - <b><?= SITENAME ?> nas Mídias</b></span>
            </h4>
        </div>
        <div class="col padding-24">
            <div class="col c-noticia-arrow pointer no-select" id="prevNoticia">
                <img src="<?= HOMEDEV ?>assets/img/arrow-circle.png">
            </div>
            <div class="col right c-noticia-arrow pointer c-arrow-invert no-select" id="nextNoticia">
                <img src="<?= HOMEDEV ?>assets/img/arrow-circle.png">
            </div>
            <div class="rest">
                <?php
                $read->exeRead("noticias", "ORDER BY ID DESC LIMIT 6");
                if ($read->getResult()) {
                    $i = 0;
                    foreach ($read->getResult() as $item) {
                        $data = new \Helpers\DateTime();
                        $item['hide'] = $i > 2 ? "hide" : "";
                        $item['imagem'] = HOME . json_decode($item['imagem'], true)[0]['url'];
                        $item['data'] = $data->getDateTime($item['data'], "d \d\\e M \d\\e Y");
                        $tpl->show("noticias", $item);
                        $i++;
                    }
                }
                ?>
            </div>
        </div>

        <div class="col padding-32"></div>

        <div class="col padding-tiny" style="background: #DDD"></div>

        <div class="left col">
            <div class="col c-container2">
                <div class="col padding-48" style="width: 190px">
                    <img src="<?= HOMEDEV ?>assets/img/cub.svg" class="left">
                </div>
                <div class="rest padding-32">
                    <h4 class="font-weight-bold color-text-grey">Indicadores Financeiros &nbsp;|&nbsp; Cube/2006
                        ABNT/NBR</h4>
                    <div class="col s12 m6 color-text-grey" style="border-right: solid 2px #AAAAAA">
                        <div class="col s12 m4 font-weight-bold">
                            Março
                        </div>
                        <div class="col s12 m4">
                            1.753,61
                        </div>
                        <div class="col s12 m4">
                            0,22%
                        </div>
                    </div>
                    <div class="col s12 m6 color-text-grey">
                        <div class="col s12 m4 font-weight-bold">
                            Fevereiro
                        </div>
                        <div class="col s12 m4">
                            1.749,71
                        </div>
                        <div class="col s12 m4">
                            0,15%
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col padding-tiny margin-bottom" style="background: #DDD"></div>

        <div class="col padding-12"></div>
        <div class="col font-large color-text-grey-dark padding-24 align-center">
            Entre em contato conosco e receba mais informações sobre o imóvel dos seus sonhos
        </div>
    </div>
</section>

<?php
require_once 'inc/footer.php';
?>
