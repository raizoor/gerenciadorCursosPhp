<?php

    require_once("config.php");

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        
        throw new Exception("Operação recebida não condiz com o esperado");
    }

    $requisicao = $_POST;

    function validarCamposText($text){

        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        $text = strtolower($text);

        return $text;
    }

    function realizarLogin($login, $password){

        $conn = new mysqli("localhost","root","","dbFacul");
        
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("SELECT senha FROM usuarios WHERE login = ?");
        $query->bind_param("s",$login);
        $query->execute();
        $result = $query->get_result();
        $result = $result->fetch_assoc();
        $senhaBanco = $result['senha'];

        if(password_verify($password, $senhaBanco)){

            $_SESSION['login'] = $login;
            validarPermissao(validarPerfilUsuario($login));
        } else{

            echo "<br><h1> Senha incorreta ou conta não existe</h1>";
            echo "<button type='button' onclick=window.location.href='cadastro.html'> Cadastrar usuário";
            echo "<button type='button' onclick=window.location.href='logoff.php'> Sair";
        }
    }

    function validarPermissao($perfil){

        if(strcmp($perfil,"administrador") == 0){
            
            header('location: infosAdministrador.php');
        }
        
        if(strcmp($perfil,"aluno") == 0) {
            
            header('location: infosUsuario.php');
        }
    }

    function validarPerfilUsuario($login){
        
        $conn = new mysqli("localhost","root","","dbFacul");
        
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }
        
        $query = $conn->prepare("SELECT perfil FROM usuarios WHERE login = ?");
        $query->bind_param("s",$login);
        $query->execute();
        $result = $query->get_result();

        $result = $result->fetch_assoc();

        return $result['perfil'];
    }

    $login = validarCamposText($requisicao['login']);

    realizarLogin($login,$requisicao['password']);
?>