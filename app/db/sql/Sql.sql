create database micro_servico_php_base;

CREATE TABLE `micro_servico_php_base`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `secret` TEXT NOT NULL,
    `pass` TEXT NOT NULL,
    `user_token` BLOB NULL,
    `user_token_exp` DATETIME NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `micro_servico_php_base`.`request_logs` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `created_at` DATETIME NOT NULL COMMENT 'Data de criação',
    `request_url` VARCHAR(255) NULL COMMENT 'Url solicitada no serviço de terceiros',
    `request` BLOB NULL COMMENT 'Dados enviados ao serviço de terceiros',
    `response` BLOB NULL COMMENT 'Dados retornados pelo serviço de terceiros',
    `status_code` VARCHAR(3) NULL COMMENT 'Status code retornado serviço de terceiros',
    `errors` TEXT NULL COMMENT 'Erros ocorridos na chamada',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);
