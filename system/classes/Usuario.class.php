<?php
require_once "Basic.class.php";

class Usuario extends Basic {

    public $id = null;
    public $nome;
    public $cpf;
    public $telefone;
    public $email;
    public $senha;
    public $rua;
    public $bairro;
    public $cidade;
    public $estado;
    public $numero;
    public $complemento = null;
    public $admin = false;
    public $datahora_cadastro;
    public $datahora_modificado;

    public static function select($keyColumn, $value, $returnObject = null) {
        return parent::select($keyColumn, $value, new Usuario());
    }

    public static function selectAll($filters, $orderBy = null, $orderDirection = "ASC", $limit = 100, $offset = 0, $returnObject = null) {
        return parent::selectAll($filters, $orderBy, $orderDirection, $limit, $offset, new Usuario());
    }

    public static function update($object, $keyColumn = null) {
        return parent::update($object, "id");
    }

    public static function isLoggedIn() {
        return isset($_SESSION['id_usuario']);
    }

    public static function getLoggedIn() {
        return self::select("id", $_SESSION['id_usuario']);
    }

    public static function hash($string) {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    public static function tryLogin($email, $password) {
        if ($email == "" || $password == "")
            return ["status" => "error", "msg" => "E-mail e/ou senha incorreto(s)."];

        $hashedPassword = self::hash($password);
        $stmt = DB::prepare("SELECT id,email,senha FROM usuario WHERE email = :email LIMIT 1;");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!password_verify($password, $userData['senha']))
                return ["status" => "error", "msg" => "E-mail e/ou senha incorreto(s)."];

            $_SESSION['id_usuario'] =  $userData['id'];

            return ["status" => "success", "msg" => "<b>Sucesso!</b> Você será redirecionado(a) em instantes..."];
        } else
            return ["status" => "error", "msg" => "E-mail e/ou senha incorreto(s)."];
    }

    public static function tryRegister($usuario, $confirmPassword, $animal) {
        if ($usuario->getSenha() != $confirmPassword)
            return ['status' => 'error', 'msg' => 'As senhas não coincidem!'];

        $usuario->setSenha(self::hash($usuario->getSenha()));

        if(!filter_var($usuario->getEmail(), FILTER_VALIDATE_EMAIL))
            return ['status' => 'error', 'msg' => 'E-mail inválido!'];

        if (self::select("email", $usuario->getEmail(), new Usuario()) != null)
            return ['status' => 'error', 'msg' => 'E-mail indisponível!'];

        if (self::select("cpf", $usuario->getCpf(), new Usuario()) != null)
            return ['status' => 'error', 'msg' => 'CPF indisponível!'];

        $userId = Usuario::insert($usuario);

        $animal->setId_usuario($userId);
        Animal::insert($animal);

        if($userId != null) {
            $_SESSION['id_usuario'] = $userId;
            return ['status' => 'success', 'msg' => 'Usuário cadastrado com sucesso!'];
        }
    }
}