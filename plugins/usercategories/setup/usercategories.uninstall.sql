/**
 * Completely removes usercategories data
 */

DELETE FROM `cot_structure` WHERE structure_area = 'users';
DELETE FROM `cot_auth` WHERE auth_code = 'users' AND auth_option != 'a';
