<?php

function conectar($banco) {
    return new PDO("mysql:host=localhost;dbname=$banco","root","");
}


function inserir($nome, $email, $cargo) {
    $con = conectar("agendap");
    $inserir = $con->prepare("insert into funcionario(nome, email, cargo)
        values(:nome,:email,:cargo)");
    
    $inserir->bindValue(":nome", "$nome");
    $inserir->bindValue(":email", "$email");
    $inserir->bindValue(":cargo", "$cargo");
    $inserir->execute();
}

function listarTodos() {
    $con = conectar("agendap");
    $select = $con->prepare("SELECT * FROM funcionario");
    $select->execute();
    $funcionario = $select->fetchAll();
    
    echo "<table border=1px>
    <tr>
    <td><b>Id</td>
    <td><b>Nome</td>
    <td><b>Email</td>
    <td><b>Cargo</td>
    </tr>";
    
    foreach ($funcionario as $linha){
        echo "<tr>";
        echo "<td>".$linha ["id"] . "</td>";
        echo "<td>".$linha ["nome"] . "</td>";
        echo "<td>".$linha ["email"] . "</td>";
        echo "<td>".$linha ["cargo"] . "</td>";
        echo "</tr>";
        
    }
    echo "</table>";
}

if(isset($_POST["botao"])){
    if(!empty($_POST["nome"]) && !empty($_POST["email"])&&!empty($_POST["cargo"])){
        
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cargo = $_POST["cargo"];
        inserir($nome, $email, $cargo);
        listarTodos();
    }else{
        echo '<script>
              alert("Preencha todos os Campos!");
              window.location.href="index.php";  
              </script>';
    }
    
    
}
