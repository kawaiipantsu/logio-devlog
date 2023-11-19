<?PHP

// Example usage
/**************************************************

# NEW
require("devlog.inc.php");
$devlog = new Devlog("<logio-ip>");

# Send message
$devlog->sendMessage("My first message!!","Group1","Internal-function1");
$devlog->sendMessage("My second message!!","Group1","Internal-function2");
$devlog->sendMessage("My third message!!","Group2","Source1");

# Enable/Disable timestamp or change format (ON by default)
$devlog->enableTimestamp();
$devlog->disableTimestamp();
$devlog->changeTimestampFormat("c"); // default

# Set timeout (2 by default)
$devlog->setTimeout(2);

# Get overall status
print_r( json_decode($devlog->getStatus(),true) );

# Get last message state (was it delivered or not)
var_dump( $devlog->getMessageState() );

# Force connect / disconnect (usefull in busy always running scripts)
# Normally not needed at all, just NEW + Send message
$devlog->connect();
$devlog->disconnect();

***************************************************/

class Devlog {

	public $server;
	public $port;
	private $timeout = 2;
	private $socket;
	private $concected = false;
	private $error_message = null;
	private $error_code = null;
	private $messageSent;
	private $timeStamp = true;
	private $timeStampFormat = "c";

	public function __construct($server = "localhost", $port = 6689) {
        	$this->server = $server;
        	$this->port = $port;
		$this->connect();
    	}

    	public function getStatus() {
		$status = array();
		$status["connection"] = $this->server.":".$this->port;
		$status["timeout"] = $this->timeout;
        	if ( $this->connected ) $status["connected"] = true;
		else                    $status["connected"] = false;
		if ( !is_null($this->error_code) ) {
			$status["error"]["code"] = $this->error_code;
			$status["error"]["message"] = $this->error_message;
		}
		$status["timestamp"]["enabled"] = $this->timeStamp;
		$status["timestamp"]["format"] = $this->timeStampFormat;
		return json_encode($status);
	}


	public function disableTimestamp($format = "c") {
		$this->timeStamp = false;
	}

	public function enableTimestamp($format = "c") {
		$this->timeStamp = true;
	}

	public function setTimestampFormat($format = "c") {
		$this->timeStampFormat = $format;
	}

    	public function getTimeout() {
        	return $this->timeout;
	}

    	public function setTimeout($timeout=2) {
		$timeout_float = floatval($timeout);
        	if ( $timeout_float ) $this->timeout = $timeout_float;
	}

    	public function sendMessage($message,$streamName="test1",$sourceName="test2") {
		$this->messageSent = false;

		if ( $this->timeStamp ) {
			$logstring = "+msg|".$streamName."|".$sourceName."|[".date($this->timeStampFormat)."] ".$message."\0";
		} else {
			$logstring = "+msg|".$streamName."|".$sourceName."|".$message."\0";
		}

		if ( $this->connected ) {
			$fp = $this->socket;
			for ($written = 0; $written < strlen($logstring); $written += $fwrite) {
        			$fwrite = fwrite($fp, substr($logstring, $written));
        			if ($fwrite === false) {
            				return $this->messageSent = true;
        			}
    			}
		}
	}

    	public function getMessageState() {
        	return $this->messageSent;
	}

	public function connect() {
		$fp = pfsockopen("tcp://".$this->server, $this->port, $this->error_code, $this->error_message, $this->timeout);
		if ( !$fp ) {
			$this->connected = false;
		} else {
			$this->socket = $fp;
			$this->connected = true;
			$this->error_message = null;
			$this->error_code = null;
		}
	}

	public function disconnect() {
		if ( $this->connected ) {
			fclose($this->socket);
			$this->connected = false;
			$this->error_message = null;
                        $this->error_code = null;
		}
	}

}


?>
