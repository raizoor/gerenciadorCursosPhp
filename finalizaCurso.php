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

    function finalizarCursoBanco($login,$curso){

        $conn = new mysqli("localhost","root","","dbFacul");
    
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("UPDATE acessos
        INNER JOIN cursos ON cursos.idcurso = acessos.idcurso
        INNER JOIN usuarios ON usuarios.iduser = acessos.iduser
        SET acessos.iscursando = 'n'
        WHERE usuarios.login = ?
        AND cursos.nome = ?");

        $query->bind_param("ss",$login,$curso);
        $query->execute();

        apresentarTela();
    }

    function apresentarTela(){

        echo "<br><h1>Curso encerrado com sucesso!</h1>";
        echo "<button type='button' onclick=window.location.href='infosUsuario.php'> Concluir";
    }

    $curso = validarCamposText($_POST['cursos']);
    $login = validarCamposText($_SESSION['login']);
    finalizarCursoBanco($login,$curso);
?>