<?php

if(!isset($_GET['id_animal'])) {
    header("Location: /inicio");
    exit();
}

$animal = Animal::select("id", $_GET['id_animal']);

if($animal == null) {
    header("Location: /inicio");
    exit();
}

include "header.php";
?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="dog-picture" style="border: 2px solid rgba(0, 0, 0, .1);border-radius: 5px; width: 150px; height: 150px; background-image: url(data:image/png;base64,<?= base64_encode($animal->getFoto());?>)"></div>
                        <div class="media-body">
                            <span class="badge badge-secondary" style="float: right; font-size: 12px">Adicionado a <?=getTimeAgo(strtotime($animal->getDatahora_cadastro()));?></span>
                            <span class="badge badge-secondary" style="float: right; margin-right: 10px; font-size: 12px"><?=ucfirst($animal->getTipo_cadastro());?></span>
                            <h5 class="dog-name"><?=($animal->getNome_atende() != null ? $animal->getNome_atende() : "Desconhecido");?></h5>
                            <?php if($animal->getSexo() != "desconhecido") :?><img src="images/icon_sexo_<?=$animal->getSexo();?>.png" width="40"><?php endif; ?>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-3">
                                    <h6 class="card-title">Tipo</h6>
                                    <h6 class="card-subtitle mb-2 text-muted"><?=$animal->getTipo()->getNome();?></h6>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="card-title">Raça</h6>
                                    <h6 class="card-subtitle mb-2 text-muted"><?=$animal->getRaca()->getNome();?></h6>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="card-title">Porte</h6>
                                    <h6 class="card-subtitle mb-2 text-muted"><?=ucfirst($animal->getPorte());?></h6>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="card-title">Idade</h6>
                                    <h6 class="card-subtitle mb-2 text-muted"><?=($animal->getIdade() > 0 ? $animal->getIdade()." anos" : "Desconhecida");?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                        if($animal->getDoencas_cuidados() != null):
                    ?>
                    <h6 class="card-title">Doenças e Cuidados</h6>
                    <p class="card-text"><?=$animal->getDoencas_cuidados();?></p>
                    <?php endif; ?>
                    <?php
                        if($animal->getTipo_cadastro() == "perdido"):
                    ?>
                    <h6 class="card-title">Local onde o Animal foi visto pela última vez</h6>
                    <?php
                        else:
                    ?>
                        <h6 class="card-title">Local onde o Animal foi encontrado</h6>
                    <?php endif; ?>
                    <p class="card-text"><?=$animal->getLocal_referencia();?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="margin-bottom: 10px">
                <div class="card-body">
                    <h6 class="card-title">Ações</h6>
                    <?php
                        if($animal->getUsuario()->getId() != Usuario::getLoggedIn()->getId()):
                    ?>
                    <button class="btn btn-primary btn-block">Solicitar Contato</button>
                    <?php else: ?>
                    <button class="btn btn-danger btn-block">Encerrar Caso</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("select[name='animal_id_tipo']").on("change", function() {
            $("select[name='animal_id_raca'] option:not(:disabled)").css("display", "none");
            $("select[name='animal_id_raca'] option[id-tipo='" + $(this).val() + "']").css("display", "flex");
        });
    </script>
<?php include "footer.php"; ?>