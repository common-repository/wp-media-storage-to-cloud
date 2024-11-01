<div class="setup-wizard-wrapper">

    <carousel class="carousel-wrapper" :autoplay="false" :nav="false" :dots="false" :items="1" :touchDrag="false" :mouseDrag="false" @changed="changed">

        <div class="single-carouel introduction">
            <h2>Welcome to Media Storage To Cloud!</h2>
            <p>Thank you for downloading Media Storage To Cloud!</p>
            <p>On the next few steps, we'll set up your preferred cloud storage services and get the other features working.</p>
            <p>So you can experience all the exciting features of Media Storage To Cloud.</p>
            <p>Let's go.</p>

        </div>

        <div class="single-carouel storage-provider">
            <div>
                <h2>Select Your Storage Service Provider</h2>
                <div class="input-wrapper">
                    <div class="input-group">
                        <input id="amazon" type="radio" name="storage" @click="slectedStorage('amazon')" value="amazon">
                        <label for="amazon" title="Amazon s3">
                            <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/amazon.png'?>">
                        </label>
                    </div>

                    <div class="input-group">
                        <input id="google-cloud" type="radio" name="storage" @click="slectedStorage('googleCloud')" value="google-cloud">
                        <label for="google-cloud" title="Google Cloud">
                            <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/google-cloud-storage.png'?>">
                        </label>
                    </div>

                    <div class="input-group">
                        <input id="digital-ocean" type="radio" name="storage" @click="slectedStorage('digitalOcean')" value="digital-ocean">
                        <label for="digital-ocean" title="Google Cloud">
                            <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/digital-ocean-spaces.png'?>">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="single-carouel documentation">
            <div v-if="storageName == 'amazon'" class="amazon-s3-doc">
                <h2>Configure Amazon S3 Storage Now</h2>
                <p>Amazon S3 or Amazon Simple Storage Service is a fast and flawless cloud service offered by Amazon.</p>

                <p>Before you configure Media Storage To Cloud with Amazon S3, make sure that on your AWS account, you've set up everything correctly.</p>

                <p>If you haven't set up your AWS account, <a href="https://s3.console.aws.amazon.com/s3/" target="_blank">click on this link</a> to do it now.</p>
                <p>Once you've done it, click on Next to start configuring your AWS account with Media Storage To Cloud.</p>

                <a href="https://rextheme.com/docs/wp-media-storage-to-cloud/set-up-iam-user-amazon-s3-bucket/" class="btn-default" target="_blank">Setup AWS Account First</a>
            </div>

            <div v-if="storageName == 'googleCloud'" class="google-cloud-doc">
                <h2>Configure Google Cloud Storage Now</h2>
                <p>Google Cloud Storage Service is a smooth and easy to use cloud service offered by Google itself.</p>

                <p>Before you configure the Media Storage To Cloud with Google Cloud Storage, make sure that on your Gogle Cloud Platform account, you've set up everything correctly.</p>

                <p>If you haven't set up your GCP account, <a href="https://console.cloud.google.com/apis/" target="_blank">click on this link</a> to do it now.</p>
                <p>Once you've done it, click on Next to start configuring your GCP account with Media Storage To Cloud.</p>

                <a href="https://rextheme.com/docs/wp-media-storage-to-cloud/set-up-google-cloud-storage-bucket/" class="btn-default" target="_blank">Setup GCP Account First</a>
            </div>

            <div v-if="storageName == 'digitalOcean'" class="digital-ocean-doc">
                <h2>Configure Digital Ocean Space Now</h2>
                <p>Digital Ocean Space is a smooth and easy to use cloud service offered by Google itself.</p>

                <p>Before you configure the Media Storage To Cloud with Digital Ocean Space, make sure that on your Digital Ocean Space Platform account, you've set up everything correctly.</p>

                <p>If you haven't set up your account, <a href="https://cloud.digitalocean.com/account/api/" target="_blank">click on this link</a> to do it now.</p>
                <p>Once you've done it, click on Next to start configuring your Digital Ocean Space account with Media Storage To Cloud.</p>

                <a href="https://rextheme.com/docs/wp-media-storage-to-cloud/connect-digitalocean-space/" class="btn-default" target="_blank">Read Documentation</a>
            </div>
        </div>

        <div class="single-carouel authorize-storage">
            <div v-if="storageName == 'amazon'" class="amazon-s3-data">
                <div class="headding-wrapper">
                    <h2 v-if="awsauthcheck != 'ready'">Authorize Amazon S3 Storage</h2>
                    <h2 v-if="awsauthcheck == 'ready'">Authorize Successful With Amazon S3</h2>

                    <p v-if="awsauthcheck != 'ready'">Simply provide your Amazon information and S3 Bucket name. Then click on Save.</p>
                    <p v-if="awsauthcheck == 'ready'">You've successfully authorized your Amazon S3 Bucket with Media Storage To Cloud.</p>
                </div>
                <AWS></AWS>
            </div>
            <div v-if="storageName == 'googleCloud'" class="google-cloud-data">
                <div class="headding-wrapper">
                    <h2 v-if="gcsauthcheck != 'ready'">Authorize Google Cloud Storage</h2>
                    <h2 v-if="gcsauthcheck == 'ready'">Authorize Successful With Google Cloud Storage</h2>

                    <p v-if="gcsauthcheck != 'ready'">Simply provide your Google Cloud Service JSON data and Bucket name. Then click on Save.</p>
                    <p v-if="gcsauthcheck == 'ready'">You've successfully authorized your Google Cloud Bucket with Media Storage To Cloud.</p>
                </div>
                <GCS></GCS>
            </div>
            <div v-if="storageName == 'digitalOcean'" class="digital-ocean-data">
                <div class="headding-wrapper">
                    <h2 v-if="doauthcheck != 'ready'">Authorize Digital Ocean Space</h2>
                    <h2 v-if="doauthcheck == 'ready'">Authorize Successful With Digital Ocean Space</h2>

                    <p v-if="doauthcheck != 'ready'">Simply provide your Digital Ocean Space informations. Then click on Save.</p>
                    <p v-if="doauthcheck == 'ready'">You've successfully authorized your Digital Ocean Space with Media Storage To Cloud.</p>
                </div>
                <DO></DO>
            </div>
        </div>

        <!-- <div class="single-carouel media-checking">
            <div v-if="storageName == 'amazon'" class="media-check amazon-media-checking">
                <amazonMediaCheck></amazonMediaCheck>
            </div>
            <div v-if="storageName == 'googleCloud'" class="media-check google-cloud-media-checking">
                <gcsMediaCheck></gcsMediaCheck>
            </div>
        </div> -->
        <div class="single-carouel conclution">
            <div v-if="storageName == 'amazon'" class="headding-wrapper text-center">
                <h2>Your Amazon S3 Bucket Is Ready To Sync</h2>
                <p>You've verified authorization with your Amazon S3 bucket with Media Storage To Cloud successfully.</p>
                <p>Go to Sync to Transfer Data.</p>
            </div>
            <div v-if="storageName == 'googleCloud'" class="headding-wrapper text-center">
                <h2>Your Google Cloud Bucket Is Ready To Sync</h2>
                <p>You've verified authorization with your Google cloud Bucket with Media Storage To Cloud successfully.</p>
                <p>Go to Sync to Transfer Data.</p>
            </div>
            <div v-if="storageName == 'digitalOcean'" class="headding-wrapper text-center">
                <h2>Your Digital Ocean Space Is Ready To Sync</h2>
                <p>You've verified authorization with your Digital Ocean Space with Media Storage To Cloud successfully.</p>
                <p>Go to Sync to Transfer Data.</p>
            </div>
        </div>

        <div>
          <div style="margin: 10% auto;" class="headding-wrapper text-center">
            <h2>Thank you for using WP Media Storage to Cloud</h2>
          </div>
        </div>

        <template slot="prev"><button class="owl-prev">previous</button></template>
        <template v-if="carousel_index == 4" slot="next"><button class="owl-next">Finish</button></template>
        <template v-else slot="next"><button class="owl-next" :disabled="next_btn == false">next</button></template>


    </carousel>



</div>
