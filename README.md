# CRUD PDO em PHP

Este código fonte apresenta um exemplo de um programa feito em PHP, com as 4 operações sobre o banco de dados, cujo conhecemos como CRUD. É utilizado PDO. O programa se refere a uma Agenda de contatos que operara simplesmente sobre uma tabela no banco de dados.

## Getting Started

O projeto é simples e não requer muito esforço para funcioná-lo

### Prerequisites

Você precisa ter instalado PHP e MySQL Server. Se estiver utilizando Linux, muitas vezes o LAMP lhe apresentará todo ambiente perfeito. No Windows, muitos costumam utilizar o XAMP.
Não faz parte desde documento, apresentar as etapas de instalação de cada elemento do ambiente.

### Installing

Após baixar o código, se estiver compactado, extrai-os e coloque-os no diretório de sua preferencia para rodar com o servidor web embutido no php.
Você deve ter acesso ao seu servidor MySQL e executar o script contatos2.sql para gerar a tabela. Além disso, você precisa configurar as definições do seu servidor no script, que fica na linha 26:

```
$conexao = new PDO("mysql:host=localhost;dbname=contatos2", "root", "P@ssw0rd");
```

Note que temos um banco de dados foi utilizado no projeto original com o nome de contatos2. A utilização deste nome é opcional. Porém, o que você definir em seu ambiente, deverá refletir aí. Então na sequencia, defina o usuário e senha que você utiliza, subistituindo os dados pré-existentes.

Após isso, você deve estar certo de que o script esteja em um diretório que possa ser lido pelo servidor web local ou, que tenha permissões suficiente de acesso ao diretório para utilizar o servidor embutido do php. 
Em geral para se utilizar o servidor embutido, utiliza-se o seguinte comando no diretório do projeto:

```
php -S localhost:8080

```

Após inicia o servidor embutido, será possível invocar o programa no browser através de um endereço URL como:

```
http://localhost:8080

```

Normalmente, seguindo estas etapas, você deveria ter aqui um crud totalmente funcional.


## Authors

* **Alexandre Bezerra Barbosa**
