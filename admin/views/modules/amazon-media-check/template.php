<div>
   <div class="headding-wrapper">
        <h2>Sync Test With Amazon S3</h2>
        <p>You've authorized your Amazon S3 Bucket with Media Storage To Cloud. <br/> Now, run these sync tests to make sure you're ready to sync media files with your cloud storage.</p>
    </div>
    
    <div class="steps-wrapper">
        <div class="single-step" :class="{success: state_status_1 == 'success1', failed: state_status_1 == 'failed1'}">
            <span class="step-count">1
                <spinner v-if="state_status_1 == 'running1'"></spinner>
                <span class="step-status">
                    <font-awesome-icon v-if="state_status_1 == 'success1'" :icon="['fas', 'check']" />
                    <font-awesome-icon v-else :icon="['fas', 'times']" />
                </span>
            </span>

        </div>

        <div class="single-step" :class="{success: state_status_2 == 'success2', failed: state_status_2 == 'failed2'}">
            <span class="step-count">2
                <spinner v-if="state_status_2 == 'running2'"></spinner>
                <span class="step-status">
                    <font-awesome-icon v-if="state_status_2 == 'success2'" :icon="['fas', 'check']" />
                    <font-awesome-icon v-else :icon="['fas', 'times']" />
                </span>
            </span>
        </div>

        <div class="single-step" :class="{success: state_status_3 == 'success3', failed: state_status_3 == 'failed3'}">
            <span class="step-count">3
                <spinner v-if="state_status_3 == 'running3'"></spinner>
                <span class="step-status">
                    <font-awesome-icon v-if="state_status_3 == 'success3'" :icon="['fas', 'check']" />
                    <font-awesome-icon v-else :icon="['fas', 'times']" />
                </span>
            </span>
        </div>
    </div>
    
    <div class="step-details">
        <ul>
            <li v-if="state_status_1 == 'success1'">
                <h6>Storage Settings Verified.</h6>
                <span>Media Storage to Cloud is successfully connected to cloud storage.</span>
            </li>
            <li v-if="state_status_2 == 'success2'">
                <h6>Sample File Uploaded.</h6>
                <span>A sample file is successfully uploaded.</span>
            </li>
            <li v-if="state_status_3 == 'success3'">
                <h6>File Accessibility Verified.</h6>
                <span>The uploaded file was successfully accessed publicly.</span>
            </li>
            <li v-if="state_status_3 == 'success3'">
                <h6>Delete Uploaded File.</h6>
                <span>The uploaded file was successfully deleted.</span>
            </li>
        </ul>
    </div>
    
    <div class="start-test">
        <button type="button" @click="validation()">Start Test</button>
    </div>
</div>
