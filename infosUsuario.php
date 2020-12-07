<?php

    require_once("config.php");
    function validarCamposText($text){

        $text = trim($text);
        $text = stripslashes($text);
        $text = htmlspecialchars($text);
        $text = strtolower($text);

        return $text;
    }

    function buscarDadosBanco($login){

        $conn = new mysqli("localhost","root","","dbFacul");
        
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->prepare("SELECT cursos.nome FROM cursos 
        INNER JOIN acessos ON cursos.idcurso = acessos.idcurso
        INNER JOIN usuarios ON acessos.iduser = usuarios.iduser
        WHERE usuarios.login = ?
        AND cursos.isativo = 's'
        AND acessos.iscursando = 's'");

        $query->bind_param("s",$login);
        $query->execute();
        $result = $query->get_result();
        $cursosAtivos = array();
        
        while($retornoCursos = $result->fetch_assoc()){
            foreach($retornoCursos as $curso){

                array_push($cursosAtivos,$curso);
            }
        }
        
        $_SESSION['cursosAtivos'] = $cursosAtivos;
        apresentarResultadosCursos($cursosAtivos);
    }
    function apresentarResultadosCursos($cursosAtivos){

        if(!empty($cursosAtivos)){

            echo "<br><h1> Seus cursos ativos atualmente</h1>";

            foreach($cursosAtivos as $cursos){
                echo "<li> $cursos </li>";
            }

            echo "<br>";
            echo "<button type='button' onclick=window.location.href='matriculaCurso.php'> Nova Matricula";
            echo "<button type='button' onclick=window.location.href='cursando.php'> Finalizar Curso";
            echo "<button type='button' onclick=window.location.href='logoff.php'> Sair";
        } else {
            
            echo "<br>";
            echo "<br> Não existe nenhum curso ativo para o usuário</br>";
            echo "<button type='button' onclick=window.location.href='matriculaCurso.php'> Nova Matricula";
            echo "<button type='button' onclick=window.location.href='logoff.php'> Sair";
        }
    }

    $login = validarCamposText($_SESSION['login']);
    buscarDadosBanco($login);
?>