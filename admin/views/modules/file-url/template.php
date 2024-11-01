<div class="w2cloud-file_url">
    <div class="w2cloud-file_body">

        <div class="w2cloud-file_input">
            <label for="name" class="required"> Preview </label>
            <input type="text" id="name" name="name"   placeholder="Input link">
            <p>An example file url utilizing all configured settings.
            </p>
        </div>

        <div class="w2cloud-file_input">
            <label for="name" class="required">Domain </label>
            <input type="text" id="name" name="name"   placeholder="Input Domain">
            <p>Replace the default GCS domain with your own custom domain. This will require you to <a href="#" class="w2cloud_submit">configure a CNAME.</a> Be advised that the bucket name and domain name must match exactly, and HTTPS is not supported with a custom domain out of the box.
            </p>
        </div>

        <div class="w2cloud-file__double-switcher">
            <div class="w2cloud-file__single-switcher">
                <div class="w2cloud-file__area">

                    <span class="title">Organization</span>
                    <div class="w2cloud-switcher">
                        <input class="switch-input" id="Organization"  type="checkbox" />
                        <label for="Organization"></label>
                    </div>

                </div>

                <p>Organize uploads into year and month based folders. This will update the <a href="#" class="w2cloud_submit">related WordPress media setting.</a></p>
            </div>

            <div class="w2cloud-file__single-switcher">
                <div class="w2cloud-file__area">
                    <span class="title">Cache-Busting</span>
                    <div class="w2cloud-switcher">
                        <input class="switch-input" id="Cache"  type="checkbox" />
                        <label for="Cache"></label>
                    </div>
                </div>

                <p>Prepends a random set of numbers and letters to the filename. This is useful for preventing caching issues when uploading files that have the same filename.</p>
            </div>

        </div>

    </div>

    <div class=" w2cloud-file__footer">
        <b-button type="submit" class="area-design">Save and Continue</b-button>
    </div>


</div>