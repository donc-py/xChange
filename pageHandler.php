 <?php       
        //GET PAGE CALLBACK
       // $page="";
        $page=$_GET["page"];
echo $_GET['success'];
unset($_SESSION["success"]);


        // CONTACT
        if  ( $page == "product"){
          //  echo '<a href="' . 'mailto:admin@' . $sitename.'"' .'> Email </a>';
          // rendervideo($test);
          include($page + "/index.php"); 

        }   
        
        // CONTACT
        if  ( $page == "register"){
          //  echo '<a href="' . 'mailto:admin@' . $sitename.'"' .'> Email </a>';
          // rendervideo($test);
          include("register.php"); 

        }   
        // CONTACT
        if  ( $page == "login"){
          //  echo '<a href="' . 'mailto:admin@' . $sitename.'"' .'> Email </a>';
          // rendervideo($test);
          include("login.php"); 

        }   
        // CONTACT
        if  ( $page == "contact"){
            echo '<a href="' . 'mailto:admin@' . $sitename.'"' .'> Email </a>';
          // rendervideo($test);

        }   
        //GAMES            
           elseif ( $page == "games" ) {
			echo '<p align="middle"><B>' . $sitename . ' Books</B>';
			$bookpath = "wallets";
			$dirs = glob($bookpath . '/*' , GLOB_ONLYDIR);
			foreach($dirs as $dirs2) {
				//render($dirs2.".php");
					render($dirs2);
				//get first file from dir to display as picture
			}
			}
			//COINS
                elseif ( $page == "coins" ) {
			echo '<p align="middle"><B>' . $sitename . ' Books</B>';
			
		    echo '<form action="upload.php" method="post" enctype="multipart/form-data">';
            echo    '<p style="color:#F78989">use wallet generated file to upload transaction';
            echo   '<input type="file" name="fileToUpload" id="fileToUpload">';
            echo    '<input type="submit" value="Upload" name="submit">';
            echo   '</p>';
            echo '</form>';
    
    
			include ("faucet2.php");
			
			

    
			$bookpath = "wallets";
			$dirs = glob($bookpath . '/*' , GLOB_ONLYDIR);
			foreach($dirs as $dirs2) {
				//render($dirs2.".php");
					render($dirs2);
				//get first file from dir to display as picture
			}
            echo "</p>";
        }  
        //CANNABIS
                elseif (  $page == "pot" ) {
			echo '<p align="middle"><B>Cannabis Pictures</B>';
			$picpath = "images";
			$dirs = glob($picpath . '/*' , GLOB_ONLYDIR);
			foreach($dirs as $dirs2) {
				render($dirs2);
				//get first file from dir to display as picture
			}
            echo "</p>";
        }  

				else {
			//$expandedpath=site_root($page);
			$expandedpath = explode("/", $page);
			$expandedpath2 = $expandedpath[count($expandedpath) - 1];
			$expandedpath = $expandedpath[count($expandedpath) - 3];
	
			echo $expandedpath;
			if ( $expandedpath == "images"){
			//uploads/mov/authd/
                $files = glob($page.'/*.{JPG,GIF,PNG,jpg,png,gif}', GLOB_BRACE);
			    foreach($files as $file) {
					render($file);
					
				}
			} elseif ( $expandedpath == "mov"){
				
				$files = glob($page.'/*.{webm}', GLOB_BRACE);
			    foreach($files as $file) {
					render($file);
					
				}
			} else {
			if ( $expandedpath2 != "" ){
							//		echo "PIC";
					//	echo "./." . $page . "/" . $expandedpath2;
			//include('./' . $page . '/' . $expandedpath2 . '.php');
		    include('./' . $page . '/index.php');}
			}


						
		//	include ("./images/cg/cg.php");
		//	echo "unknown issue or age not verified.";
         //   header("location: http://www.grandgallery.net") ;
			}		
									
    //    elseif  ( $page == "" ){ // index.php
	//		echo "main page";
		//echo '<div class="wrapper">';
    //echo			'<div class="progress-bar">';
	//echo			'<span class="progress-bar-fill" style="width: 80%;"></span>';
			//echo '</div>';
		//echo '</div>';



		//	render("books");
			//render("stories");

		//	}
		
		?>
