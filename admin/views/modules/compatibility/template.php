<div class="w2cloud-compatibility-area">

    <div class="w2cloud-compatibility__header">
        <h5><?php _e('Compatibility environment','w2cloud'); ?></h5>
    </div>

    <div class="w2cloud-compatibility__body">
        <div class="w2cloud-compatibility__single-switcher">

            <div class="w2cloud-switcher__area" v-for="(item, index) in compatibility_info ">
                <div class="w2cloud-switcher__list" v-for="(data, index) in item ">

                    <span class="title">{{ data.title }}</span>
                    <div class="w2cloud-swicher">
                        <span class="title"> {{ data.value }} </span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
