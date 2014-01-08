/**
 * Completely removes market data
 */

DROP TABLE IF EXISTS `cot_market`;

DELETE FROM `cot_structure` WHERE structure_area = 'market';
DELETE FROM `cot_auth` WHERE auth_code = 'market';