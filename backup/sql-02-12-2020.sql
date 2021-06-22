SET FOREIGN_KEY_CHECKS = 0;
CREATE DATABASE IF NOT EXISTS `dev-cms-new`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `banners` VALUES("1", "df25d1c812", "Banner1", "5e0dee265d", "0", ""); 
INSERT INTO `banners` VALUES("2", "e21eecb75c", "contacto banner", "", "0", ""); 


DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_cod` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

INSERT INTO `categorias` VALUES("42", "30ccb12d9a", "ImagenesCarrusel", "sliders", ""); 
INSERT INTO `categorias` VALUES("43", "1fdcaf1e1b", "Videos", "videos", ""); 
INSERT INTO `categorias` VALUES("44", "5e0dee265d", "banner-video", "banners", ""); 
INSERT INTO `categorias` VALUES("47", "4e06a993ac", "LINEA APICOLA", "productos", ""); 
INSERT INTO `categorias` VALUES("48", "4203723bc8", "LINEA BIDONES", "productos", ""); 
INSERT INTO `categorias` VALUES("49", "884ce62338", "LINEA DESCARTADORES", "productos", ""); 
INSERT INTO `categorias` VALUES("50", "3a2d3834e0", "LINEA INYECCION", "productos", ""); 
INSERT INTO `categorias` VALUES("51", "ae17781376", "LINEA LABORATORIO", "productos", ""); 
INSERT INTO `categorias` VALUES("52", "d1db409f76", "LINEA LIMPIEZA", "productos", ""); 
INSERT INTO `categorias` VALUES("53", "9d33bd6214", "LINEA VARIOS", "productos", ""); 
INSERT INTO `categorias` VALUES("54", "4f144d866d", "LINEA PET", "productos", ""); 
INSERT INTO `categorias` VALUES("55", "eafccc44bf", "LINEA COSMETICA", "productos", ""); 


DROP TABLE IF EXISTS `contenidos`;
CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `contenido` longtext DEFAULT NULL,
  `cod` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO `contenidos` VALUES("1", "NOSOTROS", "Nosotros", "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse elementum ex sit amet neque tempus, eu sollicitudin enim cursus. Curabitur ultricies cursus turpis sed consectetur. Integer a magna pulvinar mi accumsan elementum. Nunc mollis libero est, sed elementum ante consectetur id. Cras nunc neque, consequat non metus at, accumsan sagittis velit. Nullam bibendum, urna nec venenatis porta, neque leo convallis nibh, sed condimentum risus lacus nec odio. Fusce quis massa odio. Nulla eu dui mattis massa venenatis vehicula.</p>\n\n<p>Nulla molestie, lectus vel cursus pellentesque, ligula augue laoreet nulla, in convallis leo tortor in dui. Ut vitae mauris nulla. Nam a nunc turpis. Ut commodo imperdiet nibh nec accumsan. Nullam vitae accumsan ipsum, at bibendum magna. Donec purus augue, sagittis et eros eget, aliquet viverra augue. Proin iaculis, risus pulvinar ultricies tincidunt, nulla est dictum lorem, eget laoreet ligula lectus non odio. Pellentesque quis accumsan nibh. Etiam commodo porttitor magna. Ut vitae suscipit nisi. Fusce non tincidunt nulla, non accumsan mi. Fusce erat nibh, faucibus at eros nec, pellentesque gravida felis. Nullam in justo aliquam, scelerisque urna et, vehicula dolor. Suspendisse feugiat turpis id sem porttitor, id finibus ipsum dapibus.</p>\n\n<p>Maecenas tempor sed metus eu auctor. Aenean nec feugiat nunc. Vestibulum ac metus sit amet ipsum malesuada semper sit amet in dolor. Quisque faucibus nec lorem vel egestas. Praesent est augue, ullamcorper a augue sit amet, fringilla consequat augue. Aenean id imperdiet mauris, et vestibulum nisi. Sed ac nulla ac urna gravida semper. Duis pellentesque leo ac felis sollicitudin, in suscipit quam consequat. Praesent congue mi velit, vel pulvinar metus elementum a. Vivamus quis velit egestas, vehicula enim nec, semper augue. Nam ut ipsum eget erat placerat consectetur. Nullam eu accumsan nisl. Curabitur facilisis libero at lacus rutrum ultricies. Sed quis elit eget diam pulvinar feugiat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer justo tortor, venenatis vitae ornare eu, bibendum luctus urna.</p>\n\n<p>Donec dapibus maximus ante bibendum dapibus. Vestibulum molestie, ipsum quis tincidunt dignissim, sapien neque lobortis ipsum, in convallis orci nisi at arcu. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed feugiat urna consectetur augue pellentesque, in consequat ipsum suscipit. Duis et consectetur eros. Curabitur tempor, justo vel suscipit posuere, dui nisl pretium lectus, non elementum enim sem eu libero. Curabitur imperdiet justo gravida varius cursus. Suspendisse finibus ac massa ut volutpat. Aenean urna felis, mollis in sapien sed, laoreet ullamcorper eros. Integer fringilla ipsum a est efficitur, a interdum quam maximus. Aliquam consequat tortor tempor nunc faucibus, in posuere odio mattis. Etiam ipsum dui, tincidunt a aliquet non, consectetur varius nisl. Integer vulputate, magna lacinia commodo commodo, neque augue sagittis nisi, in sollicitudin nisl nisl ac neque. Maecenas viverra auctor facilisis. Ut gravida vehicula augue ac vestibulum. In tempor arcu ligula.</p>\n\n<p>Morbi cursus odio a lorem efficitur imperdiet. Etiam molestie ullamcorper tellus quis auctor. Quisque non risus porttitor, aliquet nibh et, ullamcorper orci. Proin leo leo, aliquet eu pretium vel, sodales vel tellus. Aliquam feugiat neque et hendrerit posuere. Donec rhoncus nisl a leo semper facilisis. Aenean vulputate faucibus ex, a varius elit laoreet rutrum. Ut vestibulum vel mauris sit amet rhoncus. Curabitur egestas fringilla tortor vel maximus. Quisque at cursus lacus, sed elementum sem. Aenean non mauris tristique, commodo sem vitae, placerat arcu. Praesent at odio id mauris aliquam accumsan a vitae orci. Vestibulum lacinia egestas dui a mollis. Curabitur venenatis risus ante, elementum eleifend lacus condimentum quis.</p>\n", "571b6301fb"); 
INSERT INTO `contenidos` VALUES("3", "Contenido inicio 1", "", "<p><white>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</white></p>\n", "26380593d3"); 
INSERT INTO `contenidos` VALUES("4", "banner-contacto", "Contactos", "", "c0b731e13e"); 
INSERT INTO `contenidos` VALUES("5", "banner-servicios", "Servicios", "", "f94b44875f"); 
INSERT INTO `contenidos` VALUES("6", "Contenido inicio 2", "FABRICA DE ENVASES PLASTICOS", "<p><white><white>Somos una empresa Argentina especializada en la fabricaci&oacute;n de envases pl&aacute;sticos. Desde C&oacute;rdoba elaboramos una gran diversidad de envases que enviamos a todo el pa&iacute;s.</white></white></p>\n", "c645ab3447"); 
INSERT INTO `contenidos` VALUES("7", "Banner-Novedades", "Novedades", "", "49106c1311"); 
INSERT INTO `contenidos` VALUES("8", "¿QUE ES EL SISTEMA IN HOUSE?", "", "<p><span style=\"font-size:12px;\"><white>El mercado de PET esta en plena expansion debido a la sustitucion de materiales a favor del PET por sus indiscutibles ventajas en apariencia, resistencia y durabilidad.</white></span></p>\n\n<p><span style=\"font-size:12px;\"><white>Este sistema consiste en el soplado de preformas para la elaboraci&oacute;n de envases PET en la propia planta de producci&oacute;n del cliente permitiendole de este modo el aprovisionamiento de envases de calidad en tiempo y forma acorde a sus necesidades productivas.</white></span></p>\n\n<p><span style=\"font-size:12px;\"><white>Estin Argentina le provee la tecnolog&iacute;a (maquinas sopladoras y demas equipamiento periferico), personal capacitado para los puestos y el know how necesario para entregarle un envase de calidad.</white></span></p>\n", "238e778f6f"); 
INSERT INTO `contenidos` VALUES("9", "BENEFICIOS DEL SISTEMA", "", "<div>\n<p><span style=\"font-size:12px;\"><white>La empresa que contrata nuestro sistema IN HOUSE , no requiere inversion de capital, pues Estin Argentina, es quien provee la tecnologia necesaria para la producci&oacute;n de envases.</white></span></p>\n\n<p><span style=\"font-size:12px;\"></span><span style=\"font-size:12px;\"><white>Al tercerizar el servicio la empresa no le quita el foco a su negocio especifico.</white></span></p>\n\n<p><span style=\"font-size:12px;\"></span><span style=\"font-size:12px;\"><white>El personal operativo para la produccion esta a cargo de Estin Argentina.</white></span></p>\n\n<p><span style=\"font-size:12px;\"></span><span style=\"font-size:12px;\"><white>Se minimiza al maximo los costos y demoras vinculadas con el transporte de los envases desde el proveedor hasta la planta del cliente.</white></span></p>\n\n<p><span style=\"font-size:12px;\"></span><span style=\"font-size:12px;\"><white>Se generan ahorros en costos de almacenaje, ya que el sistema permite una producci&oacute;n Just in time acorde a las necesidades del cliente, entregando los envases en el momento en la empresa los necesita en linea de producci&oacute;n, generando ademas ahorro en los costos de embalaje.</white></span></p>\n\n<p><span style=\"font-size:12px;\"></span><span style=\"font-size:12px;\"><white>Reduce la manipulaci&oacute;n de los envases permitiendo entregarlos al cliente en optimas condiciones de calidad.</white></span></p>\n\n<p><span style=\"font-size:12px;\"></span><span style=\"font-size:12px;\"><white>El cliente cuenta ademas con el respaldo de una empresa lider en el mercado de soplado de envases.</white></span></p>\n</div>\n", "724f0fd529"); 
INSERT INTO `contenidos` VALUES("10", "COMO CONTRATAR EL SISTEMA", "", "<p><span style=\"font-size:12px\"><white>Envienos su consulta a traves de nuestro formulario de contacto o por cualquiera de nuestras vias de comunicacion y un asesor se comunicara con Ud. a la brevedad. ESPERAMOS SU CONTACTO!</white></span></p>\n", "bca0ce08d7"); 
INSERT INTO `contenidos` VALUES("11", "Servicio de Litografiado", "", "<p><white>La impresi&oacute;n de envases se realiza a trav&eacute;s de un sistema denominado litografiado, realizado con materiales de alta calidad, que permiten destacar las caracteristicas del producto y su marca.</white></p>\n", "ad3a8219c8"); 
INSERT INTO `contenidos` VALUES("12", "Servicio de colocación de fajas", "", "<p><white>Estin Argentina le brinda a sus clientes un servicio de colocacion de etiquetas o fajas provistas por los mismos con la marca y las especificaciones del producto. Ofreciendo un producto terminado y listo para su utilizaci&oacute;n.</white></p>\n", "df79a80df7"); 
INSERT INTO `contenidos` VALUES("13", "Servicio de Matricería", "", "<p><white>Se cuenta con un &aacute;rea de producci&oacute;n y desarrollo de matricer&iacute;a, la cual proyecta crea y mantiene las matrices, para productos propios o de terceros.</white></p>\n", "bcda502119"); 
INSERT INTO `contenidos` VALUES("14", "Servicio de Logística", "", "<p><white>Brindamos asesoramiento de logistica que permite optimizar tiempos y costos para el transporte y traslado de los productos a puerta del cliente.</white></p>\n", "47f6823e69"); 
INSERT INTO `contenidos` VALUES("15", "productos", "Nuestros Productos", "", "8aa5da4415"); 
INSERT INTO `contenidos` VALUES("16", "test", "", "<div class=\"powr-multi-slider powrLoaded\" id=\"0be3abb1_1606837392075\"><iframe allowfullscreen=\"\" frameborder=\"0\" height=\"814px\" mozallowfullscreen=\"\" powrindex=\"0\" src=\"https://www.powr.io/multi-slider/u/0be3abb1_1606837392075#platform=ckeditor&amp;url=https%3A%2F%2Flocalhost%2Fdev-cms%2Fadmin%2Findex.php%3Fop%3Dcontenidos%26accion%3Dmodificar%26cod%3Df615b57ca2\" style=\"height: 814px; transition: height 0.3s ease 0s; display: inline; visibility: visible;\" webkitallowfullscreen=\"\" width=\"100%\"></iframe></div>\n\n<p>&nbsp;</p>\n", "f615b57ca2"); 


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
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

INSERT INTO `imagenes` VALUES("29", "assets/archivos/recortadas/a_46dd9c6f0e.jpg", "df25d1c812", "0"); 
INSERT INTO `imagenes` VALUES("31", "assets/archivos/recortadas/a_72b930ae8a.jpg", "e21eecb75c", "0"); 
INSERT INTO `imagenes` VALUES("35", "assets/archivos/recortadas/a_c92e195a3b.png", "4077094585", "0"); 
INSERT INTO `imagenes` VALUES("37", "assets/archivos/recortadas/a_48600da90f.jpeg", "8c6e4617dd", "0"); 
INSERT INTO `imagenes` VALUES("39", "assets/archivos/recortadas/a_79ec443938.jpg", "096f22822e", "0"); 
INSERT INTO `imagenes` VALUES("45", "assets/archivos/recortadas/a_6924f974bd.jpg", "39f10fd616", "0"); 
INSERT INTO `imagenes` VALUES("46", "assets/archivos/recortadas/a_496db92671.jpg", "39f10fd616", "0"); 
INSERT INTO `imagenes` VALUES("47", "assets/archivos/recortadas/a_5c9e91d53f.jpg", "39f10fd616", "0"); 
INSERT INTO `imagenes` VALUES("48", "assets/archivos/recortadas/a_64f2de32d5.jpg", "39f10fd616", "0"); 
INSERT INTO `imagenes` VALUES("49", "assets/archivos/recortadas/a_e7bd7847a8.jpg", "39f10fd616", "0"); 
INSERT INTO `imagenes` VALUES("50", "assets/archivos/recortadas/e7f74a12fa.jpg", "c0b731e13e", "0"); 
INSERT INTO `imagenes` VALUES("51", "assets/archivos/recortadas/5de986ccf1.jpg", "f94b44875f", "0"); 
INSERT INTO `imagenes` VALUES("52", "assets/archivos/recortadas/c355693ea0.jpg", "571b6301fb", "0"); 
INSERT INTO `imagenes` VALUES("54", "assets/archivos/recortadas/a_302a18e878.jpg", "b499c5375f", "0"); 
INSERT INTO `imagenes` VALUES("55", "assets/archivos/recortadas/a_c74670b97f.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("56", "assets/archivos/recortadas/a_f371acddfd.jpg", "4fb5af5002", "0"); 
INSERT INTO `imagenes` VALUES("57", "assets/archivos/recortadas/a_b88d98a4ae.jpg", "952dbcc80a", "0"); 
INSERT INTO `imagenes` VALUES("58", "assets/archivos/recortadas/1a9fc1f448.jpg", "238e778f6f", "0"); 
INSERT INTO `imagenes` VALUES("59", "assets/archivos/recortadas/1b8006e111.jpg", "724f0fd529", "0"); 
INSERT INTO `imagenes` VALUES("60", "assets/archivos/recortadas/ed8c93caab.jpg", "bca0ce08d7", "0"); 
INSERT INTO `imagenes` VALUES("61", "assets/archivos/recortadas/8a0bd8a5ab.jpg", "26380593d3", "0"); 
INSERT INTO `imagenes` VALUES("62", "assets/archivos/recortadas/a_8b34a0487f.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("63", "assets/archivos/recortadas/a_3e313aba3e.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("64", "assets/archivos/recortadas/a_6e98b11cd0.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("65", "assets/archivos/recortadas/a_6484f29bbf.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("66", "assets/archivos/recortadas/a_b256aa69d1.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("67", "assets/archivos/recortadas/a_efae4922cb.jpg", "75decd5df8", "0"); 
INSERT INTO `imagenes` VALUES("69", "assets/archivos/recortadas/a_8905f9d31e.jpg", "6e2f6fab5e", "0"); 
INSERT INTO `imagenes` VALUES("70", "assets/archivos/recortadas/a_7975ccb38f.jpg", "2d9ad2bdd0", "0"); 
INSERT INTO `imagenes` VALUES("71", "assets/archivos/recortadas/a_e39b67a068.jpg", "55fb916569", "0"); 
INSERT INTO `imagenes` VALUES("72", "assets/archivos/recortadas/a_97db02d614.jpg", "0414a926f5", "0"); 
INSERT INTO `imagenes` VALUES("73", "assets/archivos/recortadas/a_2f98f2b05d.jpg", "f9b6184342", "0"); 
INSERT INTO `imagenes` VALUES("74", "assets/archivos/recortadas/a_74838bdfc3.jpg", "507000b148", "0"); 
INSERT INTO `imagenes` VALUES("75", "assets/archivos/recortadas/a_5ad63798cd.jpg", "babacbd08a", "0"); 
INSERT INTO `imagenes` VALUES("76", "assets/archivos/recortadas/a_ec76aa098b.jpg", "76fae0c461", "0"); 
INSERT INTO `imagenes` VALUES("77", "assets/archivos/recortadas/a_c97e2cbf66.jpg", "c30a728b58", "0"); 
INSERT INTO `imagenes` VALUES("78", "assets/archivos/recortadas/48f2b9ac6e.jpg", "8aa5da4415", "0"); 
INSERT INTO `imagenes` VALUES("79", "assets/archivos/recortadas/a_c065afb07b.jpg", "42816e48f1", "0"); 
INSERT INTO `imagenes` VALUES("80", "assets/archivos/recortadas/a_6800d3d766.jpg", "86d30dac16", "0"); 
INSERT INTO `imagenes` VALUES("81", "assets/archivos/recortadas/a_14fa073952.jpg", "c25625c099", "0"); 
INSERT INTO `imagenes` VALUES("82", "assets/archivos/recortadas/a_05b744447a.jpg", "7fe4b29a2c", "0"); 
INSERT INTO `imagenes` VALUES("83", "assets/archivos/recortadas/a_0ef6a34853.jpg", "ec6435ad0a", "0"); 
INSERT INTO `imagenes` VALUES("84", "assets/archivos/recortadas/a_38ae3407b6.jpg", "a6cb1e29d2", "0"); 
INSERT INTO `imagenes` VALUES("85", "assets/archivos/recortadas/135f8263aa.jpg", "49106c1311", "0"); 
INSERT INTO `imagenes` VALUES("86", "assets/archivos/recortadas/a_2ac40b4fcc.jpg", "dde3e3ca9f", "0"); 


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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO `novedades` VALUES("3", "b499c5375f", "Novedad 1", "<p><strong>Lorem Ipsum</strong>&nbsp;es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno est&aacute;ndar de las industrias desde el a&ntilde;o 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido us&oacute; una galer&iacute;a de textos y los mezcl&oacute; de tal manera que logr&oacute; hacer un libro de textos especimen. No s&oacute;lo sobrevivi&oacute; 500 a&ntilde;os, sino que tambien ingres&oacute; como texto de relleno en documentos electr&oacute;nicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creaci&oacute;n de las hojas &quot;Letraset&quot;, las cuales contenian pasajes de Lorem Ipsum, y m&aacute;s recientemente con software de autoedici&oacute;n, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.</p>\n", "", "", "", "Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño.", "2020-11-04"); 
INSERT INTO `novedades` VALUES("4", "75decd5df8", "Novedad 2", "<p>Es un hecho establecido hace demasiado tiempo que un lector se distraer&aacute; con el contenido del texto de un sitio mientras que mira su dise&ntilde;o. El punto de usar Lorem Ipsum es que tiene una distribuci&oacute;n m&aacute;s o menos normal de las letras, al contrario de usar textos como por ejemplo &quot;Contenido aqu&iacute;, contenido aqu&iacute;&quot;. Estos textos hacen parecerlo un espa&ntilde;ol que se puede leer. Muchos paquetes de autoedici&oacute;n y editores de p&aacute;ginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una b&uacute;squeda de &quot;Lorem Ipsum&quot; va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo. Muchas versiones han evolucionado a trav&eacute;s de los a&ntilde;os, algunas veces por accidente, otras veces a prop</p>\n", "", "", "", "Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño.", "2020-11-04"); 
INSERT INTO `novedades` VALUES("5", "4fb5af5002", "Novedad 3", "<p>Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. Tiene sus raices en una pieza cl&acute;sica de la literatura del Latin, que data del a&ntilde;o 45 antes de Cristo, haciendo que este adquiera mas de 2000 a&ntilde;os de antiguedad. Richard McClintock, un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontr&oacute; una de las palabras m&aacute;s oscuras de la lengua del lat&iacute;n, &quot;consecteur&quot;, en un pasaje de Lorem Ipsum, y al seguir leyendo distintos textos del lat&iacute;n, descubri&oacute; la fuente indudable. Lorem Ipsum viene de las secciones 1.10.32 y 1.10.33 de &quot;de Finnibus Bonorum et Malorum&quot; (Los Extremos del Bien y El Mal) por Cicero, escrito en el a&ntilde;o 45 antes de Cristo. Este libro es un tratado de teor&iacute;a de &eacute;ticas, muy popular durante el Renacimiento. La primera linea del Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, viene de una linea en la secci&oacute;n 1.10.32</p>\n", "", "", "", "Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio", "2020-11-04"); 
INSERT INTO `novedades` VALUES("6", "952dbcc80a", "Noveda 4", "<p>Hay muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayor&iacute;a sufri&oacute; alteraciones en alguna manera, ya sea porque se le agreg&oacute; humor, o palabras aleatorias que no parecen ni un poco cre&iacute;bles. Si vas a utilizar un pasaje de Lorem Ipsum, necesit&aacute;s estar seguro de que no hay nada avergonzante escondido en el medio del texto. Todos los generadores de Lorem Ipsum que se encuentran en Internet tienden a repetir trozos predefinidos cuando sea necesario, haciendo a este el &uacute;nico generador verdadero (v&aacute;lido) en la Internet. Usa un diccionario de mas de 200 palabras provenientes del lat&iacute;n, combinadas con estructuras muy &uacute;tiles de sentencias, para generar texto de Lorem Ipsum que parezca razonable. Este Lorem Ipsum generado siempre estar&aacute; libre de repeticiones, humor agregado o palabras no caracter&iacute;sticas del lenguaje, etc.</p>\n", "", "", "", "Hay muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió alteraciones en alguna manera", "2020-11-04"); 
INSERT INTO `novedades` VALUES("7", "dde3e3ca9f", "Section 1.10.33 of ", "<p>&quot;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?&quot;</p>\n", "", "", "", "\"But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"", "2020-11-06"); 


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
  `total` float DEFAULT 0,
  `usuario` varchar(255) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `hub_cod` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cod` (`cod`,`usuario`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO `pedidos` VALUES("10", "F768B69", "0", "", "{\"envio\":{\"tipo\":\"\",\"nombre\":\"Micael\",\"apellido\":\"Estudio Rocha\",\"email\":\"micaelestudiorocha@gmail.com\",\"provincia\":\"Buenos Aires\",\"localidad\":\"11 DE SEPTIEMBRE\",\"direccion\":\"123\",\"telefono\":\"123123\"}}", "", "613296ad76", "2020-11-06 17:47:34", ""); 


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
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `envio_gratis` tinyint(1) NOT NULL DEFAULT 0,
  `mostrar_web` tinyint(1) NOT NULL DEFAULT 1,
  `variable1` text DEFAULT NULL,
  `variable2` text DEFAULT NULL,
  `variable3` text DEFAULT NULL,
  `variable4` text DEFAULT NULL,
  `variable5` text DEFAULT NULL,
  `variable6` text DEFAULT NULL,
  `variable7` text DEFAULT NULL,
  `variable8` text DEFAULT NULL,
  `variable9` int(11) DEFAULT NULL,
  `variable10` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `meli` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  KEY `subcategoria` (`subcategoria`),
  KEY `cod` (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

INSERT INTO `productos` VALUES("14", "6e2f6fab5e", "EST100902", "Botella 1000 cc 60 gr PEAD - Agroquímicos", "<p>codigo anterior:101802<br />\ncc: 1000<br />\ncolor: blanco<br />\nmaterial: PEAD gramaje:60</p>\n\n<p>Unidades por pack: 120</p>\n", "1000", "", "", "", "", "9d33bd6214", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("15", "2d9ad2bdd0", "EST500306", "Descartador agujas 4000 cc 135 gr PEAD", "<p><strong>codigo anterior:</strong>610306<br />\n<strong>cc</strong>:4000<br />\n<strong>color</strong>: rojo<br />\n<strong>material</strong>:PEAD&nbsp;<strong>gramaje</strong>:135</p>\n\n<p>Unidades por pack: 42</p>\n", "1000", "", "", "", "", "884ce62338", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("16", "55fb916569", "EST210600", "Bidón 5000 cc 120 gr REC", "<p><strong>codigo anterior:&nbsp;</strong>421801<br />\n<strong>cc</strong>:5000<br />\n<strong>color</strong>: azul.-Consulte por otros colores-&nbsp;<br />\n<strong>material</strong>: recuperado&nbsp;<strong>gramaje</strong>: 120Consulte por otros gramajes</p>\n\n<p>Unidades por pack: 30</p>\n", "1000", "", "", "", "", "4203723bc8", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("17", "0414a926f5", "INY951000", "Pinche para copetín", "<p><strong>codigo anterior:&nbsp;</strong>E9722</p>\n\n<p>Unidades por pack: 5000</p>\n", "1000", "", "", "", "", "3a2d3834e0", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("18", "f9b6184342", "EST600101", "Botella 240 cc 22 gr PET - Osito tapa rosca", "<p><strong>c&oacute;digo</strong>&nbsp;<strong>anterior</strong>:711001<br />\n<strong>cc:</strong>240&nbsp;<br />\n<strong>colores:</strong>&nbsp;natural<br />\n<strong>material:</strong>pet&nbsp;<strong>gramaje:</strong>&nbsp;22</p>\n\n<p>Unidades por pack: 150</p>\n", "1000", "", "", "", "", "4f144d866d", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("19", "507000b148", "EST700901", "Frasco 120 cc 13 gr PEAD -", "<p><strong>codigo anterior:</strong>C800901<br />\n<strong>cc</strong>: 120<br />\n<strong>color</strong>: natural,blanco&nbsp;<br />\n<strong>material</strong>:&nbsp;PEAD&nbsp;<strong>gramaje</strong>: 13</p>\n\n<p>Unidades por pack: 250</p>\n", "1000", "", "", "", "", "ae17781376", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("20", "babacbd08a", "EST200501", "Botella 1000 cc 36 gr PEAD - M3", "<p><strong>Codigo anterior:</strong>202303<br />\n<strong>cc:</strong>1000<br />\n<strong>color:</strong>&nbsp;amarillo, blanco, natural<br />\n<strong>material:</strong>&nbsp;PEAD - gramaje: 36</p>\n\n<p>Unidades por pack: 200</p>\n", "1000", "123", "", "", "", "d1db409f76", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("21", "76fae0c461", "EST310601", "Pote 1000 cc 55 gr PVC", "<p><strong>CODIGO ANTERIOR:</strong>310601<br />\n<strong>CC:&nbsp;</strong>1000<br />\n<strong>COLOR:&nbsp;</strong>cristal<br />\n<strong>MATERIAL</strong>:&nbsp;PVC&nbsp;<strong>GRAMAJE:</strong>&nbsp;55gr.</p>\n\n<p>Unidades por pack: 88</p>\n", "1000", "3000", "", "", "", "eafccc44bf", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("22", "c30a728b58", "EST601401", "Botella 1000 cc 25 gr PET - Base plana Tapa rosca", "<p>codigo anterior:712101<br />\ncc: 1000<br />\ncolor:natural, verde<br />\nmaterial: PET&nbsp;gramaje: 25</p>\n\n<p>Unidades por pack: 120</p>\n", "1000", "2000", "", "", "", "4f144d866d", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "0", "0", "2020-11-05", "", ""); 
INSERT INTO `productos` VALUES("23", "42816e48f1", "EST401301", "Bidón 3600 cc 95 gr PP - Mielero octogonal", "", "1000", "", "", "", "", "4e06a993ac", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-06", "", ""); 
INSERT INTO `productos` VALUES("24", "86d30dac16", "EST401501", "Bidón 7600 cc 175 gr PEAD - Aceitunero tapa presión", "", "1000", "123123", "", "", "", "4e06a993ac", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-06", "", ""); 
INSERT INTO `productos` VALUES("25", "c25625c099", "EST600101", "Botella 240 cc 22 gr PET - Osito tapa rosca", "", "1000", "213123000", "", "", "", "4e06a993ac", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-06", "", ""); 
INSERT INTO `productos` VALUES("26", "7fe4b29a2c", "EST600201", "Botella 240cc 21gr PET Osito tapa presión", "", "1000", "1000", "", "", "", "4e06a993ac", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-06", "", ""); 
INSERT INTO `productos` VALUES("27", "ec6435ad0a", "EST400701", "Pote 1500 CC 50 gr PVC - Aceitunero", "", "1000", "1000", "", "", "", "4e06a993ac", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-06", "", ""); 
INSERT INTO `productos` VALUES("28", "a6cb1e29d2", "EST400401", "Pote 1500 CC 57 gr PVC - Octogonal", "", "1000", "1000", "", "", "", "4e06a993ac", "", "", "", "", "0", "0", "1", "", "", "", "", "", "", "", "", "1", "0", "2020-11-06", "", ""); 


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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `servicios` VALUES("1", "4077094585", "Servicio1", "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n", "", "", "", "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", ""); 
INSERT INTO `servicios` VALUES("2", "39f10fd616", "Servicio2", "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy<strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n", "", "", "", "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", ""); 
INSERT INTO `servicios` VALUES("3", "8c6e4617dd", "Servicio3", "<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy</p>\n", "", "", "", "Lorem Ipsum is simply dummy text of the printing and typesetting industry.", ""); 


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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `sliders` VALUES("6", "096f22822e", "FABRICA DE ENVASES PLASTICOS", "1", "Somos una empresa Argentina especializada en la fabricación de envases plásticos. Desde Córdoba elaboramos una gran diversidad de envases que enviamos a todo el país.", "1", "30ccb12d9a", "", "", "2020-11-04"); 


DROP TABLE IF EXISTS `subcategorias`;
CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_subcategoria` (`cod`),
  KEY `cod_categoria_fk` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

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
INSERT INTO `subcategorias` VALUES("15", "6340c3d5b5", "test subcategoria productos", "34e907a166"); 
INSERT INTO `subcategorias` VALUES("16", "90b2c59ec0", "pequeñas", "b45ffb50d4"); 
INSERT INTO `subcategorias` VALUES("17", "fc2a26b30b", "Grandes", "b45ffb50d4"); 


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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` VALUES("13", "613296ad76", "Micael", "Estudio Rocha", "", "micaelestudiorocha@gmail.com", "080e58d2b27b0af24ad5ff675f9b2c3618dfa91524ad80f86d4e11017623966c", "123", "", "11 DE SEPTIEMBRE", "Buenos Aires", "", "123123", "", "1", "0", "0", "2020-11-06", "0"); 


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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `videos` VALUES("8", "094b5ca708", "Video1", "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsu", "1fdcaf1e1b", "", "https://www.youtube.com/watch?v=HQ40ksM2Vc0"); 
SET FOREIGN_KEY_CHECKS = 1;