Padronização dos retornos de mensagens do sistema

Exemplos de código:
    - E011-000
    - S023-293
    - D999-999

Padrão de código de mensagem:
    Utilize a base hexadecimal (de 0 a F) - para aumentar o range de representação de códigos de mensagem.
    Os arquivos na pasta 'mensagens' contém as mensagens. Podem ser utilizados para consulta ou adição de novas mensagens.
    - O primeiro caractere se refere ao tipo de mensagem.
        Erro    -> E,
        Sucesso -> S,
        Padrão  -> D.
    - Os dois seguintes serão um identificador do módulo que o arquivo se refere.
    - O caractere seguinte identifica o tipo de arquivo:
        Model      -> 1,
        View       -> 2,
        Controller -> 3.
        Middleware -> 4.
    - O sinal '-' deve ser adicionado
    - Os três últimos dígitos identificam a mensagem de forma única

Identificadores dos módulos:
    - 00: Global application
    - 01: User
    - 02: Exemple
    - 03: Request Logs