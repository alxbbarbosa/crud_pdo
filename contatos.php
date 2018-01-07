<?php
/**
 * Projeto de aplicação CRUD utilizando PDO - Agenda de Contatos
 *
 * Alexandre Bezerra Barbosa
 */
// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id        = filter_input(INPUT_POST, 'id');
    $empresa   = filter_input(INPUT_POST, 'empresa');
    $servico   = filter_input(INPUT_POST, 'servico');
    $contato   = filter_input(INPUT_POST, 'contato');
    $funcao    = filter_input(INPUT_POST, 'funcao');
    $email     = filter_input(INPUT_POST, 'email');
    $telefone  = filter_input(INPUT_POST, 'telefone');
    $ramal     = filter_input(INPUT_POST, 'ramal');
    $celular_1 = filter_input(INPUT_POST, 'celular_1');
    $celular_2 = filter_input(INPUT_POST, 'celular_2');
} else if (!isset($id)) {
// Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
}

// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=contatos", "root", "P@ssw0rd");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão:".$erro->getMessage();
}

// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $empresa != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE contatos SET empresa=?, servico=?,contato=?, funcao=?, email=?, telefone=?, ramal=?, celular_1=?, celular_2=? WHERE id = ?");
            $stmt->bindParam(10, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO contatos (empresa, servico, contato, funcao, email, telefone, ramal, celular_1, celular_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        }
        $stmt->bindParam(1, $empresa);
        $stmt->bindParam(2, $servico);
        $stmt->bindParam(3, $contato);
        $stmt->bindParam(4, $funcao);
        $stmt->bindParam(5, $email);
        $stmt->bindParam(6, $telefone);
        $stmt->bindParam(7, $ramal);
        $stmt->bindParam(8, $celular_1);
        $stmt->bindParam(9, $celular_2);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $id        = null;
                $empresa   = null;
                $servico   = null;
                $contato   = null;
                $email     = null;
                $telefone  = null;
                $ramal     = null;
                $celular_1 = null;
                $celular_2 = null;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Bloco if que recupera as informações no formulário, etapa utilizada pelo Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs        = $stmt->fetch(PDO::FETCH_OBJ);
            $id        = $rs->id;
            $empresa   = $rs->empresa;
            $servico   = $rs->servico;
            $contato   = $rs->contato;
            $funcao    = $rs->funcao;
            $email     = $rs->email;
            $telefone  = $rs->telefone;
            $ramal     = $rs->ramal;
            $celular_1 = $rs->celular_1;
            $celular_2 = $rs->celular_2;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Registo foi excluído com êxito";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de contatos</title>
    </head>
    <body>
        <form action="?act=save" method="POST" name="form1" >
            <h1>Agenda de contatos</h1>
            <hr>
            <input type="hidden" name="id" <?php
            // Preenche o id no campo id com um valor "value"
            if (isset($id) && ($id != null || $id != "")) {
                echo "value=\"{$id}\"";
            }
            ?> />
            Empresa:
            <input type="text" name="empresa" <?php
            // Preenche o nome no campo empresa com um valor "value"
            if (isset($empresa) && ($empresa != null || $empresa != "")) {
                echo "value=\"{$empresa}\"";
            }
            ?> />
            Serviço:
            <input type="text" name="servico" <?php
            // Preenche o servico no campo contato com um valor "value"
            if (isset($servico) && ($servico != null || $servico != "")) {
                echo "value=\"{$servico}\"";
            }
            ?> />
            Contato:
            <input type="text" name="contato" <?php
            // Preenche o email no campo contato com um valor "value"
            if (isset($contato) && ($contato != null || $contato != "")) {
                echo "value=\"{$contato}\"";
            }
            ?> />
            Função:
            <input type="text" name="funcao" <?php
            // Preenche o email no campo funcao com um valor "value"
            if (isset($funcao) && ($funcao != null || $funcao != "")) {
                echo "value=\"{$funcao}\"";
            }
            ?> />
            Email:
            <input type="text" name="email" <?php
            // Preenche o celular no campo email com um valor "value"
            if (isset($email) && ($email != null || $email != "")) {
                echo "value=\"{$email}\"";
            }
            ?> /><br /><hr>
            Telefone:
            <input type="text" name="telefone" <?php
            // Preenche o celular no campo telefone com um valor "value"
            if (isset($telefone) && ($telefone != null || $telefone != "")) {
                echo "value=\"{$telefone}\"";
            }
            ?> />
            Ramal:
            <input type="text" name="ramal" <?php
            // Preenche o celular no campo ramal com um valor "value"
            if (isset($ramal) && ($ramal != null || $ramal != "")) {
                echo "value=\"{$ramal}\"";
            }
            ?> />
            Celular 1:
            <input type="text" name="celular_1" <?php
            // Preenche o celular no campo celular 1 com um valor "value"
            if (isset($celular_1) && ($celular_1 != null || $celular_1 != "")) {
                echo "value=\"{$celular_1}\"";
            }
            ?> />
            Celular 2:
            <input type="text" name="celular_2" <?php
            // Preenche o celular no campo celular 2 com um valor "value"
            if (isset($celular_2) && ($celular_2 != null || $celular_2 != "")) {
                echo "value=\"{$celular_2}\"";
            }
            ?> /><hr><br />
            <input type="submit" value="salvar" />
            <input type="reset" value="Novo" />
            <hr>
        </form>
        <table border="1" width="100%">
            <tr>
                <th>Empresa</th>
                <th>Serviço</th>
                <th>Contato</th>
                <th>Função</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ramal</th>
                <th>Celular 1</th>
                <th>Celular 2</th>
                <th>Ações</th>
            </tr>
            <?php
            /**
             *  Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
             */
            try {
                $stmt = $conexao->prepare("SELECT * FROM contatos");
                if ($stmt->execute()) {
                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>";
                        echo "<td>".$rs->empresa."</td><td>".$rs->servico."</td><td>".$rs->contato."</td><td>".$rs->funcao."</td><td>".$rs->email
                        ."<td>".$rs->telefone."</td><td>".$rs->ramal."</td><td>".$rs->celular_1."</td><td>".$rs->celular_2
                        ."</td><td><center><a href=\"?act=upd&id=".$rs->id."\">[Alterar]</a>"
                        ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                        ."<a href=\"?act=del&id=".$rs->id."\">[Excluir]</a></center></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Erro: Não foi possível recuperar os dados do banco de dados";
                }
            } catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }
            ?>
        </table>
    </body>
</html>
