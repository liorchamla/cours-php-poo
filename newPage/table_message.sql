    CREATE TABLE messages (
    	id int(11) NOT NULL auto_increment,
    	id_expediteur int(11) NOT NULL default '0',
    	id_destinataire int(11) NOT NULL default '0',
    	date datetime NOT NULL default '0000-00-00 00:00:00',
    	titre text NOT NULL,
    	message text NOT NULL,
    	PRIMARY KEY  (id)
    ) TYPE=MyISAM;