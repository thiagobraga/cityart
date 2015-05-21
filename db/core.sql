/**
 * Modelagem do banco de dados do projeto bptadvogados
 *
 * @autor  Thiago Braga <contato@thiagobraga.org>
 */

/**
 * Seleciona o banco de dados
 */
USE bptadvogados;

/**
 * Desabilita a checagem por FOREIGN KEY
 * para realizar a exclusão de dados com segurança.
 */
SET FOREIGN_KEY_CHECKS = 0;

/**
 * Restaura a checagem das chaves estrangeiras
 */
SET FOREIGN_KEY_CHECKS = 1;
