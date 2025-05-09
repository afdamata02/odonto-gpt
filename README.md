# Odonto-GPT

Sistema de gerenciamento para consultórios e clínicas odontológicas.

## Requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache, Nginx, etc.)
- Extensões PHP necessárias:
  - PDO
  - PDO_MySQL
  - mbstring

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/odonto-gpt.git
cd odonto-gpt
```

2. Configure o banco de dados:
- Crie um banco de dados MySQL
- Importe o arquivo `database.sql`:
```bash
mysql -u seu_usuario -p seu_banco < database.sql
```

3. Configure o arquivo `config.php`:
- Abra o arquivo `includes/config.php`
- Atualize as credenciais do banco de dados:
```php
$host = "localhost";
$usuario = "seu_usuario";
$senha = "sua_senha";
$banco = "seu_banco";
```

4. Configure o servidor web:
- Certifique-se de que o diretório do projeto está acessível pelo servidor web
- Configure as permissões corretas para os arquivos

## Uso

1. Acesse o sistema pelo navegador:
```
http://localhost/odonto-gpt
```

2. Faça login com as credenciais padrão:
- Email: admin@odontogpt.com
- Senha: password

3. Após o login, você terá acesso às seguintes funcionalidades:
- Cadastro de pacientes
- Agendamento de consultas
- Registro de pagamentos

## Segurança

- Altere a senha do administrador após o primeiro acesso
- Mantenha o PHP e o MySQL atualizados
- Configure corretamente as permissões de arquivos
- Use HTTPS em produção
- Faça backup regular do banco de dados

## Estrutura do Projeto

```
Odonto-GPT/
├── assets/          # Arquivos estáticos (CSS, JS, imagens)
├── includes/        # Arquivos PHP de configuração e funções
└── views/           # Páginas do sistema
```

## Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Commit suas mudanças (`git commit -m 'Adiciona nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## Suporte

Para suporte, entre em contato através do email: suporte@odontogpt.com #   o d o n t o - g p t  
 