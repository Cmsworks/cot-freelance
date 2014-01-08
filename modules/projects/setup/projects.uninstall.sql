/**
 * Completely removes projects data
 */

DROP TABLE IF EXISTS `cot_projects`;
DROP TABLE IF EXISTS `cot_projects_offers`;
DROP TABLE IF EXISTS `cot_projects_posts`;
DROP TABLE IF EXISTS `cot_projects_types`;

DELETE FROM `cot_structure` WHERE structure_area = 'projects';
DELETE FROM `cot_auth` WHERE auth_code = 'projects';