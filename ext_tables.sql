CREATE TABLE tx_sitepackage_domain_model_product (
  uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
  pid int(11) DEFAULT 0 NOT NULL,
  name varchar(255) DEFAULT '' NOT NULL,
  description varchar(255) DEFAULT '' NOT NULL,
  quantity int(11) DEFAULT 0 NOT NULL,
  delieveryTime int(11) DEFAULT 0 NOT NULL,
  -- foreign uid for 1-n relation
  delieverRando int(11) DEFAULT 0 NOT NULL,
  -- categories member (its a counter in the db)
  categories int(11) DEFAULT 0 NOT NULL,

  crdate int(11) DEFAULT 0 NOT NULL,
  tstamp int(11) unsigned DEFAULT 0 NOT NULL,
  deleted smallint(4) unsigned DEFAULT 0 NOT NULL,
  hidden smallint(4) unsigned DEFAULT 0 NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid)
);

CREATE TABLE tx_sitepackage_domain_model_delieverRando(
    uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    name varchar(255) DEFAULT '' NOT NULL,
    -- products member (its a counter in the db)
    products int(11) DEFAULT 0 NOT NULL,
    -- uid of the fe-userGroup
    userGroup int(11) NOT NULL,

    crdate int(11) DEFAULT 0 NOT NULL,
    tstamp int(11) unsigned DEFAULT 0 NOT NULL,
    deleted smallint(4) unsigned DEFAULT 0 NOT NULL,
    hidden smallint(4) unsigned DEFAULT 0 NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_sitepackage_domain_model_category (
    uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    name varchar(255) DEFAULT '' NOT NULL,

    crdate int(11) DEFAULT 0 NOT NULL,
    tstamp int(11) unsigned DEFAULT 0 NOT NULL,
    deleted smallint(4) unsigned DEFAULT 0 NOT NULL,
    hidden smallint(4) unsigned DEFAULT 0 NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);

-- table for m-n relation
CREATE TABLE tx_sitepackage_product_category_mm(
    uid int(11) unsigned DEFAULT 0 NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,

    uid_local int(11) unsigned NOT NULL,
    uid_foreign int(11) unsigned NOT NULL,
    sorting int(11) unsigned NOT NULL,

    crdate int(11) DEFAULT 0 NOT NULL,
    tstamp int(11) unsigned DEFAULT 0 NOT NULL,
    deleted smallint(4) unsigned DEFAULT 0 NOT NULL,
    hidden smallint(4) unsigned DEFAULT 0 NOT NULL,
);

/* Dieser table wird nur erstellt, wenn man im install tool unter Database Analyzer
 * die Datenbank mit (dieser) Spezifikation vergleicht, und dann den table erstellt.
 */