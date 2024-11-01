<div class="w2cloud-setting__storage">

    <div class="w2cloud-setting__body">

        <div class="w2cloud-setting__input">
            <label for="name"> Bucket </label>
            <input type="text" id="name" name="name" placeholder="Input Text">
            <p>The name of the GCS bucket.</p>
        </div>

        <div class="w2cloud-setting__input">
            <label for="name">Bucket Folder </label>
            <input type="text" id="name" name="name" placeholder="Input Text">
            <p>If you would like files to be uploaded into a particular folder within the bucket, define that path here.
            </p>
        </div>

        <div class="w2cloud-setting__input">
            <label for="story" >Service Account JSON </label>
            <textarea id="story" name="story"
            rows="5" cols="33" placeholder="Input text">
            </textarea>
            <p>Private key in JSON format for the service account WP-Stateless will use to connect to your Google Cloud project and bucket.</p>
        </div>

    </div>

    <div class="w2cloud-setting__control-area">

        <div class="w2cloud-setting__input">
            <label for="control" >Cache-Control</label>
            <input type="text" id="control" name="control"   placeholder="Public, max-age=36000, must-revalidate">
            <p>Override the default cache control assigned by GCS.</p>
        </div>

        <div class="w2cloud-setting__switcher-area">

            <span class="title">Delete GCS File</span>
            <div class="w2cloud-switcher">
                <input class="switch-input" id="gcs-file"  type="checkbox" />
                <label for="gcs-file"></label>
            </div>
            <p>Delete the GCS file when the file is deleted from WordPress.</p>

        </div>

    </div>

    <div class=" w2cloud-file__footer">
        <b-button type="submit" class="area-design"> Save and Continue </b-button>
    </div>

</div>
