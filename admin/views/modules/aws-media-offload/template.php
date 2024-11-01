<div v-if="awsauthcheck == 'ready'" class="w2cloud__cloud--sync">
    <div class="w2cloud_select_sync_option">
      <span>Select sync option</span><b-form-select v-on:change="sync_data_retrieve" v-model="sync_type" :options="sync_options"></b-form-select>
    </div>
    <div v-if="processRunning == 'running'" class="w2cloud__cloud-sync-content">

        <div class="app-gcs-sync">
            <div class="sync__media">
                <p style="text-align:right;"><span>Progress:</span> <span> {{uploadPercentage}} </span> - <span>{{max}}</span></p>

            </div>

            <b-progress  :value="uploadPercentage" :max="max" variant="info" striped :animated="animate"></b-progress>
            <p v-if="errorPercentage" class="w2cloud__error-requests">Failed requests {{errorPercentage}}</p>
        </div>

    </div>


    <div class="w2cloud__button--border">
        <p v-if="processRunning == 'end'">Synchronization complete. Uploaded {{totallUpload}} files. Failed to send {{errorPercentage}} files.</p><p v-else-if="processRunning == 'running'"><span>Warning:</span> <?php _e('Do not reload or close this tab. It may take few minutes.','w2cloud'); ?></p><p v-else><?php _e('Press the sync button to sync all media.','w2cloud'); ?></p><b-button type="submit" @click.prevent="AWS_Sync" variant="primary" class="area-design" :disabled="processRunning == 'running'" > <?php _e('Sync','w2cloud'); ?> </b-button>
    </div>

</div>

<div v-else class="w2cloud__cloud--sync">
  <div class="w2cloud__cloud-sync-content">
    <p class="w2cloud__error"><?php _e('Save auth info to sync media on Amazon S3','w2cloud'); ?></p>
  </div>
</div>
