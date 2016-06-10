UPDATE `cot_ls_regions` SET  `region_country` =  'ru', `region_name`= 'Крым' WHERE  `region_id` =10227;
UPDATE `cot_ls_cities` SET `city_country`='ru' WHERE `city_region`=10227;
DELETE FROM  `cot_ls_cities` WHERE  `city_region` =277656;