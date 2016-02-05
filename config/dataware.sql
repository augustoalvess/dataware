BEGIN;

--Cria os item do menu.
INSERT INTO menu (title, icon, active) VALUES ('Administrativo', 'fa-suitcase', false);
INSERT INTO menu (title, icon) VALUES ('Cadastro', 'fa-th-list');
INSERT INTO menu (title, icon) VALUES ('Configuração', 'fa-cog');
INSERT INTO menu (title, icon) VALUES ('Processo', 'fa-sitemap');
INSERT INTO menu (fathermenu_id, title, action, icon, favorite) VALUES (2, 'Perfil', '/register/cliente/edit', 'fa-user', true);
INSERT INTO menu (fathermenu_id, title, action, icon, favorite) VALUES (2, 'Anexos', '/register/anexo', 'fa-paperclip', true);
INSERT INTO menu (fathermenu_id, title, action, icon, favorite) VALUES (3, 'Notificações', '/config/notify', 'fa-comments-o', true);
INSERT INTO menu (fathermenu_id, title, action, icon, favorite) VALUES (4, 'Agenda', '/process/agendamento', 'fa-calendar', true);
INSERT INTO menu (fathermenu_id, title, action, icon, favorite) VALUES (4, 'Prontuários', '/process/record', 'fa-file-text', true);
INSERT INTO menu (fathermenu_id, title, action, icon, favorite) VALUES (4, 'Relatórios', '/process/report', 'fa-bar-chart', true);

--Usuário admin padrão
INSERT INTO useraccount (login, password, name, active) VALUES ('admin', MD5('admin'), 'Usuário Administrativo', true);
INSERT INTO pessoa (id, nome, telefonecelular, usuario_id, tipo, sexo) VALUES (1, 'Usuário Administrativo', '(51) 9241-3296', 1, 'cliente', 'M');
INSERT INTO cliente (id) VALUES (1);
ALTER SEQUENCE pessoa_id_seq RESTART WITH 2;

COMMIT;
