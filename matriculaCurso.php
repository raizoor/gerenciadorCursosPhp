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

        $query = $conn->prepare("SELECT nome FROM cursos 
        WHERE cursos.isativo = 's'
        AND cursos.nome NOT IN (SELECT cursos.nome FROM cursos
                                INNER JOIN acessos ON cursos.idcurso = acessos.idcurso
                                INNER JOIN usuarios ON acessos.iduser = usuarios.iduser
                                WHERE usuarios.login = ?)"
                                );
        
        $query->bind_param("s",$login);
        $query->execute();
        $result = $query->get_result();
        $cursosDisponiveis = array();
        
        while($retornoCursos = $result->fetch_assoc()){
            foreach($retornoCursos as $curso){

                array_push($cursosDisponiveis,$curso);
            }
        }

        apresentarResultadosCursos($cursosDisponiveis);
    }
    function apresentarResultadosCursos($cursosAtivos){

        if(!empty($cursosAtivos)){

            echo "<br><h1> Selecione o curso que deseja se inscrever</h1>";
            echo "<form action='finalizaMatricula.php' method='POST'>";
            echo "<label> Cursos disponíveis </label>";
            echo "<select name='cursos' required>";
            foreach($cursosAtivos as $cursos){
                echo "<option> $cursos </option>";
            }
            echo "</select>";
            echo "<br>";
            echo "<input type='submit' value='Concluir'>";
            echo "<button type='button' onclick=window.location.href='infosUsuario.php'> Voltar";
            echo "</form>";
        } else {
            
            echo "<br>";
            echo "<br> Não existe nenhum curso disnponível</br>";
            echo "<button type='button' onclick=window.location.href='infosUsuario.php'> Voltar";
        }
    }

    $login = validarCamposText($_SESSION['login']);
    buscarDadosBanco($login);
?>