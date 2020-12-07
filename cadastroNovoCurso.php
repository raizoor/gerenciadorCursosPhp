<?php

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

    function salvarBanco($nome, $descricao, $tempo){

        $conn = new mysqli("localhost","root","","dbFacul");
        
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("INSERT INTO cursos (nome, descricao, tempo) VALUES (?,?,?)");
        $query->bind_param("ssi",$nome,$descricao,$tempo);
        $query->execute();

        apresentarTela();
    }

    function apresentarTela(){

        echo "<br><h1>Curso Cadastrado com suceso</h1>";
        echo "<button type='button' onclick=window.location.href='infosAdministrador.php'> Concluir";
    }

    $nome = validarCamposText($requisicao['nome']);
    $descricao = validarCamposText($requisicao['descricao']);

    salvarBanco($nome, $descricao, $requisicao['tempo']);
?>