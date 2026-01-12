<?php
require_once('zip.php');

function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry;
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }

        $d->close();
    }
	else {
        copy( $source, $target );
    }
}
// delete the full Directory
function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}
//unzip the zip file(
function zip_extract($file, $extractPath) {
    $zip = new ZipArchive;
    $res = $zip->open($file);
    if ($res === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        return TRUE;
    } else {
        return FALSE;
    }
}

function backup_db(){
    /* Store All Table name in an Array */
    $allTables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result)){
        $allTables[] = $row[0];
    }
    $return="";
    foreach($allTables as $table){
        if (isset($result)) {
            $result = mysql_query('SELECT * FROM '.$table);
        }
        $num_fields = mysql_num_fields($result);
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while($row = mysql_fetch_row($result)){
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++){
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; }
                    else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n";
    }
	$folder= ABSPATH.'wp-content/Backup/DB1_Backup/';
	$upload= ABSPATH.'wp-content/Backup/upload/';
	    if (!is_dir($folder))
        mkdir($folder, 0777, true);
    chmod($folder, 0777);
	if (!is_dir($upload))
        mkdir($upload, 0700, true);
    $date = date('m-d-Y-H-i-s', time());
    $filename = $folder."db-backup-".$date;
    $handle = fopen($filename.'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
    // code to check if plugins, themes, upload button is on
    $backupfolder=get_option('ttr_backup_folder_name');
    $file = ABSPATH.'wp-content/Backup/'.$backupfolder."-".$date.".zip";
	$ftpfile = $backupfolder." - ".$date.".zip";
    if(get_option('ttr_manual_database_backup',true)){
        ExtendedZip::zipTree(ABSPATH.'wp-content/Backup/DB1_Backup', $file, ZipArchive::CREATE,"database");
	}
    if(get_option('ttr_include_plugin_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'wp-content/plugins', $file, ZipArchive::CREATE,"plugins");
    }
    if(get_option('ttr_include_theme_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'wp-content/themes', $file, ZipArchive::CREATE,"themes");
    }
    if(get_option('ttr_include_uploads_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'wp-content/uploads', $file, ZipArchive::CREATE,"uploads");
    }
   
// storage options

    $send=get_option('ttr_storage_backup');

    switch($send){
         case "FTP":
            $ftp_server = get_option('ttr_ftp_server_address');
            $ftp_user_name = get_option('ttr_ftp_user_name');
            $ftp_user_pass = get_option('ttr_ftp_user_password');
            $conn = ftp_connect($ftp_server) or die("Could not connect");
            $login_result = ftp_login($conn,"$ftp_user_name","$ftp_user_pass");
            // move to path where you need to upload file
            ftp_pasv ( $conn, true );

            if ((!$conn) || (!$login_result)) {

                //echo "FTP connection has failed!";
            }
            else {
				
               ftp_put($conn, $ftpfile, $file, FTP_BINARY);
			    ftp_close($conn);
            }
            break;

        case "Email":
			      $email = get_option('ttr_ftp_recipient_email');
						$attachments = array($file);
            wp_mail($email, ' Backup Testing Attachment' , $date,'This is for header',$attachments);
            break;
		case "Local":
		
					header('Content-type: application/application/zip');
                    header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
                    header('Content-Transfer-Encoding: binary');
                    header('Content-Length: '.filesize($file));
                    readfile($file);
              
            break;

        default: break;
    }
	delete_directory(ABSPATH.'wp-content/Backup/DB1_Backup');
    mysql_close();
	}

function autobackup_db(){
    /* Store All Table name in an Array */
    $allTables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result)){
        $allTables[] = $row[0];
    }
    $return="";
    foreach($allTables as $table){
        if (isset($result)) {
            $result = mysql_query('SELECT * FROM '.$table);
        }
        $num_fields = mysql_num_fields($result);
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";

        for ($i = 0; $i < $num_fields; $i++) {
            while($row = mysql_fetch_row($result)){
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++){
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; }
                    else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n";
    }
    $folder= 'DB1_Backup/';
    if (!is_dir($folder))
        mkdir($folder, 0777, true);
    chmod($folder, 0777);
    $date = date('m-d-Y-H-i-s', time());
    $filename = $folder."db-backup-".$date;
    $handle = fopen($filename.'.sql','w+');
    fwrite($handle,$return);
    fclose($handle);
    // code to check if plugins, themes, upload button is on
    $backupfolder=get_option('ttr_backup_folder_name');
    $file="Auto-".$backupfolder." - ".$date.".zip";
    if(get_option('ttr_manual_database_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'DB1_Backup', $file, ZipArchive::CREATE,"database");
    }
    if(get_option('ttr_include_plugin_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'wp-content/plugins', $file, ZipArchive::CREATE,"plugins");
    }
    if(get_option('ttr_include_theme_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'wp-content/themes', $file, ZipArchive::CREATE,"themes");
    }
    if(get_option('ttr_include_uploads_backup',true)){
        ExtendedZip::zipTree(ABSPATH . 'wp-content/uploads', $file, ZipArchive::CREATE,"uploads");
    }

// storage options
    $send=get_option('ttr_storage_backup');
    switch($send){
        case "FTP":
            $ftp_server = get_option('ttr_ftp_server_address');
            $ftp_user_name = get_option('ttr_ftp_user_name');
            $ftp_user_pass = get_option('ttr_ftp_user_password');
            $conn = ftp_connect($ftp_server) or die("Could not connect");
            $login_result = ftp_login($conn,"$ftp_user_name","$ftp_user_pass");
            // move to path where you need to upload file
            ftp_pasv ( $conn, true );

            if ((!$conn) || (!$login_result)) {

                //echo "FTP connection has failed!";
            }
            else {
                if (ftp_put($conn,$file, $file, FTP_BINARY)) {

                  //  echo "successfully uploaded". $file."<br>";

                } else {
                    /** IM GETTING THIS ERROR **/
                 //   echo "There was a problem while uploading.......";

                }
                // close the connection

                ftp_close($conn_id);
            }
            break;
            case "Email":
              $email = get_option('ttr_ftp_recipient_email');
							$attachments = array($file);
              wp_mail($email, ' Autobackup Testing Attachment' , $date,'This is an automatic backup zip file generated by Theme',$attachments);

        default: break;
    }
    mysql_close();
   delete_directory($folder);
   $autofolder = ABSPATH.$file;
   delete_directory($autofolder);
    unlink($file);
}

function restore_db($file){

	
    $folder= 'C:\backup';
    zip_extract($file, $folder);
    $db_file=$folder.'\Database\\';
    $filename = glob($db_file.'*.sql');
    echo $filename[0];
    $sqlErrorText = '';
    $sqlErrorCode = 0;
    $sqlStmt      = '';
    $flag=0;
    $con = mysql_connect($dbhost,$dbuser,$dbpass);
    if ($con !== false){
        // Load and explode the sql file
        mysql_select_db("wpdb");
        $f = fopen($filename[0],"r");
        $sqlFile = fread($f,filesize($filename[0]));
        $sqlArray = explode(';',$sqlFile);
        foreach ($sqlArray as $stmt) {
            if (strlen($stmt)>3){
                $result = mysql_query($stmt);
            }
        }
    }
    // Print message (error or success)
    if ($sqlErrorCode == 0){
        print("Database restored successfully!<br>\n");
        print("Backup used: " . $filename[0]);
    } else {
        print("An error occurred while restoring backup!<br><br>\n");
        print("Error code: $sqlErrorCode<br>\n");
        print("Error text: $sqlErrorText<br>\n");
        print("Statement:<br/> $sqlStmt<br>");
    }
    // Close the connection
    $flag=1;
    mysql_close();

    echo "done successfully Database <br>";

    if(get_option('ttr_include_plugin_restore',true)){
        $tgt=WP_CONTENT_DIR.'/plugins//';
        delete_directory($tgt);
        $src=$folder.'/plugins';
        full_copy($src, $tgt);
        $flag=1;
        echo "done successfully plugins <br>";
    }
    if(get_option('ttr_include_theme_restore',true)){
        $tgt=WP_CONTENT_DIR.'/themes//';
        delete_directory($tgt);
        $src=$folder.'/themes';
        full_copy($src, $tgt);
        $flag=1;
        echo "done successfully themes <br>";
    }
    if(get_option('ttr_include_uploads_restore',true)){
        $tgt=WP_CONTENT_DIR.'/uploads//';
        delete_directory($tgt);
        $src=$folder.'/uploads';
        full_copy($src, $tgt);
        $flag=1;
        echo "done successfully uploads <br>";
    }
    if($flag==0)
        echo "choose what you want to restore";
}

?>