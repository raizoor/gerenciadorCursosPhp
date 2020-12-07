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

    function excluirCursoBancoAcessos($curso){

        $conn = new mysqli("localhost","root","","dbFacul");
    
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("DELETE a FROM acessos a
        INNER JOIN cursos c ON a.idcurso = c.idcurso
        WHERE c.nome = ?");

        $query->bind_param("s",$curso);
        $query->execute();

        excluirCursoBancoCursos($curso);
    }

    function excluirCursoBancoCursos($curso){

        $conn = new mysqli("localhost","root","","dbFacul");
    
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("DELETE FROM cursos
        WHERE nome = ?");

        $query->bind_param("s",$curso);
        $query->execute();

        apresentarTela();
    }

    function apresentarTela(){

        echo "<br><h1>Curso excluído com sucesso!</h1>";
        echo "<button type='button' onclick=window.location.href='infosAdministrador.php'> Concluir";
    }

    $curso = validarCamposText($_POST['curso']);
    excluirCursoBancoAcessos($curso);
?>