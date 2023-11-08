<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=rc
Order=100
[END_COT_EXT]
==================== */
/**
 * Verification of the identity of the freelancers. Checks the scanned passport.
 *
 * @plugin Verification
 * @version 1.0
 * @author Dr2005alex
 * @copyright Copyright (c) Dr2005alex
 *
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_langfile('verification', 'plug');

 cot_rc_add_file($cfg['plugins_dir'] . '/verification/js/verification.css');
 cot_rc_add_file($cfg['plugins_dir'] . '/verification/js/verification.js');
 cot_rc_embed_footer('var text_vf_error = "'.$L['ver_confirm_error'].'" ');

