<div class="callback-form-wrapper">
    <h2><?php echo $heading_title; ?></h2>
    <?php if($description_message){ ?>
    <p><?php echo $description_message;?></p>
    <?php } ?>
    <form class="callback-form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <p class="form-line">
            <label for="callback_name"><?php echo $entry_name; ?> <span class="required">*</span></label> 
            <input id="callback_name" type="text" name="name" value="<?php echo $name; ?>" required size="32" maxlength="32" placeholder="<?php echo $placeholder_name; ?>" />
            <?php if ($error_name) { ?>
            <span class="error"><?php echo $error_name; ?></span>
            <?php } ?>
        </p>
        <p class="form-line">
            <label for="callback_phone"><?php echo $entry_phone; ?>  <span class="required">*</span></label>
            <input id="callback_phone" class="" type="text" name="phone" value="<?php echo $phone; ?>" required size="32" placeholder="<?php echo $placeholder_phone; ?>" />
            <?php if ($error_phone) { ?>
            <span class="error"><?php echo $error_phone; ?></span>
            <?php } ?>
        </p>
        <p class="form-line">
            <label for="callback_time"><?php echo $entry_time; ?></label>
            <input id="callback_time" type="text" name="time" value="<?php echo $time; ?>" size="32" placeholder="<?php echo $placeholder_time; ?>" />
            <?php if ($error_time) { ?>
            <span class="error"><?php echo $error_time; ?></span>
            <?php } ?>
        </p>
        <?php if($use_captcha){ ?>
        <p class="form-line">
            <label for="callback_captcha"><?php echo $entry_captcha; ?> <span class="required">*</span></label> 
            <input id="callback_captcha" type="text" name="captcha" value="<?php echo $captcha; ?>" required />
            <img class="captcha" src="index.php?route=information/contact/captcha" alt="Captcha image" />
            <?php if ($error_captcha) { ?>
            <span class="error"><?php echo $error_captcha; ?></span>
            <?php } ?>
        </p>
        <?php } ?>
        <input type="submit" class="button" value="<?php echo $entry_submit; ?>" />
    </form>
</div>
