<div class="rx-gcs w2cloud__amazon-storage">

    <div class="w2cloud__title--top">
      <h6>Digital Ocean Space<p><a style="color:#0073aa;" href="https://rextheme.com/docs/wp-media-storage-to-cloud/connect-digitalocean-space/" target="_blank">Before setup check our documentation here.</a></p></h6><b-button v-if="doauthcheck == 'ready'" type="submit" @click.prevent="DO_Edit" variant="primary" class="area-design"><?php _e('Reauthorize','w2cloud'); ?></b-button>
    </div>

    <div v-if="doauthcheck == 'notready'" class="w2cloud__cloud--checkbox">

        <div class="w2cloud_amazon-radio">

            <form ref="form" @submit.stop.prevent="handleSubmit">
              <b-form-group label="Space Access Key:" label-for="do-client-id">
                <a style="color:#5b9dd9;" href="https://cloud.digitalocean.com/account/api/" target="_blank">Visit this link to setup credentials</a>
                <b-form-input id="do-client-id" v-model="do_client_id" type="text" required placeholder="Enter space access key" required></b-form-input>
              </b-form-group>

              <b-form-group label="Space Access Secret:" label-for="do-client-secret">
                <b-form-input id="do-client-secret" v-model="do_client_secret" type="text" required placeholder="Enter space access secret" required></b-form-input>
              </b-form-group>

              <b-form-group label="Space Name:" label-for="do-bucket">
                <a style="color:#5b9dd9;" href="https://cloud.digitalocean.com/spaces/" target="_blank">Visit this link to setup space</a>
                <b-form-input id="do-bucket" v-model="do_bucket" type="text" required placeholder="Enter space name" required></b-form-input>
              </b-form-group>

              <b-form-group label="Space Region:" label-for="do-region">
                <a style="color:#5b9dd9;" href="https://cloud.digitalocean.com/spaces/" target="_blank">Visit this link to setup space region</a>
                <b-form-input id="do-region" v-model="do_region" type="text" required placeholder="Enter space region" required></b-form-input>
              </b-form-group>

            </form>

        </div>

    </div>

    <div class="w2cloud__button--border">
        <p v-if="doauthcheck == 'ready'" style="color:green;"><?php _e('Ready to sync','w2cloud'); ?></p><b-button v-if="doauthcheck == 'notready'" type="submit" @click.prevent="DO_Authorize" variant="primary" class="area-design"><?php _e('Save','w2cloud'); ?></b-button>
    </div>

</div>
