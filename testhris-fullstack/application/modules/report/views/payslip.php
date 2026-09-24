<style>
    * {
	padding:0;
	margin:0;
}

h1 {
	text-align: center;
	padding: 20px 0 12px 0;
	margin: 0;
}
h2 {
	font-size: 16px;
	text-align: center;
	padding: 0 0 12px 0; 
}

#container {
	box-shadow: 0 5px 10px -5px rgba(0,0,0,0.5);
	position: relative;
	background: white; 
}

table {
	background-color: #F3F3F3;
	border-collapse: collapse;
	width: 100%;
	margin: 15px 0;
}

th {
	background-color: #FE4902;
	color: #FFF;
	cursor: pointer;
	padding: 5px 10px;
}

th small {
	font-size: 9px; 
}

td, th {
	text-align: left;
}

a {
	text-decoration: none;
}

td a {
	color: #663300;
	display: block;
	padding: 5px 10px;
}
th a {
	padding-left: 0
}

td:first-of-type a {
	background: url(<?= base_url(); ?>/assets/images_file/file.png) no-repeat 10px 50%;
	padding-left: 35px;
}
th:first-of-type {
	padding-left: 35px;
}

td:not(:first-of-type) a {
	background-image: none !important;
} 

tr:nth-of-type(odd) {
	background-color: #E6E6E6;
}

tr:hover td {
	background-color:#CACACA;
}

tr:hover td a {
	color: #000;
}





/* icons for file types (icons by famfamfam) */

/* images */
table tr td:first-of-type a[href$=".jpg"], 
table tr td:first-of-type a[href$=".png"], 
table tr td:first-of-type a[href$=".gif"], 
table tr td:first-of-type a[href$=".svg"], 
table tr td:first-of-type a[href$=".jpeg"]
{background-image: url(<?= base_url(); ?>/assets/images_file/image.png);}

/* zips */
table tr td:first-of-type a[href$=".zip"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/zip.png);}

/* css */
table tr td:first-of-type a[href$=".css"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/css.png);}

/* docs */
table tr td:first-of-type a[href$=".doc"],
table tr td:first-of-type a[href$=".docx"],
table tr td:first-of-type a[href$=".ppt"],
table tr td:first-of-type a[href$=".pptx"],
table tr td:first-of-type a[href$=".pps"],
table tr td:first-of-type a[href$=".ppsx"],
table tr td:first-of-type a[href$=".xls"],
table tr td:first-of-type a[href$=".xlsx"]
{background-image: url(<?= base_url(); ?>/assets/images_file/office.png)}

/* videos */
table tr td:first-of-type a[href$=".avi"], 
table tr td:first-of-type a[href$=".wmv"], 
table tr td:first-of-type a[href$=".mp4"], 
table tr td:first-of-type a[href$=".mov"], 
table tr td:first-of-type a[href$=".m4a"]
{background-image: url(<?= base_url(); ?>/assets/images_file/video.png);}

/* audio */
table tr td:first-of-type a[href$=".mp3"], 
table tr td:first-of-type a[href$=".ogg"], 
table tr td:first-of-type a[href$=".aac"], 
table tr td:first-of-type a[href$=".wma"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/audio.png);}

/* web pages */
table tr td:first-of-type a[href$=".html"],
table tr td:first-of-type a[href$=".htm"],
table tr td:first-of-type a[href$=".xml"]
{background-image: url(<?= base_url(); ?>/assets/images_file/xml.png);}

table tr td:first-of-type a[href$=".php"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/php.png);}

table tr td:first-of-type a[href$=".js"] 
{background-image: url(<?= base_url(); ?>/assets/images_file/script.png);}

/* directories */
table tr.dir td:first-of-type a
{background-image: url(<?= base_url(); ?>/assets/images_file/folder.png);}
</style>


<div class="nk-ibx-reply nk-reply" data-simplebar>
    <div class="tab-content">
        <div>
            <center><h4>Directory Contents of Payslip</h4></center>
            <br>
        </div>
    </div>
    <div class="card card-preview">
        <div class="tab-content">
            <table class="table">
                <thead>
                <tr>
                    <th>Filename</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Date Modified</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    // Adds pretty filesizes
                    function pretty_filesize($files) {
                        
                        if ($handle = opendir("reports/payslip/20180026/")) {
                            while (false !== ($file = readdir($handle))) { 
                                  $fpath = 'reports/payslip/20180026/'.$files;
                                  if (file_exists($fpath)) {
                                        $size=filesize($fpath);
                                  }
                                
                            }
                        }
                        closedir($handle); 
                        // $size=filesize($file);
                        if($size<1024){$size=$size." Bytes";}
                        elseif(($size<1048576)&&($size>1023)){$size=round($size/1024, 1)." KB";}
                        elseif(($size<1073741824)&&($size>1048575)){$size=round($size/1048576, 1)." MB";}
                        else{$size=round($size/1073741824, 1)." GB";}
                        return $size;
                    }

                    // Checks to see if veiwing hidden files is enabled
                    if($_SERVER['QUERY_STRING']=="hidden")
                    {$hide="";
                    $ahref="./";
                    $atext="Hide";}
                    else
                    {$hide=".";
                    $ahref="./?hidden";
                    $atext="Show";}

                    // Opens directory
                    $myDirectory=opendir("reports/payslip/20180026/");

                    // Gets each entry
                    while($entryName=readdir($myDirectory)) {
                        if($entryName != 'index.php' && $entryName != 'index.html'){
                            $dirArray[]=$entryName;
                        }
                    }

                    // Closes directory
                    closedir($myDirectory);

                    // Counts elements in array
                    $indexCount=count($dirArray);

                    // Sorts files
                    sort($dirArray);

                    // Loops through the array of files
                    for($index=0; $index < $indexCount; $index++) {
                        // var_dump(base_url()."reports/payslip/20180026/".$dirArray[2]);die;
                    // Decides if hidden files should be displayed, based on query above.
                        if(substr("$dirArray[$index]", 0, 1)!=$hide) {

                    // Resets Variables
                        $favicon="";
                        $class="file";

                    // Gets File Names
                        $name=$dirArray[$index];

                    if ($handle = opendir("reports/payslip/20180026/")) {
                        while (false !== ($file = readdir($handle))) { 
                
                                $fpath = 'reports/payslip/20180026/'.$name;
                                if (file_exists($fpath)) {
                                
                                // Gets Date Modified
                                $modtime = date("d/m/Y H:i:s", filemtime($fpath));
                                $timekey=date("YmdHis", filemtime($fpath));

                                // Gets File Names
                                $namehref=$fpath;
                                }
                            
                        }
                    }
                    closedir($handle); 


                    // Separates directories, and performs operations on those directories
                        if(is_dir($dirArray[$index]))
                        {
                                $extn="&lt;Directory&gt;";
                                $size="&lt;Directory&gt;";
                                $sizekey="0";
                                $class="dir";

                            // Gets favicon.ico, and displays it, only if it exists.
                                if(file_exists("$namehref/favicon.ico"))
                                    {
                                        $favicon=" style='background-image:url($namehref/favicon.ico);'";
                                        $extn="&lt;Website&gt;";
                                    }

                            // Cleans up . and .. directories
                                if($name=="."){$name=". (Current Directory)"; $extn="&lt;System Dir&gt;"; $favicon=" style='background-image:url($namehref/.favicon.ico);'";}
                                if($name==".."){$name=".. (Parent Directory)"; $extn="&lt;System Dir&gt;";}
                        }

                    // File-only operations
                        else{
                            // Gets file extension
                            $extn=pathinfo($dirArray[$index], PATHINFO_EXTENSION);

                            // Prettifies file type
                            switch ($extn){
                                case "png": $extn="PNG Image"; break;
                                case "jpg": $extn="JPEG Image"; break;
                                case "jpeg": $extn="JPEG Image"; break;
                                case "svg": $extn="SVG Image"; break;
                                case "gif": $extn="GIF Image"; break;
                                case "ico": $extn="Windows Icon"; break;

                                case "txt": $extn="Text File"; break;
                                case "log": $extn="Log File"; break;
                                case "htm": $extn="HTML File"; break;
                                case "html": $extn="HTML File"; break;
                                case "xhtml": $extn="HTML File"; break;
                                case "shtml": $extn="HTML File"; break;
                                case "php": $extn="PHP Script"; break;
                                case "js": $extn="Javascript File"; break;
                                case "css": $extn="Stylesheet"; break;

                                case "pdf": $extn="PDF Document"; break;
                                case "xls": $extn="Spreadsheet"; break;
                                case "xlsx": $extn="Spreadsheet"; break;
                                case "doc": $extn="Microsoft Word Document"; break;
                                case "docx": $extn="Microsoft Word Document"; break;

                                case "zip": $extn="ZIP Archive"; break;
                                case "htaccess": $extn="Apache Config File"; break;
                                case "exe": $extn="Windows Executable"; break;

                                default: if($extn!=""){$extn=strtoupper($extn)." File";} else{$extn="Unknown";} break;
                            }

                            // Gets and cleans up file size
                                $size=pretty_filesize($name);

                                if ($handle = opendir("reports/payslip/20180026/")) {
                                    while (false !== ($file = readdir($handle))) { 
                                          $fpath = 'reports/payslip/20180026/'.$name;
                                          if (file_exists($fpath)) {
                                                // Gets file size
                                                $sizekey=filesize($fpath);
                                          }
                                        
                                    }
                                }
                                closedir($handle); 
                        }

                    //Output
                    echo("
                        <tr class='$class'>
                            <td><a target='_blank' rel='noopener noreferrer' href='$namehref'$favicon class='name'>$name</a></td>
                            <td><a target='_blank' rel='noopener noreferrer' href='$namehref'>$extn</a></td>
                            <td sorttable_customkey='$sizekey'><a target='_blank' rel='noopener noreferrer' href='$namehref'>$size</a></td>
                            <td sorttable_customkey='$timekey'><a target='_blank' rel='noopener noreferrer' href='$namehref'>$modtime</a></td>
                        </tr>");
                    }
                    }
                    ?>

                
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= base_url(); ?>/assets/sorttable.js"></script>

<!-- Pengganti Output -->
<!-- <tr class="<?=$class?>">
    <td><span onclick="window.open('<?=$namehref?>')"> <?=$name?></span></td>
    <td><span onclick="window.open('<?=$namehref?>')"> <?=$extn?></span></td>
    <td sorttable_customkey='<?=$sizekey?>'><span onclick="window.open('<?=$namehref?>')"> <?=$size?></span></td>
    <td sorttable_customkey='<?=$timekey?>'><span onclick="window.open('<?=$namehref?>')"> <?=$modtime?></span></td>
</tr> -->