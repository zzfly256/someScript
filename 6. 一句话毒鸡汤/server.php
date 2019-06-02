<?php
class Fun
{
	private $data;
	private $templete;
	private $server;

	private function loadData($filename) {
		$this->data = explode("\n", file_get_contents($filename));
	}

	private function loadTemplete($filename) {
		$this->templete = explode("{{string}}", file_get_contents($filename));
	}

	private function generatePage($string) {
		return $this->templete[0].$string.$this->templete[1];
	}

	public function onStart() {
		echo "Start Fun Server at ", $this->host.":", $this->port, "\n";

	}

	public function onRequest($request, $response) {
		$response->header("Content-Type", "text/html; charset=UTF-8");
    	$response->end($this->generatePage($this->data[rand(0, count($this->data)-1)]));
	}

	public function __construct($host, $port) {
		$this->loadData("fun.txt");
		$this->loadTemplete("fun.html");

		$this->host = $host;
		$this->port = $port;
		$this->server = new swoole_http_server($this->host, $this->port);
		$this->server->set(array(
		    'worker_num' => 8,   //设置启动的Worker进程数。
		));
		$this->server->on('start',[$this,'onStart']);
		$this->server->on('request',[$this,'onRequest']);
		$this->server->start();

	}
}

(new Fun("0.0.0.0", 9420));