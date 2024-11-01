<div class="w2cloud__media-library-area">

    <h5>Select Storage</h5>

    <div class="w2cloud__nav">

        <b-tabs pills>

            <b-tab title="Amazon S3" active>

                <template v-slot:title>
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/amazon.png'?>">
                </template>

                <AWS></AWS>

            </b-tab>

            <b-tab title="Google Cloud Storage">

                <template v-slot:title>
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/google-cloud-storage.png'?>">
                </template>

                <GCS></GCS>

            </b-tab>

            <b-tab title="DigitalOcean Spaces">

                <template v-slot:title>

                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/digital-ocean-spaces.png'?>">

                </template>

                <DO></DO>
                <!-- <div class="rx-gcs w2cloud__cloud-storage">
                    <div class="w2cloud__title--top">
                      <h6>Digital Ocean Space</h6>
                    </div>
                    <div class="w2cloud__button--border">
                      <p><?php _e('Coming Soon','w2cloud'); ?></p>
                    </div>
                </div> -->

            </b-tab>

            <b-tab title="Microsoft Azure">

                <template v-slot:title>

                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/microsoft-azure.png'?>">

                </template>

                <div class="rx-gcs w2cloud__cloud-storage">
                    <div class="w2cloud__title--top">
                      <h6>Microsoft Azure</h6>
                    </div>
                    <div class="w2cloud__button--border">
                      <p><?php _e('Coming Soon','w2cloud'); ?></p>
                    </div>
                </div>

            </b-tab>

        </b-tabs>

    </div>

</div>
