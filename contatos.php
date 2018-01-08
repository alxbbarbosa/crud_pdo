<?php
/**
 * Projeto de aplicação CRUD utilizando PDO - Agenda de Contatos
 *
 * Alexandre Bezerra Barbosa
 */
// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id');
    $empresa = filter_input(INPUT_POST, 'empresa');
    $servico = filter_input(INPUT_POST, 'servico');
    $contato = filter_input(INPUT_POST, 'contato');
    $funcao = filter_input(INPUT_POST, 'funcao');
    $email = filter_input(INPUT_POST, 'email');
    $telefone = filter_input(INPUT_POST, 'telefone');
    $ramal = filter_input(INPUT_POST, 'ramal');
    $celular_1 = filter_input(INPUT_POST, 'celular_1');
    $celular_2 = filter_input(INPUT_POST, 'celular_2');
} else if (!isset($id)) {
// Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
}

// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=contatos2", "root", "P@ssw0rd");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "<p class=\"bg-danger\">Erro na conexão:" . $erro->getMessage() . "</p>";
}

// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $empresa != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE contatos SET empresa=?, servico=?,contato=?, funcao=?, email=?, telefone=?, ramal=?, celular_1=?, celular_2=? WHERE id = ?");
            $stmt->bindParam(10, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO contatos (empresa, servico, contato, funcao, email, telefone, ramal, celular_1, celular_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
                echo "<p class=\"bg-success\">Dados cadastrados com sucesso!</p>";
                $id = null;
                $empresa = null;
                $servico = null;
                $contato = null;
                $funcao = null;
                $email = null;
                $telefone = null;
                $ramal = null;
                $celular_1 = null;
                $celular_2 = null;
            } else {
                echo "<p class=\"bg-danger\">Erro ao tentar efetivar cadastro</p>";
            }
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}

// Bloco if que recupera as informações no formulário, etapa utilizada pelo Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $empresa = $rs->empresa;
            $servico = $rs->servico;
            $contato = $rs->contato;
            $funcao = $rs->funcao;
            $email = $rs->email;
            $telefone = $rs->telefone;
            $ramal = $rs->ramal;
            $celular_1 = $rs->celular_1;
            $celular_2 = $rs->celular_2;
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</p>";
    }
}

// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM contatos WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "<p class=\"bg-success\">Registo foi excluído com êxito</p>";
            $id = null;
        } else {
            echo "<p class=\"bg-danger\">Erro: Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p class=\"bg-danger\">Erro: " . $erro->getMessage() . "</a>";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de contatos</title>
        <link href="assets/css/bootstrap.css" type="text/css" rel="stylesheet" />
        <script src="assets/js/bootstrap.js" type="text/javascript" ></script>
    </head>
    <body>
        <div class="container">
            <header class="row">
                <br />
            </header>
            <article>
                <div class="row">
                    <form action="?act=save" method="POST" name="form1" class="form-horizontal" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span class="panel-title">Contato</span>
                            </div>
                            <div class="panel-body">

                                <input type="hidden" name="id" <?php
                                // Preenche o id no campo id com um valor "value"
                                if (isset($id) && ($id != null || $id != "")) {
                                    echo "value=\"{$id}\"";
                                }

                                ?> />
                                <div class="form-group">
                                    <label for="empresa" class="col-sm-1 control-label">Empresa:</label>
                                    <div class="col-md-5">
                                        <input type="text" name="empresa" <?php
                                        // Preenche o nome no campo empresa com um valor "value"
                                        if (isset($empresa) && ($empresa != null || $empresa != "")) {
                                            echo "value=\"{$empresa}\"";
                                        }

                                        ?> class="form-control"/>
                                    </div>
                                    <label for="servico" class="col-sm-1 control-label">Serviço:</label>
                                    <div class="col-md-4">
                                        <input type="text" name="servico" <?php
                                        // Preenche o servico no campo contato com um valor "value"
                                        if (isset($servico) && ($servico != null || $servico != "")) {
                                            echo "value=\"{$servico}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contato" class="col-sm-1 control-label">Contato:</label>
                                    <div class="col-md-4">
                                        <input type="text" name="contato" <?php
                                        // Preenche o email no campo contato com um valor "value"
                                        if (isset($contato) && ($contato != null || $contato != "")) {
                                            echo "value=\"{$contato}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                    <label for="funcao" class="col-sm-2 control-label">Função:</label>
                                    <div class="col-md-4">
                                        <input type="text" name="funcao" <?php
                                        // Preenche o email no campo funcao com um valor "value"
                                        if (isset($funcao) && ($funcao != null || $funcao != "")) {
                                            echo "value=\"{$funcao}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-1 control-label">E-mail:</label>
                                    <div class="col-md-4">
                                        <input type="text" name="email" <?php
                                        // Preenche o celular no campo email com um valor "value"
                                        if (isset($email) && ($email != null || $email != "")) {
                                            echo "value=\"{$email}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                    <label for="telefone" class="col-sm-2 control-label">Telefone:</label>
                                    <div class="col-md-2">
                                        <input type="text" name="telefone" <?php
                                        // Preenche o celular no campo telefone com um valor "value"
                                        if (isset($telefone) && ($telefone != null || $telefone != "")) {
                                            echo "value=\"{$telefone}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                    <label for="ramal" class="col-sm-1 control-label">Ramal:</label>
                                    <div class="col-md-1">
                                        <input type="text" name="ramal" <?php
                                        // Preenche o celular no campo ramal com um valor "value"
                                        if (isset($ramal) && ($ramal != null || $ramal != "")) {
                                            echo "value=\"{$ramal}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="celular_1" class="col-sm-1 control-label">Celular 1:</label>
                                    <div class="col-md-2">
                                        <input type="text" name="celular_1" <?php
                                        // Preenche o celular no campo celular 1 com um valor "value"
                                        if (isset($celular_1) && ($celular_1 != null || $celular_1 != "")) {
                                            echo "value=\"{$celular_1}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                    <label for="celular_2" class="col-sm-4 control-label">Celular 2:</label>
                                    <div class="col-md-2">
                                        <input type="text" name="celular_2" <?php
                                        // Preenche o celular no campo celular 2 com um valor "value"
                                        if (isset($celular_2) && ($celular_2 != null || $celular_2 != "")) {
                                            echo "value=\"{$celular_2}\"";
                                        }

                                        ?> class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <input type="submit" value=":: salvar ::" class="btn btn-primary" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="jumbotron">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Empresa</th>
                                    <th>Serviço</th>
                                    <th>Contato</th>
                                    <!--<th>Função</th>
                                    <!-- <th>E-mail</th> -->
                                    <th>Telefone</th>
                                    <th>Ramal</th>
                                    <th>Celular 1</th>
                                    <th>Celular 2</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                /**
                                 *  Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                                 */
                                try {
                                    $stmt = $conexao->prepare("SELECT * FROM contatos");
                                    if ($stmt->execute()) {
                                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                            echo "<tr>";
                                            echo "<td>" . $rs->empresa . "</td><td>" . $rs->servico . "</td><td>" . $rs->contato . "</td>"
                                            . "<td>" . $rs->telefone . "</td><td>" . $rs->ramal . "</td><td>" . $rs->celular_1 . "</td><td>" . $rs->celular_2
                                            . "</td><td><center><a href=\"?act=upd&id=" . $rs->id . "\" class=\"btn btn-warning btn-xs\">:: Alterar ::</a>"
                                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                            . "<a href=\"?act=del&id=" . $rs->id . "\" class=\"btn btn-danger btn-xs\" >:: Excluir ::</a></center></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "Erro: Não foi possível recuperar os dados do banco de dados";
                                    }
                                } catch (PDOException $erro) {
                                    echo "Erro: " . $erro->getMessage();
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
        </div>
    </body>
</html>
