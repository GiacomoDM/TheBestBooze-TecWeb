SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `Admin`;
CREATE TABLE `Admin` (
  `ID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(30) NOT NULL,
  `Passwd` char(128) NOT NULL,
  PRIMARY KEY (`ID`)
);

DROP TABLE IF EXISTS `Cliente`;
CREATE TABLE `Cliente` (
  `Passwd` char(128) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `Cognome` varchar(30) NOT NULL,
  `Data` date NOT NULL,
  `Indirizzo` varchar(30) NOT NULL,
  `Citta` varchar(30) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Telefono` varchar(15),
  `PartitaIVA` varchar(15),
  `TipoCarta` enum('Visa','AmericanExpress','MasterCard') NOT NULL,
  `NumeroCarta` varchar(16) NOT NULL,
  PRIMARY KEY (`Email`)
);

DROP TABLE IF EXISTS `Prodotto`;
CREATE TABLE `Prodotto` (
  `Codice` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(30) NOT NULL,
  `Lingua` varchar(10) NOT NULL,
  `Prezzo` decimal(8,2) unsigned NOT NULL,
  `Categoria` varchar(20) NOT NULL,
  `Sottocategoria` varchar(20) DEFAULT NULL,
  `Anno` smallint(4) DEFAULT NULL,
  `Produttore` varchar(40) NOT NULL,
  `Disponibile` bool NOT NULL DEFAULT 1,
  PRIMARY KEY (`Codice`)
);

DROP TABLE IF EXISTS `OrdineInCorso`;
CREATE TABLE `OrdineInCorso` (
  `ID` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `Cliente` varchar(64) NOT NULL,
  `Data` date NOT NULL,
  `PrezzoProdotti` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Cliente`) REFERENCES `Cliente` (`Email`) ON DELETE NO ACTION
);

DROP TABLE IF EXISTS `Carrello`;
CREATE TABLE `Carrello` (
  `Prodotto` int(6) unsigned NOT NULL,
  `OrdineInCorso` smallint(4) unsigned NOT NULL,
  `Quantita` smallint(3) unsigned NOT NULL,
  `Costo` decimal(8,2) unsigned NOT NULL,
  PRIMARY KEY (`Prodotto`,`OrdineInCorso`),
  FOREIGN KEY (`Prodotto`) REFERENCES `Prodotto` (`Codice`) ON DELETE CASCADE,
  FOREIGN KEY (`OrdineInCorso`) REFERENCES `OrdineInCorso` (`ID`) ON DELETE CASCADE
);

DROP TABLE IF EXISTS `Fattura`;
CREATE TABLE `Fattura` (
  `ID` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `Intestatario` varchar(64) NOT NULL,
  `Data` date NOT NULL,
  `Totale` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Intestatario`) REFERENCES `Cliente` (`Email`) ON DELETE NO ACTION
);

DROP TABLE IF EXISTS `DettaglioFattura`;
CREATE TABLE `DettaglioFattura` (
  `Fattura` int(9) unsigned NOT NULL ,
  `Prodotto` int(6) unsigned NOT NULL,
  `Quantita` smallint(3) unsigned NOT NULL,
  `Costo` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`Fattura`,`Prodotto`),
  FOREIGN KEY (`Fattura`) REFERENCES `Fattura` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`Prodotto`) REFERENCES `Prodotto` (`Codice`) ON DELETE NO ACTION
);

DROP TABLE IF EXISTS `OrdineConcluso`;
CREATE TABLE `OrdineConcluso` (
  `ID` smallint(4) NOT NULL AUTO_INCREMENT,
  `Fattura` int(9) unsigned NOT NULL,
  `Spedizione` enum('Standard','Express','Daily') NOT NULL,
  `GiorniLavorativi` enum('7-10','3-5','1') NOT NULL,
  `CostoFinale` decimal(8,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`Fattura`) REFERENCES `Fattura` (`ID`) ON DELETE NO ACTION
);

INSERT INTO Admin (Nome, Passwd) 
VALUES ('admin','admin');


INSERT INTO Prodotto (Nome, Lingua, Prezzo, Categoria, Sottocategoria, Anno, Produttore)
VALUES ('Lager','de','5.00','Birra','Rossa','2008','Pustertaler Freheit'),
	('Franciacorta Brut','it','4.00','Vino','Spumante','2002','Ferghettina'),
	('Amaro Montenegro','it','12.00','Superalcolico','Amaro','2005','Montenegro S.r.L'),
	('Ribolla Gialla','it','22.00','Vino','Bianco','2006','Toros'),
	('Sauvignon','fr','7.50','Vino','Bianco','2003','Vigna Petrussa'),
	('Fragolino','it','9.80','Superalcolico','Liquore','2011','Giarola'),
	('Mirto','it','6.70','Superalcolico','Liquore','1997','Benalonga'),
	('Bacardi Rum','it','14.00','Superalcolico','Rum','2015','Bacardi Limited'),
	('Amaro Lucano','it','17.00','Superalcolico','Amaro','2016','Lucano'),
	('Chateau Lafite','fr','117530.00','Vino','Rosso','1901','Rothschild'),
	('Apple Jack','en','7.00','Superalcolico','Distillato','2009','Laird'),
	('Jagermeister','en','9.77','Superalcolico','Amaro','2001','Mast-Jägermeister'),
	('Richebourg Grand Cru','fr','16000.00','Vino','Rosso','1985','Henri Jayer'),
	('Brachetto - Il Furetto','it','9.00','Vino','Spumante','2004','Vite Colte'),
	('Rosolio Ligure','it','13.00','Superalcolico','Liquore','2013','Anni Trenta'),
	('Dry Gin','en','11.80','Superalcolico','Gin','2011','Bombay Sapphire'),
	('Angry Orchard','en','14.00','Sidro',NULL,'1999','Boston Beer Company'),
	('Sidro Di Mele Antiche','it','6.50','Sidro',NULL,'2009','Il Frutto Permesso'),
	('Harp Lager','en','6.20','Birra','Bionda','2011','Diageo'),
	('Sambuca','it','11.00','Superalcolico','Liquore','2015','Molinari'),
	('Herfstbok','fr','7.00','Birra','Rossa','2015','Grolsh'),
	('Guinness Extra Stout','en','17.00','Birra','Nera','2016','Guinness'),
	('Dreher','de','6.20','Birra','Bionda','2011','Heineken'),
	('Duff','en','4.30','Birra','Bionda','2012','Budweiser'),
	('Bollinger Champagne','fr','200.00','Vino','Spumante','2002','Coffret'),
	('Krug Brut Rose Champagne','fr','290.00','Vino','Spumante','1966','Krug'),
	('Cognac Grande Champagne','fr','295.00','Superalcolico','Cognac','1980','Jean Grosperrin'),
	('Maremma Toscana','it','504.00','Vino','Rosso','2012','Frescobaldi'),
	('Vinsanto Chianti Classico','it','600.00','Vino','Bianco','2008','Antinori'),
	('Cardinal Speciale','en','6.00','Birra','Bionda','2015','Cardinal'),
	('Franziskaner Dunkel','en','3.45','Birra','Rossa','2016','Franziskaner Weissebier'),
	('HB - Hofbrau Original','de','2.40','Birra','Bionda','1989','Hofbrauhaus'),
	('Forst','it','3.50','Birra','Rossa','1957','Forst'),
	('Moretti Alla Toscana','it','4.00','Birra','Bionda','1959','Luigi Moretti'),
	('Corona Extra','it','1.10','Birra','Bionda','2003','Cerveceria Modelo'),
	('Moretti Alla Piemontese','it','3.15','Birra','Bionda','1959','Luigi Moretti'),
	('Moscato Di Asti','it','12.00','Vino','Bianco','1994','Araldica'),
	('Bin 407 Cabernet Sauvignon','fr','90.90','Vino','Rosso','1990','Penfolds'),
	('Conte Ugo Bolgheri','it','30.50','Vino','Rosso','2013','Antinori'),
	('Jack Daniels - Old No.7','en','16.00','Superalcolico','Whisky','2002','Jack Daniels Distillery'),
	('Hibiki 17','it','180.00','Superalcolico','Whisky','1999','Suntory Whisky'),
	('Lagavulin','fr','62.00','Superalcolico','Whisky','1999','Lagavulin Distillery'),
	('Oban Single Scotch','en','56.30','Superalcolico','Whisky', '1985','Oban Distillery'),
	('Caol Ila','en','41.90','Superalcolico','Whisky','2004','Caol Ila Distillery'),
	('Talisker Storm Single Malt','en','75.95','Superalcolico','Whisky','1912','Ile Off Skiye Distillery'),
	('Prime Uve','it','23.00','Superalcolico','Grappa','1903','Bonaventura Maschio'),
	('Grappa Riserva Magnum','it','49.00','Superalcolico','Grappa','2010','Sibona'),
	('Grappa Di Amarone Barricata','it','29.00','Superalcolico','Grappa','1994','Bonollo'),
	('Le Diciotto Lune','it','129.00','Superalcolico','Whisky','2013','Marzardo'),
	('Legacy By Angostura','en','17962.5','Superalcolico','Rum','1916','Angostura'),
	('Block 42 - Penfolds Ampoule','fr','157329.00','Vino','Rosso','2004','Penfolds'),
	('Dalmore 40','en','4500.00','Superalcolico','Whisky','1966','Dalmore'),
	('Lalique 57','fr','1200.00','Superalcolico','Whisky','1959','Macallan'),
	('Silver Patron','en','65.90','Superalcolico','Tequila','2001','Patron Spirits International');

SET FOREIGN_KEY_CHECKS = 1;

DELIMITER |

DROP TRIGGER IF EXISTS ModificaCarrello |

CREATE TRIGGER ModificaCarrello

AFTER UPDATE ON Carrello
FOR EACH ROW

	BEGIN

		UPDATE OrdineInCorso OIC
		SET PrezzoProdotti = PrezzoProdotti + NEW.Costo - OLD.Costo
		WHERE OIC.ID = NEW.OrdineInCorso;

	END |

DELIMITER ;

DELIMITER |

DROP TRIGGER IF EXISTS AggiungiAlCarrello |

CREATE TRIGGER AggiungiAlCarrello

AFTER INSERT ON Carrello
FOR EACH ROW

	BEGIN

		UPDATE OrdineInCorso OIC
		SET PrezzoProdotti = PrezzoProdotti + NEW.Costo
		WHERE OIC.ID = NEW.OrdineInCorso;

	END |

DELIMITER ;

DELIMITER |

DROP TRIGGER IF EXISTS RimuoviDalCarrello |

CREATE TRIGGER RimuoviDalCarrello

AFTER DELETE ON Carrello
FOR EACH ROW

	BEGIN

		UPDATE OrdineInCorso OIC
		SET PrezzoProdotti = PrezzoProdotti - OLD.Costo
		WHERE OIC.ID = OLD.OrdineInCorso;

		IF (SELECT PrezzoProdotti
			FROM OrdineInCorso
			WHERE ID = OLD.OrdineInCorso) = 0

		THEN

			DELETE FROM OrdineInCorso
			WHERE ID = OLD.OrdineInCorso;

		END IF;

	END |

DELIMITER ;
