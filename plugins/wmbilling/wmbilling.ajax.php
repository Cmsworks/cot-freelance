<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
 */
/**
 * Webmoney billing Plugin
 *
 * @package wmbilling
 * @version 1.1.0
 * @author CMSWorks Team
 * @copyright Copyright (c) CMSWorks.ru
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('payments', 'module');

if (isset($_POST['LMI_PREREQUEST']) && $_POST['LMI_PREREQUEST'] == 1)
{
	if (isset($_POST['LMI_PAYMENT_NO']) && preg_match('/^\d+$/', $_POST['LMI_PAYMENT_NO']) == 1 && isset($_POST['RND']) && preg_match('/^[A-Z0-9]{8}$/', $_POST['RND'], $match) == 1)
	{
		$pinfo = $db->query("SELECT * FROM $db_payments
			WHERE pay_id='" . $_POST['LMI_PAYMENT_NO'] . "' 
				AND pay_wmrnd='" . $_POST['RND'] . "' 
					AND pay_status='process'")->fetch();

		if (empty($pinfo))
		{
			echo "ERR: Item not found";
		}
		else
		{
			$amount = number_format($pinfo['pay_summ']*$cfg['plugin']['wmbilling']['webmoney_rate'], 2, '.', '');
			if ($_POST['LMI_PAYMENT_NO'] == $pinfo['pay_id'] && $_POST['LMI_PAYEE_PURSE'] == $cfg['plugin']['wmbilling']['webmoney_purse'] && $_POST['LMI_PAYMENT_AMOUNT'] == $amount)
			{
				echo 'YES';
			}
			else
			{
				echo "ERR: Inconsistent parameters";
			};
		};
	}
	else
	{
		echo "ERR: Inconsistent parameters";
	};
}
else
{
	if (isset($_POST['LMI_PAYMENT_NO']) && preg_match('/^\d+$/', $_POST['LMI_PAYMENT_NO']) == 1 && isset($_POST['RND']) && preg_match('/^[A-Z0-9]{8}$/', $_POST['RND'], $match) == 1)
	{
		$pinfo = $db->query("SELECT * FROM $db_payments
			WHERE pay_id='" . $_POST['LMI_PAYMENT_NO'] . "' 
				AND pay_wmrnd='" . $_POST['RND'] . "' 
					AND pay_status='process'")->fetch();

		if (empty($pinfo))
		{
			echo "ERR: Payment not found";
		}
		else
		{
			$chkstring = $cfg['plugin']['wmbilling']['webmoney_purse'] . $pinfo['pay_summ'] . $pinfo['pay_id'] .
					$_POST['LMI_MODE'] . $_POST['LMI_SYS_INVS_NO'] . $_POST['LMI_SYS_TRANS_NO'] . $_POST['LMI_SYS_TRANS_DATE'] .
					$cfg['plugin']['wmbilling']['webmoney_skey'] . $_POST['LMI_PAYER_PURSE'] . $_POST['LMI_PAYER_WM'];

			if ($cfg['plugin']['wmbilling']['webmoney_hashmethod'] == 'MD5')
			{
				$md5sum = strtoupper(md5($chkstring));
				$hash_check = ($_POST['LMI_HASH'] == $md5sum);
			}
			elseif ($cfg['plugin']['wmbilling']['webmoney_hashmethod'] == 'SHA256')
			{
				$sha256sum = strtoupper(hash('sha256', $chkstring));
				$hash_check = ($_POST['LMI_HASH'] == $sha256sum);
			}
			elseif ($cfg['plugin']['wmbilling']['webmoney_hashmethod'] == 'SIGN')
			{
				// not done yet!!!
			}
			else
			{
				echo "ERR: Config parameter LMI_HASH_METHOD incorrect!";
			};

			$amount = number_format($pinfo['pay_summ']*$cfg['plugin']['wmbilling']['webmoney_rate'], 2, '.', '');
			if ($_POST['LMI_PAYMENT_NO'] == $pinfo['pay_id'] && $_POST['LMI_PAYEE_PURSE'] == $cfg['plugin']['wmbilling']['webmoney_purse'] && $_POST['LMI_PAYMENT_AMOUNT'] == $amount && $_POST['LMI_MODE'] == $cfg['plugin']['wmbilling']['webmoney_mode'] && $hash_check)
			{
				if (cot_payments_updatestatus($pinfo['pay_id'], 'paid'))
				{
					echo "YES";
				}
				else
				{
					echo "ERR: Payment failed";
				};
			}
			else
			{
				echo "ERR: Inconsistent parameters";
			};
		};
	}
	else
	{
		echo "ERR: Inconsistent parameters";
	};
}
?>