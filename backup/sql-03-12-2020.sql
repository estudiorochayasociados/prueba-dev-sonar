SET FOREIGN_KEY_CHECKS = 0;
CREATE DATABASE IF NOT EXISTS dev-cms-new`;
USE `dev-cms-new`;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `admin` VALUES("1", "facundo@estudiorochayasoc.com.ar", "faAr2010"); 
INSERT INTO `admin` VALUES("2", "web@estudiorochayasoc.com.ar", "weAr2010"); 
INSERT INTO `admin` VALUES("3", "user1@gmail.com", "1234"); 
INSERT INTO `admin` VALUES("4", "user3@gmail.com", "1234"); 


DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `vistas` int(11) NOT NULL DEFAULT 0,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `banners_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_cod` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

INSERT INTO `categorias` VALUES("1", "9e22039913", "ESCRITORIO", "sliders", ""); 
INSERT INTO `categorias` VALUES("2", "e93d84e02a", "MOBILE", "sliders", ""); 
INSERT INTO `categorias` VALUES("18", "76971c0593", "Informacion", "landing", ""); 
INSERT INTO `categorias` VALUES("19", "369925caea", "Compra", "landing", ""); 
INSERT INTO `categorias` VALUES("20", "68ba690364", "Sorteo", "landing", ""); 
INSERT INTO `categorias` VALUES("21", "d01d047aca", "Evento", "landing", ""); 
INSERT INTO `categorias` VALUES("22", "0c2b514bb4", "General", "novedades", ""); 
INSERT INTO `categorias` VALUES("23", "2015d60278", "GENERAL", "videos", ""); 
INSERT INTO `categorias` VALUES("28", "d6b3c8150a", "Frutas", "productos", ""); 
INSERT INTO `categorias` VALUES("41", "20c763610d", "Verduras", "productos", ""); 


DROP TABLE IF EXISTS `contenidos`;
CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `contenido` longtext DEFAULT NULL,
  `cod` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `contenidos` VALUES("1", "NOSOTROS", "Nosotros", "<p>En Verduler&iacute;a Sahara queremos brindarte lo mejor de nuestra tierra. Llevar a tu mesa alimentos frescos y de calidad es nuestra tradici&oacute;n familiar, y sabemos lo importante que es poder experimentar el placer de cocinar, saborear y compartir con los nuestros. Es por eso que seleccionamos rigurosamente cada una de nuestras frutas y verduras que llegar&aacute;n a tu mesa cada d&iacute;a.&nbsp;<br />\nSomos la primera y &uacute;nica verduler&iacute;a de San Francisco que cuenta con un mercado de frutas y verduras online. Es pr&aacute;ctico, conveniente y confiable. Te llevamos a la puerta de tu casa productos 100% frescos. Te ahorramos el tiempo de salir de compras para que puedas disfrutar haciendo lo que te apasiona.&nbsp;<br />\nKeywords: Verduras online, Verduler&iacute;a a domicilio en San Francisco, Verduras online delivery, Frutas y verduras de estaci&oacute;n, Frutas y verduras a domicilio San Francisco.<br />\nDescription: Llevar a tu mesa alimentos frescos y de calidad es nuestra tradici&oacute;n familiar. Lo mejor de nuestra tierra en Verduler&iacute;a Sahara. Frutas y verduras online en San Francisco, C&oacute;rdoba.</p>\n", "571b6301fb"); 
INSERT INTO `contenidos` VALUES("2", "DATOS DE CONTACTO", "DATOS DE CONTACTO", "<p>&iquest;Ten&eacute;s alguna duda, comentario o sugerencia? Contamos con un equipo que se contactar&aacute; con vos a la brevedad para brindarte una respuesta. Queremos brindarte el mejor servicio de delivery de frutas de la ciudad. Dejanos tu mensaje ac&aacute;.<br />\nKeywords: Frutas y verduras frescas, Verduler&iacute;as en San Francisco C&oacute;rdoba, Delivery de verduler&iacute;a, Verduler&iacute;a con delivery, Verduler&iacute;a env&iacute;o a domicilio San Francisco.&nbsp;<br />\nDescription: Delivery de frutas y verduras en San Francisco, C&oacute;rdoba. Estamos para brindarte el mejor servicio. Productos 100% frescos. &iquest;Quer&eacute;s saber m&aacute;s de nosotros? &iexcl;Contactanos!&nbsp;<br />\n&nbsp;</p>\n\n<div class=\"btgrid\">\n<div class=\"row row-1\">\n<div class=\"col col-md-4\">\n<div class=\"content\">\n<p><span style=\"font-size:14px;\"><strong>Tel&eacute;fono:</strong><br />\n3564 15-41-0499</span></p>\n</div>\n</div>\n\n<div class=\"col col-md-4\">\n<div class=\"content\">\n<p><span style=\"font-size:14px;\"><strong>Email:</strong><br />\ninfo@verduleriasahara.com.ar</span></p>\n</div>\n</div>\n\n<div class=\"col col-md-4\">\n<div class=\"content\">\n<p><span style=\"font-size:14px;\"><strong>Ubicaci&oacute;n:</strong><br />\nEsq. 25 de Mayo y Jujuy, San Francisco, C&oacute;rdoba</span></p>\n</div>\n</div>\n</div>\n</div>\n", "14160346d5"); 
INSERT INTO `contenidos` VALUES("3", "test", "", "<div class=\"powr-multi-slider powrLoaded\" id=\"cca9fdb8_1606837707490\"><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"500px\" mozallowfullscreen=\"\" powrindex=\"0\" scrolling=\"yes\" src=\"https://www.powr.io/multi-slider/u/cca9fdb8_1606837707490#platform=ckeditor&amp;url=https%3A%2F%2F26.209.21.226%2Fdev-cms%2Fadmin%2Findex.php%3Fop%3Dcontenidos%26accion%3Dagregar\" style=\"height: 500px; transition: height 0.3s ease 0s; display: inline; visibility: visible;\" webkitallowfullscreen=\"\" width=\"100%\"></iframe></div>\n\n<p>&nbsp;</p>\n", "6ee4878fa6"); 


DROP TABLE IF EXISTS `envios`;
CREATE TABLE `envios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` text NOT NULL,
  `peso` int(11) DEFAULT NULL,
  `precio` float NOT NULL,
  `estado` int(11) NOT NULL,
  `limite` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

INSERT INTO `envios` VALUES("4", "29783", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "600", "478.49", "1", "0"); 
INSERT INTO `envios` VALUES("5", "c3d6c899c7", "Oca", "10", "150", "1", "4500"); 
INSERT INTO `envios` VALUES("6", "60e0c2fe8d", "sucursal", "1", "200", "1", "4000"); 
INSERT INTO `envios` VALUES("9", "25198", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "20", "894", "1", "0"); 
INSERT INTO `envios` VALUES("10", "27116", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "25", "1005", "1", "0"); 
INSERT INTO `envios` VALUES("12", "59136", "E-PAK ESTANDAR  SUCURSAL  A SUCURSAL", "1", "273.09", "1", "1000"); 
INSERT INTO `envios` VALUES("13", "98665", "OCA -  SUCURSAL  A SUCURSAL", "2", "292.2", "1", "0"); 
INSERT INTO `envios` VALUES("14", "53930", "E-PAK ESTANDAR  SUCURSAL  A SUCURSAL", "5", "366.19", "1", "0"); 
INSERT INTO `envios` VALUES("15", "78074", "E-PAK ESTANDAR  SUCURSAL  A SUCURSAL", "10", "489.9", "1", "0"); 
INSERT INTO `envios` VALUES("16", "17591", "E-PAK ESTANDAR  SUCURSAL  A SUCURSAL", "15", "613.75", "1", "0"); 
INSERT INTO `envios` VALUES("17", "42823", "E-PAK ESTANDAR  SUCURSAL  A SUCURSAL", "20", "727.74", "1", "0"); 
INSERT INTO `envios` VALUES("18", "22669", "E-PAK ESTANDAR  SUCURSAL  A SUCURSAL", "25", "861.9", "1", "0"); 
INSERT INTO `envios` VALUES("19", "dd21e06696", "ENVÍO A TOLOSA/LOS HORNOS/GONNET - COORDINAR POR WHATSAPP", "0", "150", "1", "3500"); 
INSERT INTO `envios` VALUES("20", "399dda4612", "RETIRO EN FARMACIA (GRATIS)", "0", "0", "1", "0"); 
INSERT INTO `envios` VALUES("21", "1337cf7b93", "ENVIOS LA PLATA CASCO URBANO - todos los días entre las 17.30 y 19.30hs", "0", "90", "1", "3500"); 
INSERT INTO `envios` VALUES("22", "8ead874541", "ENVÍOS A CITY BELL/VILLA ELISA/BERISSO Y ENSENADA- COORDINAR POR WHATSAPP", "25", "861.9", "1", "0"); 
INSERT INTO `envios` VALUES("23", "f6e2ed1544", "efectivo", "0", "200", "1", "4000"); 
INSERT INTO `envios` VALUES("24", "9469", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "2", "498.65", "1", "0"); 
INSERT INTO `envios` VALUES("25", "49536", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "5", "564.76", "1", "0"); 
INSERT INTO `envios` VALUES("26", "90807", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "10", "670.94", "1", "0"); 
INSERT INTO `envios` VALUES("27", "68816", "E-PAK ESTANDAR  SUCURSAL  A PUERTA", "15", "782.4", "1", "0"); 


DROP TABLE IF EXISTS `galerias`;
CREATE TABLE `galerias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `desarrollo` text DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `galerias_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `imagenes`;
CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(255) NOT NULL,
  `cod` varchar(255) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

INSERT INTO `imagenes` VALUES("17", "assets/archivos/recortadas/a_f3841425f1.jpg", "60559768da", "0"); 
INSERT INTO `imagenes` VALUES("19", "assets/archivos/recortadas/a_ca7c6687b4.jpg", "3702926363", "0"); 
INSERT INTO `imagenes` VALUES("21", "assets/archivos/recortadas/a_a2183716d0.jpg", "25d65f4db2", "0"); 
INSERT INTO `imagenes` VALUES("22", "assets/archivos/recortadas/a_d3dde1f6c2.jpg", "34d8330eec", "0"); 
INSERT INTO `imagenes` VALUES("23", "assets/archivos/recortadas/a_bb6f75424c.jpg", "963e257488", "0"); 
INSERT INTO `imagenes` VALUES("25", "assets/archivos/recortadas/a_86f8173b57.jpg", "50bdf0102c", "0"); 
INSERT INTO `imagenes` VALUES("26", "assets/archivos/recortadas/a_35e67d4e97.jpg", "51b2f935ed", "0"); 


DROP TABLE IF EXISTS `novedades`;
CREATE TABLE `novedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `desarrollo` text DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `subcategoria` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `subcategoria` (`subcategoria`),
  KEY `cod` (`cod`),
  CONSTRAINT `fgk_categorias_novedades` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fgk_subcategorias_novedades` FOREIGN KEY (`subcategoria`) REFERENCES `subcategorias` (`cod`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `novedades` VALUES("1", "34d8330eec", "El consumo de frutos rojos previene la aparición de enfermedades cardiovasculares", "<p>Los zumos de cerezas, ciruelas, granada, frambuesa, grosella o ar&aacute;ndonos son ricos en flavonoides. Seg&uacute;n diversos estudios realizados, los zumos elaborados con estos productos tienen grandes propiedades antioxidantes.</p>\n\n<p>El valor antioxidante de los zumos de frutas viene determinado por la acci&oacute;n conjunta de una serie de sustancias (vitaminas antioxidantes, carotenoides y polifenoles, entre otros) presentes en la fruta de la que proceden. Dicha capacidad antioxidante les confiete notorias propiedades beneficiosas para la salud.</p>\n\n<p>Seg&uacute;n se indica en el Libro del Zumo, editado el a&ntilde;o pasado por Asozumos, las l&iacute;neas de investigaci&oacute;n de los &uacute;ltimos quince a&ntilde;os se han centrado en demostrar las m&uacute;ltiples actividades beneficiosas de ciertos compuestos fen&oacute;licos. Entre los m&aacute;s importantes cabe destacar -por su presencia en las frutas y zumos- los flavonoles (manzana, pera, uva y tomate), flavanonas (c&iacute;tricos), flavanoles (presentes en manzana, albaricoque, melocot&oacute;n, ar&aacute;ndanos, cerezas, ciruelas, granada, caqui, frambuesas y uva) y antocianidinas (uvas y frutos rojos), entre otros.</p>\n\n<p>Por otro lado, los flavonoides son sustancias capaces de inhibir la peroxidaci&oacute;n lip&iacute;dica y de proteger las LDL frente a la oxidaci&oacute;n. Destacan por sus propiedades antioxidantes propiedades antimutag&eacute;nicas, antiinflamatorias, antial&eacute;rgicas, antivirales, antiproliferativas, cardioprotectoras y efectos anticarcinog&eacute;nicos, as&iacute; como por su influencia en la disminuci&oacute;n de l&iacute;pidos en sangre, entre otras.</p>\n\n<p>Los zumos de frutos rojos, ricos en polifenoles, destacan por su papel antioxidante y por su aporte de efectos positivos en la salud vascular, sobre todo, por los beneficios sobre la presi&oacute;n sangu&iacute;nea. Adem&aacute;s, son ricos en antocianinas, de las que se han identificado m&aacute;s de quinientos tipos, que son los pigmentos naturales responsables de los colores rojos, azules y morados de muchas frutas y vegetales.</p>\n\n<p>Las antocianinas, adem&aacute;s, son capaces de actuar en distintas c&eacute;lulas involucradas en el desarrollo de la arteriosclerosis, una de las principales causas de enfermedades cardiovasculares. Poseen actividad antitumoral y antimutag&eacute;nica, efectos beneficiosos en la diabetes, actividad antimicrobiana y antiviral o efectos en los procesos neurodegenerativos.</p>\n\n<p>Algunos autores consideran que es posible que los efectos beneficiosos de estos zumos se potencien mediante el consumo de zumos de uva tinta -que contiene los mayores niveles de flavanoles y procianidinas, antocianinas y &aacute;cidos hidroxicin&aacute;micos- y zumo de ar&aacute;ndanos, ricos en flavonoles.Los zumos de granada, fresa y frambuesa contienen mayoritariamente el elagitanino y en menor cantidad, el &aacute;cido el&aacute;gico libre del que se encuentran entre 2,9 y 15 mg / 100 ml en zumos de granada comerciales y cantidades algo menores en sus derivados. Algunas propiedades atribuidas a los elagitaninos se relacionan con la actividad anticancer&iacute;gena, hepatoprotectora, as&iacute; como con su papel en la prevenci&oacute;n de enfermedades cardiovasculares. Asimismo, ha demostrado en diversos estudios un papel de relevancia en la actividad antioxidante.</p>\n\n<p>En general, los zumos contienen un gran n&uacute;mero de compuestos que, adem&aacute;s de aportarles un sabor muy apetecible, les hace muy apropiados para hidratarnos en estos d&iacute;as de calor sofocante.</p>\n", "0c2b514bb4", "", "124", "124", "2020-04-20"); 
INSERT INTO `novedades` VALUES("2", "963e257488", "Consumo de frutas y verduras", "<p>El consumo diario de frutas y verduras es una parte esencial de la alimentaci&oacute;n saludable, ayuda a garantizar una ingesta diaria suficiente de fibra diet&eacute;tica y micronutrientes. Contribuye a la prevenci&oacute;n de la obesidad y de numerosas enfermedades, como las cardiovasculares y algunos c&aacute;nceres.</p>\n\n<p>Las Gu&iacute;as Alimentarias para la Poblaci&oacute;n Argentina (GAPA), elaboradas por el Ministerio de Salud de la Naci&oacute;n en el 2016, recomiendan un consumo diario de 5 porciones de frutas y verduras variadas en tipo y color (una porci&oacute;n equivale a medio plato de verduras o una fruta chica). Quedan excluidas de esta recomendaci&oacute;n las hortalizas feculentas (papa, batata, mandioca y choclo), que deben consumirse con moderaci&oacute;n.</p>\n\n<p>La ingesta actual de frutas y verduras en la Argentina se encuentra muy por debajo de esta meta: seg&uacute;n la Encuesta Nacional de Factores de Riesgo (ENFR) 2018, solo el 6% de la poblaci&oacute;n adulta cumple con la recomendaci&oacute;n de consumo de cinco porciones de frutas y verduras. Por otro lado, seg&uacute;n la Encuesta Mundial de Salud Escolar realizada en 2012 por el Ministerio de Salud de la Naci&oacute;n, de la poblaci&oacute;n adolescente de entre 13 y 15 a&ntilde;os, s&oacute;lo el 17,6% cumple con la recomendaci&oacute;n.</p>\n\n<p>Seg&uacute;n la Organizaci&oacute;n Mundial de la Salud (OMS), si la poblaci&oacute;n mundial incrementara el consumo de frutas y verduras de manera suficiente, podr&iacute;an salvarse 1,7 millones de vidas.</p>\n\n<p>Actualmente, el consumo estimado es muy variable entre los distintos pa&iacute;ses, pero el de los pa&iacute;ses de altos ingresos es considerablemente mayor que el de los pa&iacute;ses de medianos y bajos ingresos, acentuando la desigualdad.</p>\n\n<p>Este patr&oacute;n alimentario de bajo consumo de frutas y verduras, en un contexto de crecimiento de la ingesta de productos procesados con altos contenidos de az&uacute;car, grasas y/o sal, se asocia con una mayor prevalencia de sobrepeso y obesidad, diabetes, hipertensi&oacute;n, enfermedades cardiovasculares (infarto y accidentes cerebrovasculares) y algunos tipos de c&aacute;ncer. En este sentido, la evidencia cient&iacute;fica se&ntilde;ala que la ingesta insuficiente de frutas y verduras provoca en el mundo aproximadamente un 19% de los c&aacute;nceres gastrointestinales, un 31% de las cardiopat&iacute;as isqu&eacute;micas y un 11% de los ACV.</p>\n\n<p>En este marco, la comunidad internacional, a trav&eacute;s de la Estrategia Mundial de OMS sobre r&eacute;gimen alimentario, actividad f&iacute;sica y salud (2004), y el Plan de Acci&oacute;n Global de la OMS para la prevenci&oacute;n y Control de las Enfermedades Cr&oacute;nicas No Transmisibles (2013-2020) insta a los gobiernos a adoptar medidas para aumentar la disponibilidad, asequibilildad y consumo de frutas y verduras en la poblaci&oacute;n. Esto tiene el objetivo de reducir el impacto de las enfermedades no transmisibles y proteger la salud.</p>\n", "0c2b514bb4", "", "", "", "2020-04-24"); 


DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `leyenda` text DEFAULT NULL,
  `cod` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL,
  `aumento` int(11) DEFAULT 0,
  `disminuir` int(11) DEFAULT 0,
  `defecto` int(11) DEFAULT 0,
  `tipo` varchar(11) DEFAULT NULL COMMENT 'ID de _cfg_pagos',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `pagos` VALUES("1", "Efectivo", "", "33958cd6c6", "1", "", "", "1", ""); 
INSERT INTO `pagos` VALUES("4", "Tarjeta de crédito 10% recargo", "", "a0d3801be9", "1", "10", "", "1", "1"); 


DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `estado` int(11) DEFAULT 0,
  `tipo` varchar(255) DEFAULT '0',
  `detalle` text DEFAULT NULL,
  `total` float NOT NULL DEFAULT 0,
  `usuario` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `hub_cod` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cod` (`cod`,`usuario`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `pedidos` VALUES("1", "0757041", "1", "Efectivo", "{\"leyenda\":\"\",\"descuento\":\"\",\"envio\":{\"tipo\":\"Envio Sucursañ\",\"nombre\":\"564\",\"apellido\":\"654\",\"email\":\"jhgjh@dfg.com\",\"provincia\":\"Chaco\",\"localidad\":\"10 DE MAYO\",\"direccion\":\"489\",\"telefono\":\"465\"},\"pago\":{\"nombre\":\"564\",\"apellido\":\"654\",\"email\":\"jhgjh@dfg.com\",\"dni\":\"156\",\"provincia\":\"Chaco\",\"localidad\":\"10 DE MAYO\",\"direccion\":\"489\",\"telefono\":\"465\",\"factura\":false}}", "70", "16122c1c6e", "2020-08-31 17:28:50", ""); 
INSERT INTO `pedidos` VALUES("2", "E095598", "1", "Efectivo", "{\"leyenda\":\"\",\"descuento\":\"\",\"envio\":{\"tipo\":\"efectivo\",\"nombre\":\"Micael\",\"apellido\":\"Galvan\",\"email\":\"micaelestudiorocha@gmail.com\",\"provincia\":\"Chubut\",\"localidad\":\"28 DE JULIO\",\"direccion\":\"123\",\"telefono\":\"123123\"},\"pago\":{\"nombre\":\"Micael\",\"apellido\":\"Galvan\",\"email\":\"micaelestudiorocha@gmail.com\",\"dni\":\"12312312323\",\"provincia\":\"Chubut\",\"localidad\":\"28 DE JULIO\",\"direccion\":\"123\",\"telefono\":\"123123\",\"factura\":false}}", "231", "7f027471dc", "2020-10-21 15:28:07", ""); 
INSERT INTO `pedidos` VALUES("3", "CDA9177", "1", "Efectivo", "{\"leyenda\":\"\",\"descuento\":\"\",\"envio\":{\"tipo\":\"ENVIOS LA PLATA CASCO URBANO - todos los días entre las 17.30 y 19.30hs\",\"nombre\":\"Micael\",\"apellido\":\"Galvan\",\"email\":\"micaelestudiorocha@gmail.com\",\"provincia\":\"Chaco\",\"localidad\":\"10 DE MAYO\",\"direccion\":\"123\",\"telefono\":\"123123\"},\"pago\":{\"nombre\":\"Micael\",\"apellido\":\"Galvan\",\"email\":\"micaelestudiorocha@gmail.com\",\"dni\":\"12312312323\",\"provincia\":\"Chaco\",\"localidad\":\"10 DE MAYO\",\"direccion\":\"123\",\"telefono\":\"123123\",\"factura\":false}}", "121", "7f027471dc", "2020-10-21 15:34:30", ""); 


DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `desarrollo` text DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `subcategoria` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `subcategoria` (`subcategoria`),
  KEY `subcategoria_2` (`subcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `cod_producto` varchar(255) DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `desarrollo` text DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `precio` float DEFAULT 0,
  `precio_descuento` float DEFAULT 0,
  `porcentaje_descuento` float DEFAULT NULL,
  `precio_mayorista` float DEFAULT 0,
  `categoria` varchar(255) DEFAULT NULL,
  `subcategoria` varchar(255) DEFAULT NULL,
  `peso` float DEFAULT 0,
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `envio_gratis` tinyint(1) DEFAULT 0,
  `mostrar_web` tinyint(1) DEFAULT 1,
  `variable1` text DEFAULT NULL,
  `variable2` text DEFAULT NULL,
  `variable3` text DEFAULT NULL,
  `variable4` text DEFAULT NULL,
  `variable5` text DEFAULT NULL,
  `variable6` text DEFAULT NULL,
  `variable7` text DEFAULT NULL,
  `variable8` text DEFAULT NULL,
  `variable9` text DEFAULT NULL,
  `variable10` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `meli` tinyint(1) DEFAULT 0,
  `url` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `subcategoria` (`subcategoria`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO `productos` VALUES("6", "60559768da", "", "Banana (1kg)", "", "10", "70", "", "", "", "d6b3c8150a", "", "0", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-05-07", "1", ""); 
INSERT INTO `productos` VALUES("7", "25d65f4db2", "", "Palta (1kg)", "", "99", "150", "", "", "", "d6b3c8150a", "", "0.5", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-05-07", "0", ""); 
INSERT INTO `productos` VALUES("8", "3702926363", "", "Acelga (1kg)", "", "100", "7500", "7000", "", "", "20c763610d", "", "0.3", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-10-30", "", ""); 
INSERT INTO `productos` VALUES("9", "51b2f935ed", "", "Test combinaciones y envio", "", "10", "13", "0", "", "", "d6b3c8150a", "", "1.1", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-07-15", "0", ""); 
INSERT INTO `productos` VALUES("10", "117f3f6ce7", "dfsfdsdf", "sd", "<p>543</p>\n", "9998", "352", "31", "", "43543", "d6b3c8150a", "", "1", "543", "534", "0", "0", "1", "543", "543", "543", "543", "543", "543", "543", "543", "1", "1", "2020-10-21", "0", ""); 
INSERT INTO `productos` VALUES("11", "f0079cc537", "123", "crema", "\n654646446\n\n\n", "235", "1236", "", "", "", "d6b3c8150a", "2c99b9fa7b", "10", "456", "654", "", "", "1", "654", "", "", "", "", "", "", "", "", "1", "2020-12-02", "", ""); 
INSERT INTO `productos` VALUES("12", "61e4e2a43d", "", "a", "<p>asd</p>\n", "10", "2001", "", "", "", "20c763610d", "2ccd00a8d3", "", "#Paisagismoresidencial ,#jardimresidencial ,#paisagismoflorianopolis ,#paisagistaflorianopolis ,#arquitetapaisagista ,#arquitetopaisagista ,#jardimdecasasmodernas ,#jardimmoderno ,#paisagismotropical ,#paisagismomoderno ,#casaejardim ,#paisagismobrasil ,#paisagista ,#arquiteturapaisagistica ,#arquiteturadesign ,#arquitetando ,#imoveisdeluxo ,#altopadrao ,#jardimtropical ,#landscapearchitect ,#landscapedesigner ,#giardino ,#contemporaygarden ,#moderngarden ,#paisajismo ,#sofisticacao ,#designinspirations ,#yaelgossis ,#jurere ,#paisagismoresidencial ,#paisagismourbano ,#paisagismocomercial ", "", "", "", "1", "", "", "", "", "", "", "", "", "1", "", "2020-12-02", "", ""); 


DROP TABLE IF EXISTS `servicios`;
CREATE TABLE `servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `desarrollo` text DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `subcategoria` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `categoria_2` (`categoria`),
  KEY `categoria_3` (`categoria`),
  KEY `categoria_4` (`categoria`),
  KEY `subcategoria` (`subcategoria`),
  KEY `subcategoria_2` (`subcategoria`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `sliders`;
CREATE TABLE `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `titulo` text DEFAULT NULL,
  `titulo_on` tinyint(1) DEFAULT 0,
  `subtitulo` text DEFAULT NULL,
  `subtitulo_on` tinyint(1) DEFAULT 0,
  `categoria` varchar(255) DEFAULT NULL,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `link_on` tinyint(1) DEFAULT 0,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `sliders` VALUES("3", "50bdf0102c", "Slider 1", "", "", "", "9e22039913", "", "", "2020-05-21"); 


DROP TABLE IF EXISTS `subcategorias`;
CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_subcategoria` (`cod`),
  KEY `cod_categoria_fk` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO `subcategorias` VALUES("1", "1214a", "SUBCATEGORIA", "ec0af"); 
INSERT INTO `subcategorias` VALUES("2", "3bad4", "1", "e5e12"); 
INSERT INTO `subcategorias` VALUES("3", "aa4bc", "SUBCATEGORIA", "12f4c"); 
INSERT INTO `subcategorias` VALUES("4", "394f2", "1", "925b1"); 
INSERT INTO `subcategorias` VALUES("5", "51d08", "SUBCATEGORIA", "33ee9"); 
INSERT INTO `subcategorias` VALUES("6", "b0868", "1", "cdb9b"); 
INSERT INTO `subcategorias` VALUES("7", "691ec", "1", "1b58d"); 
INSERT INTO `subcategorias` VALUES("8", "1115b", "1", "96ddb"); 
INSERT INTO `subcategorias` VALUES("10", "a309c", "1", "e9c96"); 
INSERT INTO `subcategorias` VALUES("12", "70ffaa07ba", "Jeans", "7bef662404"); 
INSERT INTO `subcategorias` VALUES("13", "a722595ffc", "Sueltas", "6059b18aae"); 
INSERT INTO `subcategorias` VALUES("14", "111eeaaa59", "asdasd", "d6b3c8150a"); 
INSERT INTO `subcategorias` VALUES("15", "2ccd00a8d3", "test", "20c763610d"); 
INSERT INTO `subcategorias` VALUES("16", "2c99b9fa7b", "teeeeeestttt", "d6b3c8150a"); 


DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) DEFAULT NULL,
  `nombre` text DEFAULT NULL,
  `apellido` text DEFAULT NULL,
  `doc` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `postal` text DEFAULT NULL,
  `localidad` text DEFAULT NULL,
  `provincia` text DEFAULT NULL,
  `pais` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `celular` text DEFAULT NULL,
  `minorista` int(1) DEFAULT 1,
  `invitado` int(1) DEFAULT 1,
  `descuento` float DEFAULT 0,
  `fecha` date DEFAULT NULL,
  `estado` int(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` VALUES("1", "60df254db4", "FACUNDO", "ROCHA", "", "facundo@estudiorochayasoc.com.ar", "", "Moreno 357", "", "SAN FRANCISCO", "Córdoba", "", "3564570789", "", "1", "1", "0", "2020-04-20", "1"); 
INSERT INTO `usuarios` VALUES("2", "1d9b871c81", "facundo", "facundo", "", "facundo_rocha@af", "", "124", "", "11 DE SEPTIEMBRE", "Buenos Aires", "", "124124", "", "1", "1", "0", "2020-04-20", "1"); 
INSERT INTO `usuarios` VALUES("3", "6985c2e605", "facundo", "facundo", "", "facundo.rocha93@gmail.com", "080e58d2b27b0af24ad5ff675f9b2c3618dfa91524ad80f86d4e11017623966c", "124", "", "11 DE SEPTIEMBRE", "Buenos Aires", "", "124124", "", "1", "0", "50", "2020-04-20", "1"); 
INSERT INTO `usuarios` VALUES("4", "449022e113", "facundo", "rocha", "", "facundoestudiorocha@gmail.com", "", "morneo 357", "", "SAN FRANCISCO", "Córdoba", "", "3564570789", "", "1", "1", "0", "2020-04-20", "1"); 
INSERT INTO `usuarios` VALUES("5", "f4bb8e9056", "Lautaro", "Gonzalez", "", "webestudiorocha@gmail.com", "04588924d0cb3f712722e6fc336ac31160fc4dd4fecab565ea85b38ea1c3a581", "asdadasd", "", "28 DE JULIO", "Chubut", "", "123213", "", "1", "0", "0", "2020-04-24", "1"); 
INSERT INTO `usuarios` VALUES("6", "00e2867d40", "124", "124", "", "124@a124", "", "2412", "", "12 DE OCTUBRE", "Buenos Aires", "", "124@", "", "1", "1", "0", "2020-06-19", "1"); 
INSERT INTO `usuarios` VALUES("7", "16122c1c6e", "234243", "34243", "", "gfd6@gmai.com", "", "342", "", "16 DE JULIO", "Buenos Aires", "", "342", "", "1", "1", "0", "2020-06-26", "1"); 
INSERT INTO `usuarios` VALUES("8", "8bab5a63a6", "Miguel", "Miguel", "", "gastonestudiorocha@gmail.com", "", "ad", "", "28 DE JULIO", "Chubut", "", "123", "", "1", "1", "0", "2020-07-15", "1"); 
INSERT INTO `usuarios` VALUES("9", "7f027471dc", "Micael", "123", "", "micaelestudiorocha@gmail.com", "8e3e63eacece69a71cba0a091140fbf6ba18e32dcc57aa0aebfd99e94b4b88c4", "123", "", "C.A.B.A.", "Ciudad Autónoma de Buenos Aires (CABA)", "", "123123", "", "1", "0", "0", "2020-10-21", "1"); 


DROP TABLE IF EXISTS `videos`;
CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `subcategoria` varchar(255) DEFAULT NULL,
  `link` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`,`subcategoria`),
  KEY `subcategoria` (`subcategoria`),
  CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`cod`),
  CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`subcategoria`) REFERENCES `subcategorias` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;