/**
 * Completely removes folio data
 */

DROP TABLE IF EXISTS `cot_folio`;

DELETE FROM `cot_structure` WHERE structure_area = 'folio';
DELETE FROM `cot_auth` WHERE auth_code = 'folio';