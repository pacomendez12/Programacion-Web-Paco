<?php
	class UploadMdl{
		public $driver;
		
		function __construct($driver) {
			$this->driver = $driver;
		}
	
		function subir() {
			if(move_uploaded_file($_FILES['archivo']['tmp_name'], 'uploads/'.$_FILES['archivo']['name'])){
				return true;
			}else{
				return false;
			}
		}
	}

?>
