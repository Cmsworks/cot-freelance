<?php

/**
 * Полное удаление SBR
 */

cot_rmdir(cot::$cfg['plugin']['sbr']['filepath']);

cot::$db->query('DROP TABLE IF EXISTS ' . cot::$db->quoteTableName(cot::$db->sbr));
cot::$db->query('DROP TABLE IF EXISTS ' . cot::$db->quoteTableName(cot::$db->sbr_stages));
cot::$db->query('DROP TABLE IF EXISTS ' . cot::$db->quoteTableName(cot::$db->sbr_posts));
cot::$db->query('DROP TABLE IF EXISTS ' . cot::$db->quoteTableName(cot::$db->sbr_claims));
cot::$db->query('DROP TABLE IF EXISTS ' . cot::$db->quoteTableName(cot::$db->sbr_files));
