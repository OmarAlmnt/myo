-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2020 at 08:02 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myo`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_venta_temp` (IN `codprod` INT, IN `cantidad` INT, IN `token_user` VARCHAR(50))  BEGIN
    		
            DECLARE precio_actual decimal(10,2);
            SELECT precio INTO precio_actual from producto WHERE idprod = codprod;
            
            INSERT INTO detalle_venta_temp(token_user,idprod,cantidad_venta,precio_venta) VALUES 				     				(token_user,codprod,cantidad,precio_actual);
            
            SELECT dt.iddet, dt.idprod,p.descripcion,dt.cantidad_venta,dt.precio_venta FROM detalle_venta_temp dt
            INNER JOIN producto p
            ON dt.idprod = p.idprod
            WHERE dt.token_user = token_user;
            
            
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura` (IN `no_factura` INT)  BEGIN
    	DECLARE existe_factura int;
        DECLARE registros int;
        DECLARE a int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_factura = (SELECT COUNT(*) FROM factura WHERE nofactura = no_factura and activo = 'si');
        
        IF existe_factura > 0 THEN 
           CREATE TEMPORARY TABLE tbl_tmp( id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                    cod_prod BIGINT,
                                    cant_prod int);
                                    
                                    SET a = 1;
                                    
                                    SET registros = (SELECT COUNT(*) FROM detallefactura WHERE nofactura = no_factura);
                                    IF registros > 0 THEN
                                    
                                    	INSERT INTO tbl_tmp(cod_prod,cant_prod) SELECT idprod,cantidad FROM detallefactura WHERE nofactura = no_factura;
                                    	
                                        WHILE a <= registros DO
                                        	SELECT cod_prod,cant_prod INTO cod_producto,cant_producto FROM tbl_tmp WHERE id = a;
                                            SELECT existencia INTO existencia_actual FROM producto where idprod = cod_producto;
                                            SET nueva_existencia = existencia_actual + cant_producto;
                                            
                                            UPDATE producto SET existencia = nueva_existencia WHERE idprod = cod_producto;
                                            SET a = a + 1;
                                         END WHILE;
                                         UPDATE factura SET activo = "no" WHERE nofactura = no_factura;
                                         DROP table tbl_tmp;
                                         
                                         SELECT * FROM factura WHERE nofactura = no_factura;
                                    
                                    
                                    END IF;
                                    
           
           
       
        
        ELSE
        	SELECT 0 FROM FACTURA;
        END IF;
        
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `del_detalle_temp` (`id_detalle` INT, `token` VARCHAR(50))  BEGIN 
    		DELETE FROM detalle_venta_temp WHERE iddet = id_detalle;
            
            SELECT tmp.iddet,tmp.idprod,p.descripcion,tmp.cantidad_venta,tmp.precio_venta FROM detalle_venta_temp tmp
            INNER JOIN producto p
            ON tmp.idprod = p.idprod
            WHERE tmp.token_user = token;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))  BEGIN
    		DECLARE factura INT;
            DECLARE registros INT;
            DECLARE total DECIMAL(10,2);
            DECLARE  nueva_existencia int;
            DECLARE existencia_actual int;
            DECLARE tmp_cod_producto int;
            DECLARE tmp_cant_producto int;
            DECLARE a int;
            SET a  = 1;
            
            CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
              id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
              cod_prod BIGINT,
              cant_prod INT);
            
            
            
            
            SET registros = (SELECT COUNT(*) FROM detalle_venta_temp WHERE token_user = token);
            
            IF registros > 0 THEN
            
              	INSERT INTO tbl_tmp_tokenuser (cod_prod,cant_prod) SELECT idprod,cantidad_venta FROM detalle_venta_temp WHERE token_user = token;
                
                INSERT INTO factura (idusuario,idcliente) VALUES (cod_usuario,cod_cliente);
                SET factura = LAST_INSERT_ID();
                
                INSERT INTO detallefactura(nofactura,idprod,cantidad,precio_venta) SELECT (factura) as nofactura,idprod,cantidad_venta,precio_venta FROM detalle_venta_temp WHERE token_user = token;
                
                WHILE a <= registros DO
                
                SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
                SELECT existencia INTO existencia_actual FROM producto WHERE idprod = tmp_cod_producto;
                
                SET nueva_existencia = existencia_actual - tmp_cant_producto;
                UPDATE producto set existencia = nueva_existencia WHERE idprod = tmp_cod_producto;
                
                set a = a + 1;
                
                END WHILE;
                
                set total = (SELECT SUM(cantidad_venta * precio_venta) FROM detalle_venta_temp WHERE token_user = token);
                set total = (total +(total*0.18));
                UPDATE factura SET total_factura = total WHERE nofactura = factura;
                DELETE FROM detalle_venta_temp WHERE token_user = token;
                TRUNCATE TABLE tbl_tmp_tokenuser;
                SELECT * FROM factura WHERE nofactura = factura;
                
            ELSE
            	SELECT 0;
            END IF;
            
    
    
    
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `RNC` int(9) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `fecha_entrada` varchar(255) NOT NULL,
  `activo` char(2) NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombre`, `RNC`, `direccion`, `telefono`, `fecha_entrada`, `activo`) VALUES
(1, 'Pedro Ramirez', 111111111, 'La villa Olimpica', '347-12312-4214', '2019-01-27', 'no'),
(2, 'Prof. Jime', 601937659, 'Suite 061', '1-233-402-6788', '2020-07-06', 'si'),
(3, 'Winifred Hansen', 932650768, 'Apt. 600', '(501)678-1549', '2019-11-17', 'si'),
(4, 'Justin Duran', 794879462, 'Apt. 029', '88(2)2264994', '2020-04-21', 'si'),
(5, 'Hermina Bailey', 105003254, 'Suite 922', '(241)220-2656', '2019-08-11', 'si'),
(6, 'Imelda Mosciski II', 984320546, 'Suite 979', '673-473-1640', '2020-10-07', 'si'),
(7, 'Aniya Considine', 390301912, 'Apt. 921', '086-075-6976', '2019-02-21', 'si'),
(8, 'Esteban Witting', 685482300, 'Suite 294', '905-924-1528', '2020-10-18', 'si'),
(9, 'Alexis Marks', 638828660, 'Suite 239', '286-957-5950', '2019-12-17', 'si'),
(10, 'Alvera Block', 774700769, 'Suite 522', '(233)199-7130', '2019-06-28', 'si'),
(11, 'Shane Kuhn', 523761537, 'Suite 378', '+57(1)2144481', '2020-04-23', 'si'),
(12, 'Vincenzo Bashirian', 844801762, 'Suite 887', '1-261-975-5726', '2019-11-09', 'si'),
(13, 'Marian Tremblay', 388323626, 'Suite 008', '06698011867', '2020-03-15', 'si'),
(14, 'Dwight Dietrich', 611801672, 'Suite 187', '04227286938', '2019-05-12', 'si'),
(15, 'Pauline Carter', 482206529, 'Suite 557', '55(3)8824695', '2020-04-27', 'si'),
(16, 'Roscoe Osinski', 894815754, 'Suite 443', '1-812-562-0048', '2019-09-29', 'si'),
(17, 'Karlie Grady', 466632478, 'Suite 476', '1-600-614-9696', '2020-02-18', 'si'),
(18, 'Rhiannon Wyman', 187885471, 'Suite 546', '(820)589-6836', '2020-12-01', 'si'),
(19, 'Mrs. Daphnee Gutmann II', 808873157, 'Apt. 221', '67(8)323244', '2019-07-04', 'si'),
(20, 'Anika Schroeder II', 163686059, 'Suite 007', '02(5)672213', '2020-03-20', 'si'),
(21, 'Hulda Schmeler', 973895488, 'Suite 908', '243-008-7754', '2019-04-11', 'si'),
(22, 'Savanna Wolf', 731881385, 'Suite 830', '+21(1)680784', '2019-04-21', 'si'),
(23, 'Ms. Cali Weber V', 558697952, 'Apt. 624', '05660776330', '2020-06-06', 'si'),
(24, 'Rubye Lindgren', 689401491, 'Suite 942', '582-174-0751', '2019-08-23', 'si'),
(25, 'Hardy Parisian', 334141834, 'Apt. 831', '845-229-9519', '2019-02-05', 'si'),
(26, 'Edwina Will', 724791908, 'Suite 724', '296.215.3961', '2020-05-19', 'si'),
(27, 'Jennie Terry', 904846231, 'Apt. 481', '04310244445', '2019-02-22', 'si'),
(28, 'Tate Carter', 568972421, 'Apt. 493', '386-306-7277', '2019-11-28', 'si'),
(29, 'Dixie Grant', 271431309, 'Apt. 638', '1-053-758-9075', '2019-01-19', 'si'),
(30, 'Adrian Hahn', 584379743, 'Apt. 217', '732-736-9769', '2020-08-09', 'si'),
(31, 'Arlie Daniel', 241414710, 'Suite 032', '1-302-308-0511', '2019-09-12', 'si'),
(32, 'Saul Hand', 964231588, 'Suite 562', '+94(8)500848', '2019-04-08', 'si'),
(33, 'Tabitha Stark', 882985472, 'Apt. 283', '410.362.2620', '2020-01-17', 'si'),
(34, 'Annabelle Wyman', 980378334, 'Suite 640', '777-656-1609', '2020-11-27', 'si'),
(35, 'Bryana Lindgren', 744307597, 'Suite 677', '210.742.9948', '2019-12-16', 'si'),
(36, 'Murphy Moore', 300887422, 'Apt. 812', '319-639-0443', '2020-06-04', 'si'),
(37, 'Rosalind O\'Conner', 571904794, 'Apt. 886', '950-865-5116', '2019-03-05', 'si'),
(38, 'Dr. Ismael Leannon', 509862345, 'Apt. 199', '528-599-2520', '2020-03-09', 'si'),
(39, 'Miss Faye Spinka DVM', 759108207, 'Suite 642', '+92(6)6142016', '2019-05-02', 'si'),
(40, 'Janie Welch', 861810416, 'Suite 787', '+29(9)1263080', '2020-07-21', 'si'),
(41, 'Mr. Bertrand Schmeler', 215153422, 'Suite 944', '+45(3)2588136', '2020-11-18', 'si'),
(42, 'Lamar Jones', 433302932, 'Suite 515', '257-098-8770', '2019-03-21', 'si'),
(43, 'Zaria Orn', 573781926, 'Suite 670', '477-825-2088', '2020-09-30', 'si'),
(44, 'Mrs. Brenda Wisoky', 675735239, 'Apt. 652', '978-025-5338', '2019-01-29', 'si'),
(45, 'Prof. Devon Frami I', 374346504, 'Suite 695', '978-204-6709', '2020-05-23', 'si'),
(46, 'Kelsi Weissnat', 374212075, 'Suite 151', '380.185.0869', '2019-05-14', 'si'),
(47, 'Dr. Carmella Collier V', 368456153, 'Suite 732', '333-204-4950', '2020-02-26', 'si'),
(48, 'Edythe Reichel', 733615151, 'Suite 400', '(528)552-9985', '2019-05-09', 'si'),
(49, 'Dr. Trycia Jaskolski Jr.', 844337147, 'Suite 766', '750-546-3483', '2020-03-29', 'si'),
(50, 'Tyrell Jenkins', 961065283, 'Apt. 742', '03916075978', '2019-05-11', 'si'),
(51, 'Omar Almonte', 123456789, 'Los prados', '809-963-4326', '2020-10-15', 'si'),
(53, 'ConsumidorFinal', 0, 'Local', '000-000-0000', '', 'si'),
(54, 'yosmery', 87665554, 'calle f', '347-12312-4214', '2020-01-15', 'si');

-- --------------------------------------------------------

--
-- Table structure for table `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `RNC` char(9) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `itbis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `configuracion`
--

INSERT INTO `configuracion` (`id`, `RNC`, `nombre`, `telefono`, `direccion`, `email`, `itbis`) VALUES
(1, '987654321', 'El viejo continente import', '809-295-3033', 'Carretera la cienaga', 'michelleyomar@gmail.com', 18);

-- --------------------------------------------------------

--
-- Table structure for table `detallefactura`
--

CREATE TABLE `detallefactura` (
  `iddetfac` bigint(20) NOT NULL,
  `nofactura` bigint(20) NOT NULL,
  `idprod` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detallefactura`
--

INSERT INTO `detallefactura` (`iddetfac`, `nofactura`, `idprod`, `cantidad`, `precio_venta`) VALUES
(1, 1, 1, 3, '800.00'),
(2, 1, 3, 10, '700.00'),
(4, 2, 1, 3, '800.00'),
(5, 3, 1, 2, '800.00'),
(6, 3, 1, 2, '800.00'),
(7, 3, 1, 2, '800.00'),
(8, 3, 1, 2, '800.00'),
(9, 3, 1, 3, '800.00'),
(12, 4, 1, 3, '800.00'),
(13, 5, 1, 2, '800.00'),
(14, 6, 3, 1, '700.00'),
(15, 7, 1, 3, '800.00'),
(16, 8, 3, 1, '700.00'),
(17, 9, 3, 22, '700.00'),
(18, 10, 3, 23, '700.00'),
(19, 11, 3, 23, '700.00'),
(20, 12, 1, 21, '800.00'),
(21, 13, 3, 1, '700.00'),
(22, 14, 3, 1, '700.00'),
(23, 15, 1, 2, '800.00'),
(24, 16, 1, 3, '800.00'),
(25, 17, 1, 78, '800.00'),
(26, 18, 1, 5, '800.00'),
(27, 19, 3, 1, '700.00'),
(28, 20, 1, 2, '800.00'),
(29, 21, 1, 2, '800.00'),
(30, 22, 1, 2, '800.00'),
(31, 23, 1, 2, '800.00'),
(32, 24, 1, 1, '800.00'),
(33, 25, 1, 3, '800.00'),
(34, 26, 3, 1, '700.00'),
(35, 27, 1, 3, '800.00'),
(36, 28, 1, 1, '800.00'),
(37, 29, 1, 3, '800.00'),
(38, 29, 1, 3, '800.00'),
(40, 30, 1, 1, '800.00'),
(41, 31, 1, 2, '800.00'),
(42, 32, 1, 11, '800.00'),
(43, 33, 1, 3, '800.00'),
(44, 34, 1, 3, '800.00'),
(45, 34, 3, 1, '700.00'),
(47, 35, 1, 3, '800.00'),
(48, 36, 1, 2, '800.00'),
(49, 37, 1, 3, '800.00'),
(50, 38, 1, 2, '800.00'),
(51, 38, 3, 1, '700.00'),
(53, 39, 3, 1, '700.00'),
(54, 39, 1, 32, '800.00'),
(56, 40, 3, 11, '700.00'),
(57, 41, 1, 3, '800.00'),
(58, 41, 3, 12, '700.00'),
(60, 42, 3, 12, '700.00'),
(61, 42, 1, 9, '800.00'),
(62, 42, 1, 2, '800.00'),
(63, 43, 1, 3, '800.00'),
(64, 43, 10, 9, '620.00'),
(65, 43, 4, 6, '900.00'),
(66, 43, 9, 2, '430.00'),
(67, 43, 11, 6, '600.00'),
(68, 43, 3, 2, '700.00'),
(69, 43, 7, 1, '1100.00'),
(70, 43, 10, 23, '620.00'),
(71, 43, 5, 5, '800.00'),
(72, 43, 6, 23, '1200.00'),
(73, 43, 9, 12, '430.00'),
(74, 43, 12, 9, '850.00'),
(75, 44, 1, 3, '800.00'),
(76, 44, 3, 4, '700.00'),
(77, 44, 10, 5, '620.00'),
(78, 45, 1, 3, '800.00'),
(79, 46, 4, 20, '900.00'),
(80, 46, 1, 6, '800.00'),
(81, 46, 11, 3, '600.00'),
(82, 47, 1, 4, '800.00'),
(83, 48, 1, 3, '800.00'),
(84, 48, 5, 23, '800.00'),
(85, 48, 2, 3, '500.00'),
(86, 48, 3, 6, '700.00'),
(87, 48, 4, 10, '900.00'),
(88, 48, 6, 12, '1200.00'),
(89, 48, 7, 12, '1100.00'),
(90, 48, 8, 11, '750.00'),
(91, 48, 9, 5, '430.00'),
(92, 48, 10, 34, '620.00'),
(93, 48, 11, 230, '600.00'),
(94, 48, 12, 43, '850.00'),
(95, 48, 13, 24, '1100.00'),
(96, 48, 14, 56, '520.00'),
(97, 48, 15, 56, '1300.00'),
(98, 48, 17, 23, '960.00'),
(99, 48, 16, 5, '500.00'),
(100, 48, 18, 45, '400.00'),
(101, 48, 19, 3, '650.00'),
(102, 48, 21, 4, '1400.00'),
(103, 49, 1, 3, '800.00'),
(104, 49, 1, 3, '800.00'),
(105, 49, 1, 3, '800.00'),
(106, 50, 1, 34, '800.00'),
(107, 50, 3, 12, '700.00'),
(109, 51, 4, 23, '900.00'),
(110, 51, 1, 5, '800.00'),
(111, 51, 11, 6, '600.00'),
(112, 51, 12, 2, '850.00'),
(113, 51, 12, 2, '850.00'),
(114, 51, 2, 123, '500.00'),
(115, 51, 2, 123, '500.00'),
(116, 51, 21, 12, '1400.00'),
(117, 52, 3, 12, '700.00'),
(118, 52, 2, 1, '500.00'),
(119, 53, 1, 2, '800.00'),
(120, 53, 4, 123, '900.00'),
(121, 54, 1, 5, '800.00'),
(122, 55, 4, 10, '900.00'),
(123, 55, 1, 2, '800.00'),
(124, 55, 4, 12, '900.00'),
(125, 55, 8, 3, '750.00'),
(126, 56, 3, 67, '700.00');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_venta_temp`
--

CREATE TABLE `detalle_venta_temp` (
  `iddet` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `idprod` int(11) DEFAULT NULL,
  `cantidad_venta` int(11) NOT NULL,
  `precio_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `total_factura` decimal(10,2) NOT NULL,
  `activo` char(2) NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `factura`
--

INSERT INTO `factura` (`nofactura`, `fecha_hora`, `idusuario`, `idcliente`, `total_factura`, `activo`) VALUES
(1, '2019-12-05 00:00:00', 1, 1, '9400.00', 'si'),
(2, '2019-11-05 00:00:00', 1, 2, '2832.00', 'si'),
(3, '2020-01-05 17:50:06', 1, 1, '10384.00', 'si'),
(4, '2020-01-05 19:00:39', 1, 12, '2832.00', 'si'),
(5, '2020-01-05 19:02:15', 1, 6, '1888.00', 'si'),
(6, '2020-01-05 19:02:38', 1, 53, '826.00', 'si'),
(7, '2020-01-05 20:01:25', 1, 23, '2832.00', 'si'),
(8, '2020-01-05 20:04:19', 1, 53, '826.00', 'si'),
(9, '2020-01-05 20:05:21', 1, 53, '18172.00', 'si'),
(10, '2020-01-05 20:07:09', 1, 53, '18998.00', 'si'),
(11, '2020-01-05 20:15:56', 1, 1, '18998.00', 'si'),
(12, '2020-01-05 20:16:34', 1, 1, '19824.00', 'si'),
(13, '2020-01-05 20:17:01', 1, 1, '826.00', 'si'),
(14, '2020-01-05 20:18:06', 1, 1, '826.00', 'si'),
(15, '2020-01-05 20:18:36', 1, 1, '1888.00', 'si'),
(16, '2020-01-05 20:19:54', 1, 1, '2832.00', 'si'),
(17, '2020-01-05 20:27:03', 1, 51, '73632.00', 'no'),
(18, '2020-01-05 20:35:52', 1, 53, '4720.00', 'si'),
(19, '2020-01-05 20:37:08', 1, 53, '826.00', 'si'),
(20, '2020-01-05 20:38:18', 1, 53, '1888.00', 'si'),
(21, '2020-01-05 20:39:12', 1, 53, '1888.00', 'si'),
(22, '2020-01-05 20:41:44', 1, 53, '1888.00', 'si'),
(23, '2020-01-05 20:43:07', 1, 51, '1888.00', 'si'),
(24, '2020-01-05 20:45:22', 1, 1, '944.00', 'si'),
(25, '2020-01-05 20:47:20', 1, 1, '2832.00', 'si'),
(26, '2020-01-05 20:47:57', 1, 1, '826.00', 'si'),
(27, '2020-01-05 20:49:03', 1, 1, '2832.00', 'si'),
(28, '2020-01-05 20:49:30', 1, 1, '944.00', 'si'),
(29, '2020-01-05 20:51:17', 1, 53, '5664.00', 'si'),
(30, '2020-01-05 20:53:27', 1, 53, '944.00', 'si'),
(31, '2020-01-05 20:57:06', 1, 53, '1888.00', 'si'),
(32, '2020-01-05 21:01:40', 1, 53, '10384.00', 'no'),
(33, '2020-01-05 21:02:58', 1, 53, '2832.00', 'si'),
(34, '2020-01-05 21:07:44', 1, 53, '3658.00', 'si'),
(35, '2020-01-05 21:09:32', 1, 53, '2832.00', 'si'),
(36, '2020-01-05 21:10:08', 1, 53, '1888.00', 'no'),
(37, '2020-01-05 21:11:00', 1, 53, '2832.00', 'si'),
(38, '2020-01-05 21:12:00', 1, 53, '2714.00', 'si'),
(39, '2020-01-05 21:13:22', 1, 53, '31034.00', 'no'),
(40, '2020-01-05 21:14:43', 1, 1, '9086.00', 'no'),
(41, '2020-01-05 21:16:45', 1, 1, '12744.00', 'si'),
(42, '2020-01-05 21:19:27', 1, 1, '20296.00', 'no'),
(43, '2020-01-06 19:58:35', 3, 9, '93231.80', 'no'),
(44, '2020-01-07 10:52:34', 1, 1, '9794.00', 'si'),
(45, '2020-01-09 08:22:02', 1, 51, '2832.00', 'no'),
(46, '2020-01-09 12:15:59', 1, 4, '29028.00', 'si'),
(47, '2020-01-09 20:06:58', 1, 53, '3776.00', 'no'),
(48, '2020-01-12 18:50:27', 3, 17, '528144.40', 'si'),
(49, '2020-01-15 09:05:05', 1, 51, '8496.00', 'si'),
(50, '2020-01-16 11:58:10', 1, 53, '42008.00', 'no'),
(51, '2020-01-16 12:42:21', 1, 51, '202370.00', 'si'),
(52, '2020-01-17 08:49:56', 1, 51, '10502.00', 'si'),
(53, '2020-01-24 09:51:17', 3, 53, '132514.00', 'no'),
(54, '2020-01-27 14:16:29', 3, 8, '4720.00', 'si'),
(55, '2020-01-27 14:17:43', 3, 8, '27907.00', 'no'),
(56, '2020-01-30 13:15:59', 1, 53, '55342.00', 'si');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `idprod` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `existencia` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `activo` char(2) NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`idprod`, `descripcion`, `precio`, `existencia`, `idproveedor`, `activo`) VALUES
(1, '185/50R14', '800.00', 1316, 31, 'si'),
(2, '265/60R15', '500.00', 115, 33, 'si'),
(3, '205/45R16', '700.00', 124, 1, 'si'),
(4, '255/55R18', '900.00', 267, 19, 'si'),
(5, '235/45R19', '800.00', 407, 46, 'si'),
(6, '245/35R20', '1200.00', 688, 47, 'si'),
(7, '155/70R13', '1100.00', 388, 17, 'si'),
(8, '225/55R16', '750.00', 196, 11, 'si'),
(9, '225/60R15', '430.00', 97, 8, 'si'),
(10, '195/65R14', '620.00', 38, 47, 'si'),
(11, '245/75R16', '600.00', 464, 50, 'si'),
(12, '195/75R16', '850.00', 521, 1, 'si'),
(13, '225/65R18', '1100.00', 375, 44, 'si'),
(14, '145/80R13', '520.00', 284, 1, 'si'),
(15, '235/45R20', '1300.00', 178, 17, 'si'),
(16, '215/80R16', '500.00', 399, 52, 'si'),
(17, '225/40R17', '960.00', 100, 38, 'si'),
(18, '195/80R15', '400.00', 597, 34, 'si'),
(19, '275/50R20', '650.00', 788, 45, 'si'),
(21, '275/35R19', '1400.00', 214, 16, 'si');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `nombreprov` varchar(255) NOT NULL,
  `representante` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `activo` char(2) NOT NULL DEFAULT 'si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `nombreprov`, `representante`, `telefono`, `pais`, `activo`) VALUES
(1, 'Clown', 'Diego Bell', '347-12312-4214', 'Canada', 'si'),
(2, 'Will-Bailey', 'Solon Bailey', '466.806.6729', 'Yemen', 'si'),
(3, 'Anderson LLC', 'Conner Torphy', '(636)438-0909', 'Gambia', 'si'),
(4, 'Fritsch', 'Shirley Mertz', '811.873.1191', 'African Republic', 'si'),
(5, 'Smitham Ltd', 'Kacie Tillman', '1-892-138-4612', 'Cote d\'Ivoire', 'si'),
(6, 'Kreiger LLC', 'Catherine Paucek', '(525)862-1907', 'Trinidad and Tobago', 'si'),
(7, 'Gerlach PLC', 'Leola Boyle', '649-724-3251', 'Chad', 'si'),
(8, 'Satterfield', 'Estella Wintheiser', '785.865.8115', 'Martinique', 'si'),
(9, 'Renner-Spencer', 'Ms. Anne Orn II', '292-938-8458', 'Suriname', 'si'),
(10, 'Morissette PLC', 'Chanel Schimmel Sr.', '527-446-1710', 'Cocos Islands', 'si'),
(11, 'Reichel LLC', 'Carmella Gislason', '1-195-788-4412', 'Uzbekistan', 'si'),
(12, 'Jenkins-Doyle', 'Russel Moen', '549.169.0722', 'Canada', 'si'),
(13, 'Lemke-Leffler', 'Agnes Cormier', '1-004-184-7837x', 'Micronesia', 'si'),
(14, 'Pacocha and Dickens', 'Jack Kozey I', '887-530-9674', 'Bouvet Island', 'si'),
(15, 'Considine-Padberg', 'Lavonne Mertz', '(603)328-7211', 'Croatia', 'si'),
(16, 'Corwin-Wiza', 'Theron Skiles', '846-202-7242', 'Palestinian Territory', 'si'),
(17, 'Ratke and Sons', 'Patsy Skiles', '07240688856', 'Jersey', 'si'),
(18, 'White Sanford', 'Jacynthe Monahan', '+43(9)471483', 'Gabon', 'si'),
(19, 'Williamson Windler', 'Ayden Heaney', '1-379-744-6459', 'Burundi', 'si'),
(20, 'Johnston-Pouros', 'Millie Barton', '1-399-730-6788', 'El Salvador', 'si'),
(21, 'Thompson-Baumbach', 'Colt Schulist', '1-849-734-5477', 'British Indian', 'si'),
(22, 'Keeling-Botsford', 'Jessyca Wilkinson', '612.080.4895', 'Cuba', 'si'),
(23, 'Paucek LLC', 'Unique Ruecker', '461-340-9586', 'Northern Mariana Islands', 'si'),
(25, 'Hirthe-Abshire', 'Darwin Fay', '278-948-4407', 'Montserrat', 'si'),
(26, 'Denesik Effertz', 'Jaiden Nienow', '1-722-789-6910', 'Monaco', 'si'),
(27, 'Nikolau', 'Oma Huel', '06666822587', 'Senegal', 'si'),
(28, 'Price-Stoltenberg', 'Abdiel Carroll', '962-662-2513', 'Bangladesh', 'si'),
(29, 'Vandervort-Brown', 'Ulices Haag', '383-831-1524', 'Iraq', 'si'),
(30, 'Howe Nolan', 'Maverick Lindgren', '272-366-7375', 'French Southern', 'si'),
(31, 'Huels', 'Marielle Heathcote', '669-444-4373', 'France', 'si'),
(32, 'Harvey-Bins', 'Unique Larson', '1-316-740-1226', 'Turks and Caicos', 'si'),
(33, 'Hayes-Lynch', 'Julius Boehm', '(735)798-8958', 'Maldives', 'si'),
(34, 'Luettgen Ltd', 'Raina Kautzer', '+75(2)382788', 'Chile', 'si'),
(35, 'Kilback-Abshire', 'Deja Barrows', '766.867.4590', 'Algeria', 'si'),
(36, 'Herman-Nienow', 'Mr. Micah Lowe', '616-214-9927', 'Nigeria', 'si'),
(37, 'Blanda and Sons', 'Sonny Krajcik', '+82(7)8430563066', 'Serbia', 'si'),
(38, 'Rice Purdy', 'Jerrell Stehr', '+31(7)696176', 'Argentina', 'si'),
(39, 'Medhurst-Spinka', 'Lue Bartoletti', '746-0575x0946', 'Kuwait', 'si'),
(40, 'Littel Ltd', 'Kaci Lind IV', '+38(6)898762', 'Kiribati', 'si'),
(41, 'Nolan-DuBuque', 'Angus Beer', '(453)063-2290', 'Iran', 'si'),
(42, 'Connelly-Stamm', 'Gladys Jast I', '+21(4)936749', 'Andorra', 'si'),
(43, 'Daugherty-Bradtke', 'Carli O\'Kon', '023.867.7811', 'Faroe Islands', 'si'),
(44, 'Mitchell Ltd', 'Albertha Huels', '1-244-265-1884', 'Ethiopia', 'si'),
(45, 'Nolan-Doyle', 'Beau Effertz', '(416)735-1888', 'Sweden', 'si'),
(46, 'Parisian', 'Ayden Legros', '1-928-140-6891', 'Netherlands', 'si'),
(47, 'Ledner-Mayer', 'Jeramie Tremblay', '+88(4)260365', 'Qatar', 'si'),
(48, 'Bernier and Spencer', 'Raleigh Wuckert', '(022)832-4474', 'Somalia', 'si'),
(49, 'Steuber-Wunsch', 'Dr. Citlalli Donnelly', '864.088.6682', 'United States', 'si'),
(50, 'Little Gaylord', 'Alessia Beahan', '(034)627-1980', 'Spain', 'si'),
(51, '', 'Javier Perez', '809-963-4326', 'Mexico', 'no'),
(52, 'RodAutomotive INC', 'Javier Perez', '809-963-4326', 'Mexico', 'si');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idusuario`, `fullname`, `username`, `password`, `rol`) VALUES
(1, 'Omar Almonte', 'Omar@myo', '12345', 'administrador'),
(2, 'default', '', '', ''),
(3, 'Michelle Fermin', 'Michelle', '12345', 'administrador'),
(4, 'Alba Vasquez', 'Alba', '12345', 'vendedor');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_actual`
--

CREATE TABLE `usuario_actual` (
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `year` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`year`) VALUES
('2019'),
('2020'),
('2021');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`iddetfac`),
  ADD KEY `nofactura` (`nofactura`),
  ADD KEY `idprod` (`idprod`);

--
-- Indexes for table `detalle_venta_temp`
--
ALTER TABLE `detalle_venta_temp`
  ADD PRIMARY KEY (`iddet`),
  ADD KEY `idprod` (`idprod`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idprod`),
  ADD UNIQUE KEY `descripcion` (`descripcion`),
  ADD KEY `idproveedor` (`idproveedor`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `usuario_actual`
--
ALTER TABLE `usuario_actual`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `iddetfac` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `detalle_venta_temp`
--
ALTER TABLE `detalle_venta_temp`
  MODIFY `iddet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `idprod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario_actual`
--
ALTER TABLE `usuario_actual`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`),
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`);

--
-- Constraints for table `detalle_venta_temp`
--
ALTER TABLE `detalle_venta_temp`
  ADD CONSTRAINT `detalle_venta_temp_ibfk_1` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`);

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
