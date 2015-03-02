<?php

/**
 * mavatars for Cotonti CMF
 *
 * @version 1.00
 * @author	esclkm
 * @copyright (c) 2013 esclkm
 */
defined('COT_CODE') or die('Wrong URL');

/* @var $db CotDB */
/* @var $cache Cache */
/* @var $t Xtemplate */

global $db_mavatars, $db_x, $cfg, $R;

$db_mavatars = $db_x.'mavatars';
require_once cot_langfile('mavatars');

require_once cot_incfile('uploads');
require_once cot_incfile('forms');

class mavatar
{

	/**
	 * @var array Total mavatar config
	 */
	public $config = array();

	/**
	 * @var string Extension
	 */
	public $extension = '__default';

	/**
	 * @var string category
	 */
	public $category = '__default';

	/**
	 * @var string code
	 */
	public $code;

	/**
	 * @var array mavatar files (mavatars) array
	 */
	public $mavatars = array();

	/**
	 * @var array code
	 */
	private $images_ext = array('jpg', 'jpeg', 'png', 'gif');
	private $suppressed_ext = array('php', 'php3', 'php4', 'php5');
	private $path = '';
	private $thumbspath = '';
	private $req = '';
	private $allowed_ext = '';
	private $max = '';

	public function __construct($extension, $category, $code)
	{
		$this->load_config_table();
		$this->get_current_config($extension, $category);

		$this->extension = $extension;
		$this->category = $category;
		$this->code = $code;

		$this->get_mavatars();
	}

	protected function load_config_table()
	{
		global $cfg;
		$tpaset = str_replace("\r\n", "\n", $cfg['plugin']['mavatars']['set']);
		$tpaset = explode("\n", $tpaset);
		foreach ($tpaset as $val)
		{
			$val = explode('|', $val);
			$val = array_map('trim', $val);
			if (count($val) > 1)
			{
				$val[2] = (!empty($val[2])) ? $val[2] : $cfg['photos_dir'];
				$val[2] .= (substr($val[2], -1) == '/') ? '' : '/';

				$val[3] = (!empty($val[3])) ? $val[3] : $val[2];
				$val[3] .= (substr($val[3], -1) == '/') ? '' : '/';

				$val[1] = (empty($val[1])) ? '__default' : $val[1];

				$val[5] = str_replace(array(' ', '.', '*'), array('', '', ''), $val[5]);
				$extensions = explode(',', mb_strtolower($val[5]));

				$set_array = array(
					'path' => $val[2],
					'thumbspath' => $val[3],
					'req' => (int)$val[4] ? 1 : 0,
					'ext' => (!empty($val[5])) ? $extensions : $this->images_ext,
					'max' => ((int)$val[6] > 0) ? $val[6] : 0
				);
				$val[1] = empty($val[0]) ? '__default' : $val[1];
				$val[0] = empty($val[0]) ? '__default' : $val[0];
				$mav_cfg[$val[0]][$val[1]] = $set_array;
			}
		}
		if (!$mav_cfg['__default']['__default'])
		{
			$def_photodir = (substr($cfg['photos_dir'], -1) == '/') ? $cfg['photos_dir'] : $cfg['photos_dir'].'/';
			$mav_cfg['__default']['__default'] = array(
				'path' => $def_photodir,
				'thumbspath' => $def_photodir,
				'req' => 0,
				'ext' => $this->images_ext,
				'max' => 0
			);
		}
		$this->config = $mav_cfg;
	}

	protected function get_current_config($extension = '__default', $category = '__default')
	{
		if (!isset($this->config[$extension]))
		{
			$extension = '__default';
		}
		if ($extension == '__default')
		{
			$category = '__default';
		}
		else
		{
			if ($category != '__default')
			{

				$cat_parents = cot_structure_parents($extension, $category);
				$cat_parents = array_reverse($cat_parents);

				$breaker = false;
				foreach ($cat_parents as $cat)
				{
					if (isset($this->config[$extension][$cat]))
					{
						$category = $cat;
						$breaker = true;
						break;
					}
				}
				if (!$breaker)
				{
					$category = '__default';
				}
			}
			if (!isset($this->config[$extension][$category]))
			{
				$extension = '__default';
			}
		}
		$this->path = $this->config[$extension][$category]['path'];
		$this->thumbspath = $this->config[$extension][$category]['thumbspath'];
		$this->req = $this->config[$extension][$category]['req'];
		$this->allowed_ext = $this->config[$extension][$category]['ext'];
		$this->max = $this->config[$extension][$category]['max'];
	}

	public function get_mavatars()
	{
		global $db, $db_mavatars;
		$this->mavatars = array();
		if ($this->code != 'new')
		{
			$sql = $db->query("SELECT * FROM $db_mavatars WHERE mav_extension ='".$db->prep($this->extension)."' AND	mav_code = '".$db->prep($this->code)."' ORDER BY mav_order ASC, mav_item ASC");
			$i = 0;
			$mav_struct = array();
			while ($mav_row = $sql->fetch())
			{
				$i++;
				$mavatar = array();
				foreach ($mav_row as $key => $val)
				{
					$keyx = str_replace('mav_', '', $key);
					if ($keyx == 'filepath' || $keyx == 'thumbpath')
					{
						$val .= (substr($val, -1) == '/') ? '' : '/';
					}
					$mavatar[$keyx] = $val;
				}
				$mavatar['i'] = $i;
				$this->mavatars[$i] = $mavatar;
			}
		}
		return $this->mavatars;
	}

	private function get_mavatar_byid($id)
	{
		foreach ($this->mavatars as $key => $mavatar)
		{
			if ($mavatar['id'] == $id)
			{
				return $mavatar;
			}
		}
	}

	public function get_mavatar_files($mavatar)
	{
		$file_list = array();
		if (!empty($mavatar['filepath']) && !empty($mavatar['filename']) && !empty($mavatar['fileext']))
		{
			if (in_array($mavatar['fileext'], $this->images_ext))
			{
				foreach (glob($mavatar['thumbpath'].$mavatar['filename']."*.".$mavatar['fileext']) as $file)
				{
					$filename = basename($file, '.'.$mavatar['fileext']);
					$mt = array();
					if (preg_match("/".$mavatar['filename']."_(\d+)_(\d+)_(crop|width|height|auto)_?(.+)?/i", $filename, $mt))
					{
						$file_list[$mt[1].'_'.$mt[2].'_'.$mt[3].'_'.$mt[4]] = $file;
					}
				}
			}

			$file_list['main'] = $mavatar['filepath'].$mavatar['filename'].'.'.$mavatar['fileext'];
		}
		return $file_list;
	}

	public function delete_mavatar($mavatar)
	{
		global $db, $db_mavatars;

		$db->delete($db_mavatars, "mav_id=".$mavatar['id']);

		foreach ($this->get_mavatar_files($mavatar) as $key => $file)
		{
			if (file_exists($file) && is_writable($file))
			{
				@unlink($file);
			}
		}
		unset($this->mavatars[$mavatar['i']]);
	}

	public function delete_all_mavatars()
	{
		foreach ($this->mavatars as $mavatar)
		{
			$this->delete_mavatar($mavatar);
		}
	}

	public function generate_tags($mavatar)
	{
		$curr_mavatar = array();
		$curr_mavatar['FILE'] = $mavatar['filepath'].$mavatar['filename'].'.'.$mavatar['fileext'];
		$curr_mavatar['SHOW'] = cot_url('plug', 'e=mavatars&m=show&id='.$mavatar['id']);

		foreach ($mavatar as $key_p => $val_p)
		{
			$keyx = mb_strtoupper($key_p);
			$curr_mavatar[$keyx] = $val_p;
		}
		return $curr_mavatar;
	}

	public function generate_mavatars_tags()
	{
		$array = array();
		foreach ($this->mavatars as $key => $mavatar)
		{
			$array[$key] = $this->generate_tags($mavatar);
		}
		return $array;
	}

	public function generate_upload_form()
	{
		global $cfg, $L;
		$mskin = cot_tplfile(array('mavatars', 'form', $this->extension, $this->category, $this->code), 'plug');
		$t = new XTemplate($mskin);

		foreach ($this->mavatars as $key => $mavatar)
		{
			$t->assign($this->generate_tags($mavatar));
			$t->assign(array(
				'ENABLED' => cot_checkbox(true, 'mavatar_enabled['.$mavatar['id'].']', '', 'title="'.$L['Enabled'].'"'),
				'FILEORDER' => cot_inputbox('text', 'mavatar_order['.$mavatar['id'].']', $mavatar['order'], 'maxlength="4" size="4"'),
				'FILEDESC' => cot_inputbox('text', 'mavatar_desc['.$mavatar['id'].']', $mavatar['desc']),
				'FILENEW' => cot_inputbox('hidden', 'mavatar_new['.$mavatar['id'].']', 0),
			));
			$t->parse("MAIN.FILES.ROW");
		}
		if (count($this->mavatars) > 0)
		{
			$t->parse("MAIN.FILES");
		}
		$t->assign("FILEUPLOAD_INPUT", cot_inputbox('file', 'mavatar_file[]', ''));

		if ($cfg['jquery'] && $cfg['turnajax'] && $cfg['plugin']['mavatars']['turnajax'])
		{
			$t->assign("FILEUPLOAD_URL", cot_url('plug', 'r=mavatars&m=upload&ext='.$this->extension.'&cat='.$this->category.'&code='.$this->code.'&'.cot_xg(), '', true));
			$t->parse("MAIN.AJAXUPLOAD");
		}
		else
		{
			$t->parse("MAIN.UPLOAD");
		}
		if ($cfg['plugin']['mavatars']['turncurl'])
		{
			$t->assign("CURLUPLOAD_INPUT", cot_inputbox('text', 'mavatar_curlfile[]', ''));
			$t->parse("MAIN.CURLUPLOAD");
		}
		$t->parse("MAIN");
		return $t->text("MAIN");
	}

	public function curl_upload($file)
	{
		global $cfg;
		$ch = curl_init();
		$ch = curl_init($file);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		$rawdata = curl_exec($ch);

		$path = parse_url($file, PHP_URL_PATH);
		$path_parts = pathinfo($path);
		$file_name = $path_parts['basename'];
		$extension = mb_strtolower($path_parts['extension']);
		if (!in_array($extension, $this->suppressed_ext) && in_array($path_parts['extension'], $this->allowed_ext))
		{
			$file_name = cot_safename($path_parts['basename'], $this->path);
			$file_name = str_replace('.'.$extension, '', $file_name);

			if (file_exists($this->path.$file_name.'.'.$extension))
			{
				$file_name = $file_name."_".date("Ymd_His");
			}

			$file_fullname = $this->path.$file_name.'.'.$extension;

// Check if any error occured 
			if (curl_errno($ch))
			{
				$fp = fopen($file_fullname, 'w');
				fwrite($fp, $rawdata);
				fclose($fp);
			}
			curl_close($ch);

			if (!$this->file_check($file_fullname, $path_parts['extension']) && $cfg['plugin']['mavatars']['filecheck'])
			{
				unlink($file_fullname);
				return false;
			}

			return array(
				'fullname' => $file_fullname,
				'extension' => $extension,
				'size' => filesize($file_fullname),
				'path' => $this->path,
				'name' => $file_name,
				'origname' => str_replace('.'.$path_parts['extension'], '', $path_parts['basename'])
			);
		}

		return false;
	}

	function file_upload($file_object)
	{
		global $cfg;
		$path_parts = pathinfo($file_object['name']);
		$file_name = $path_parts['basename'];
		$extension = mb_strtolower($path_parts['extension']);
		if (!in_array($extension, $this->suppressed_ext) && in_array($extension, $this->allowed_ext))
		{
			$file_name = cot_safename($path_parts['basename'], $this->path);
			
			$file_name = str_replace('.'.$extension, '', $file_name);
			if ($this->file_check($file_object['tmp_name'], $extension) || !$cfg['plugin']['mavatars']['filecheck'])
			{
				if (file_exists($this->path.$file_name.'.'.$extension))
				{
					$file_name = $file_name."_".date("Ymd_His");
				}
				if (move_uploaded_file($file_object['tmp_name'], $this->path.$file_name.'.'.$extension))		
				{
					return array(
						'fullname' => $this->path.$file_name.'.'.$extension,
						'extension' => $extension,
						'size' => $file_object['size'],
						'path' => $this->path,
						'name' => $file_name,
						'origname' => str_replace('.'.$extension, '', $file_object['name'])
					);
				}
			}
			return false;
		}
		return false;
	}
	
	function mavatar_add($file, $desc='',$order=0, $type='')
	{
		global $db, $db_mavatars;
		$mavarray = array(
			'mav_userid' => $usr['id'],
			'mav_extension' => $this->extension,
			'mav_category' => $this->category,
			'mav_code' => $this->code,
			'mav_item' => $this->item,
			'mav_filepath' => $file['path'],
			'mav_filename' => $file['name'],
			'mav_fileext' => $file['extension'],
			'mav_fileorigname' => $file['origname'],
			'mav_thumbpath' => $this->thumbspath,
			'mav_filesize' => $file['size'],
			'mav_desc' => empty($desc) ? $file['origname'] : $desc,
			'mav_order' => $order,
			'mav_type' => $type,
		);
		$db->insert($db_mavatars, $mavarray);
		$mavarray['mav_id'] = $db->lastInsertId();
		return $mavarray;
	}

	function ajax_upload()
	{

		global $db, $db_mavatars;
		$order = count($this->mavatars);
		$file_object = array();
		if (is_array($_FILES['mavatar_file']['name']))
		{
			$file_object['name'] = $_FILES['mavatar_file']['name'][0];
			$file_object['tmp_name'] = $_FILES['mavatar_file']['tmp_name'][0];
			$file_object['size'] = $_FILES['mavatar_file']['size'][0];
			$file_object['error'] = $_FILES['mavatar_file']['error'][0];
		}
		else
		{
			$file_object = $_FILES['mavatar_file'];
		}
		$file = $this->file_upload($file_object);
		if ($file)
		{
			$order++;
			$mavarray = $this->mavatar_add($file, '', $order);
		}
		$mavatar = array();
		foreach ($mavarray as $key => $val)
		{
			$keyx = str_replace('mav_', '', $key);
			if ($keyx == 'filepath' || $keyx == 'thumbpath')
			{
				$val .= (substr($val, -1) == '/') ? '' : '/';
			}
			$mavatar[$keyx] = $val;
		}
		$mskin = cot_tplfile(array('mavatars', 'form', $this->extension, $this->category, $this->code), 'plug');
		$t = new XTemplate($mskin);

		$t->assign($this->generate_tags($mavatar));
		$t->assign(array(
			'ENABLED' => cot_checkbox(true, 'mavatar_enabled['.$mavatar['id'].']', '', 'title="'.$L['Enabled'].'"'),
			'FILEORDER' => cot_inputbox('text', 'mavatar_order['.$mavatar['id'].']', $mavatar['order'], 'maxlength="4" size="4"'),
			'FILEDESC' => cot_inputbox('text', 'mavatar_desc['.$mavatar['id'].']', $mavatar['desc']),
			'FILENEW' => cot_inputbox('hidden', 'mavatar_new['.$mavatar['id'].']', 0),
		));
		$t->parse("MAIN.FILES.ROW");
		if ($this->mavatars)
		{
			$mavatar['form'] = htmlspecialchars($t->text("MAIN.FILES.ROW"));
		}
		else
		{
			$t->parse("MAIN.FILES");
			$mavatar['form'] = htmlspecialchars($t->text("MAIN.FILES"));
		}
		$mavatar['success'] = 1;
		return $mavatar;
	}

	function upload($input_name = 'mavatar_file')
	{

		global $db, $db_mavatars, $cfg;
		
		if ($cfg['plugin']['mavatars']['turnajax']) {
			return false;
		}
		
		$order = count($this->mavatars);
		$files_array = array();
		if (is_array($_FILES[$input_name]['name']))
		{
			foreach ($_FILES[$input_name]['name'] as $key => $val)
			{
				$files_array[$key]['name'] = $_FILES[$input_name]['name'][$key];
				$files_array[$key]['tmp_name'] = $_FILES[$input_name]['tmp_name'][$key];
				$files_array[$key]['size'] = $_FILES[$input_name]['size'][$key];
				$files_array[$key]['error'] = $_FILES[$input_name]['error'][$key];
			}
		}
		else
		{
			$files_array[0] = $_FILES[$input_name];
		}

		foreach ($files_array as $key => $file_object)
		{
			$file = $this->file_upload($file_object);
			if ($file)
			{
				$order++;
				$this->mavatar_add($file, '', $order);
			}
		}
		if ($cfg['plugin']['mavatars']['turncurl'])
		{
			$files_array = array();
			if (is_array($_GET['mavatar_curlfile']))
			{
				$files_array = cot_import('mavatar_curlfile', 'G', 'ARR');
			}
			elseif (is_string($_GET['mavatar_curlfile']))
			{
				$files_array[] = $_GET['mavatar_curlfile'];
			}
			foreach ($files_array as $key => $file_object)
			{
				$order++;
				$file = $this->curl_upload($file_object);
				if ($file)
				{
					$order++;
					$this->mavatar_add($file, '', $order);
				}
			}
		}
		//
	}

	function update()
	{
		global $db, $db_mavatars;
		if ($this->code != 'new')
		{

			$mavatars['mav_enabled'] = cot_import('mavatar_enabled', 'P', 'ARR');
			$mavatars['mav_order'] = cot_import('mavatar_order', 'P', 'ARR');
			$mavatars['mav_desc'] = cot_import('mavatar_desc', 'P', 'ARR');
			$mavatars['mav_new'] = cot_import('mavatar_new', 'P', 'ARR');

			$mavatars['mav_enabled'] = (count($mavatars['mav_enabled']) > 0) ? $mavatars['mav_enabled'] : array();

			foreach ($mavatars['mav_enabled'] as $id => $enabled)
			{
				$mavatar = array();
				$enabled = cot_import($enabled, 'D', 'BOL') ? true : false;
				$mavatar['mav_order'] = cot_import($mavatars['mav_order'][$id], 'D', 'INT');
				$mavatar['mav_desc'] = cot_import($mavatars['mav_desc'][$id], 'D', 'TXT');
				$new = cot_import($mavatars['mav_new'][$id], 'D', 'BOL');
				if ($enabled)
				{
					$mavatar['mav_extension'] = $this->extension;
					$mavatar['mav_category'] = $this->category;
					$mavatar['mav_code'] = $this->code;

					$db->update($db_mavatars, $mavatar, 'mav_id='.(int)$id);
				}
				else
				{
					$mavatar = $this->get_mavatar_byid($id);
					$this->delete_mavatar($mavatar);
				}
			}
			$this->get_mavatars();
		}
	}

	/**
	 * Strips all unsafe characters from file base name and converts it to latin
	 *
	 * @param string $basename File base name
	 * @param string $savedirectory File path
	 * @param string $postfix Postfix appended to filename
	 * @return string
	 */
	function safename($basename, $savedirectory = '', $postfix = '')
	{
		global $lang, $cot_translit, $sys;
		if (!$cot_translit && $lang != 'en' && file_exists(cot_langfile('translit', 'core')))
		{
			require_once cot_langfile('translit', 'core');
		}

		$fname = mb_substr($basename, 0, mb_strrpos($basename, '.'));
		$ext = mb_substr($basename, mb_strrpos($basename, '.') + 1);
		if ($lang != 'en' && is_array($cot_translit))
		{
			$fname = strtr($fname, $cot_translit);
		}

		$fname = str_replace(' ', '_', $fname);
		$fname = preg_replace('#[^a-zA-Z0-9\-_\.\ \+]#', '', $fname);
		$fname = str_replace('..', '.', $fname);
		if (empty($fname))
		{
			$fname = cot_unique();
		}
		if (file_exists($savedirectory.$fname.$postfix.'.'.mb_strtolower($ext)))
		{
			$fname = $fname."_".cot_date('dmY_His', $sys['now']);
		}
		return $fname.$postfix.'.'.mb_strtolower($ext);
	}

	/**
	 * Checks a file to be sure it is valid
	 *
	 * @param string $file File path
	 * @param string $ext File extension
	 * @return bool
	 */
	function file_check($file, $ext)
	{
		global $L, $cfg, $mime_type;
		require './datas/mimetype.php';
		$fcheck = FALSE;
		if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif')))
		{
			switch ($ext)
			{
				case 'gif':
					$fcheck = @imagecreatefromgif($file);
					break;

				case 'png':
					$fcheck = @imagecreatefrompng($file);
					break;

				default:
					$fcheck = @imagecreatefromjpeg($file);
					break;
			}
			$fcheck = $fcheck !== FALSE;
		}
		else
		{
			if (!empty($mime_type[$ext]))
			{
				foreach ($mime_type[$ext] as $mime)
				{
					$content = file_get_contents($file, 0, NULL, $mime[3], $mime[4]);
					$content = ($mime[2]) ? bin2hex($content) : $content;
					$mime[1] = ($mime[2]) ? strtolower($mime[1]) : $mime[1];
					$i++;
					if ($content == $mime[1])
					{
						$fcheck = TRUE;
						break;
					}
				}
			}
		}
		return($fcheck);
	}

}

/**
 * Creates image thumbnail
 *
 * @param array $object Mavatar object or string with img path
 * @param string $target Thumbnail path
 * @param int $width Thumbnail width
 * @param int $height Thumbnail height
 * @param string $resize resize options: crop auto width height
 * @param string $filter filter options: need exists function with this name
 * @param int $quality JPEG quality in %
 */
function cot_mav_thumb($object, $width, $height, $resize = 'crop', $filter = '', $quality = 85)
{
	global $mav_cfg;
	if (empty($object))
	{
		return false;
	}
	if (!is_array($object))
	{
		$path_info = pathinfo($object);
		$object['fileext'] = $path_info['extension'];
		$object['filename'] = $path_info['filename'];
		$object['filepath'] = $path_info['dirname'];
		$object['thumbpath'] = $mav_cfg['__default']['thumbspath'];
	}
	else
	{
		$objectx = array();
		foreach ($object as $key => $val)
		{
			$keyx = mb_strtolower($key);
			$objectx[$keyx] = $val;
		}
		$object = $objectx;
	}
	if (!in_array($object['fileext'], array('jpg', 'jpeg', 'png', 'gif')))
	{
		return false;
	}

	$source_file = $object['filepath'].$object['filename'].'.'.$object['fileext'];

	$thumb_file = $object['thumbpath'].$object['filename'].'_'.$width.'_'.$height.'_'.$resize;
	$thumb_file .= (!empty($filter)) ? '_'.$filter : '';
	$thumb_file .= '.'.$object['fileext'];

	if (!file_exists($source_file))
	{
		return false;
	}
	if (file_exists($thumb_file))
	{
		return $thumb_file;
	}

	list($width_orig, $height_orig) = getimagesize($source_file);
	$x_pos = 0;
	$y_pos = 0;

	$width = (mb_substr($width, -1, 1) == '%') ? (int)($width_orig * (int)mb_substr($width, 0, -1) / 100) : (int)$width;
	$height = (mb_substr($height, -1, 1) == '%') ? (int)($height_orig * (int)mb_substr($height, 0, -1) / 100) : (int)$height;

	if ($resize == 'crop')
	{
		$newimage = imagecreatetruecolor($width, $height);
		$width_temp = $width;
		$height_temp = $height;

		if ($width_orig / $height_orig > $width / $height)
		{
			$width = $width_orig * $height / $height_orig;
			$x_pos = -($width - $width_temp) / 2;
			$y_pos = 0;
		}
		else
		{
			$height = $height_orig * $width / $width_orig;
			$y_pos = -($height - $height_temp) / 2;
			$x_pos = 0;
		}
	}
	else
	{
		if ($resize == 'width' || $height == 0)
		{
			if ($width_orig > $width)
			{
				$height = $height_orig * $width / $width_orig;
			}
			else
			{
				$width = $width_orig;
				$height = $height_orig;
			}
		}
		elseif ($resize == 'height' || $width == 0)
		{
			if ($height_orig > $height)
			{
				$width = $width_orig * $height / $height_orig;
			}
			else
			{
				$width = $width_orig;
				$height = $height_orig;
			}
		}
		elseif ($resize == 'auto')
		{
			if ($width_orig < $width && $height_orig < $height)
			{
				$width = $width_orig;
				$height = $height_orig;
			}
			else
			{
				if ($width_orig / $height_orig > $width / $height)
				{
					$height = $width * $height_orig / $width_orig;
				}
				else
				{
					$width = $height * $width_orig / $height_orig;
				}
			}
		}


		$newimage = imagecreatetruecolor($width, $height); //
	}

	switch ($object['fileext'])
	{
		case 'gif':
			$oldimage = imagecreatefromgif($source_file);
			break;
		case 'png':
			imagealphablending($newimage, false);
			imagesavealpha($newimage, true);
			$oldimage = imagecreatefrompng($source_file);
			break;
		default:
			$oldimage = imagecreatefromjpeg($source_file);
			break;
	}

	imagecopyresampled($newimage, $oldimage, $x_pos, $y_pos, 0, 0, $width, $height, $width_orig, $height_orig);

	if (function_exists($filter))
	{
		$filter($newimage);
	}

	switch ($object['fileext'])
	{
		case 'gif':
			imagegif($newimage, $thumb_file);
			break;
		case 'png':
			imagepng($newimage, $thumb_file);
			break;
		default:
			imagejpeg($newimage, $thumb_file, $quality);
			break;
	}

	imagedestroy($newimage);
	imagedestroy($oldimage);

	return $thumb_file;
}