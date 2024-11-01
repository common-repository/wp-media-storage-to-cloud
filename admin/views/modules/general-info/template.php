<div class=" w2cloud-general__info-area">
    <div class="w2cloud-general__checkbox">

        <ul class="w2cloud-checkbox">

             <h6>Mode</h6>

            <li>
                <input type="radio" name="radio" id="w2cloud_disabled" />
                <label for="w2cloud_disabled">
                    <span class="title"></span><span class="w2cloud__uppercase">Disabled</span> - Disable Stateless Media.
                </label>
            </li>

            <li>
                <input type="radio" name="radio" id="w2cloud_backup" />
                <label for="w2cloud_backup">
                    <span class="title"></span><span class="w2cloud__uppercase">Backup</span> - Upload media files to Google Storage and serve local file urls
                </label>
            </li>

            <li>
                <input type="radio" name="radio" id="w2cloud_CDN" v-on:click="general_select_type('3')"/>
                <label for="w2cloud_CDN">
                    <span class="title"></span><span class="w2cloud__uppercase">CDN</span> - Copy media files to Google Storage and serve them directly from there.
                </label>
            </li>

            <li>
                <input type="radio" name="radio" id="w2cloud_stateless" v-on:click="general_select_type('4')"/>
                <label for="w2cloud_stateless">
                    <span class="title"></span><span class="w2cloud__uppercase">Stateless</span> - Store and serve media files with Google Cloud Storage only. Media files are not stored locally.
                </label>
            </li>

        </ul>

    </div>


    <div class="w2cloud-general__replaces" v-if="select_type == '4'">

        <h6>File URL Replacement</h6>

        <div class="w2cloud-general__select">
            <select class="select">
                <option>Disable</option>
                <option>Option 2</option>
                <option>Option 3</option>
                <option>Option 4</option>
            </select>
        </div>

        <p>Scans post content and meta during presentation and replaces local media file urls with GCS urls. When selecting meta or true depending on the amount of meta, this could be significantly impact performance negatively. This setting does not modify your database.</p>
    </div>

    <div class="w2cloud__button--border">
        <b-button type="submit" class="area-design">Save and Continue</b-button>
    </div>

</div>





