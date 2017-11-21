<?php
	function make_thumb($src, $dest, $desired_width,$extension)
    {
    	$extension=strtolower($extension);	
        if($extension == 'jpeg' ||  $extension == 'jpg' )
        {
            $source_image = imagecreatefromjpeg($src);
        }
        if($extension == 'png')
        {
            $source_image = imagecreatefrompng($src);
        }
        if($extension == 'gif')
        {
            $source_image = imagecreatefromgif($src);
        }
        
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        $desired_height = floor($height * ($desired_width / $width));

        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        if($extension == 'jpeg' ||  $extension == 'jpg')
        {
            imagejpeg($virtual_image, $dest);
        }
        
        if($extension == 'png' )
        {
            @imagepng($virtual_image, $dest);
        }
        
        if($extension == 'gif' )
        {
            imagegif($virtual_image, $dest);
        }
    }
    function file_upload($files,$form_name,$upload_path)
    {
        $return_path=$upload_path;
    	$thumb_tmp_path=UPLOAD_DIR."tmp/";
    	$upload_path=UPLOAD_DIR.$upload_path;//pre($upload_path);
        if(is_array($files[$form_name]['name']))
    	{
    		$image_array=array();
    		$total_image=count($files[$form_name]['name']);
    		for($i=0;$i<$total_image;$i++)
			{
				$name=$files[$form_name]['name'][$i];
				$e=explode(".",$name);	
				$ext=end($e);
				$tmp=$files[$form_name]['tmp_name'][$i];
				$names=md5(rand().time().$name).".".$ext;
				make_thumb($tmp,$upload_path."/thumb/".$names,512,$ext);
				move_uploaded_file($tmp,$upload_path.$names);
				array_push($image_array,$names);
			}
			return $image_array;
    	}
    	else
    	{
			$name=$files[$form_name]['name'];
			$e=explode(".",$name);	
			$ext=end($e);
			$tmp=$files[$form_name]['tmp_name'];
			$names=md5(rand().time().$name).".".$ext;
			make_thumb($tmp,$upload_path."/thumb/".$names,512,$ext);
			@move_uploaded_file($tmp,$upload_path."/".$names);
			return $names;
    	}
    }
    function file_check($name,$type,$is_thumb=0,$is_update=0)
    {
        $path="";
        switch($type)
        {
            case "USER":
                $path="users/";
                break;           
            case "COMMUNITY":
                $path="community/";
                break;
             case "SUB_COMMUNITY":
                $path="subcommunity/";    
                break;
        }
        if($is_thumb==1)
        {
            $path.="thumb/";
        }
        $image=$path.$name;
        if(!file_exists(UPLOAD_DIR.$image))
        {
            if($is_update==1)
                return false;
            $image=$path."default.png";
        }
        return $image;
    }
    function facebook_file_upload($id)
    {
        $path="http://graph.facebook.com/".$id."/picture?width=";
        $names=md5(rand().time().$id).".jpg";
        @copy($path."480",UPLOAD_DIR."users/".$names);
        @copy($path."200",UPLOAD_DIR."users/thumb/".$names);
        return $names;
    }
    function google_file_upload($url)
    {
        $names=md5(rand().time().$url).".jpg";
        @copy($url,UPLOAD_DIR."users/".$names);
        @copy($url,UPLOAD_DIR."users/thumb/".$names);
        return $names;
    }
?>