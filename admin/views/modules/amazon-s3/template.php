<div class="rx-gcs w2cloud__amazon-storage">

    <div class="w2cloud__title--top">
      <h6>Amazon S3<p><a style="color:#0073aa;" href="https://rextheme.com/docs/wp-media-storage-to-cloud/set-up-iam-user-amazon-s3-bucket/" target="_blank">Before setup check our documentation here.</a></p></h6><b-button v-if="awsauthcheck == 'ready'" type="submit" @click.prevent="AWS_Edit" variant="primary" class="area-design"><?php _e('Reauthorize','w2cloud'); ?></b-button>
    </div>

    <div v-if="awsauthcheck == 'notready'" class="w2cloud__cloud--checkbox">

        <div class="w2cloud_amazon-radio">

            <form ref="form" @submit.stop.prevent="handleSubmit">
              <b-form-group label="Access Key ID:" label-for="aws-client-id">
                <a style="color:#5b9dd9;" href="https://s3.console.aws.amazon.com/s3/" target="_blank">Visit this link to setup credentials</a>
                <b-form-input id="aws-client-id" v-model="aws_client_id" type="text" required placeholder="Enter AWS access key id" required></b-form-input>
              </b-form-group>

              <b-form-group label="Secret Access Key:" label-for="aws-client-secret">
                <b-form-input id="aws-client-secret" v-model="aws_client_secret" type="text" required placeholder="Enter AWS secret access key" required></b-form-input>
              </b-form-group>

              <b-form-group label="S3 Bucket name:" label-for="aws-bucket">
                <a style="color:#5b9dd9;" href="https://s3.console.aws.amazon.com/s3/buckets/" target="_blank">Visit this link to setup bucket</a>
                <b-form-input id="aws-bucket" v-model="aws_bucket" type="text" required placeholder="Enter bucket name" required></b-form-input>
              </b-form-group>

              <b-form-group label="Bucket Region:" label-for="aws-region">
                <a style="color:#5b9dd9;" href="https://docs.aws.amazon.com/general/latest/gr/rande.html#s3_region" target="_blank">Visit this link to setup bucket region</a>
                <b-form-input id="aws-region" v-model="aws_region" type="text" required placeholder="Enter Bucket Region" required></b-form-input>
              </b-form-group>

            </form>

        </div>

    </div>

    <div class="w2cloud__button--border">
        <p v-if="awsauthcheck == 'ready'" style="color:green;"><?php _e('Ready to sync','w2cloud'); ?></p><b-button v-if="awsauthcheck == 'notready'" type="submit" @click.prevent="AWS_Authorize" variant="primary" class="area-design"><?php _e('Save','w2cloud'); ?></b-button>
    </div>

</div>
