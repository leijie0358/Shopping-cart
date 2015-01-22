<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class JR_Controller extends CI_Controller
{
	public $resources = array();
	
	function __construct()
    {
        parent::__construct();

		//print_r($_SERVER);
		$this->load->library("autho"); 
		$this->autho->action_isauth();

		$query = $this->db->get("resource");
		$resourcess = $query->result();
		foreach($resourcess as  $resource)
		{
			$this->resources[$resource->name] = $resource; 
		}
    }

	function isauth($resource_name,$actionname)
	{
		$role_type= $this->session->userdata["user"]->role_type;
		if($role_type == 3) return true;
		$role_id = $this->session->userdata["user"]->role_id;
		$this->load->library("autho"); 
		return $this->autho->isauth($role_id,$this->resources[$resource_name]->id,$actionname);
	}

	function error($title,$errinfo,$url)
	{
		$data['errinfo'] = $errinfo;
		$data['title'] = $title;
		$data['url'] = $url == null?"":$url;
		$data['root_url'] = $this->get_root_url();
		$this->load->vars($data);
		echo $this->load->view("v_error",'',true);
	}

	
	/** * 计算字符串的长度（汉字按照两个字符计算） *
	* @param   string      $str        字符串 *
	* @return int
	*/
	function ex_strlen($str)
	{
		$length = strlen(preg_replace('/[\x00-\x7F]/', '', $str));

		if ($length)
		{
			return strlen($str) - $length + intval($length / 3);
		}
		else
		{
			return strlen($str);
		}
	}

	
	function ex_substr($str, $start, $len,$char="utf-8")
	{  
		$result = "";  
		$strlen = strlen($str);

		$index = 0;

		for($i = 0; $i < $strlen; $i++)
		{  
			$tmpstr = "";
			if(ord(substr($str, $i, 1)) > 0xa0)
			{  
				$tmpstr .= substr($str, $i, $char=="utf-8"?3:2);  
				if($char=="utf-8")
					$i+=2;
				else
					$i++;
			}
			else  
			{
				$tmpstr .= substr($str, $i, 1);  
			}

			if($index >= $start && $index < $start + $len)
			{
				$result.=$tmpstr;
			}
			$index++;
			
		}  
		return $result;  
	}  

	function get_pinyin_firstchar($_string,$_is_upper=true, $_code='gb2312')
	{
		$len = $this->ex_strlen($_string);
		//echo $_string." ".$len;
		//exit;
		//echo $this->ex_substr("家电很ab好",5,1);
		//exit;
		$result = "";
		for($i=0;$i<$len;$i++)
		{
			$char =  $this->ex_substr($_string,$i,1);
			// echo $char."<br>";
			$py = substr($this->get_pinyin($char,$_code,'utf-8'),0,1);
			if($_is_upper) $py = strtoupper($py);
			$result.=$py;
		}
		return $result;
	}

	function get_pinyin($_string, $_Code='gb2312') 
	{ 
		$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha". 
		"|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|". 
		"cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er". 
		"|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui". 
		"|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang". 
		"|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang". 
		"|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue". 
		"|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne". 
		"|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen". 
		"|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang". 
		"|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|". 
		"she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|". 
		"tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu". 
		"|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you". 
		"|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|". 
		"zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo"; 

		$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990". 
		"|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725". 
		"|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263". 
		"|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003". 
		"|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697". 
		"|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211". 
		"|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922". 
		"|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468". 
		"|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664". 
		"|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407". 
		"|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959". 
		"|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652". 
		"|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369". 
		"|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128". 
		"|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914". 
		"|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645". 
		"|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149". 
		"|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087". 
		"|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658". 
		"|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340". 
		"|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888". 
		"|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585". 
		"|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847". 
		"|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055". 
		"|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780". 
		"|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274". 
		"|-10270|-10262|-10260|-10256|-10254"; 
		$_TDataKey = explode('|', $_DataKey); 
		$_TDataValue = explode('|', $_DataValue); 

		$_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : $this->_array_combine($_TDataKey, $_TDataValue); 
		arsort($_Data); 
		reset($_Data); 

		if($_Code != 'gb2312') $_string = $this->_U2_Utf8_Gb($_string); 
		$_Res = ''; 
		for($i=0; $i<strlen($_string); $i++) 
		{ 
			$_P = ord(substr($_string, $i, 1)); 
			if($_P>160) { $_Q = ord(substr($_string, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; } 
			$_Res .= $this->_pinyin($_P, $_Data); 
		} 
		return preg_replace("/[^a-z0-9]*/", '', $_Res); 
	} 

	function _pinyin($_Num, $_Data) 
	{ 
		if ($_Num>0 && $_Num<160 ) return chr($_Num); 
		elseif($_Num<-20319 || $_Num>-10247) return ''; 
		else 
		{ 
			foreach($_Data as $k=>$v){ if($v<=$_Num) break; } 
			return $k; 
		} 
	} 

	function _U2_Utf8_Gb($_C) 
	{ 
		$_string = ''; 
		if($_C < 0x80) $_string .= $_C; 
		elseif($_C < 0x800) 
		{ 
			$_string .= chr(0xC0 | $_C>>6); 
			$_string .= chr(0x80 | $_C & 0x3F); 
		}
		elseif($_C < 0x10000)
		{ 
			$_string .= chr(0xE0 | $_C>>12); 
			$_string .= chr(0x80 | $_C>>6 & 0x3F); 
			$_string .= chr(0x80 | $_C & 0x3F); 
		} 
		elseif($_C < 0x200000) 
		{ 
			$_string .= chr(0xF0 | $_C>>18); 
			$_string .= chr(0x80 | $_C>>12 & 0x3F); 
			$_string .= chr(0x80 | $_C>>6 & 0x3F); 
			$_string .= chr(0x80 | $_C & 0x3F); 
		} 
		return iconv('UTF-8', 'GB2312', $_string);  
	} 

	function _array_combine($_arr1, $_arr2) 
	{ 
		for($i=0; $i<count($_arr1); $i++) $_res[$_arr1[$i]] = $_arr2[$i]; 
		return $_res;   
	} 

	
	function get_root_url()
	{
		/*
		if ($this->uri->segment(3) != "")
		{
			return "../../../";
		}
		if ($this->uri->segment(2) != "")
		{
			return "../../";
		}
		if ($this->uri->segment(1) !== "")
		{
			return "../";
		}

		return "./";

		*/

		//print_r($_SERVER);
		$url = "http://".$_SERVER["SERVER_NAME"].($_SERVER["SERVER_PORT"]==80?"":(":".$_SERVER["SERVER_PORT"]))."".$_SERVER["SCRIPT_NAME"];

		$url = str_replace("index.php","",$url);

		//echo $url;
		return  $url;

		
	}

	function html($viewname,$params)
	{
		$params["root_url"] = $this->get_root_url();

		$this->load->vars($params);
		$html = $this->load->view($viewname,'',true);
		
		return $html;
	}

	function __call($function_name,$args)
	{
		if($function_name == "view")
		{
			if(sizeof($args)==2)
			{
				$this->view2($args[0],$args[1]);
			}
			if(sizeof($args)==3)
			{
				$this->view3($args[0],$args[1],$args[2]);
			}
			if(sizeof($args)==4)
			{
				//echo "abc";
				$this->view4($args[0],$args[1],$args[2],$args[3]);
			}
		}
	}


	function view2($viewname,$params)
	{
		$params["root_url"] = $this->get_root_url();

		$this->load->vars($params);
		$this->load->view($viewname);
	}

	function view4($viewname,$params,$masterview,$masterparams)
	{
		$params["root_url"] =  $this->get_root_url();
		$html = $this->html($viewname,$params);
		$masterparams["root_url"] =  $this->get_root_url();
		$masterparams["content"] = $html;
		$this->load->vars($masterparams);
		$this->load->view($masterview);
	}

	function view3($views,$masterview,$masterparams)
	{
		$params["root_url"] =  $this->get_root_url();
		$masterparams["root_url"] =  $this->get_root_url();
		foreach($views as $key => $value)
		{
			$html = $this->html($value[0],$value[1]);
			$masterparams[$key] = $html;
		}
		$this->load->vars($masterparams);
		$this->load->view($masterview);
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */