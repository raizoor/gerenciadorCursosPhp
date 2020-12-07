<?php

    require_once("config.php");

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        
        throw new Exception("Operação recebida não condiz com o esperado");
    }

    function validarCamposText($text){

        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        $text = strtolower($text);
    
        return $text;
    }

    function finalizarMatriculaBanco($login,$curso){

        $conn = new mysqli("localhost","root","","dbFacul");
    
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("INSERT INTO acessos (iduser,idcurso) VALUES (
            (SELECT iduser FROM usuarios WHERE login = ?),
            (SELECT idcurso FROM cursos WHERE nome = ?))"
            );
        
        $query->bind_param("ss",$login,$curso);
        $query->execute();

        apresentarTela();
    }

    function apresentarTela(){

        echo "<br><h1>Matrícula finalizada com sucesso!</h1>";
        echo "<button type='button' onclick=window.location.href='infosUsuario.php'> Concluir";
    }

    $curso = validarCamposText($_POST['cursos']);
    $login = validarCamposText($_SESSION['login']);

    finalizarMatriculaBanco($login, $curso);
?>