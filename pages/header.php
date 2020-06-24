<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" type="image/x-icon" href=""  />

    <title>Buscapet</title>

    <link href="https://fonts.googleapis.com/css2?family=Carter+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/w/bs4/dt-1.10.18/fh-3.1.4/r-2.2.2/sc-2.0.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/w/bs4/dt-1.10.18/fh-3.1.4/r-2.2.2/sc-2.0.0/datatables.min.js"></script>
</head>
<style>
    body {
        font-size: 16px;
        background: #e5f7ff;
        padding-top: 100px;
        padding-bottom: 100px;
    }

    .card {
        margin-bottom: 10px;
    }

    .navbar {
        padding-top: 5px;
        padding-bottom: 5px;
        border-bottom: 4px solid #73c1ff;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, .05);
        background: #ffffff !important;
    }

    .navbar-brand {
        font-family: 'Carter One', cursive;
        color: #212529;
    }

    .navbar .navbar-nav .nav-link {
        padding: 10px 15px;
        font-weight: bold;
    }

    .navbar .navbar-nav .nav-item {
        color: #fff;
        border-bottom: 3px solid transparent;
        transition: all .2s ease-out;
    }

    .navbar .navbar-nav .nav-item:focus, .navbar .navbar-nav .nav-item:hover {
        border-bottom: 3px solid #fff;
    }

    .main-logo {
        width: 540px;
        height: 460px;
        position: fixed;
        margin-top: -230px;
        top: 50%;
        margin-left: -270px;
        left: 50%;
    }

    .main-logo-image {
        height: 350px;
        text-align: center;
        font-size: 60px;
        margin: 0 auto 20px auto;
        background: url(images/logo.png) center/contain no-repeat;
    }

    .main-logo-title {
        font-family: 'Carter One', cursive;
        font-size: 60px;
        text-align: center;
        margin-bottom: 20px;
    }

    .btn-primary {
        background: #2196f3;
    }

    .btn-outline-primary {
        border-color: #2196f3;
        color: #2196f3;
    }

    .btn-outline-primary:hover {
        background: #2196f3;
    }

    .media .dog-picture {
        width: 100px;
        height: 100px;
        background-position: center;
        background-size: cover;
        margin-right: 20px;
    }

    .media .dog-name {
        margin-bottom: 0;
        margin-top: 20px;
    }

    .media .dog-race {
        font-size: 15px;
    }

    .media .dog-created {
        font-size: 13px;
        float: right;
        margin-right: 10px;
        margin-top: 10px;
    }

    #animals-list .list-group-item {
        padding: 0px;
        overflow: hidden;
    }

    .footer {
        background: #fff;
        padding: 10px;
        border-top: 3px solid #73c1ff;
        margin-top: 30px;
        color: rgba(0,0,0,.6);
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .animal-image-preview {
        width: 100px;
        height: 100px;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 5px;
        margin-right: 15px;
        margin-bottom: 10px;
        background-position: center;
        background-size: cover;
    }
</style>
<body>
<script>
    function performAjax(endpoint, body, callback) {
        $.ajax({
            url: "/callback/" + endpoint,
            method: "POST",
            data: body,
            headers: {'Content-Type': undefined}
        }).done(callback);
    }
</script>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" style="font-size: 14px;">
    <div class="container">
        <a class="navbar-brand" href="/inicio">Buscapet</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav  mr-auto">
                <?php if(Usuario::isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/inicio">Página Inicial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Meus Animais</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/contato">Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sobre">Sobre Nós</a>
                </li>
            </ul>
            <?php if(!Usuario::isLoggedIn()): ?>
            <form class="form-inline">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Acesse sua Conta</button>
                <span style="font-size: 20px; margin-left: 10px; margin-right: 10px">ou</span>
                <a type="button" class="btn btn-outline-primary" href="/registro">Crie uma agora!</a>
            </form>
            <?php else: ?>
                <form class="form-inline">
                    <a class="btn btn-success" href="/animal_novo" style="margin-right: 10px">Adicionar Animal</a>
                    <a class="btn btn-outline-danger" href="/logout">Sair da Conta</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php
if(!Usuario::isLoggedIn()):
?>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Acesse sua Conta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if(isset($_GET['error'])):
                ?>
                <script>
                    $('#loginModal').modal('show');
                </script>
                <div class="alert alert-danger" role="alert">
                    <?=urldecode($_GET['error']);?>
                </div>
                <?php endif; ?>
                <form method="post" action="/callback/login">
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" placeholder="E-mail" name="email" value="<?=(isset($_GET['email'] )? urldecode($_GET['email']) : "");?>" required="">
                    </div>
                    <div class="form-group">
                        <label>Senha</label>
                        <input type="password" class="form-control" placeholder="Senha" name="senha" required="">
                    </div>
                    <button type="submit"  style="float: right" class="btn btn-success">Entrar</button>
                    <div class="btn btn-outline-primary">Registre-se</div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
endif;
?>
<div class="container">