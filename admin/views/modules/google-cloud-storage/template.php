<div class="rx-gcs w2cloud__cloud-storage">

    <div class="w2cloud__title--top">
      <h6>Google Cloud Storage<p><a style="color:#0073aa;" href="https://rextheme.com/docs/wp-media-storage-to-cloud/set-up-google-cloud-storage-bucket/" target="_blank">Before setup check our documentation here.</a></p></h6><b-button v-if="gcsauthcheck == 'ready'" type="submit" @click.prevent="GCS_Edit" variant="primary" class="area-design"><?php _e('Reauthorize','w2cloud'); ?></b-button>
    </div>

    <div v-if="gcsauthcheck == 'notready'" class="w2cloud__cloud--checkbox">

        <form ref="form" @submit.stop.prevent="handleSubmit">

          <b-form-group label="Enter GCS Service account key JSON data:" label-for="client-data">
            <a style="color:#5b9dd9;" href="https://console.cloud.google.com/apis/" target="_blank">Visit this link to setup api credentials</a>
            <b-form-textarea
              id="client-data"
              v-model="gcs_auth_data"
              placeholder="Enter JSON information here"
              rows="6"
              max-rows="6"
              required
            ></b-form-textarea>
          </b-form-group>

          <b-form-group label="Storage Bucket Name:" label-for="gcs-bucket">
            <a style="color:#5b9dd9;" href="https://console.cloud.google.com/storage/" target="_blank">Visit this link to setup storage</a>
            <b-form-input id="gcs-bucket" v-model="gcs_bucket" type="text" required placeholder="Enter storage bucket name"></b-form-input>
          </b-form-group>

      </form>

    </div>

    <div class="w2cloud__button--border">
      <p v-if="gcsauthcheck == 'ready'" style="color:green;"><?php _e('Ready to sync','w2cloud'); ?></p><b-button v-if="gcsauthcheck == 'notready'" type="submit" @click.prevent="GCS_Authorize" variant="primary" class="area-design"><?php _e('Save','w2cloud'); ?></b-button>
    </div>


</div>
