# 🏆 PointTasker

Aplicação web gamificada para gerenciamento de tarefas, onde a produtividade é recompensada. Complete seus afazeres, acumule pontos e desbloqueie recompensas configuráveis.

<img src="doc/screenshot.png" height="400" alt="img aplicação em execução"/>

---

## 🚀 Funcionalidades (Implementadas)

- **Gestão de Tarefas**: Adicione, visualize e remova tarefas pendentes.

- **Sistema de Pontuação**: Cada tarefa marcada como concluída soma 1 ponto ao seu progresso.

- **Recompensas Configuráveis**: Defina uma meta de pontos e a recompensa que deseja receber ao atingi-la.

- **Persistência de Dados**: Suas tarefas e pontos ficam salvos com segurança.

---

## 🛠️ Tecnologias Utilizadas

- **HTML5 & CSS3**: Estruturação e estilização da interface responsiva.

- **JavaScript**: Lógica de interação no front-end e feedback dinâmico.

- **PHP 8+**: Processamento no lado do servidor e comunicação com o banco de dados.

- **SQLite**: Sistema de gerenciamento de banco de dados relacional leve e embutido, dispensando configurações complexas de servidor.

---

## 🗄️ Banco de Dados Utilizado

SQLite — Utilizado pela sua natureza autossuficiente e portabilidade, sendo ideal para rodar localmente ou em servidores simples de hospedagem PHP.

---

## ⚙️ Como Executar o Projeto

- Certifique-se de ter um servidor local instalado (como XAMPP, WampServer ou PHP nativo).

- Clone este repositório para a pasta pública do seu servidor (ex: `htdocs` ou `www`).

- Verifique se a extensão `pdo_sqlite` está habilitada no seu arquivo `php.ini`.

- Acesse `localhost/PointTasker` no seu navegador.

- O banco de dados SQLite (`.db`) será criado automaticamente na primeira execução, se configurado na classe de conexão.