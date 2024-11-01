
<?php
  $dashboard_option = get_option( 'w2cloud_dashboard_option' );
?>
<div class="app-dashboard">

    <div class="w2cloud-dashboard-content">
        <b-tabs class="main-menu">

            <b-tab disabled>
                <template v-slot:title>
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/logo.png'?>">
                </template>
            </b-tab>

            <?php
              if ($dashboard_option == 1) {
                ?>
                <b-tab title="Storages" active>
                    <template v-slot:title>
                        <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/media-library.png'?>" class="regular-img icon">
                        <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/media-file-hover.png'?>" class="hover-img icon">
                        <span>Storages</span>
                    </template>
                    <Media></Media>
                </b-tab>
                <?php
              }
              else {
                ?>
                <b-tab title="Storages">
                    <template v-slot:title>
                        <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/media-library.png'?>" class="regular-img icon">
                        <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/media-file-hover.png'?>" class="hover-img icon">
                        <span>Storages</span>
                    </template>
                    <Media></Media>
                </b-tab>
                <?php
              }
            ?>


            <b-tab title="Setting">
                <template v-slot:title>
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/setting.png'?>" class="regular-img icon">
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/settings-hover.png'?>" class="hover-img icon">
                    <span>Settings</span>
                </template>
                <Setting></Setting>
            </b-tab>


            <b-tab title="Sync">
                <template v-slot:title>
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/sync.png'?>" class="regular-img icon">
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/sync-hover.png'?>" class="hover-img icon">
                    <span>Sync</span>
                </template>
                <syncs></syncs>
            </b-tab>

            <b-tab title="Compatibility">
                <template v-slot:title>
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/compatibility.png'?>" class="regular-img icon">
                    <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/compatibility-hover.png'?>" class="hover-img icon">
                    <span>Compatibility</span>
                </template>
               <Compatibility></Compatibility>
            </b-tab>

            <?php
              if ($dashboard_option != 1) {
                ?>
                <b-tab title="Setup Wizard" active>
                    <template v-slot:title>
                        <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/documentation.png'?>" class="regular-img icon">
                        <img src="<?php echo w2cloud_PLUGIN_DIR_URL.'admin/app/assets/images/documentation-hover.png'?>" class="hover-img icon">
                        <span>Setup Wizard</span>
                    </template>
                    <wizard/>
                </b-tab>
                <?php
              }
            ?>

            <b-tab>
            </b-tab>

        </b-tabs>

    </div>

</div>
<?php
    update_option( 'w2cloud_dashboard_option', 1 );
?>
