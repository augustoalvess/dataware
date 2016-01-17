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

COMMIT;
