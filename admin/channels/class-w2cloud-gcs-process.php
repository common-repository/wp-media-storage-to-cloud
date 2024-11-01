<?php
use Google\Cloud\Storage\StorageClient;

class w2cloud_GCS_Process extends w2cloud_Process {
    /**
     * GCS media transfer handle
     */
    public function gcs_media_transfer_handle($id) {

      update_post_meta($id, 'w2cloud_sync', 'none');
      $bucket = get_option('gcs_bucket');
      $json = get_option('gcs_auth_data');
      $base_decode = base64_decode($json);
      $decode = json_decode($base_decode, true);

      $file_path = get_attached_file($id);

      $storage = new StorageClient([
          'keyFile' => $decode
      ]);

      $upload_directory = wp_upload_dir();
      $base_directory = $upload_directory['basedir'].'/';
      $data_info = wp_get_attachment_metadata( $id );
      $bucket = $storage->bucket($bucket);
      $file_name = str_replace($base_directory, '', $file_path);

      $filename_only = basename( get_attached_file( $id ) );
      $size_path = str_replace($filename_only, '', $file_path);
      $date_directory = str_replace($base_directory, '', $size_path);

      $main_file = fopen($file_path, 'r');
      $object = $bucket->upload($main_file, [
           'name' => $file_name
       ]);
      $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);

      if (isset($data_info['sizes'])) {
        foreach ($data_info['sizes'] as $sizedata) {
          $path = $size_path.$sizedata['file'];
          $name = $date_directory.$sizedata['file'];
          $sized_file = fopen($path, 'r');
          $object = $bucket->upload($sized_file, [
               'name' => $name
           ]);
          $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
        }
      }

      if (isset($data_info['original_image'])) {
        $orig_path = $size_path.$data_info['original_image'];
        $orig_name = $date_directory.$data_info['original_image'];
        $original_file = fopen($orig_path, 'r');
        $object = $bucket->upload($original_file, [
             'name' => $orig_name
         ]);
        $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
      }

      update_post_meta($id, 'w2cloud_sync', 'success');
      return 'success';
    }

    /**
     * GCS media delete handle
     */
    public function gcs_delete_object($id) {

      $bucket = get_option('gcs_bucket');
      $json = get_option('gcs_auth_data');
      $base_decode = base64_decode($json);
      $decode = json_decode($base_decode, true);

      $file_path = get_attached_file($id);

      $storage = new StorageClient([
          'keyFile' => $decode
      ]);

      $upload_directory = wp_upload_dir();
      $base_directory = $upload_directory['basedir'].'/';
      $data_info = wp_get_attachment_metadata( $id );
      $bucket = $storage->bucket($bucket);
      $file_name = str_replace($base_directory, '', $file_path);

      $filename_only = basename( get_attached_file( $id ) );
      $size_path = str_replace($filename_only, '', $file_path);
      $date_directory = str_replace($base_directory, '', $size_path);

      $object = $bucket->object($file_name);
      $object->delete();


      if (isset($data_info['sizes'])) {
        foreach ($data_info['sizes'] as $sizedata) {
          $name = $date_directory.$sizedata['file'];
          $object = $bucket->object($name);
          $object->delete();
        }
      }

      if (isset($data_info['original_image'])) {
        $orig_name = $date_directory.$data_info['original_image'];
        $object = $bucket->object($orig_name);
        $object->delete();
      }

      return true;
    }

    /**
     * GCS auth checker
     */
    public function gcs_auth_checker() {
      $bucket = get_option('gcs_bucket');
      $json = get_option('gcs_auth_data');

      if (!empty($bucket) && !empty($json)) {
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
     * GCS auth data validation
     */
    public function gcs_auth_form_data_validate($bucket, $data, $id) {

      try {
        $base_decode = base64_decode($data);
        $decode = json_decode($base_decode, true);

        $file_path = get_attached_file($id);

        $storage = new StorageClient([
            'keyFile' => $decode
        ]);

        $buckets = array();
        foreach ($storage->buckets() as $bucketo) {
          $buckets[] = $bucketo->name();
        }

        if (in_array($bucket, $buckets)) {
          $upload_directory = wp_upload_dir();
          $base_directory = $upload_directory['basedir'].'/';

          $bucket = $storage->bucket($bucket);
          $file_name = str_replace($base_directory, '', $file_path);

          $main_file = fopen($file_path, 'r');
          $object = $bucket->upload($main_file, [
               'name' => $file_name
           ]);
          $object->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);

          $object = $bucket->object($file_name);
          $object->delete();

          return 'success';
        }
        else {
          return "Bucket not found.";
        }

      } catch (Exception $e) {
        return "Invalid service account data. Could not connect.";
      }

    }
}
