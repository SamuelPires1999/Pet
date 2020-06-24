<?php include "header.php"; ?>
<div class="card">
    <form method="post" action="/callback/register" enctype="multipart/form-data">
        <div class="card-body" id="registro_usuario">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title">Dados Básicos</h5>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="1" placeholder="Nome" name="usuario_nome" required="">
                    </div>
                    <div class="form-group">
                        <label>Telefone<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="2" placeholder="Telefone" name="usuario_telefone" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CPF<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="1" placeholder="CPF" name="usuario_cpf" required="">
                    </div>
                    <div class="form-group">
                        <label>E-mail<span style="color: red">*</span></label>
                        <input type="email" class="form-control" tabindex="3" placeholder="E-mail" name="usuario_email" required="">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title">Acesso</h5>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Senha<span style="color: red">*</span></label>
                        <input type="password" class="form-control" tabindex="4" placeholder="Senha" name="usuario_senha" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirmar Senha<span style="color: red">*</span></label>
                        <input type="password" class="form-control" tabindex="5" placeholder="Confirmar Senha" name="usuario_confirmar_senha" required="">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5 class="card-title">Endereço</h5>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Rua<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="6" placeholder="Rua" name="usuario_rua" required="">
                    </div>
                    <div class="form-group">
                        <label>Cidade<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="8" placeholder="Cidade" name="usuario_cidade" required="">
                    </div>
                    <div class="form-group">
                        <label>Número<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="10" placeholder="Número" name="usuario_numero" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Bairro<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="7" placeholder="Bairro" name="usuario_bairro" required="">
                    </div>
                    <div class="form-group">
                        <label>Estado<span style="color: red">*</span></label>
                        <input type="text" class="form-control" tabindex="9" placeholder="Estado" name="usuario_estado" required="">
                    </div>
                    <div class="form-group">
                        <label>Complemento</label>
                        <input type="text" class="form-control" tabindex="11" placeholder="Complemento" name="usuario_complemento">
                    </div>
                </div>
                <div class="col-md-12">
                    <span><span style="color: red">*</span> Campos obrigatórios</span>
                    <button type="button"  style="float: right" class="btn btn-success" tabindex="12" onclick="trocarPasso('registro_animal')">Próximo</button>
                </div>
            </div>
        </div>
        <div class="card-body" id="registro_animal" style="display:none">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Tipo de Cadastro<span style="color: red">*</span></label>
                        <input type="hidden" name="animal_tipo_cadastro">
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-lg btn-primary btn-block" type="button" id="tipo_perdi" onclick="trocarTipo(1)">Perdi um Animal</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-lg btn-primary btn-block" type="button" id="tipo_encontrei" onclick="trocarTipo(2)">Encontrei um Animal</button>
                </div>
            </div>
            <div class="row" id="animal_dados" style="display: none">
                <div class="col-md-12">
                    <hr>
                    <h5 class="card-title">Dados Básicos</h5>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo do Animal<span style="color: red">*</span></label>
                        <select class="custom-select" name="animal_id_tipo" required>
                            <option disabled selected value="">Escolha...</option>
                            <?php
                            foreach(DB::query("SELECT id, nome FROM tipo")->fetchAll(PDO::FETCH_ASSOC) as $item):
                                ?>
                                <option value="<?=$item['id'];?>"><?=$item['nome'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Porte do Animal<span style="color: red">*</span></label>
                        <select class="custom-select" name="animal_porte" required>
                            <option disabled selected value="">Escolha...</option>
                            <option value="pequeno">Pequeno</option>
                            <option value="medio">Médio</option>
                            <option value="grande">Grande</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Raça do Animal<span style="color: red">*</span></label>
                        <select class="custom-select" name="animal_id_raca" required>
                            <option disabled selected value="">Escolha...</option>
                            <?php
                            foreach(DB::query("SELECT id, id_tipo, nome FROM raca")->fetchAll(PDO::FETCH_ASSOC) as $item):
                                ?>
                                <option value="<?=$item['id'];?>" id-tipo="<?=$item['id_tipo'];?>" style="display: none"><?=$item['nome'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Cor dos Pelos<span style="color: red">*</span></label>
                        <input type="text" class="form-control" placeholder="Cor dos Pelos" name="animal_cor_pelos" required="">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5 class="card-title">Dados Detalhados</h5>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nome que Atende<span style="color: red">*</span></label>
                        <input type="text" class="form-control" placeholder="Nome que Atende" name="animal_nome_atende" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Idade do Animal (em anos)</label>
                        <input type="number" class="form-control" placeholder="Idade do Animal" name="animal_idade">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Local onde o Animal foi visto pela última vez<span style="color: red">*</span></label>
                        <input type="text" class="form-control" placeholder="..." name="animal_local_referencia">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sexo<span style="color: red">*</span></label>
                        <select class="custom-select" name="animal_sexo" required>
                            <option disabled selected value="">Escolha...</option>
                            <option value="femea">Fêmea</option>
                            <option value="macho">Macho</option>
                            <option value="desconhecido">Desconhecido</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Doenças e Cuidados</label>
                        <input type="text" class="form-control" placeholder="Doeças e Cuidados" name="animal_doencas_cuidados">
                    </div>
                    <div class="media">
                        <div class="animal-image-preview"></div>
                        <div class="media-body">
                            <div class="form-group">
                                <label>Foto do Animal<span style="color: red">*</span></label>
                                <div><input type="file" name="animal_foto" required></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <span><span style="color: red">*</span> Campos obrigatórios</span>
                    <button type="submit"  style="float: right" class="btn btn-success">Finalizar Cadastro</button>
                    <button type="button"  style="float: right; margin-right: 10px" class="btn btn-primary" onclick="trocarPasso('registro_usuario')">Voltar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $("input[name='animal_foto']").on("change", function() {
        console.log("a")
        var reader = new FileReader();
        reader.onloadend = function() {
            $(".animal-image-preview").css("background-image", "url(" + reader.result + ")");
        };
        reader.readAsDataURL($(this).prop('files')[0]);
    });

    $("select[name='animal_id_tipo']").on("change", function() {
        $("select[name='animal_id_raca'] option:not(:disabled)").css("display", "none");
        $("select[name='animal_id_raca'] option[id-tipo='" + $(this).val() + "']").css("display", "flex");
    });

    var tipoSelecionado = 0;
    var passoAtual = "registro_usuario";

    function trocarTipo(tipo) {
        if(tipo == tipoSelecionado)
            return;

        if(tipo == 1) {
            $("#tipo_perdi").removeClass("btn-outline-primary").addClass("btn-primary");
            $("#tipo_encontrei").removeClass("btn-primary").addClass("btn-outline-primary");
            $("input[name='animal_nome_atende']").attr("required", "required").parent().children("label").html('Nome que Atende<span style="color: red">*</span>');
            $("input[name='animal_local']").parent().children("label").html('Local onde o Animal foi visto pela última vez<span style="color: red">*</span>');
            $("input[name='animal_tipo_cadastro']").val("perdido");
        } else {
            $("#tipo_perdi").removeClass("btn-primary").addClass("btn-outline-primary");
            $("#tipo_encontrei").removeClass("btn-outline-primary").addClass("btn-primary");
            $("input[name='animal_nome_atende']").removeAttr("required").parent().children("label").html('Nome que Atende');
            $("input[name='animal_local']").parent().children("label").html('Local onde o Animal foi encontrado<span style="color: red">*</span>');
            $("input[name='animal_tipo_cadastro']").val("encontrado");
        }

        $("#animal_dados").css("display", "flex");
    }

    function trocarPasso(passo) {
        let campoFaltante = false;

        if(passoAtual == "registro_usuario") {
            $("#" + passoAtual + " input[required]").each(function() {
                if($(this).val() === "") {
                    alert("Preencha todos os campos obrigatórios antes de prosseguir!");
                    campoFaltante = true;
                    return false;
                }
            });
        }

        if(!campoFaltante) {
            $("#" + passoAtual).css("display", "none");
            $("#" + passo).css("display", "block");
            passoAtual = passo;
        }
    }
</script>
<?php include "footer.php"; ?>