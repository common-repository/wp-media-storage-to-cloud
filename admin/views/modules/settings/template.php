<div class="w2cloud-settings-area">
    <div class="w2cloud-general__checkbox">

        <b-form-group label="Active Storage:">
          <b-form-radio-group
            id="radio-group-1"
            v-model="settings.active_storage"
            :options="active_storage_options"
            name="radio-options"
          ></b-form-radio-group>
        </b-form-group>

    </div>

    <div v-if="settings.active_storage != 'none'" class="w2cloud-settings__switcher-area">
            <label for="input-live">Content Delivery Network URL: </label>
            <b-form-input id="input-live" v-model="settings.active_cdn" placeholder="Enter custom domain address (e.g. https://example.com)"></b-form-input>
    </div>

    <div v-if="settings.active_storage != 'none'" class="w2cloud-settings__switcher-area">
        <div class="w2cloud-settings__single-switcher-area">
            <div class="w2cloud-switcher">
                <input class="switch-input" v-model="settings.serve_from_bucket" id="serve-from-bucket"  type="checkbox" />
                <label for="serve-from-bucket"></label>
            </div>
            <div class="w2cloud-text">
                <span class="title">Serve media files from bucket</span>

                <p><?php _e('Media files all over the site will be served from the storage bucket. Before, you have to sync all your media files to your bucket. Unsynced media\'s will be served from media library.','w2cloud'); ?></p>
            </div>

        </div>
    </div>

    <div v-if="settings.active_storage != 'none'" class="w2cloud-settings__switcher-area">
        <div class="w2cloud-settings__single-switcher-area">
            <div class="w2cloud-switcher">
                <input class="switch-input" v-model="settings.up_on_bucket" id="up-on-bucket"  type="checkbox" />
                <label for="up-on-bucket"></label>
            </div>
            <div class="w2cloud-text">

                <span class="title">Upload media files on bucket when uploaded on media library</span>
                <p><?php _e('If you upload a new file on your media library, It will sync automatically to your active storage.','w2cloud'); ?></p>

            </div>

        </div>
    </div>

    <div v-if="settings.active_storage != 'none'" class="w2cloud-settings__switcher-area last-switcher-area">
        <div class="w2cloud-settings__single-switcher-area">
            <div class="w2cloud-switcher">
                <input class="switch-input" v-model="settings.delete_from_bucket" id="delete-from-bucket"  type="checkbox" />
                <label for="delete-from-bucket"></label>
            </div>
            <div class="w2cloud-text">
                <span class="title">Delete media from bucket when deleted from media library</span>
                <p><?php _e('Media file will be removed from the bucket if you delete a media permanently from your media library.','w2cloud'); ?></p>
            </div>

        </div>
    </div>

    <!-- <div v-if="settings.active_storage != 'none'" class="w2cloud-settings__switcher-area last-switcher-area">
        <div class="w2cloud-settings__single-switcher-area">
            <div class="w2cloud-switcher">
                <input class="switch-input" v-model="settings.erase_from_local" id="erase-from-local"  type="checkbox" />
                <label for="erase-from-local"></label>
            </div>
            <div class="w2cloud-text">
                <span class="title">Erase media files from local server during sync</span>
                <p style="color:red;"><?php _e('Strongly recommended to keep a backup of your local media files. You can\'t undo it later.','w2cloud'); ?></p>
            </div>

        </div>
    </div> -->


    <div class="w2cloud__button--border">
        <b-button type="submit" @click.prevent="save" class="area-design"> <?php _e('Save','w2cloud'); ?> </b-button>
    </div>



</div>
