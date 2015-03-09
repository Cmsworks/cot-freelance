/**
 * Completely removes usercategories data
 */

DELETE FROM `cot_structure` WHERE structure_area = 'usercategories';
DELETE FROM `cot_auth` WHERE auth_code = 'usercategories';