<?php

class w2cloud_media_control {
    /**
     * media controller hook
     */
     public function w2cloud_media_url_modification($attachment_url) {

      $id = $this->w2cloud_get_attachment_id_from_url($attachment_url);
      $mime_type = get_post_mime_type($id);
      $mime_type_explode = explode('/', $mime_type);
      $extension = $mime_type_explode[0];

      if ($extension == 'image') {
        $upload_directory = wp_upload_dir();
        $media_base_url = $upload_directory['baseurl'];

        $general_options = get_option('w2cloud_general_settings');
        $settings = json_decode($general_options);
        if ($settings->active_storage == 'gcs') {

          //===Serve from google===//
          $google = new w2cloud_GCS_Process();
          $checker = $google->gcs_auth_checker();
          if ($checker['message'] == 'ready') {
            $bucket = get_option('gcs_bucket');
            if ($bucket) {
              if (!empty($settings->active_cdn)) {
                $gcs_storage_location = $settings->active_cdn;
              }
              else {
                $gcs_storage_location = 'https://storage.googleapis.com/'.$bucket;
              }

              $attachment_url_modified = str_replace($media_base_url, $gcs_storage_location, $attachment_url);
              if ($this->w2cloud_media_validation($attachment_url)) {
                  return $attachment_url_modified;
              }
            }
          }
          //===End Serve from google===//
        }
        elseif ($settings->active_storage == 'aws') {
          //===Serve from aws===//
          $amazon = new w2cloud_AWS_Process();
          $checker = $amazon->aws_auth_checker();
          if ($checker['message'] == 'ready') {
            $bucket = get_option('aws_bucket');
            if ($bucket) {
              if (!empty($settings->active_cdn)) {

                $aws_storage_location = $settings->active_cdn;
              }
              else {
                $aws_storage_location = 'https://'.$bucket.'.s3.amazonaws.com';
              }
              $attachment_url_modified = str_replace($media_base_url, $aws_storage_location, $attachment_url);

              if ($this->w2cloud_media_validation($attachment_url)) {
                  return $attachment_url_modified;
              }
            }
          }
          //===End Serve from aws===//
        }
        elseif ($settings->active_storage == 'do') {
          //===Serve from do===//
          $ocean = new w2cloud_DO_Process();
          $checker = $ocean->do_auth_checker();
          if ($checker['message'] == 'ready') {
            $bucket = get_option('do_bucket');
            $region = get_option('do_region');
            if ($bucket) {
              if (!empty($settings->active_cdn)) {

                $do_storage_location = $settings->active_cdn;
              }
              else {
                $do_storage_location = 'https://'.$bucket.'.'.$region.'.digitaloceanspaces.com';
              }
              $attachment_url_modified = str_replace($media_base_url, $do_storage_location, $attachment_url);

              if ($this->w2cloud_media_validation($attachment_url)) {
                  return $attachment_url_modified;
              }
            }
          }
          //===End Serve from do===//
        }
      }

     	return $attachment_url;
     }

     /**
      * media attribute controller hook
      */
     public function w2cloud_media_attr_modification($attr) {

         $upload_directory = wp_upload_dir();
         $media_base_url = $upload_directory['baseurl'];

         $general_options = get_option('w2cloud_general_settings');
         $settings = json_decode($general_options);
         if ($settings->active_storage == 'gcs') {
           //===Serve from google===//
           $google = new w2cloud_GCS_Process();
           $checker = $google->gcs_auth_checker();
           if ($checker['message'] == 'ready') {
             $bucket = get_option('gcs_bucket');
             if ($bucket) {
               if (!empty($settings->active_cdn)) {
                 $gcs_storage_location = $settings->active_cdn;
               }
               else {
                 $gcs_storage_location = 'https://storage.googleapis.com/'.$bucket;
               }
               $main_url = str_replace($gcs_storage_location, $media_base_url, $attr['src']);
               if ($this->w2cloud_media_validation($main_url)) {
                 $id = $this->w2cloud_get_attachment_id_from_url($main_url);
                 $mime_type = get_post_mime_type($id);
                 $mime_type_explode = explode('/', $mime_type);
                 $extension = $mime_type_explode[0];

                 if ($extension == 'image') {
                   if (isset($attr['srcset'])) {
                     $attr['srcset'] = str_replace($media_base_url, $gcs_storage_location, $attr['srcset']);
                   }
                 }

               }
             }
           }
           //=== End Serve from google===//
         }
         elseif ($settings->active_storage == 'aws') {
           //===Serve from aws===//
           $amazon = new w2cloud_AWS_Process();
           $checker = $amazon->aws_auth_checker();
           if ($checker['message'] == 'ready') {
             $bucket = get_option('aws_bucket');
             if ($bucket) {
               if (!empty($settings->active_cdn)) {
                 $aws_storage_location = $settings->active_cdn;
               }
               else {
                 $aws_storage_location = 'https://'.$bucket.'.s3.amazonaws.com';
               }
               $main_url = str_replace($aws_storage_location, $media_base_url, $attr['src']);
               if ($this->w2cloud_media_validation($main_url)) {
                 $id = $this->w2cloud_get_attachment_id_from_url($main_url);
                 $mime_type = get_post_mime_type($id);
                 $mime_type_explode = explode('/', $mime_type);
                 $extension = $mime_type_explode[0];

                 if ($extension == 'image') {
                   if (isset($attr['srcset'])) {
                      $attr['srcset'] = str_replace($media_base_url, $aws_storage_location, $attr['srcset']);
                   }
                 }
               }
             }
           }
           //===End Serve from aws===//
         }
         elseif ($settings->active_storage == 'do') {
           //===Serve from do===//
           $ocean = new w2cloud_DO_Process();
           $checker = $ocean->do_auth_checker();
           if ($checker['message'] == 'ready') {
             $bucket = get_option('do_bucket');
             $region = get_option('do_region');
             if ($bucket) {
               if (!empty($settings->active_cdn)) {
                 $do_storage_location = $settings->active_cdn;
               }
               else {
                 $do_storage_location = 'https://'.$bucket.'.'.$region.'.digitaloceanspaces.com';
               }
               $main_url = str_replace($do_storage_location, $media_base_url, $attr['src']);
               if ($this->w2cloud_media_validation($main_url)) {
                 $id = $this->w2cloud_get_attachment_id_from_url($main_url);
                 $mime_type = get_post_mime_type($id);
                 $mime_type_explode = explode('/', $mime_type);
                 $extension = $mime_type_explode[0];

                 if ($extension == 'image') {
                    if (isset($attr['srcset'])) {
                        $attr['srcset'] = str_replace($media_base_url, $do_storage_location, $attr['srcset']);
                    }
                 }
               }
             }
           }
           //===End Serve from do===//
         }

     		return $attr;
     }

     /**
      * media storage file validation
      */
     public function w2cloud_media_validation($url) {

       $id = $this->w2cloud_get_attachment_id_from_url($url);
       if ($id) {
         $response = get_post_meta($id, 'w2cloud_sync', true);
         if ($response == 'success') {
           return true;
         }
         else {
           return false;
         }
       }
       else {
         return false;
       }
     }

     /**
      * Delete media configured with hook
      */
     public function w2cloud_delete_media($id) {
       $mime_type = get_post_mime_type($id);
       $mime_type_explode = explode('/', $mime_type);
       $extension = $mime_type_explode[0];

       if ($extension == 'image') {
         $general_options = get_option('w2cloud_general_settings');
         $settings = json_decode($general_options);
         if ($settings->active_storage == 'gcs') {
           //===gcs===//
           $google = new w2cloud_GCS_Process();
           $response = $google->gcs_delete_object($id);
           //===gcs===//
         }
         elseif ($settings->active_storage == 'aws') {
           //===aws===//
           $amazon = new w2cloud_AWS_Process();
           $response = $amazon->aws_delete_object($id);
           //===aws===//
         }
         elseif ($settings->active_storage == 'do') {
           //===do===//
           $ocean = new w2cloud_DO_Process();
           $response = $ocean->do_delete_object($id);
           //===do===//
         }
       }
     }

     /**
      * Get media id from url
      */
     public function w2cloud_get_attachment_id_from_url($attachment_url) {

        global $wpdb;
        $attachment_id = false;

        if ( '' == $attachment_url )
          return;

        $upload_dir_paths = wp_upload_dir();

        if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
          $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
          $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
          $attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
        }
        return $attachment_id;
      }

      /**
       * content controller hook
       */
       public function w2cloud_content_media_url_modification($content) {

          preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);
          $content_urls = $match[0];

          $upload_directory = wp_upload_dir();
          $media_base_url = $upload_directory['baseurl'];
          $general_options = get_option('w2cloud_general_settings');
          $settings = json_decode($general_options);

          foreach ($content_urls as $content_url) {
            //===Serve from google===//
            if ($settings->active_storage == 'gcs') {
              $google = new w2cloud_GCS_Process();
              $checker = $google->gcs_auth_checker();
              if ($checker['message'] == 'ready') {
                $bucket = get_option('gcs_bucket');
                if ($bucket) {
                  if (!empty($settings->active_cdn)) {
                    $gcs_storage_location = $settings->active_cdn;
                  }
                  else {
                    $gcs_storage_location = 'https://storage.googleapis.com/'.$bucket;
                  }

                   if (strpos($content_url, $gcs_storage_location) !== false) {
                     $content = str_replace($media_base_url, $gcs_storage_location, $content);
                   }
                   else {
                     if ($this->w2cloud_media_validation($content_url)) {
                       $content = str_replace($media_base_url, $gcs_storage_location, $content);
                     }
                   }
                }
              }
            }
            //===Serve from google end===//
            //===Serve from aws start===//
            elseif ($settings->active_storage == 'aws') {
                $amazon = new w2cloud_AWS_Process();
                $checker = $amazon->aws_auth_checker();
                if ($checker['message'] == 'ready') {
                  $bucket = get_option('aws_bucket');
                  if ($bucket) {

                    if (!empty($settings->active_cdn)) {
                      $aws_storage_location = $settings->active_cdn;
                    }
                    else {
                      $aws_storage_location = 'https://'.$bucket.'.s3.amazonaws.com';
                    }

                   if (strpos($content_url, $aws_storage_location) !== false) {
                     $content = str_replace($media_base_url, $aws_storage_location, $content);
                   }
                   else {
                     if ($this->w2cloud_media_validation($content_url)) {
                       $content = str_replace($media_base_url, $aws_storage_location, $content);
                     }
                   }
                }
              }
            }
            //===Serve from do start===//
            elseif ($settings->active_storage == 'do') {
                $ocean = new w2cloud_DO_Process();
                $checker = $ocean->do_auth_checker();
                if ($checker['message'] == 'ready') {
                  $bucket = get_option('do_bucket');
                  $region = get_option('do_region');
                  if ($bucket) {

                    if (!empty($settings->active_cdn)) {
                      $do_storage_location = $settings->active_cdn;
                    }
                    else {
                      $do_storage_location = 'https://'.$bucket.'.'.$region.'.digitaloceanspaces.com';
                    }

                   if (strpos($content_url, $do_storage_location) !== false) {
                     $content = str_replace($media_base_url, $do_storage_location, $content);
                   }
                   else {
                     if ($this->w2cloud_media_validation($content_url)) {
                       $content = str_replace($media_base_url, $do_storage_location, $content);
                     }
                   }
                }
              }
            }
          }
          return $content;
       }
}
