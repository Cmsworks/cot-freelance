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

cot::$db->registerTable('mavatars');

cot_extrafields_register_table('mavatars');

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
	private $filepath = '';
	private $thumbpath = '';
	private $required = '';
	private $allowed_ext = '';
	private $maxsize = '';
	private $mode = '';

	public function __construct($extension, $category, $code, $mode = '', $inputdata = array())
	{
		$this->get_config($extension, $category);

		$this->extension = $extension;
		$this->category = $category;
		$this->code = $code;
		$this->mode = $mode;

		$this->get_mavatars($inputdata);
	}

	/**
	 * Загружает таблицу конфигов
	 */
	protected function load_config_table()
	{
		global $cfg;
		$tpaset = str_replace("\r", "", $cfg['plugin']['mavatars']['set']);
		$tpaset = explode("\n", $tpaset);
		foreach ($tpaset as $val)
		{
			$val = explode('|', $val);
			$val = array_map('trim', $val);
			if (count($val) > 1)
			{
				$val_ext = empty($val[0]) ? '__default' : $val[0];
				$val_cat = (empty($val[1]) || empty($val[0])) ? '__default' : $val[1];
				
				$val_path = $this->fix_path($val[2], $cfg['photos_dir']);
				$val_thumbspath = $this->fix_path($val[3], $val_path);	

				$val[5] = str_replace(array(' ', '.', '*'), array('', '', ''), $val[5]);
				$extensions = explode(',', mb_strtolower($val[5]));
		
				$mav_cfg[$val_ext][$val_cat] = array(
					'filepath' => $val_path,
					'thumbspath' => $val_thumbspath,
					'required' => (int)$val[4] ? 1 : 0,
					'allowed_ext' => (!empty($val[5])) ? $extensions : $this->images_ext,
					'maxsize' => ((int)$val[6] > 0) ? (int)$val[6] : 0
				);
			}
		}
		if (!$mav_cfg['__default']['__default'])
		{
			$def_photodir = $this->fix_path($cfg['photos_dir']);
			$mav_cfg['__default']['__default'] = array(
				'filepath' => $def_photodir,
				'thumbspath' => $def_photodir,
				'required' => 0,
				'allowed_ext' => $this->images_ext,
				'maxsize' => 0
			);
		}
		$this->config = $mav_cfg;
	}
	
	/**
	 * Функция загружает текущую конфигурацию
	 *
	 * @param string $extension Расширение
	 * @param string $category $categoryКатегория
	 */
	protected function get_config($extension = '__default', $category = '__default')
	{
		$this->load_config_table();
		
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

				$category = '__default';
				foreach ($cat_parents as $cat)
				{
					if (isset($this->config[$extension][$cat]))
					{
						$category = $cat;
						break;
					}
				}
			}
			if (!isset($this->config[$extension][$category]))
			{
				$extension = '__default';
				$category = '__default';
			}
		}
		$this->filepath = $this->config[$extension][$category]['filepath'];
		$this->thumbpath = $this->config[$extension][$category]['thumbspath'];
		$this->required = $this->config[$extension][$category]['required'];
		$this->allowed_ext = $this->config[$extension][$category]['allowed_ext'];
		$this->maxsize = $this->config[$extension][$category]['maxsize'];
	}
	
	/**
	 * Функция возвращает строку запроса к текущим маватарам
	 *
	 * @return string
	 */	
	private function mavatars_query()
	{
		global $db_mavatars, $db, $usr, $sys;

		if($this->mode == 'edit')
		{
			if($usr['id'] == 0)
			{
				$query_string = " AND mav_sessid='".cot_import('PHPSESSID', 'C', 'TXT')."'";
			}
			else
			{
				$query_string = " AND mav_userid=".$usr['id'];
			}

			$oldmavatars = $db->query("SELECT * FROM $db_mavatars 
				WHERE mav_extension ='".$db->prep($this->extension)."' 
					AND mav_code = '' $query_string 
					AND mav_date+86400<".$sys['now'])->fetchAll();

			if(is_array($oldmavatars))
			{
				foreach ($oldmavatars as $oldmavatar) 
				{
					$mavatar = $this->sqldata_to_array($oldmavatar);
					$this->delete_mavatar($mavatar);
				}
			}
		}

		return "SELECT * FROM $db_mavatars WHERE mav_extension ='".$db->prep($this->extension)."' AND
			mav_code = '".$db->prep($this->code)."' $query_string ORDER BY mav_order ASC, mav_item ASC";
	}
	private function mavatars_queryid($id)
	{
		global $db_mavatars, $db;
		return "SELECT * FROM $db_mavatars WHERE mav_id ='".(int)$id."' LIMIT 1";
	}	
	
	private function filter_inputdata($data_array)
	{
		global $db_mavatars, $db;
		$mavatars_data = array();
		foreach ($data_array as $data)
		{
			if($data['mav_extension'] == $this->extension && $data['mav_code'] == $this->code)
			{
				$mavatars_data[] = $data;
			}
		}
		return $mavatars_data;
	}	
	
	private function sqldata_to_array($data)
	{
		$mavatar = array();
		foreach ($data as $key => $val)
		{
			$keyx = str_replace('mav_', '', $key);
			if ($keyx == 'filepath' || $keyx == 'thumbpath')
			{
				$val = $this->fix_path($val);
			}
			$mavatar[$keyx] = $val;
		}
		return $mavatar;
	}
	
	/**
	 * Функция получает маватары для текущего элемента
	 * @param $mavatars_ids array массив маватаров
	 * @return array
	 */
	public function get_mavatars($mavatars_ids = null)
	{
		global $db, $db_mavatars;
		$this->mavatars = array();
		if ($this->code != 'new')
		{
			if (empty($mavatars_ids))
			{
				$mavs = $db->query($this->mavatars_query())->fetchAll();
			}
			elseif((int)$mavatars_ids > 0)
			{
				$mavs = $db->query($this->mavatars_queryid($mavatars_ids))->fetchAll();
			}
			else
			{
				$mavs = $this->filter_inputdata($mavatars_ids);
			}
			$i = 0;
			$mav_struct = array();
			foreach ($mavs as $mav_row)
			{
				$i++;				
				$mavatar = $this->sqldata_to_array($mav_row);
				$mavatar['i'] = $i;
				$this->mavatars[$i] = $mavatar;
			}
		}
		return $this->mavatars;
	}

	private function get_mavatar_byid($id)
	{
		global $db;
		
		foreach ($this->mavatars as $key => $mavatar)
		{
			if ($mavatar['id'] == $id)
			{
				return $mavatar;
			}
		}
		if (empty($mavatar))
		{
			$sql = $db->query($this->mavatars_queryid($id));
			$mav_row = $sql->fetch();
			$mavatar = $this->sqldata_to_array($mav_row);
			$mavatar['i'] = 1;
			return $mavatar;
		}
		if (empty($mavatar))
		{
			return false;
		}
	}
	
	public function get_mavatar_files($mavatar)
	{
		$file_list = array();
		if (!empty($mavatar['filepath']) && !empty($mavatar['filename']) && !empty($mavatar['fileext']))
		{
			if (in_array($mavatar['fileext'], $this->images_ext))
			{
				// большое изменение - теперь должны миниатюры хранится в папках !
				foreach (glob($mavatar['thumbpath'].'*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
				{
					$file = $this->file_path($dir, $mavatar['filename'], $mavatar['fileext']);
					if (file_exists($file))
					{
						$file_list[basename($dir)] = $file;
					}
				}
			}

			$file_list['main'] = $this->file_path($mavatar['filepath'], $mavatar['filename'], $mavatar['fileext']);
		}
		return $file_list;
	}

	public function delete_mavatar($mavatar)
	{
		global $db, $db_mavatars;

		$db->delete($db_mavatars, "mav_id=".$mavatar['id']);
		$this->delete_files($mavatar);
		unset($this->mavatars[$mavatar['i']]);
	}
	
	public function delete_mavatar_byid($id)
	{
		$mavatar = $this->get_mavatar_byid($id);
		if(!empty($mavatar))
		{
			$this->delete_mavatar($mavatar);
		}
	}

	public function delete_all_mavatars()
	{
		foreach ($this->mavatars as $mavatar)
		{
			$this->delete_mavatar($mavatar);
		}
	}
	
	public function delete_files($mavatar, $onlythumbs = false)
	{
		foreach ($this->get_mavatar_files($mavatar) as $key => $file)
		{
			if (!($key == 'main' && $onlythumbs) && file_exists($file) && is_writable($file))
			{
				@unlink($file);
			}
		}
	}
	
	public function object_tags($mavatar)
	{
		$curr_mavatar = array();
		$curr_mavatar['FILE'] = $this->file_path($mavatar['filepath'], $mavatar['filename'], $mavatar['fileext']);
		$curr_mavatar['SHOW'] = cot_url('plug', 'e=mavatars&m=show&id='.$mavatar['id']);

		foreach ($mavatar as $key_p => $val_p)
		{
			$keyx = mb_strtoupper($key_p);
			//TODO: исправить для дат
			$curr_mavatar[$keyx] = $val_p;
		}
		return $curr_mavatar;
	}
	public function object_edittags($mavatar, $prefix="mavatar_")
	{
		global $db_mavatars, $cot_extrafields;
		$curr_mavatar = array(
				'MAVATAR' => $this->object_tags($mavatar),
				'DELETE' => cot_checkbox(false, $prefix.'delete['.$mavatar['id'].']', '', 'title="'.$L['Enabled'].'"'),
				'FILEORDER' => cot_inputbox('text', $prefix.'order['.$mavatar['id'].']', $mavatar['order'], 'maxlength="4" size="4"'),
				'FILEDESC' => cot_inputbox('text', $prefix.'desc['.$mavatar['id'].']', $mavatar['desc']),
				'FILEDESCTEXT' => cot_inputbox('text', $prefix.'desc['.$mavatar['id'].']', $mavatar['desc']),
				'FILENEW' => cot_inputbox('hidden', $prefix.'new['.$mavatar['id'].']', 0),
		);
		foreach($cot_extrafields[$db_mavatars] as $exfld)
		{
			$uname = strtoupper($exfld['field_name']);
			$exfld_val = cot_build_extrafields($prefix.$exfld['field_name'], $exfld, $mavatar[$exfld['field_name']]);
			$exfld_title = isset($L['mavatar_'.$exfld['field_name'].'_title']) ?  $L['mavatar_'.$exfld['field_name'].'_title'] : $exfld['field_description'];

			$curr_mavatar[$uname] = $exfld_val;
			$curr_mavatar[$uname.'_TITLE'] = $exfld_title;
		}
		return $curr_mavatar;
	}
	public function tags()
	{
		$array = array();
		foreach ($this->mavatars as $key => $mavatar)
		{
			$array[$key] = $this->object_tags($mavatar);
		}
		return $array;
	}
	
	public function upload_form()
	{
		global $cfg, $L;
		$mskin = cot_tplfile(array('mavatars', 'form', $this->extension, $this->category, $this->code), 'plug');
		$t = new XTemplate($mskin);

		foreach ($this->mavatars as $key => $mavatar)
		{
			$t->assign($this->object_edittags($mavatar));
			$t->parse("MAIN.FILES.ROW");
		}
		if (count($this->mavatars) > 0)
		{
			$t->parse("MAIN.FILES");
		}
		$t->assign("FILEUPLOAD_INPUT", cot_inputbox('file', 'mavatar_file[]', ''));

		if ($cfg['jquery'] && $cfg['plugin']['mavatars']['turnajax'])
		{
			$t->assign("FILEUPLOAD_URL", cot_url('plug', 'r=mavatars&m=upload&ext='.$this->extension.'&cat='.$this->category.'&code='.$this->code.'&'.cot_xg(), '', true));
			$t->assign('MAXFILESIZE', $this->maxsize);
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
		list($file_name, $file_extension) = $this->file_info($path);

		if (!in_array($file_extension, $this->suppressed_ext) && in_array($path_parts['extension'], $this->allowed_ext))
		{
			$file_name = $this->safename($file_name, $file_extension, $this->filepath);
			$file_fullname = $this->file_path($this->filepath, $file_name, $file_extension);

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
				'extension' => $file_extension,
				'size' => filesize($file_fullname),
				'path' => $this->filepath,
				'name' => $file_name,
				'origname' => str_replace('.'.$path_parts['extension'], '', $path_parts['basename'])
			);
		}

		return false;
	}

	function file_upload($file_object)
	{
		global $cfg;

		list($file_name, $file_extension) = $this->file_info($file_object['name']);
		$file_size = (isset($file_object['tmp_name']['size'])) ? $file_object['tmp_name']['size'] : 0;
		if (!empty($file_name) && !in_array($file_extension, $this->suppressed_ext) && in_array($file_extension, $this->allowed_ext) && $file_size <= $this->maxsize)
		{
			$safe_name = $this->safename($file_name, $file_extension, $this->filepath);
			$file_fullname = $this->file_path($this->filepath, $safe_name, $file_extension);

			if ($this->file_check($file_object['tmp_name'], $file_extension) || !$cfg['plugin']['mavatars']['filecheck'])
			{
				if (move_uploaded_file($file_object['tmp_name'], $file_fullname))		
				{
					return array(
						'fullname' => $file_fullname,
						'extension' => $file_extension,
						'size' => $file_object['size'],
						'path' => $this->filepath,
						'name' => $safe_name,
						'origname' => $file_name
					);
				}
			}
			return false;
		}
		return false;
	}	
	/// стоп
	function mavatar_add($file, $desc='',$order=0, $type='')
	{
		global $db, $db_mavatars, $sys, $cot_extrafields, $usr;
		$mavarray = array(
			'mav_userid' => $usr['id'],
      		'mav_sessid' => ($usr['id'] > 0) ? '' : cot_import('PHPSESSID', 'C', 'TXT'),
			'mav_extension' => $this->extension,
			'mav_category' => $this->category,
			'mav_code' => $this->code,
			'mav_item' => $this->item,
			'mav_filepath' => $file['path'],
			'mav_filename' => $file['name'],
			'mav_fileext' => $file['extension'],
			'mav_fileorigname' => $file['origname'],
			'mav_thumbpath' => $this->thumbpath,
			'mav_filesize' => $file['size'],
			'mav_desc' => empty($desc) ? $file['origname'] : $desc,
			'mav_order' => $order,
			'mav_date' => $sys['now'],
			'mav_type' => $type,
		);

		$db->insert($db_mavatars, $mavarray);
		$mavarray['mav_id'] = $db->lastInsertId();
		return $this->sqldata_to_array($mavarray);
	}

	function ajax_upload($input_name = 'mavatar_file')
	{

		global $db, $db_mavatars;
		$order = count($this->mavatars);

		$files_array = $this->filedata_to_array($input_name);
		$file = $this->file_upload($files_array[0]);
		$mavatar = array();
		if ($file)
		{
			$order++;
			$mavatar = $this->mavatar_add($file, '', $order);
		}

		$mskin = cot_tplfile(array('mavatars', 'form', $this->extension, $this->category, $this->code), 'plug');
		$t = new XTemplate($mskin);

		$t->assign($t->assign($this->object_edittags($mavatar)));
		$t->parse("MAIN.FILES.ROW");
		// код выполняется для посторения формы если нет маватаров
		if (count($this->mavatars))
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
// тттттт
	function upload($input_name = 'mavatar_file')
	{

		global $db, $db_mavatars, $cfg;;

/*		
		if ($cfg['plugin']['mavatars']['turnajax'])
		{
			return false;
		}
*/
		$order = count($this->mavatars);
		$files_array = $this->filedata_to_array($input_name);

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
		global $db, $db_mavatars, $sys, $cot_extrafields;
		if ($this->code != 'new') //TODO: а что происходит с аякс загрузкой?
		{

			$mavatars['mav_delete'] = cot_import('mavatar_delete', 'P', 'ARR');
			$mavatars['mav_order'] = cot_import('mavatar_order', 'P', 'ARR');
			$mavatars['mav_desc'] = cot_import('mavatar_desc', 'P', 'ARR');
			$mavatars['mav_new'] = cot_import('mavatar_new', 'P', 'ARR');

			$mavatars['mav_delete'] = (count($mavatars['mav_delete']) > 0) ? $mavatars['mav_delete'] : array();

			foreach ($cot_extrafields[$db_mavatars] as $exfld)
			{
				if ($exfld['field_type'] != 'file' || $exfld['field_type'] != 'filesize')
				{
					$mavatars[$exfld['field_name']] = cot_import('mavatar_' . $exfld['field_name'], 'P', 'ARR');
				}
				elseif ($exfld['field_type'] == 'file')
				{
					// TODO FIXME!
					//$rstructureextrafieldsarr[$exfld['field_name']] = cot_import_filesarray('rstructure'.$exfld['field_name']);
				}
			}

			foreach ($mavatars['mav_delete'] as $id => $delete)
			{
				$mavatar_info = $this->get_mavatar_byid($id);
				$mavatar = array();
				$delete = cot_import($delete, 'D', 'BOL') ? true : false;
				$mavatar['mav_order'] = cot_import($mavatars['mav_order'][$id], 'D', 'INT');
				$mavatar['mav_desc'] = cot_import($mavatars['mav_desc'][$id], 'D', 'TXT');

				foreach ($cot_extrafields[$db_mavatars] as $exfld)
				{
					$mavarray['mav_'.$exfld['field_name']] = cot_import_extrafields($mavatars['mav_'.$exfld['field_name']][$id], $exfld, 'D', $mavatar_info['mav_'.$exfld['field_name']]);
				}

				$new = cot_import($mavatars['mav_new'][$id], 'D', 'BOL');
				
				if (!$delete)
				{
					$mavatar['mav_extension'] = $this->extension;
					$mavatar['mav_category'] = $this->category;
					$mavatar['mav_code'] = $this->code;
					$mavatar['mav_filename'] = $this->rename_file($mavatar_info, $mavatar['mav_desc']) ;
					$mavatar['mav_date'] = $sys['now'];
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
	
	private function filedata_to_array($input_name = 'mavatar_file')
	{
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
		
		return $files_array; 
	}	
	
	/**
	 * Strips all unsafe characters from file base name and converts it to latin
	 *
	 * @param string $name File base name
	 * @param string $ext File extension
	 * @param string $savedirectory File path
	 * @param string $unique_name File path 
	 * @return string
	 */
	function safename($name, $ext, $savedirectory = '', $unique_name = true)
	{
		global $lang, $cot_translit, $sys;
		if (!$cot_translit && $lang != 'en' && file_exists(cot_langfile('translit', 'core')))
		{
			require_once cot_langfile('translit', 'core');
		}

		if ($lang != 'en' && is_array($cot_translit))
		{
			$name = strtr($name, $cot_translit);
		}

		$name = str_replace(' ', '_', $name);
		$name = preg_replace('#[^a-zA-Z0-9\-_\.\ \+]#', '', $name);
		$name = str_replace('..', '.', $name);
		$name = mb_substr($name , 0 , 200 );
		
		if (empty($name))
		{
			$name = cot_unique();
		}
		if ($unique_name && file_exists($this->file_path($savedirectory, $name, $ext)))
		{
			$name .="_".cot_date('dmY_His', $sys['now']);
		}
		if ($unique_name && file_exists($this->file_path($savedirectory, $name, $ext)))
		{
			$name .="_".rand(1, 999);
		}
		return $name;
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
	
	private function rename_file($object, $newname)
	{
		if ($newname != $object['desc'] && !empty($object['desc']))
		{
			$newfilename = $this->safename($newname, $object['fileext'], $object['filepath']);
			$this->delete_files($object, true);
			$newpath = $this->file_path($object['filepath'], $newfilename, $object['fileext']);
			$oldpath = $this->file_path($object['filepath'], $object['filename'], $object['fileext']);
			if (rename($oldpath, $newpath));
			{
				return $newfilename;
			}
			return $object['filename'];
		}	
		
	}	
	private function file_info($file)
	{
		$path_parts = pathinfo($file);
		$name = $path_parts['filename'];
		$extension = mb_strtolower($path_parts['extension']);	
		return array($name, $extension);
	}
	
	private function file_path($dir, $file, $ext)
	{
		$dir = $this->fix_path($dir);
		return $dir.$file.'.'.$ext;
	}
	
	private function fix_path($path, $default = '')
	{
		$path = (!empty($path)) ? $path : $default;
		$path .= (substr($path, -1) == '/') ? '' : '/';
		return $path;
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
	public function thumb($object, $width, $height, $resize = 'crop', $filter = '', $quality = 85)
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

		$source_file = $this->file_path($object['filepath'], $object['filename'], $object['fileext']);
		if (!file_exists($source_file))
		{
			if((int)$object['id'] > 0)
			{
				$this->delete_mavatar($object);
			}
			return false;
		}	
		
		$thumb_dir = $object['thumbpath'].$width.'_'.$height.'_'.$resize;
		$thumb_dir .= (!empty($filter)) ? '_'.$filter : '';
		$thumb_dir = $this->fix_path($thumb_dir);
		if (!file_exists($thumb_dir)) {
			mkdir($thumb_dir, 0777);
			chmod($thumb_dir, 0777);
		}
		$thumb_file = $this->file_path($thumb_dir, $object['filename'], $object['fileext']);

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
	public function check_thumb($object, $width, $height, $resize = 'crop', $filter = '', $quality = 85)
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

		$source_file = $this->file_path($object['filepath'], $object['filename'], $object['fileext']);
	
		
		$thumb_dir = $object['thumbpath'].$width.'_'.$height.'_'.$resize;
		$thumb_dir .= (!empty($filter)) ? '_'.$filter : '';
		$thumb_dir = $this->fix_path($thumb_dir);

		$thumb_file = $this->file_path($thumb_dir, $object['filename'], $object['fileext']);

		if (file_exists($thumb_file))
		{
			return $thumb_file;
		}	
		else
		{
			return cot_url('plug', 'r=mavatars&m=thumb&ext='.$this->extension.'&cat='.$this->category.'&code='.$this->code.'&id='.$object['id'].'&width='.$width
				.'&height='.$height.'&resize='.$resize.'&filter='.$filter.'&quality='.$quality);
		}	
	}

	public function filter ($param, $value)
	{
		$array = array();
		$param = mb_strtolower($param);
		foreach ($this->mavatars as $key => $mavatar)
		{
			if($mavatar[$param] == $value)
			{
				$array[$key] = $this->object_tags($mavatar);
			}
		}
		return $array;
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
	global $mavatar;
	return $mavatar->check_thumb($object, $width, $height, $resize, $filter, $quality);
}

function cot_mav_filter($mavatar, $param, $value)
{
	return $mavatar->filter($param, $value);
}
