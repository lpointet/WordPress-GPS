<div class="wrap">

    <!-- Header -->
    <div id="icon-themes" class="icon32"><br></div>

    <!-- Title -->
    <h2><?php echo GB_GPS_ADMIN_MENU_TITLE; ?></h2>

    <?php if(!empty($this->message)): ?>
        <div id="setting-error-settings_updated" class="updated settings-error">
            <p><strong><?php echo $this->message; ?></strong></p>
        </div>
    <?php endif; ?>

    <!-- Global form -->
    <form method="post" action="">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('gb_gps_nonce'); ?>" />

        <h3><?php echo GB_GPS_ADMIN_MENU_SUBTITLE; ?></h3>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php echo GB_GPS_ADMIN_MENU_LABEL; ?></th>

                <td>
                    <select id="gb_gps_select_scenario" name="scenario">
                        <option value=""></option>
                        <?php foreach($this->scenarios as $k => $scenario): ?>
                            <option value="<?php echo $k; ?>">
                                <?php echo $scenario->get_label(); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <td>
                    <?php foreach($this->scenarios as $k => $scenario): ?>
                        <div class="hidden gb_gps_description" id="gb_gps_<?php echo $k; ?>_description">
                            <?php echo $scenario->get_description(); ?>
                        </div>
                    <?php endforeach; ?>
                </td>

            </tr>

        </table>

        <!-- Submit button -->
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php echo GB_GPS_ADMIN_MENU_LAUNCH_BUTTON; ?>" />
        </p>

    </form>
    <!-- Global form end -->

</div> <!-- .wrap -->