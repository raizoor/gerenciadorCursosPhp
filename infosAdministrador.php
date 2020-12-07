<?php

    require_once("config.php");

    function buscarDadosBanco(){

        $conn = new mysqli("localhost","root","","dbFacul");
        
        if($conn->connect_error){

            throw new Exception("Falha ao conectar com o banco de dados".$conn->connect_error);
        }

        $query = $conn->query("SELECT nome FROM cursos");
        $cursosBanco = array();
        
        while($retornoCursos = $query->fetch_assoc()){
            foreach($retornoCursos as $curso){

                array_push($cursosBanco,$curso);
            }
        }
        
        $_SESSION['todosCursos'] = $cursosBanco;
        apresentarResultadosCursos($cursosBanco);
    }
    function apresentarResultadosCursos($cursosBanco){

        if(!empty($cursosBanco)){

            echo "<br><h1> Todos cursos</h1>";

            foreach($cursosBanco as $cursos){
                echo "<li> $cursos </li>";
            }

            echo "<br>";
            echo "<button type='button' onclick=window.location.href='cadastroNovoCurso.html'> Cadastrar Novo Curso";
            echo "<button type='button' onclick=window.location.href='listaCursos.php'> Excluir Curso";
            echo "<button type='button' onclick=window.location.href='cadastroNovoAdmin.html'> Cadastrar Novo Administrador";
            echo "<button type='button' onclick=window.location.href='logoff.php'> Sair";
        } else {
            
            echo "<br>";
            echo "<br> Não existe nenhum curso</br>";
            echo "<button type='button' onclick=window.location.href='cadastroNovoCurso.html'> Cadastrar Novo Curso";
            echo "<button type='button' onclick=window.location.href='logoff.php'> Sair";
        }
    }

    buscarDadosBanco();
?>