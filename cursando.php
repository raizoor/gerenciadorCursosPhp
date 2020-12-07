<?php

    require_once("config.php");

    function validarCamposText($text){

        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        $text = strtolower($text);
    
        return $text;
    }

    function apresentarCursosAtivos($cursosAtivos){
    
            echo "<br><h1> Selecione o curso que deseja finalizar</h1>";
            echo "<form action='finalizaCurso.php' method='POST'>";
            echo "<label> Cursos em andamento </label>";
            echo "<select name='cursos' required>";
            foreach($cursosAtivos as $cursos){
                echo "<option> $cursos </option>";
            }
            echo "</select>";
            echo "<br>";
            echo "<input type='submit' value='Concluir'>";
            echo "<button type='button' onclick=window.location.href='infosUsuario.php'> Voltar";
            echo "</form>";
    }
    
    $cursosAtivos = array();

    foreach($_SESSION['cursosAtivos'] as $cursos){

        array_push($cursosAtivos, validarCamposText($cursos));
    }

    apresentarCursosAtivos($cursosAtivos);

?>