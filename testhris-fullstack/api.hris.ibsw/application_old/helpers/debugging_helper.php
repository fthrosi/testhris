<?php 
	/* Debugger CodeIgniter By Aliipp */
	/* Fingermedia Solution */
    function header_status($statusCode) {
    static $status_codes = null;

    if ($status_codes === null) {
        $status_codes = array (
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );
    }

    if ($status_codes[$statusCode] !== null) {
        $status_string = $statusCode . ' ' . $status_codes[$statusCode];
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
    }
}
	
	function dumper($data=null, $is_sql = 0) { 
		@ob_clean(); 
		
		$ci =& get_instance();

        header_status(500);
		
		echo "<style>ul {
				list-style-type: none;
			}

			ul > li:before {
				content: \"-\"; /* en dash here */
				position: absolute;
				margin-left: -1.1em; 
			}</style>";
		echo "<pre><b style='font-size:18px'>Output Dumper :</b></pre><pre style='margin-left:15px;'>";
		
		if(!$is_sql) {
			
			
			$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
			do $caller = array_shift($backtrace); while ($caller && !isset($caller['file']));
			if ($caller) {
				echo "File Trace : ".$caller['file'].':'.$caller['line']."
							  <br /><span>Called By : <ul><li> Controller : ".
								$ci->router->fetch_class()."</li><li> Function&nbsp;&nbsp;&nbsp;: ".
								$ci->router->fetch_method().
							  '</li></ul></span><br />
							  <div>$VAR1 = </div>'.
							  "<div style='margin-left:50px;'>";
				if($data != null) {
					print_r($data);
				} else {
					echo "Not Returning Variable Or Variable is Null";
					
					echo "<br /><br />To Do : Make sure the variables has a value (if it is a function, make sure that the function has a 'return'))";
				}
				
				echo "</div>";
			}
			 
		} else {
			echo mysql_error();			
		}
		echo "</pre><pre></pre>";
		$ci->db->trans_rollback();
		exit; 
	}
	
	function call($var,$param = array()){
		$ci =& get_instance();
		$var = explode('/',$var);
		require_once(APPPATH."controllers/$var[0].php"); 
		$ci->oHome =  new $var[0]();
		return call_user_func_array(array($ci->oHome,$var[1]), $param );	
		
	}
	
	function is_private($var){
		$ci =& get_instance();
		$c = $ci->router->fetch_class();
		$m = $ci->router->fetch_method();
		if($c.$m == str_replace('/','',$var)){
			ob_clean();
			show_error(503);
			exit;
		}
	}
	
	function filter_null($args){
		return (array_filter($args));
	}
	
?>