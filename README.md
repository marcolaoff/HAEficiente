# Sistema HAE – Fatec Itapira

Este é um sistema web para automatização parcial da concessão de Horas de Atividades Específicas (HAEs) aos professores da Fatec Itapira.

## 🚀 Tecnologias Utilizadas
- PHP
- MySQL
- HTML5 / CSS3
- JavaScript (em breve)
- XAMPP / phpMyAdmin

## 📂 Estrutura do Projeto

```
/painel/
  ├── admin/              # Gerenciamento de usuários e aprovações
  ├── coordenador/        # Avaliação de propostas e publicação de editais
  └── professor/          # Submissão e acompanhamento de propostas

/sql/                     # Scripts SQL para estrutura e alterações no banco
/uploads/                 # PDFs enviados pelos professores
config.php                # Configuração da conexão com o banco
```

## ✅ Funcionalidades Implementadas

### 👨‍🏫 Professor
- Envia proposta de projeto vinculada a um edital
- Visualiza status de envio
- Acompanha parecer do coordenador
- Envia relatório final

### 🎓 Coordenador
- Avalia propostas recebidas
- Pode aceitar, rejeitar ou sugerir nova proposta
- Avalia relatório final do professor
- Publica novos editais

### 👨‍💼 Administrador
- Aprova ou inativa usuários
- Monitora coordenadores e professores ativos

## 🧩 Banco de Dados

Scripts disponíveis na pasta `/sql`:
- Criação das tabelas
- Alterações extras (`created_at`, `ativo`)

## ⚙️ Instruções para Executar

1. Importe o banco de dados no phpMyAdmin usando o script SQL.
2. Configure a conexão no `config.php` com seu host, usuário e senha.
3. Coloque o projeto em seu servidor local (ex: `htdocs` no XAMPP).
4. Acesse `localhost/sistema_hae/login.php`.

## 📌 Observações
- Certifique-se de criar um usuário `admin` direto no banco.
- Professores e coordenadores devem se cadastrar e aguardar aprovação.

---

Desenvolvido como parte do Projeto Integrador 2 – Fatec Itapira.
