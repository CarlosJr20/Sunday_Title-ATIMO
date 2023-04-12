<h1> Versão sem POO</h1>
O código obtém uma lista de diretórios no diretório especificado, filtrando apenas os arquivos que possuem números no final de seus nomes. Em seguida, ordena essa lista em ordem decrescente e extrai o ano do arquivo mais recente.

O código obtém uma lista de arquivos no diretório correspondente ao ano obtido, filtrando apenas os arquivos que possuem extensões .pdf ou .PDF. Essa lista é ordenada em ordem decrescente e o nome do arquivo mais recente é extraído.

Em seguida, o código gera um nome de arquivo de destino para um arquivo de texto, com base no diretório, ano e nome do arquivo obtidos.

O código verifica se o arquivo de destino .txt já existe. Se o arquivo existir, lê seu conteúdo e o exibe. Caso contrário, realiza uma requisição HTTP para obter informações da http://feed.evangelizo.org/ , cria o arquivo de destino, escreve as informações obtidas no arquivo e exibe as informações.

<h1> Versão em POO </h1>

Nesta versão em POO, o código foi encapsulado dentro de uma classe chamada BulletinReader, com o método readBulletin() para ler o boletim. A lógica de manipulação de diretórios e arquivos foi encapsulada dentro do método, e as variáveis que eram usadas como globais no código original foram convertidas em propriedades da classe. Isso torna o código mais organizado, reutilizável e fácil de manter.

