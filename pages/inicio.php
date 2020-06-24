<?php include "header.php"; ?>
<div class="row">
    <div class="col-md-4">
        <div class="card" style="margin-bottom: 10px">
            <div class="card-body">
                <h5 class="card-title">Olá, <?=Usuario::getLoggedIn()->getNome();?>!</h5>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <button class="btn btn-primary" data-toggle="collapse" data-target="#filtros" style="float: right" aria-expanded="false">
            Filtrar Resultados
        </button>
        <h4 style="line-height: 50px">Animais Adicionados Recentemente</h4>
        <div class="collapse" id="filtros">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo do Animal</label>
                                <select class="custom-select" name="animal_id_tipo">
                                    <option value="0">Não aplicar</option>
                                    <?php
                                    foreach(DB::query("SELECT id, nome FROM tipo")->fetchAll(PDO::FETCH_ASSOC) as $item):
                                        ?>
                                        <option <?=(isset($_GET['filtro_id_tipo']) && $_GET['filtro_id_tipo'] == $item['id'] ? "selected" : "");?> value="<?=$item['id'];?>"><?=$item['nome'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Raça do Animal</label>
                                <select class="custom-select" name="animal_id_raca">
                                    <option value="0">Não aplicar</option>
                                    <?php
                                    foreach(DB::query("SELECT id, id_tipo, nome FROM raca")->fetchAll(PDO::FETCH_ASSOC) as $item):
                                        ?>
                                        <option <?=(isset($_GET['filtro_id_raca']) && $_GET['filtro_id_raca'] == $item['id'] ? "selected" : "");?> value="<?=$item['id'];?>" id-tipo="<?=$item['id_tipo'];?>" style="display: none"><?=$item['nome'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sexo do Animal</label>
                                <select class="custom-select" name="animal_sexo">
                                    <option value="0">Não aplicar</option>
                                    <option <?=(isset($_GET['filtro_sexo']) && $_GET['filtro_sexo'] == "femea" ? "selected" : "");?> value="femea">Fêmea</option>
                                    <option <?=(isset($_GET['filtro_sexo']) && $_GET['filtro_sexo'] == "macho" ? "selected" : "");?> value="macho">Macho</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success btn-block" onclick="applyFilters()">Aplicar Filtros</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="list-group" id="animals-list">
            <?php
                $filters = [];
                if(isset($_GET['filtro_id_tipo']) && $_GET['filtro_id_tipo'] != 0) {
                    $filters["id_tipo"] = $_GET['filtro_id_tipo'];
                    ?>
                <script>  $("select[name='animal_id_raca'] option[id-tipo='<?=$_GET['filtro_id_tipo'];?>']").css("display", "flex");</script>
                <?php
                }

                if(isset($_GET['filtro_id_raca']) && $_GET['filtro_id_raca'] != 0) {
                    $filters["id_raca"] = $_GET['filtro_id_raca'];
                }

                if(isset($_GET['filtro_sexo']) && $_GET['filtro_sexo'] != 0) {
                    $filters["sexo"] = $_GET['filtro_sexo'];
                }

                foreach(Animal::selectAll($filters, "id", "DESC") as $animal):
            ?>
            <a href="/animal?id_animal=<?=$animal->getId();?>" class="list-group-item list-group-item-action">
                <div class="media">
                    <div class="dog-picture" style="background-image: url(data:image/png;base64,<?= base64_encode($animal->getFoto());?>)"></div>
                    <div class="media-body">
                        <h5 class="dog-name">
                            <?=($animal->getNome_atende() != null ? $animal->getNome_atende() : "Desconhecido");?> <?php if($animal->getSexo() != "desconhecido") :?><img src="images/icon_sexo_<?=$animal->getSexo();?>.png" width="30"><?php endif; ?>
                            <span class="badge badge-secondary" style="float: right; margin-right: 10px; font-size: 12px"><?=getTimeAgo(strtotime($animal->getDatahora_cadastro()));?></span>
                            <span class="badge badge-secondary" style="float: right; margin-right: 10px; font-size: 12px"><?=ucfirst($animal->getTipo_cadastro());?></span>
                        </h5>
                        <div class="dog-race"><?=$animal->getTipo()->getNome();?> - <?=$animal->getRaca()->getNome();?></div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    function applyFilters() {
        var tipo = $("select[name='animal_id_tipo']").val();
        var raca = $("select[name='animal_id_raca']").val();
        var sexo = $("select[name='animal_sexo']").val();

        var filterUrl = "";
        if(filterUrl == "")
            filterUrl = "?filtro_id_tipo=" + tipo;
        else
            filterUrl += "&filtro_id_tipo=" + tipo;

        if (filterUrl == "")
            filterUrl = "?filtro_id_raca=" + raca;
        else
            filterUrl += "&filtro_id_raca=" + raca;

        if (filterUrl == "")
            filterUrl = "?filtro_sexo=" + sexo;
        else
            filterUrl += "&filtro_sexo=" + sexo;

        location.href = "/inicio" + filterUrl;
    }

    $("select[name='animal_id_tipo']").on("change", function() {
        $("select[name='animal_id_raca'] option:not(:first-child)").css("display", "none");
        $("select[name='animal_id_raca'] option[id-tipo='" + $(this).val() + "']").css("display", "flex");
    });
</script>
<?php include "footer.php"; ?>