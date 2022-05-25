<?php
class GJPCheck {
	public function check($gjp, $accountID) {
		chdir(__DIR__);
		require_once "XORCipher.php";
		require_once "generatePass.php";
		require_once "connection.php";
		$xor = new XORCipher();
		$gjpdecode = str_replace("_","/",$gjp);
		$gjpdecode = str_replace("-","+",$gjpdecode);
		$gjpdecode = base64_decode($gjpdecode);
		$gjpdecode = $xor->cipher($gjpdecode,37526);
		$generatePass = new generatePass();
		return $generatePass->isValid($accountID, $gjpdecode);
	}
}
?>
