<?php
echo __FILE__;
namespace At;
class Parser
{
	public $dbh = null;
	public $db_name = null;
	public $table_name = null;
	
    public function __construct($url)
	{
		$this->dbh = $this->getDbh();
		$host = $zone = null;
		$URL = parse_url($url);
		if (isset($URL['host'])) {
			$host = trim($URL['host'])
		}
		if (preg_match("/\.(\w+)$/", $host, $matches)) {
			$zone = $matches[1];
		}
		if ($zone) {
			$zone_id = $this->find($zone);
		}
	}
	
	
	
	
}