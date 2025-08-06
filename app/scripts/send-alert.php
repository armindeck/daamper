<?php class SendAlert {
	private function Send(string $type = "success", string $text = "", string $route = "", array $tmp = []){
		$types = Daamper::$data->Config("default")["other"]["alert-types"] ?? [];
		$type = !in_array($type, $types) ? "default" : $type;
		
		$_SESSION['sendAlert'] = ["type" => $type, "text" => $text];
		if(!empty($tmp)){ $_SESSION['tmpForm'] = $tmp; }
		if(!empty($route)){ header("Location: $route"); exit; }
	}
	public function Success(string $text, string $route, array $tmp = []){
		return $this->Send("success", $text, $route, $tmp);
	}
	public function Warning(string $text, string $route, array $tmp = []){
		return $this->Send("warning", $text, $route, $tmp);
	}
	public function Error(string $text, string $route, array $tmp = []){
		return $this->Send("error", $text, $route, $tmp);
	}
	public function Info(string $text, string $route, array $tmp = []){
		return $this->Send("info", $text, $route, $tmp);
	}
	public function Refresh(string $text, string $route, array $tmp = []){
		return $this->Send("refresh", $text, $route, $tmp);
	}
}
Daamper::$sendAlert = new SendAlert;