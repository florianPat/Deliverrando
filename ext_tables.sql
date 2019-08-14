CREATE TABLE tx_sitepackage_domain_model_product (
  uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  name varchar(255) DEFAULT '' NOT NULL,
  description varchar(255) DEFAULT '' NOT NULL,
  quantity int(11) DEFAULT '0' NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

/* Dieser table wird nur erstellt, wenn man im install tool unter Database Analyzer
 * die Datenbank mit (dieser) Spezifikation vergleicht, und dann den table erstellt.
 */