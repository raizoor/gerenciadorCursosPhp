<?php
    require_once("config.php");

    function validarCamposText($text){

        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        $text = strtolower($text);
    
        return $text;
    }

    function apresentarCursos($todosCursos){
    
            echo "<br><h1> Selecione o curso que deseja excluir</h1>";
            echo "<form action='excluiCurso.php' method='POST'>";
            echo "<label> Cursos ativos </label>";
            echo "<select name='curso' required>";
            foreach($todosCursos as $cursos){
                echo "<option> $cursos </option>";
            }
            echo "</select>";
            echo "<br>";
            echo "<input type='submit' value='Excluir'>";
            echo "<button type='button' onclick=window.location.href='infosAdministrador.php'> Voltar";
            echo "</form>";
    }

    $todosCursos = array();

    foreach($_SESSION['todosCursos'] as $curso){

        array_push($todosCursos, validarCamposText($curso));
    }


    apresentarCursos($todosCursos);
?>