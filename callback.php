<?php
if(!isset($_GET['callback']))
    exit("Nenhuma solicitação.");
else
    $callback = $_GET['callback'];

include "system/global.php";
global $config;

if(!in_array($callback, array_keys($config['callbacks'])))
    exit("Não encontrada.");

if(!Usuario::isLoggedIn() && $config['callbacks'][$callback])
    exit("Não pode.");

switch($callback) {
    case "login":
        if(!isset($_POST['email']) | !isset($_POST['senha']))
            exit();

        $result = Usuario::tryLogin($_POST['email'], $_POST['senha']);
var_dump($result);
        if($result['status'] == "success") {
            header("Location: /inicio");
            exit();
        } else {
            header("Location: /login?email=".$_POST['email']."&error=".urlencode($result['msg']));
            exit();
        }
        break;
    case "register":
          if(
            !isset($_POST['usuario_nome']) |
            !isset($_POST['usuario_cpf']) |
            !isset($_POST['usuario_telefone']) |
            !isset($_POST['usuario_email']) |
            !isset($_POST['usuario_senha']) |
            !isset($_POST['usuario_confirmar_senha']) |
            !isset($_POST['usuario_rua']) |
            !isset($_POST['usuario_bairro']) |
            !isset($_POST['usuario_cidade']) |
            !isset($_POST['usuario_estado']) |
            !isset($_POST['usuario_numero'])
        )
            exit("Missing fields in Usuario.");

        if(
            !isset($_POST['animal_id_tipo']) |
            !isset($_POST['animal_id_raca']) |
            !isset($_POST['animal_nome_atende']) |
            !isset($_POST['animal_cor_pelos']) |
            !isset($_POST['animal_porte']) |
            !isset($_POST['animal_idade']) |
            !isset($_POST['animal_doencas_cuidados']) |
            !isset($_POST['animal_local_referencia']) |
            !isset($_POST['animal_sexo']) |
            !isset($_POST['animal_tipo_cadastro']) |
            !isset($_FILES['animal_foto'])
        )
            exit("Missing fields in Animal.");

        $usuario = new Usuario();
        $usuario = $usuario->setNome($_POST['usuario_nome']);
        $usuario->setCpf($_POST['usuario_cpf']);
        $usuario->setTelefone($_POST['usuario_telefone']);
        $usuario->setEmail($_POST['usuario_email']);
        $usuario->setSenha($_POST['usuario_senha']);
        $usuario->setRua($_POST['usuario_rua']);
        $usuario->setBairro($_POST['usuario_bairro']);
        $usuario->setCidade($_POST['usuario_cidade']);
        $usuario->setEstado($_POST['usuario_estado']);
        $usuario->setNumero($_POST['usuario_numero']);

        $animal = new Animal();
        $animal->setId_tipo($_POST['animal_id_tipo']);
        $animal->setId_raca($_POST['animal_id_raca']);
        $animal->setNome_atende($_POST['animal_nome_atende']);
        $animal->setCor_pelos($_POST['animal_cor_pelos']);
        $animal->setPorte($_POST['animal_porte']);
        $animal->setIdade($_POST['animal_idade']);
        $animal->setDoencas_cuidados($_POST['animal_doencas_cuidados']);
        $animal->setLocal_referencia($_POST['animal_local_referencia']);
        $animal->setSexo($_POST['animal_sexo']);
        $animal->setTipo_cadastro($_POST['animal_tipo_cadastro']);
        $animal->setFoto(file_get_contents($_FILES['animal_foto']['tmp_name']));

        $result = Usuario::tryRegister($usuario, $_POST['usuario_confirmar_senha'], $animal);

        if($result['status'] == "success") {
            header("Location: /inicio");
            exit();
        } else {
            echo '<script>alert("'.$result['msg'].'")</script>';
            header("Location: /login");
            exit();
        }
        break;
    case "animal_novo":
        if(
            !isset($_POST['animal_id_tipo']) |
            !isset($_POST['animal_id_raca']) |
            !isset($_POST['animal_nome_atende']) |
            !isset($_POST['animal_cor_pelos']) |
            !isset($_POST['animal_porte']) |
            !isset($_POST['animal_idade']) |
            !isset($_POST['animal_doencas_cuidados']) |
            !isset($_POST['animal_local_referencia']) |
            !isset($_POST['animal_sexo']) |
            !isset($_POST['animal_tipo_cadastro']) |
            !isset($_FILES['animal_foto'])
        )
            exit("Missing fields in Animal.");

        $animal = new Animal();
        $animal->setId_tipo($_POST['animal_id_tipo']);
        $animal->setId_raca($_POST['animal_id_raca']);
        $animal->setNome_atende($_POST['animal_nome_atende']);
        $animal->setCor_pelos($_POST['animal_cor_pelos']);
        $animal->setPorte($_POST['animal_porte']);
        $animal->setIdade($_POST['animal_idade']);
        $animal->setDoencas_cuidados($_POST['animal_doencas_cuidados']);
        $animal->setLocal_referencia($_POST['animal_local_referencia']);
        $animal->setSexo($_POST['animal_sexo']);
        $animal->setTipo_cadastro($_POST['animal_tipo_cadastro']);
        $animal->setFoto(file_get_contents($_FILES['animal_foto']['tmp_name']));
        $animal->setId_usuario(Usuario::getLoggedIn()->getId());
        $result = Animal::insert($animal);

        if($result != null) {
            header("Location: /inicio");
            exit();
        } else {
            echo '<script>alert("'.$result['msg'].'")</script>';
            header("Location: /login");
            exit();
        }
        break;
}
