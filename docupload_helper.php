<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('docUpload'))
{
    function docUpload($path, $id, $doctype = 'doc', $current = FALSE, $file = FALSE)
    {
    	$CI =& get_instance();

        /* if directory does not exist then create. */
    	if (ENVIRONMENT == 'production')
        {

            if (!is_dir($path.'/'.$id))
        	{
                $ftpstream = ftp_connect('ftp-address-here');
                $login = ftp_login($ftpstream, 'ftp-username-here', 'ftp-password-here');

                if($login)
                {
                    ftp_mkdir($ftpstream, '/httpdocs/'.$path.'/'.$id);
                    ftp_chmod($ftpstream, 0777, '/httpdocs/'.$path.'/'.$id);
                }
                ftp_close($ftpstream);
            }
        }
        else
        {
            if (!is_dir($path.'/'.$id))
            {
                mkdir($path.'/'.$id, 0755, TRUE);
            }
        }

    	/* if there is already a doc, remove to make way for this one */
    	if ($current)
    	{
    		/* delete files current files */
    		unlink($path.'/'.$id.'/'.$current);
    	}

    	/* set upload path. */
    	$config['upload_path'] = $path.'/'.$id.'/';

    	/* set allowed file extensions. */
        switch ($doctype)
        {
            case 'doc':
                $allowed_types = 'pdf|xls|doc|docx|ppt|pptx|zip';
                break;

            case 'image':
                $allowed_types = 'jpg|png|gif';
                break;
        }

    	$config['allowed_types'] = $allowed_types;

    	/* do upload. */
    	$CI->load->library('upload', $config);

        $no_errors = TRUE;

        if ($file)
        {
    	   if (!$CI->upload->do_upload($file))
    	   {
                $no_errors = FALSE;
                /* display upload errors. */
                print_r(array('error' => $CI->upload->display_errors()));exit();
    	   }
        }
        else
        {
            if (!$CI->upload->do_upload())
            {
                $no_errors = FALSE;
                /* display upload errors. */
                print_r(array('error' => $CI->upload->display_errors()));exit();
            }
        }

    	if ($no_errors)
        {
    		$data = array('upload_data' => $CI->upload->data());

            $filename = $data['upload_data']['file_name'];

			return $filename;
    	}
    }
}

/* End of file docupload_helper.php */
