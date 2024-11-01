<?php
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class w2cloud_DO_Process extends w2cloud_Process {

    /**
     * DO media transfer handle
     */
    public function do_media_transfer_handle($id) {

      update_post_meta($id, 'w2cloud_sync', 'none');
      $do_bucket = get_option('do_bucket');
      $do_region = get_option('do_region');
      $do_client_id = get_option('do_client_id');
      $do_client_secret = base64_decode(get_option('do_client_secret'));

      $host = "digitaloceanspaces.com";
      $endpoint = "https://".$do_bucket.".".$do_region.".".$host;

      try {
  				$s3Client = Aws\S3\S3Client::factory([
  						'version'     => 'latest',
  						'region'      => $do_region,
              'endpoint'    => $endpoint,
  						'credentials' => [
  								'key'     => $do_client_id,
  								'secret'  => $do_client_secret,
  						],
              'bucket_endpoint' => true,
  				]);

  				//===Media Transfer===//
  				$file_path = get_attached_file($id);

  				$upload_directory = wp_upload_dir();
  				$base_directory = $upload_directory['basedir'].'/';
  				$data_info = wp_get_attachment_metadata( $id );
  				$file_name = str_replace($base_directory, '', $file_path);

          $filename_only = basename( get_attached_file( $id ) );
          $size_path = str_replace($filename_only, '', $file_path);
          $date_directory = str_replace($base_directory, '', $size_path);

  		    $result = $s3Client->putObject([
  		        'Bucket' => $do_bucket,
  		        'Key' => $file_name,
  		        'SourceFile' => $file_path,
  						'ACL'    => 'public-read'
  		    ]);

  				if (isset($data_info['sizes'])) {
  	        foreach ($data_info['sizes'] as $sizedata) {
  	          $path = $size_path.$sizedata['file'];
  	          $name = $date_directory.$sizedata['file'];

  						$result = $s3Client->putObject([
  				        'Bucket' => $do_bucket,
  				        'Key' => $name,
  				        'SourceFile' => $path,
  								'ACL'    => 'public-read'
  				    ]);
  	        }
  	      }

          if (isset($data_info['original_image'])) {
            $orig_path = $size_path.$data_info['original_image'];
            $orig_name = $date_directory.$data_info['original_image'];
            $result = $s3Client->putObject([
                'Bucket' => $do_bucket,
                'Key' => $orig_name,
                'SourceFile' => $orig_path,
                'ACL'    => 'public-read'
            ]);
          }
  				//===Media Transfer End===//
  		} catch (S3Exception $e) {
  				return 'error';
  		}

      update_post_meta($id, 'w2cloud_sync', 'success');
      return 'success';
    }

    /**
     * DO media delete handle
     */
    public function do_delete_object($id) {
      $do_bucket = get_option('do_bucket');
      $do_region = get_option('do_region');
      $do_client_id = get_option('do_client_id');
      $do_client_secret = base64_decode(get_option('do_client_secret'));

      $host = "digitaloceanspaces.com";
      $endpoint = "https://".$do_bucket.".".$do_region.".".$host;

      try {
  				$s3Client = Aws\S3\S3Client::factory([
  						'version'     => 'latest',
  						'region'      => $do_region,
              'endpoint'    => $endpoint,
  						'credentials' => [
  								'key'     => $do_client_id,
  								'secret'  => $do_client_secret,
  						],
              'bucket_endpoint' => true,
  				]);

          $file_path = get_attached_file($id);
  				$upload_directory = wp_upload_dir();
  				$base_directory = $upload_directory['basedir'].'/';
          $data_info = wp_get_attachment_metadata( $id );
  				$file_name = str_replace($base_directory, '', $file_path);
          $filename_only = basename( get_attached_file( $id ) );
          $size_path = str_replace($filename_only, '', $file_path);
          $date_directory = str_replace($base_directory, '', $size_path);

          $s3Client->deleteObject([
              'Bucket' => $do_bucket,
              'Key'    => $file_name
          ]);

          if (isset($data_info['sizes'])) {
            foreach ($data_info['sizes'] as $sizedata) {
              $path = $size_path.$sizedata['file'];
              $name = $date_directory.$sizedata['file'];

              $s3Client->deleteObject([
                  'Bucket' => $do_bucket,
                  'Key'    => $name
              ]);
            }
          }

          if (isset($data_info['original_image'])) {
            $orig_path = $size_path.$data_info['original_image'];
            $orig_name = $date_directory.$data_info['original_image'];
            $s3Client->deleteObject([
                'Bucket' => $do_bucket,
                'Key'    => $orig_name
            ]);
          }
          return true;

        } catch (S3Exception $e) {
            return false;
        }
    }

    /**
     * DO auth checker
     */
    public function do_auth_checker() {
      $do_bucket = get_option('do_bucket');
      $do_client_id = get_option('do_client_id');
      $do_client_secret = get_option('do_client_secret');
      $do_region = get_option('do_region');

      if (!empty($do_bucket) && !empty($do_client_id) && !empty($do_client_secret) && !empty($do_region)) {
        return(array(
            'status'=>'success',
            'message'=>'ready'
          ));
      }
      else {
        return(array(
            'status'=>'error',
            'message'=>'notready'
          ));
      }
    }

    /**
     * DO auth data validation
     */
    public function do_auth_form_data_validate($do_bucket, $do_client_id, $do_client_secret, $do_region, $id) {

      $do_client_secret = base64_decode($do_client_secret);
      $host = "digitaloceanspaces.com";
      $endpoint = "https://".$do_bucket.".".$do_region.".".$host;
      try {
            $s3Client = Aws\S3\S3Client::factory([
                'version'     => 'latest',
                'region'      => $do_region,
                'endpoint'    => $endpoint,
                'credentials' => [
                    'key'     => $do_client_id,
                    'secret'  => $do_client_secret,
                ],
                'bucket_endpoint' => true,
            ]);

            $file_path = get_attached_file($id);

            $upload_directory = wp_upload_dir();
            $base_directory = $upload_directory['basedir'].'/';
            $file_name = str_replace($base_directory, '', $file_path);

            $result = $s3Client->putObject([
    		        'Bucket' => $do_bucket,
    		        'Key' => $file_name,
    		        'SourceFile' => $file_path,
    						'ACL'    => 'public-read'
    		    ]);

            $s3Client->deleteObject([
                'Bucket' => $do_bucket,
                'Key'    => $file_name
            ]);

            return 'success';
          } catch (S3Exception $e) {
              $error = $e->getMessage();
              $pattern = "#<\s*?Code\b[^>]*>(.*?)</Code\b[^>]*>#s";
              preg_match($pattern, $error, $matches);
              if ($matches[1]) {
                $match = $matches[1];
                $error = preg_replace('/(?<! )(?<!^)[A-Z]/',' $0', $match);
                return $error;
              }
              return "Bucket Region Invalid";
          }
    }
}
